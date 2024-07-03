<?php
if (isset($_POST['update'])) {

    // Ambil Data Dari Input Yang Mau Di Update
    $idk = $_POST['idk'];
    $nama_k = $_POST['nama_k'];
    $jenis_k = $_POST['jenis_k'];
    $bobot = $_POST['bobot'];
    $nilai_max = $_POST['nilai_max'];
    $nilai_min = $_POST['nilai_min'];
    $metode = $_POST['metode'];

    // Proses Update Data Kriteria
    $sql = "UPDATE kriteria SET nama_k='$nama_k', jenis_k='$jenis_k', bobot='$bobot', nilai_max='$nilai_max', nilai_min='$nilai_min', metode='$metode' WHERE idk='$idk'";
    if ($conn->query($sql) === TRUE) {
        echo 'Updated';
    }
}

// Memanggil Data Yang Mau Di Edit
$idk = $_GET['idk'];

$sql = "SELECT * FROM kriteria WHERE idk='$idk'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="space-y-12 sm:space-y-16">
                <div class="items-center justify-center grid grid-cols-3">
                    <h2 class="font-bold leading-7 text-gray-900 text-center">Update Data Kriteria</h2>
                    <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div hidden class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">ID</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["idk"] ?>" name="idk" readonly>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Metode</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["metode"] ?>" name="metode" readonly>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Nama Kriteria</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["nama_k"] ?>" name="nama_k" maxlength="255" readonly>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Jenis Kriteria</label>
                            <select class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" name="jenis_k" required>
                                <option value="benefit" <?php echo ($row["jenis_k"] == "benefit") ? "selected" : ""; ?>>Benefit</option>
                                <option value="cost" <?php echo ($row["jenis_k"] == "cost") ? "selected" : ""; ?>>Cost</option>
                            </select>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Bobot</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["bobot"] ?>" name="bobot" required>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Nilai Max</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["nilai_max"] ?>" name="nilai_max" required>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="">Nilai Min</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <input type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["nilai_min"] ?>" name="nilai_min" required>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-center gap-x-6">
                <a class="text-sm font-semibold leading-6 text-gray-900" href="?page=kriteria">Batal</a>
                <input class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" name="update" value="Update">
            </div>
        </form>
    </div>
</div>