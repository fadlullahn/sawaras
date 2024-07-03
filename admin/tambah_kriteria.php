<?php
if (isset($_POST['simpan'])) {
    // Ambil data dari input
    $nama_k = $_POST['nama_k'];
    $jenis_k = $_POST['jenis_k'];
    $bobot = $_POST['bobot'];
    $nilai_max = $_POST['nilai_max'];
    $nilai_min = $_POST['nilai_min'];
    $metode = $_POST['metode']; // Menambah input untuk metode

    // Validasi Data K Berdasarkan Nama K dan Metode
    $sql = "SELECT * FROM kriteria WHERE nama_k='$nama_k' AND metode='$metode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Data Tidak Tersimpan Karena Nama K Sudah Digunakan pada Metode yang Sama</strong>
        </div>
<?php
    } else {
        // Proses simpan setelah divalidasi
        $sql_insert_kriteria = "INSERT INTO kriteria (nama_k, jenis_k, bobot, nilai_max, nilai_min, metode) VALUES ('$nama_k', '$jenis_k', '$bobot', '$nilai_max', '$nilai_min', '$metode')";

        if ($conn->query($sql_insert_kriteria) === TRUE) {
            // Mendapatkan idk yang baru ditambahkan
            $new_idk = $conn->insert_id;
            echo 'Tambah Data Berhasil';
        }
    }
}
?>


<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="space-y-12 sm:space-y-16">
                <div class="items-center justify-center grid grid-cols-3">
                    <h2 class="font-bold leading-7 text-gray-900 text-center">Input Data Kriteria</h2>
                    <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label for="metode" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Metode</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <select name="metode" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                                    <option value="SAW">SAW</option>
                                    <option value="ARAS">ARAS</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label for="nama_k" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Nama Kriteria</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" name="nama_k" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" maxlength="255" required>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label for="jenis_k" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Jenis Kriteria</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <select name="jenis_k" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                                    <option value="benefit">Benefit</option>
                                    <option value="cost">Cost</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label for="bobot" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Bobot</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" name="bobot" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label for="nilai_max" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Nilai Max</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" name="nilai_max" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label for="nilai_min" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Nilai Min</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" name="nilai_min" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" required>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-center gap-x-6">
                <a href="?page=kriteria" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
                <input type="submit" name="simpan" value="Simpan" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            </div>
        </form>
    </div>
</div>