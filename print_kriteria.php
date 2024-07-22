<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Data Kriteria</title>
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
        <h1>Data Kriteria</h1>
    </div>
    <table id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Metode</th>
                <th>Nama Kriteria</th>
                <th>Jenis Kriteria</th>
                <th>Bobot</th>
                <th>Nilai Max</th>
                <th>Nilai Min</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = "SELECT * FROM kriteria ORDER BY idk ASC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['metode']; ?></td>
                    <td><?php echo $row['nama_k']; ?></td>
                    <td><?php echo $row['jenis_k']; ?></td>
                    <td><?php echo $row['bobot']; ?></td>
                    <td><?php echo $row['nilai_max']; ?></td>
                    <td><?php echo $row['nilai_min']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <div class="no-print">
        <button onclick="window.print()">Print</button>
        <button onclick="generatePDF()">Download PDF</button>
        <button onclick="exportToExcel()">Download Excel</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            doc.autoTable({
                html: '#data-table'
            });
            doc.save('data_kriteria.pdf');
        }

        function exportToExcel() {
            const table = document.getElementById("data-table");
            const workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, "data_kriteria.xlsx");
        }
    </script>
</body>

</html>