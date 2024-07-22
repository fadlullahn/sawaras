<?php
include 'config.php';

// Ambil data alternatif
$alternatives = array();
$sql_alternatives = 'SELECT * FROM pendaftaran';
$data_alternatives = $conn->query($sql_alternatives);
while ($row_alternatives = $data_alternatives->fetch_object()) {
    $alternatives[$row_alternatives->iddaftar] = $row_alternatives->name;
}

// Ambil data kriteria
$criteria_data = array();
$bobot = array();

$sql_criteria = 'SELECT * FROM kriteria WHERE metode = "SAW"';
$data_criteria = $conn->query($sql_criteria);
while ($row_criteria = $data_criteria->fetch_object()) {
    $criteria_data[$row_criteria->idk] = array($row_criteria->nama_k, $row_criteria->jenis_k);
    $bobot[$row_criteria->idk] = $row_criteria->bobot;
}

// Ambil data matrix keputusan
$decision_matrix = array();
$sql_decision_matrix = 'SELECT perangkingan.*, kriteria.nama_k 
                       FROM perangkingan 
                       JOIN kriteria ON perangkingan.idk = kriteria.idk 
                       WHERE kriteria.metode = "SAW"';
$data_decision_matrix = $conn->query($sql_decision_matrix);

while ($row_decision_matrix = $data_decision_matrix->fetch_object()) {
    $j = $row_decision_matrix->idk;
    $v = $row_decision_matrix->value;
    $nama_k = $row_decision_matrix->nama_k;
    $decision_matrix[$row_decision_matrix->iddaftar][$j] = array(
        'value' => $v,
        'nama_k' => $nama_k
    );
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Penilaian SAW</title>
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
        <h1>Penilaian SAW</h1>
    </div>
    <table id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <?php foreach ($criteria_data as $idk => $data) : ?>
                    <th><?= $data[0] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($decision_matrix as $iddaftar => $criteria_values) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= isset($alternatives[$iddaftar]) ? $alternatives[$iddaftar] : ''; ?></td>
                    <?php foreach ($criteria_values as $idk => $data) : ?>
                        <td>
                            <b><?= $data['nama_k'] ?></b><br>
                            <?= $data['value'] ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
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
            doc.save('penilaian_saw.pdf');
        }

        function exportToExcel() {
            const table = document.getElementById("data-table");
            const workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, "penilaian_saw.xlsx");
        }
    </script>
</body>

</html>