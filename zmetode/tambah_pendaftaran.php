<?php
// Fungsi untuk mendapatkan iddaftar yang belum digunakan
function getAvailableIdDaftar($conn)
{
    $sql = "SELECT iddaftar FROM pendaftaran ORDER BY iddaftar";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $currentIdDaftar = 1;

        while ($row = $result->fetch_assoc()) {
            if ($row['iddaftar'] != $currentIdDaftar) {
                return $currentIdDaftar;
            }

            $currentIdDaftar++;
        }
    }

    return $currentIdDaftar;
}

// Ambil data nim dan nama_mahasiswa dari tabel mahasiswa
$getMahasiswa = "SELECT nim, nama_mahasiswa FROM mahasiswa";
$Mahasiswa = $conn->query($getMahasiswa);

// Proses tambah pendaftaran
if (isset($_POST['simpan'])) {
    $ambilNIM = $_POST['nim'];

    // Ambil data nama_mahasiswa dari tabel mahasiswa berdasarkan nim yang dipilih
    $sqlNamaMahasiswa = "SELECT nama_mahasiswa FROM mahasiswa WHERE nim = '$ambilNIM'";
    $NamaMahasiswa = $conn->query($sqlNamaMahasiswa);

    if ($NamaMahasiswa->num_rows > 0) {
        $rowNamaMahasiswa = $NamaMahasiswa->fetch_assoc();
        $name = $rowNamaMahasiswa['nama_mahasiswa'];

        // Mendapatkan iddaftar yang belum digunakan
        $lastInsertedId = getAvailableIdDaftar($conn);

        // Tambahkan data pendaftaran ke tabel pendaftaran
        $sqlPendaftaran = "INSERT INTO pendaftaran (iddaftar, nim, name) VALUES ('$lastInsertedId', '$ambilNIM', '$name')";

        if ($conn->query($sqlPendaftaran) === TRUE) {
            echo "Data pendaftaran berhasil disimpan.";

            // Ambil semua data kriteria dari tabel kriteria
            $sqlKriteria = "SELECT idk FROM kriteria";
            $resultKriteria = $conn->query($sqlKriteria);

            if ($resultKriteria->num_rows > 0) {
                while ($rowKriteria = $resultKriteria->fetch_assoc()) {
                    $idk = $rowKriteria['idk'];

                    // Tambahkan data ke tabel perangkingan dengan nilai 0
                    $sqlPerangkingan = "INSERT INTO perangkingan (iddaftar, idk, value) VALUES ('$lastInsertedId', '$idk', 0)";

                    if ($conn->query($sqlPerangkingan) !== TRUE) {
                        echo "Error: " . $sqlPerangkingan . "<br>" . $conn->error;
                    }
                }
                echo "Data perangkingan berhasil disimpan.";
                header("Location:?page=penilaian_saw");
            } else {
                echo "Tidak ada data kriteria.";
            }
        } else {
            echo "Error: " . $sqlPendaftaran . "<br>" . $conn->error;
        }
    } else {
        echo "Nama mahasiswa tidak ditemukan untuk NIM tersebut.";
    }
}
?>

<form action="" method="POST">
    <div class="space-y-12 sm:space-y-16">
        <div class="items-center justify-center grid grid-cols-3">
            <h2 class="font-bold leading-7 text-gray-900 text-center">Tambah Pendaftar</h2>
            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="nim">NIM:</label>
                    <select class="chosen block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" name="nim" required>
                        <?php
                        while ($row_mahasiswa = $Mahasiswa->fetch_assoc()) {
                            echo "<option value='" . $row_mahasiswa['nim'] . "'>" . $row_mahasiswa['nim'] . "</option>";
                        }
                        ?>
                    </select><br>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6 flex items-center justify-center gap-x-6">
        <a href="?page=users" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
        <input type="submit" name="simpan" value="Simpan" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
    </div>
</form>