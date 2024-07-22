<?php
// Proses Mengambil Data Pendaftaran
$i = 1;
$alternatif = array();
$sql = 'SELECT * FROM pendaftaran';
$data = $conn->query($sql);
// Kemudian Mengisi Array $alternatif Dengan Data Dari Database
while ($row = $data->fetch_object()) {
    $alternatif[$row->iddaftar] = $row->name;
}

// Proses Mengambil Data Jenis Kriteria
$nama_jenis_k = array();
$sql = 'SELECT * FROM kriteria WHERE metode = "ARAS"';
$data = $conn->query($sql);
while ($row = $data->fetch_object()) {
    $nama_jenis_k[$row->idk] = $row->nama_k;
}
?>
<!-- Proses Matriks Keputusan (X) -->
<?php
$keputusan = array();
$sql = 'SELECT perangkingan.*, kriteria.nama_k AS nama_kriteria
        FROM perangkingan 
        JOIN kriteria ON perangkingan.idk = kriteria.idk
        WHERE perangkingan.idk IN (SELECT idk FROM kriteria WHERE metode = "ARAS")';
$data = $conn->query($sql);
while ($row = $data->fetch_object()) {
    $idd = $row->iddaftar;
    $idk = $row->idk;
    $nilai = $row->value;
    $nama_kriteria = $row->nama_kriteria;

    if (!isset($keputusan[$idd][$idk])) {
        $keputusan[$idd][$idk] = array(
            'nilai' => $nilai,
            'nama_kriteria' => $nama_kriteria
        );
    }
}
?>

<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">Penilaian ARAS</h1>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="print_aras.php" target="_blank" class="block rounded-md bg-indigo-600 px-3 py-2 text-center font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Print, PDF & EXCEL</a>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none"> <a href="?page=pendaftaran&action=tambah" class="block rounded-md bg-indigo-600 px-3 py-2 text-center  font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tambah</a> </div>
    </div>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left  font-semibold text-gray-900 sm:pl-6">No</th>
                                <th scope="col" class="px-3 py-3.5 text-left  font-semibold text-gray-900">Nama</th>
                                <th scope="col" class="px-3 py-3.5 text-center font-semibold text-gray-900" colspan="<?php echo count($nama_jenis_k); ?>">Kriteria</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($keputusan as $idd => $row) : ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3  font-medium text-gray-900 sm:pl-6"><?php echo $idd; ?></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-900"><?php echo isset($alternatif[$idd]) ? $alternatif[$idd] : ''; ?></td>
                                    <?php foreach ($row as $idk => $data) : ?>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-900 text-center">
                                            <b>
                                                <?php echo $data['nama_kriteria']; ?>
                                            </b>
                                            <br>
                                            <?php echo $data['nilai']; ?><br>
                                            <a href="?page=penilaian_saw&action=update&idd=<?= $idd ?>&idk=<?= $idk ?>">
                                                <span class="text-sm">Edit</span>
                                            </a>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-900 text-center">
                                        <a onclick="return confirm('Yakin Ingin Menghapus Data ini ?')" class="btn btn-danger" href="?page=penilaian_saw&action=hapus&iddaftar=<?php echo $idd; ?>">
                                            <span class="text-sm">Hapus</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>