<?php
// Include file konfigurasi database
require_once "config.php";

// Pesan kesalahan atau keberhasilan
$message = "";

// Cek apakah formulir telah dikirim
if (isset($_POST['submit'])) {
    // Mendapatkan nilai dari input form
    $gid = $_POST['gid'];
    $kid = $_POST['kid'];

    // Validasi
    $checkQuery = "SELECT * FROM dokumen WHERE gid = '$gid' AND kid = '$kid'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $message = "Error: Data dengan GID dan KID yang sama sudah ada.";
    } else {
        // Konfigurasi direktori penyimpanan file
        $uploadDirectory = "uploads/";

        // Membuat direktori berdasarkan gid dan kid
        $gidDir = $uploadDirectory . $gid . '/';
        $kidDir = $gidDir . $kid . '/';

        if (!is_dir($gidDir)) {
            mkdir($gidDir);
        }

        if (!is_dir($kidDir)) {
            mkdir($kidDir);
        }

        // Mendapatkan informasi file
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        // Menyiapkan variabel untuk menyimpan pesan kesalahan
        $uploadError = "";

        // Memeriksa apakah tidak ada kesalahan saat pengunggahan
        if ($fileError === 0) {
            // Nama unik file disederhanakan menjadi nama asli file
            $targetPath = $kidDir . $fileName;

            // Pindahkan file ke direktori penyimpanan
            if (move_uploaded_file($fileTmpName, $targetPath)) {
                // Menyimpan informasi file ke dalam tabel dokumen
                $insertQuery = "INSERT INTO dokumen (gid, kid, gname, glok) VALUES ('$gid', '$kid', '$fileName', '$targetPath')";
                if ($conn->query($insertQuery) === TRUE) {
                    $message = "File berhasil diunggah dan informasi file disimpan ke dalam database.";
                } else {
                    $message = "Error: " . $conn->error;
                }
            } else {
                $message = "Terjadi kesalahan saat mengunggah file.";
            }
        } else {
            $message = "Terjadi kesalahan saat mengunggah file.";
        }
    }
}
?>

<h2>Form Upload File</h2>

<!-- Menampilkan pesan kesalahan atau keberhasilan -->
<?php if (!empty($message)) : ?>
    <div>
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<!-- Form untuk mengunggah file -->
<form action="" method="POST" enctype="multipart/form-data">
    <label for="file">Pilih File</label>
    <input type="file" name="file" id="file" required>
    <input type="hidden" name="gid" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">

    <!-- Menampilkan data dari tabel kriteria dalam opsi -->
    <label for="kid">Pilih Jenis Dokumen</label>
    <select name="kid" id="kid" required>
        <?php
        // Ambil data dari tabel kriteria
        $queryKriteria = "SELECT idk, nama_k, metode FROM kriteria";
        $resultKriteria = $conn->query($queryKriteria);

        // Loop untuk menampilkan opsi
        while ($rowKriteria = $resultKriteria->fetch_assoc()) {
            $nama_k = $rowKriteria['nama_k'];
            $metode = $rowKriteria['metode'];
            $idKriteria = $rowKriteria['idk'];

            echo "<option value='$idKriteria'>$nama_k - $metode</option>";
        }
        ?>
    </select>

    <button type="submit" name="submit">Unggah</button>
</form>

<h2>Gambar yang Sudah Diupload</h2>

<?php
// Ambil data dokumen berdasarkan gid
$gid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$queryDocuments = "SELECT d.*, k.nama_k, k.metode
                    FROM dokumen d
                    JOIN kriteria k ON d.kid = k.idk
                    WHERE d.gid = '$gid'";
$resultDocuments = $conn->query($queryDocuments);
?>

<?php if ($resultDocuments->num_rows > 0) : ?>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Dokumen</th>
                <th>Jenis Dokumen</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rowDocument = $resultDocuments->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $rowDocument['gname']; ?></td>
                    <td><?php echo $rowDocument['nama_k']; ?> - <?php echo $rowDocument['metode']; ?></td>
                    <td>
                        <a href="<?php echo $rowDocument['glok']; ?>" target="_blank" class="btn btn-primary">Lihat Gambar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Tidak ada gambar yang diupload untuk GID ini.</p>
<?php endif; ?>