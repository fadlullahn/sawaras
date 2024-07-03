<?php

if (isset($_POST['simpan'])) {

    // Ambil Data Dari Input
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $fak = $_POST['fak'];
    $prodi = $_POST['prodi'];

    // Validasi Data Mahasiswa Berdasarkan NIM
    $sql = "SELECT * FROM mahasiswa WHERE nim='$nim'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Data Tidak Tersimpan Karena NIM Sudah Digunakan</strong>
        </div>
<?php
    } else {
        // Proses Simpan Setelah Di Validasi
        $sql = "INSERT INTO mahasiswa VALUES ('$nim','$nama','$alamat','$telp', '$fak', '$prodi')"; // tambahkan fak dan prodi
        if ($conn->query($sql) === TRUE) {
            echo 'Data Berhasil Ditambah';
        }
    }
}
?>
<form action="" method="POST">
    <div class="space-y-12 sm:space-y-16">
        <div class="items-center justify-center grid grid-cols-3">
            <h2 class="font-bold leading-7 text-gray-900 text-center">Input Data Mahasiswa</h2>
            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="nim" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">NIM</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="nim" id="nim" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="20" required>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="nama" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Nama Mahasiswa</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="nama" id="nama" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="100" required>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="alamat" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Alamat</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="alamat" id="alamat" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="100">
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="telp" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">No. Telepon</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="telp" id="telp" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="15">
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="fak" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Fakultas</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="fak" id="fak" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="50">
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label for="prodi" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Prodi</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="prodi" id="prodi" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="50">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-center gap-x-6">
        <a href="?page=mahasiswa" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
        <button type="submit" name="simpan" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
    </div>
</form>