<?php
include 'config.php';

if (isset($_POST['simpan'])) {

    // Ambil Data Dari Input
    $nim = $_POST['nim'];
    $nama = $_POST['nama_mahasiswa'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $fak = $_POST['fak'];
    $prodi = $_POST['prodi'];
    $pass = $_POST['pass']; // Ambil password dari input

    // Validasi Data Mahasiswa Berdasarkan NIM
    $sql = "SELECT * FROM mahasiswa WHERE nim='$nim'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
        <script>
            alert("Data Tidak Tersimpan Karena NIM Sudah Digunakan");
        </script>
        <?php
    } else {
        // Proses Simpan Data Mahasiswa
        $sql = "INSERT INTO mahasiswa (nim, nama_mahasiswa, alamat, telp, fak, prodi) VALUES ('$nim','$nama','$alamat','$telp', '$fak', '$prodi')";
        if ($conn->query($sql) === TRUE) {
            // Proses Simpan Data Pengguna
            $pass_md5 = md5($pass); // Enkripsi password dengan MD5
            $sql_user = "INSERT INTO users (username, pass, level, cek) VALUES ('$nim', '$pass_md5', 'Mahasiswa', 'off')";
            if ($conn->query($sql_user) === TRUE) {
        ?>
                <script>
                    alert("Registrasi Berhasil");
                    window.location.href = 'login.php'; // Ganti dengan URL halaman login Anda
                </script>
<?php
            } else {
                echo 'Terjadi Kesalahan pada Tabel Users: ' . $conn->error;
            }
        } else {
            echo 'Terjadi Kesalahan: ' . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="src/style.css">
</head>

<body>
    <h2 class="font-bold leading-7 text-gray-900 text-center mt-10">Register</h2>
    <form action="" method="POST">
        <div class="space-y-12 sm:space-y-16">
            <div class="items-center justify-center grid grid-cols-3 ">
                <h2 class="font-bold leading-7 text-gray-900 text-center"></h2>
                <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0 bg-white px-6 shadow sm:rounded-lg ">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                        <label for="nim" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">NIM</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input type="text" name="nim" id="nim" class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="20" required>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                        <label for="pass" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Password</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input type="password" name="pass" id="pass" class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="100" required>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                        <label for="nama" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Nama Mahasiswa</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="100" required>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                        <label for="alamat" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Alamat</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input type="text" name="alamat" id="alamat" class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="100">
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                        <label for="telp" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">No. Telepon</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input type="text" name="telp" id="telp" class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="15">
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                        <label for="fak" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Fakultas</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input type="text" name="fak" id="fak" class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="50">
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                        <label for="prodi" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Prodi</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input type="text" name="prodi" id="prodi" class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="50">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-center gap-x-6">
            <button type="submit" name="simpan" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
        </div>
        <div class="relative flex justify-center text-sm font-medium leading-6 mt-6">
            <span class="bg-white px-6 text-gray-900">Sudah Punya Akun? <a class="text-indigo-600 hover:text-indigo-900" href="login.php">Login</a></span>
        </div>
    </form>
</body>

</html>