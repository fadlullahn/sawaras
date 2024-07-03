<?php

if (isset($_POST['update'])) {

    // Ambil Data Dari Input Yang Mau Di Update
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $fak = $_POST['fak'];
    $prodi = $_POST['prodi'];

    // Proses Update Data Mahasiswa
    $sql = "UPDATE mahasiswa SET nama_mahasiswa='$nama', alamat='$alamat', telp='$telp', fak='$fak', prodi='$prodi' WHERE nim='$nim'";
    if ($conn->query($sql) === TRUE) {
        echo 'Updated';
    }
}

// Memanggil Data Yang Mau Di Edit
$nim = $_GET['nim'];

$sql = "SELECT * FROM mahasiswa WHERE nim='$nim'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>


<form action="" method="POST">
    <div class="space-y-12 sm:space-y-16">
        <div class="items-center justify-center grid grid-cols-3">
            <?php
            if ($_SESSION['level'] == "Admin") {
            ?>
                <h2 class="font-bold leading-7 text-gray-900 text-center">Update Data Mahasiswa</h2>
            <?php
            }
            ?>
            <?php
            if ($_SESSION['level'] == "Mahasiswa") {
            ?>
                <h2 class="font-bold leading-7 text-gray-900 text-center">Profile</h2>
            <?php
            }
            ?>
            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5 for="">NIM</label>
                    <div class=" mt-2 sm:col-span-2 sm:mt-0">
                        <input type=" text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["nim"] ?>" name="nim" readonly>
                </div>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5 for="">Nama</label>
                    <div class=" mt-2 sm:col-span-2 sm:mt-0">
                    <input type=" text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["nama_mahasiswa"] ?>" name="nama" maxlength="100" required>

            </div>
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
            <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5 for="">Alamat</label>
                    <div class=" mt-2 sm:col-span-2 sm:mt-0">
                <input type=" text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["alamat"] ?>" name="alamat" maxlength="100">
        </div>
    </div>
    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
        <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5 for="">No. Telepon</label>
                    <div class=" mt-2 sm:col-span-2 sm:mt-0">
            <input type=" text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["telp"] ?>" name="telp" maxlength="15">

    </div>
    </div>
    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
        <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5 for="">Fakultas</label>
                    <div class=" mt-2 sm:col-span-2 sm:mt-0">
            <input type=" text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["fak"] ?>" name="fak" maxlength="50">
    </div>
    </div>
    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
        <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5 for="">Prodi</label>
                    <div class=" mt-2 sm:col-span-2 sm:mt-0">
            <input type=" text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" value="<?php echo $row["prodi"] ?>" name="prodi" maxlength="50">

    </div>

    </div>

    </div>

    </div>
    </div>
    <div class="mt-6 flex items-center justify-center gap-x-6">
        <?php
        if ($_SESSION['level'] == "Admin") {
        ?>
            <a class="text-sm font-semibold leading-6 text-gray-900" href="?page=mahasiswa">Batal</a>
        <?php
        }
        ?>
        <input class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" name="update" value="Update">
    </div>
</form>