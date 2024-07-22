<?php
include 'config.php';

// Ambil data alternatif
$alternatif = array();
$sql = 'SELECT * FROM pendaftaran';
$data = $conn->query($sql);
while ($row = $data->fetch_object()) {
    $alternatif[$row->iddaftar] = $row->name;
}

// Ambil data kriteria
$nama_jenis_k = array();
$sql = 'SELECT * FROM kriteria WHERE metode = "ARAS"';
$data = $conn->query($sql);
while ($row = $data->fetch_object()) {
    $nama_jenis_k[$row->idk] = $row->nama_k;
}

// Ambil data matrix keputusan
$keputusan = array();
$sql = 'SELECT perangkingan.*, kriteria.nama_k AS nama_kriteria
        FROM perangkingan 
        JOIN kriteria ON perangkingan.idk = kriteria.idk
        WHERE perangkingan.idk IN (SELECT idk FROM kriteria WHERE metode = "ARAS")';
$data = $conn->query($sql);
while ($row = $data->fetch_object()) {
    $idd = $row->iddaftar;
    $idk = $row->idk;
    $nilai = $row->value;
    $nama_kriteria = $row->nama_kriteria;

    if (!isset($keputusan[$idd][$idk])) {
        $keputusan[$idd][$idk] = array(
            'nilai' => $nilai,
            'nama_kriteria' => $nama_kriteria
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Penilaian ARAS</title>
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
        <h1>Penilaian ARAS</h1>
    </div>
    <table id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <?php foreach ($nama_jenis_k as $idk => $nama_kriteria) : ?>
                    <th><?= $nama_kriteria ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($keputusan as $idd => $row) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= isset($alternatif[$idd]) ? $alternatif[$idd] : ''; ?></td>
                    <?php foreach ($row as $idk => $data) : ?>
                        <td>
                            <b><?= $data['nama_kriteria'] ?></b><br>
                            <?= $data['nilai'] ?>
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
            doc.save('penilaian_aras.pdf');
        }

        function exportToExcel() {
            const table = document.getElementById("data-table");
            const workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, "penilaian_aras.xlsx");
        }
    </script>
</body>

</html>