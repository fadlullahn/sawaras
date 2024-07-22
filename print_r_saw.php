<?php
include 'config.php';

// Ambil data alternatif
$alternatives = array();
$sql_alternatives = 'SELECT * FROM pendaftaran';
$data_alternatives = $conn->query($sql_alternatives);
while ($row_alternatives = $data_alternatives->fetch_object()) {
    $alternatives[$row_alternatives->iddaftar] = $row_alternatives->name;
}

// Ambil data kriteria dan bobot
$criteria_data = array();
$bobot = array();
$sql_criteria = 'SELECT * FROM kriteria WHERE metode = "SAW"';
$data_criteria = $conn->query($sql_criteria);
while ($row_criteria = $data_criteria->fetch_object()) {
    $criteria_data[$row_criteria->idk] = array($row_criteria->nama_k, $row_criteria->jenis_k);
    $bobot[$row_criteria->idk] = $row_criteria->bobot;
}

// Ambil data matriks keputusan
$decision_matrix = array();
$sql_decision_matrix = 'SELECT perangkingan.*, kriteria.nama_k FROM perangkingan 
                       JOIN kriteria ON perangkingan.idk = kriteria.idk
                       WHERE perangkingan.idk IN (SELECT idk FROM kriteria WHERE metode = "SAW")';
$data_decision_matrix = $conn->query($sql_decision_matrix);
$min_values = array();
$max_values = array();
$sql_kriteria_values = 'SELECT idk, MIN(nilai_min) AS nilai_min, MAX(nilai_max) AS nilai_max FROM kriteria WHERE metode = "SAW" GROUP BY idk';
$data_kriteria_values = $conn->query($sql_kriteria_values);

while ($row_kriteria_values = $data_kriteria_values->fetch_object()) {
    $min_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_min;
    $max_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_max;
}

while ($row_decision_matrix = $data_decision_matrix->fetch_object()) {
    $j = $row_decision_matrix->idk;
    $v = $row_decision_matrix->value;
    $decision_matrix[$row_decision_matrix->iddaftar][$j] = array(
        'value' => $v,
        'nama_k' => $row_decision_matrix->nama_k
    );
}

// Normalisasi
$normalized_matrix = array();
foreach ($decision_matrix as $i => $x_i) {
    $normalized_matrix[$i] = array();
    foreach ($x_i as $j => $x_ij) {
        if ($criteria_data[$j][1] == 'cost') {
            $normalized_matrix[$i][$j] = $min_values[$j] / $x_ij['value'];
        } else {
            $normalized_matrix[$i][$j] = $x_ij['value'] / $max_values[$j];
        }
    }
}

// Hitung nilai preferensi
$preference_values = array();
foreach ($normalized_matrix as $i => $r_i) {
    $preference_values[$i] = 0;
    foreach ($r_i as $j => $r_ij) {
        $preference_values[$i] += $bobot[$j] * $r_ij;
    }
}

arsort($preference_values);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print SAW Ranking</title>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            .print-header {
                text-align: center;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="print-header">
        <h1>Perangkingan SAW</h1>
    </div>
    <table id="data-table">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Nama</th>
                <th>Preferensi</th>
            </tr>
        </thead>
        <tbody>
            <?php $rank = 1;
            foreach ($preference_values as $i => $preference) : ?>
                <tr>
                    <td><?= $rank ?></td>
                    <td><?= $alternatives[$i] ?></td>
                    <td><?= $preference ?></td>
                </tr>
            <?php $rank++;
            endforeach; ?>
        </tbody>
    </table>
    <div class="no-print">
        <button onclick="window.print()">Print</button>
        <button onclick="generatePDF()">Download PDF</button>
        <button onclick="exportToExcel()">Download Excel</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.15/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            doc.autoTable({
                html: '#data-table',
                theme: 'grid',
            });
            doc.save('perangkingan_saw.pdf');
        }

        function exportToExcel() {
            const table = document.getElementById("data-table");
            const workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, "perangkingan_saw.xlsx");
        }
    </script>
</body>

</html>