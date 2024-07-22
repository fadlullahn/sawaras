<?php
include 'config.php';

// Ambil data alternatif
$alternatif = array();
$sqlp = 'SELECT iddaftar, name FROM pendaftaran';
$data = $conn->query($sqlp);
while ($row = $data->fetch_object()) {
    $alternatif[$row->iddaftar] = $row->name;
}

// Ambil data bobot dan jenis kriteria
$nama_jenis_k = array();
$sqlk = 'SELECT * FROM kriteria WHERE metode = "ARAS"';
$data = $conn->query($sqlk);
while ($row = $data->fetch_object()) {
    $nama_jenis_k[$row->idk] = array($row->nama_k, $row->jenis_k);
    $bobot[$row->idk] = $row->bobot;
}

// Ambil data matriks keputusan
$keputusan = array();
$nilaiterbaik = array();
$sqlpk = 'SELECT perangkingan.*, kriteria.nama_k
          FROM perangkingan 
          JOIN kriteria ON perangkingan.idk = kriteria.idk
          WHERE perangkingan.idk IN (SELECT idk FROM kriteria WHERE metode = "ARAS") ORDER BY iddaftar ASC';
$data = $conn->query($sqlpk);
while ($row = $data->fetch_object()) {
    $idd = intval($row->iddaftar);
    $idk = intval($row->idk);
    $nilai = $row->value;

    if (!isset($keputusan[$idd][$idk])) {
        $keputusan[$idd][$idk] = $nilai;
    }

    if (!isset($nilaiterbaik[$idk])) $nilaiterbaik[$idk] = ($nama_jenis_k[$idk][1] == 'cost') ? 10 : 0;
    $nilaiterbaik[$idk] = ($nama_jenis_k[$idk][1] == 'cost') ? ($nilaiterbaik[$idk] < $nilai ? $nilaiterbaik[$idk] : $nilai) : ($nilaiterbaik[$idk] > $nilai ? $nilaiterbaik[$idk] : $nilai);
}
array_unshift($keputusan, $nilaiterbaik);

// Normalisasi
$u1 = 1;
$total = array();
foreach ($keputusan as $idd => $nilaialternatif) {
    foreach ($nilaialternatif as $idk => $nilaiakurat) {
        if (!isset($total[$idk])) $total[$idk] = 0;
        $total[$idk] += ($nama_jenis_k[$idk][1] == 'cost' && $nilaiakurat != 0) ? 1 / $nilaiakurat : ($nilaiakurat != 0 ? $nilaiakurat : 1);
    }
}

$normalisasi = array();
foreach ($keputusan as $idd => $nilaialternatif) {
    foreach ($nilaialternatif as $idk => $nilaiakurat) {
        $normalisasi[$idd][$idk] = ($nama_jenis_k[$idk][1] == 'cost' && $nilaiakurat != 0 && $total[$idk] != 0) ? ((1 / $nilaiakurat) / $total[$idk]) : (($nilaiakurat != 0 && $total[$idk] != 0) ? ($nilaiakurat / $total[$idk]) : 0);
    }
}

$u2 = 1;
$ternormalisasi = array();
foreach ($normalisasi as $idd => $barisnormalisasi) {
    foreach ($barisnormalisasi as $idk => $nilainormalisasi) {
        $ternormalisasi[$idd][$idk] = $nilainormalisasi * $bobot[$idk];
    }
}

// Hitung skor
$u3 = 1;
$optimumS = array();
foreach ($ternormalisasi as $idd => $baristernormalisasi) {
    $optimumS[$idd] = array_sum($baristernormalisasi);
}

$utilitasK = array();
foreach ($optimumS as $idd => $barisoptimumS) {
    if ($idd != 0) {
        $utilitasK[$idd] = ($optimumS[0] != 0) ? $barisoptimumS / $optimumS[0] : 0;
    }
}
arsort($utilitasK);
$pilih = key($utilitasK);
$detail = reset($utilitasK);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print ARAS Ranking</title>
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
        <h1>Perangkingan ARAS</h1>
    </div>
    <table id="data-table">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Nama Mahasiswa</th>
                <th>Optimal Balance (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php $rank = 1;
            foreach ($utilitasK as $nama => $utilitas) : ?>
                <tr>
                    <td><?php echo $rank; ?></td>
                    <td><?php echo $alternatif[$nama]; ?></td>
                    <td><?php echo $utilitas * 100 . "%"; ?></td>
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
            doc.save('perangkingan_aras.pdf');
        }

        function exportToExcel() {
            const table = document.getElementById("data-table");
            const workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, "perangkingan_aras.xlsx");
        }
    </script>
</body>

</html>