<?php
// Pernyataan SQL untuk mengambil data
$sql = "SELECT gid, kid, gname, glok FROM dokumen";
$result = $conn->query($sql);

// Cek apakah hasilnya ada
if ($result->num_rows > 0) {
    // Ambil data dan simpan dalam variabel
    while ($row = $result->fetch_assoc()) {
        $gid = $row["gid"];
        $kid = $row["kid"];
        $gname = $row["gname"];
        $glok = $row["glok"];
    }
} else {
    echo "Mahasiswa Belum Melakukan Input Dokumen.";
}
?>

<div class="pt-3">
    <h2>Data Pendaftaran</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>View</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sqlPendaftaran = "SELECT * FROM pendaftaran";
            $resultPendaftaran = $conn->query($sqlPendaftaran);

            while ($rowPendaftaran = $resultPendaftaran->fetch_assoc()) :
            ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $rowPendaftaran['name']; ?></td>
                    <td>
                        <a href='uploads/<?php echo $rowPendaftaran['nim']; ?>/1/' target='_blank'>
                            <span class="fas fa-eye"></span>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="?page=pendaftaran&action=update&id=<?php echo $rowPendaftaran['iddaftar']; ?>">
                            <span class="fas fa-edit"></span>
                        </a>
                        <a onclick="return confirm('Yakin Ingin Menghapus Data ini ?')" class="btn btn-danger" href="?page=pendaftaran&action=hapus&id=<?php echo $rowPendaftaran['iddaftar']; ?>">
                            <span class="fas fa-trash-alt"></span>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<!-- KODE DIBAWAH DI AMBIL DARI HALAMAN PERANGKINGAN -->


<?php
// Fungsi Untuk Mendapatkan Informasi Kriteria Berdasarkan Nama Kriteria
function getKriteria($nama_k)
{
    global $conn;
    $sql = "SELECT * FROM kriteria WHERE nama_k = '$nama_k'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

if (isset($_POST['proses'])) {
    // Ambil Data
    $tahun = $_POST['tahun'];

    // Ambil Metode dari Tabel Kriteria (saya mengambilnya dari 'ipk', bisa disesuaikan dengan kriteria lainnya)
    $metode = getKriteria('ipk')['metode'];

    // Check apakah metode yang dipilih adalah SAW
    if ($metode == 'saw') {
        // Mengambil Nilai Min dan Max Dari Tabel Kriteria Berdasarkan Nama Kriteria
        $sql_kriteria = "SELECT 
            MIN(CASE WHEN nama_k = 'ipk' THEN nilai_min END) as min_ipk,
            MAX(CASE WHEN nama_k = 'ipk' THEN nilai_max END) as max_ipk,
            MIN(CASE WHEN nama_k = 'kti' THEN nilai_min END) as min_kti,
            MAX(CASE WHEN nama_k = 'kti' THEN nilai_max END) as max_kti,
            MIN(CASE WHEN nama_k = 'ba' THEN nilai_min END) as min_ba,
            MAX(CASE WHEN nama_k = 'ba' THEN nilai_max END) as max_ba,
            MIN(CASE WHEN nama_k = 'org' THEN nilai_min END) as min_org,
            MAX(CASE WHEN nama_k = 'org' THEN nilai_max END) as max_org,
            MIN(CASE WHEN nama_k = 'seni' THEN nilai_min END) as min_seni,
            MAX(CASE WHEN nama_k = 'seni' THEN nilai_max END) as max_seni
            FROM kriteria";
        $result_kriteria = $conn->query($sql_kriteria);
        $row = $result_kriteria->fetch_assoc();

        // Mengambil Nilai Min dan Max Untuk Setiap Kriteria
        $min_ipk = $row["min_ipk"];
        $max_ipk = $row["max_ipk"];
        $min_kti = $row["min_kti"];
        $max_kti = $row["max_kti"];
        $min_ba = $row["min_ba"];
        $max_ba = $row["max_ba"];
        $min_org = $row["min_org"];
        $max_org = $row["max_org"];
        $min_seni = $row["min_seni"];
        $max_seni = $row["max_seni"];

        // Ambil Data Bobot Dari Tabel Kriteria
        $bobot_ipk = getKriteria('ipk')['bobot'];
        $bobot_kti = getKriteria('kti')['bobot'];
        $bobot_ba = getKriteria('ba')['bobot'];
        $bobot_org = getKriteria('org')['bobot'];
        $bobot_seni = getKriteria('seni')['bobot'];

        // Ambil Jenis Kriteria di Tabel Kriteria, Apakah Itu Benefit Atau Cost
        $j_ipk = getKriteria('ipk')['jenis_k'];
        $j_kti = getKriteria('kti')['jenis_k'];
        $j_ba = getKriteria('ba')['jenis_k'];
        $j_org = getKriteria('org')['jenis_k'];
        $j_seni = getKriteria('seni')['jenis_k'];

        // Ambil Data Pendaftaran Berdasarkan Tahun di Tabel Perangkingan
        $sql_pendaftaran = "SELECT * FROM pendaftaran WHERE tahun=$tahun";
        $result_pendaftaran = $conn->query($sql_pendaftaran);

        if ($result_pendaftaran->num_rows > 0) {
            // Proses Perangkingan
            while ($row = $result_pendaftaran->fetch_assoc()) {
                // Mengambil Data Pendaftaran
                $iddaftar = $row["iddaftar"];
                $ipk = $row["ipk"];
                $kti = $row["kti"];
                $ba = $row["ba"];
                $org = $row["org"];
                $seni = $row["seni"];

                // Proses Normalisasi Untuk Setiap Kriteria
                // Jika Tipe Kriteria Adalah Cost Maka Nilai Rendah Lebih Baik
                // Jika Bukan Berarti Dia Termasuk Benefit, Nilai Tinggi Tetap Nilai Baik
                $nipk = ($j_ipk == 'cost') ? 1 - (($ipk - $min_ipk) / ($max_ipk - $min_ipk)) : ($ipk - $min_ipk) / ($max_ipk - $min_ipk);
                $nkti = ($j_kti == 'cost') ? 1 - (($kti - $min_kti) / ($max_kti - $min_kti)) : ($kti - $min_kti) / ($max_kti - $min_kti);
                $nba = ($j_ba == 'cost') ? 1 - (($ba - $min_ba) / ($max_ba - $min_ba)) : ($ba - $min_ba) / ($max_ba - $min_ba);
                $norg = ($j_org == 'cost') ? 1 - (($org - $min_org) / ($max_org - $min_org)) : ($org - $min_org) / ($max_org - $min_org);
                $nseni = ($j_seni == 'cost') ? 1 - (($seni - $min_seni) / ($max_seni - $min_seni)) : ($seni - $min_seni) / ($max_seni - $min_seni);

                // Hitung Nilai Normalisasi Dengan Bobot dan Menghasilkan Nilai Preferensi
                $preferensi = ($nipk * $bobot_ipk) + ($nkti * $bobot_kti) + ($nba * $bobot_ba) + ($norg * $bobot_org) + ($nseni * $bobot_seni);

                // Hapus Data Perangkingan Lama
                $sql_delete = "DELETE FROM perangkingan WHERE iddaftar='$iddaftar'";
                $conn->query($sql_delete);

                // Simpan Data Perangkingan Baru
                $sql_insert = "INSERT INTO perangkingan VALUES (NULL, '$iddaftar', '$nipk', '$nkti', '$nba', '$norg', '$nseni', '$preferensi')";
                if ($conn->query($sql_insert) === TRUE) {
                    header("Location:?page=perangkingan&thn=$tahun");
                }
            }
        } else {
?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Data Tidak Ditemukan</strong>
            </div>
<?php
        }
    } else {
        echo "Metode yang dipilih bukan SAW";
    }
}
?>

<style>
    /* Style agar nampak lebih baik */
    .accordion {
        display: flex;
        flex-direction: column;
    }

    .accordion-item {
        border: 1px solid #ddd;
        margin-bottom: 5px;
        overflow: hidden;
    }

    .accordion-header {
        padding: 10px;
        background-color: #f1f1f1;
        cursor: pointer;
    }

    .accordion-content {
        padding: 10px;
    }
</style>

<div class="accordion card">
    <div class="accordion-item">
        <div class="accordion-header card-header bg-primary text-white border-dark" onclick="toggleAccordion(0)">
            <div class="row">
                <div class="col">
                    <span><i class="">Metode SAW</i></span>
                </div>
                <div class="col-auto">
                    <span><i class="fas fa-lg fa-chevron-circle-down"></i></span>
                </div>
            </div>
        </div>
        <div class="accordion-content">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="">Tahun</label>
                    <select class="form-control chosen" data-placeholder="Pilih Tahun" name="tahun">
                        <option value="<?php echo $_GET['thn']; ?>"><?php echo $_GET['thn']; ?></option>
                        <?php
                        for ($x = date("Y"); $x >= 2019; $x--) {
                        ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <input class="btn btn-primary mb-2" type="submit" name="proses" value="Proses">
            </form>
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th width="100px">No</th>
                        <th width="100px">NIM</th>
                        <th width="200px">Nama Mahasiswa</th>
                        <th width="100px">n_IPK</th>
                        <th width="100px">n_KTI</th>
                        <th width="100px">n_BA</th>
                        <th width="100px">n_ORG</th>
                        <th width="100px">n_SENI</th>
                        <th width="100px">Preferensi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $sql = "SELECT perangkingan.idperangkingan, perangkingan.iddaftar, pendaftaran.tgldaftar,pendaftaran.tahun,pendaftaran.nim,perangkingan.n_ipk,perangkingan.n_kti,perangkingan.n_ba,perangkingan.n_org,perangkingan.n_seni,perangkingan.preferensi, mahasiswa.nama_mahasiswa 
                FROM perangkingan INNER JOIN pendaftaran ON perangkingan.iddaftar = pendaftaran.iddaftar 
                INNER JOIN mahasiswa ON pendaftaran.nim = mahasiswa.nim ORDER BY preferensi DESC";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['nim']; ?></td>
                            <td><?php echo $row['nama_mahasiswa']; ?></td>
                            <td><?php echo $row['n_ipk']; ?></td>
                            <td><?php echo $row['n_kti']; ?></td>
                            <td><?php echo $row['n_ba']; ?></td>
                            <td><?php echo $row['n_org']; ?></td>
                            <td><?php echo $row['n_seni']; ?></td>
                            <td><?php echo $row['preferensi']; ?></td>
                        </tr>
                    <?php
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header card-header bg-secondary text-white border-dark" onclick="toggleAccordion(0)">
            <div class="row">
                <div class="col">
                    <span><i class="">Metode ARAS</i></span>
                </div>
                <div class="col-auto">
                    <span><i class="fas fa-lg fa-chevron-circle-down"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAccordion(index) {
        var accordionItem = document.querySelectorAll('.accordion-item')[index];
        var accordionContent = accordionItem.querySelector('.accordion-content');

        // Toggle display: none
        accordionContent.style.display = (accordionContent.style.display === 'none') ? 'block' : 'none';
    }
</script>
















<?php
if (isset($_POST['update'])) {
    $iddaftar = $_POST['iddaftar'];
    $idk = $_POST['idk'];
    $value = $_POST['value'];

    // Pastikan memakai prepared statement untuk menghindari SQL injection
    $sql_update = "UPDATE perangkingan SET value = ? WHERE iddaftar = ? AND idk = ?";
    $stmt = $conn->prepare($sql_update);
} else if (isset($_GET['idd']) && isset($_GET['idk'])) {
    $iddaftar = $_GET['idd'];
    $idk = $_GET['idk'];

    // Query untuk mengambil data pendaftaran berdasarkan idd
    $sql_pendaftaran_data = "SELECT nim FROM pendaftaran WHERE iddaftar = $iddaftar";
    $result_pendaftaran_data = $conn->query($sql_pendaftaran_data);

    if ($result_pendaftaran_data->num_rows > 0) {
        // Ambil data pendaftaran
        $rowPendaftaran = $result_pendaftaran_data->fetch_assoc();

        // Query untuk mengambil data perangkingan
        $sql_perangkingan = "SELECT * FROM perangkingan WHERE iddaftar = $iddaftar AND idk = $idk";
        $result_perangkingan = $conn->query($sql_perangkingan);

        if ($result_perangkingan->num_rows > 0) {
            $perangkingan = $result_perangkingan->fetch_object();

            // Query untuk mengambil data dokumen berdasarkan kid
            $sql_dokumen_data = "SELECT gname FROM dokumen WHERE kid = $idk";
            $result_dokumen_data = $conn->query($sql_dokumen_data);

            if ($result_dokumen_data->num_rows > 0) {
                // Ambil data dokumen
                $rowDokumen = $result_dokumen_data->fetch_assoc();
?>
                <form action="" method="post">
                    <h5>Lihat Dokumen</h5>
                    <a href='uploads/<?php echo $rowPendaftaran['nim']; ?>/<?php echo $idk; ?>/<?php echo $rowDokumen['gname']; ?>' target='_blank'>
                        <span class="fas fa-eye"></span>
                    </a> <br> <br>
                    <input type="hidden" name="iddaftar" value="<?= $perangkingan->iddaftar ?>">
                    <input type="hidden" name="idk" value="<?= $perangkingan->idk ?>">
                    <label for="value">Nilai:</label>
                    <input type="text" name="value" value="<?= $perangkingan->value ?>">
                    <button type="submit" name="update">Simpan Perubahan</button>
                </form>
<?php
            } else {
                echo "Data dokumen tidak ditemukan.";
            }
        } else {
            echo "Data perangkingan tidak ditemukan.";
        }
    } else {
        echo "Data pendaftaran tidak ditemukan.";
    }
} else {
    echo "ID Kriteria (idk) atau ID Daftar (iddaftar) tidak ditemukan.";
}
?>