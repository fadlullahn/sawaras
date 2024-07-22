<?php
$alternatives = array();
$sql_alternatives = 'SELECT * FROM pendaftaran';
$data_alternatives = $conn->query($sql_alternatives);
while ($row_alternatives = $data_alternatives->fetch_object()) {
    $alternatives[$row_alternatives->iddaftar] = $row_alternatives->name;
}
?>

<?php
$criteria_data = array();
$bobot = array();

// Tambahkan kondisi WHERE untuk memilih kriteria dengan metode SAW 
$sql_criteria = 'SELECT * FROM kriteria WHERE metode = "SAW"';

$data_criteria = $conn->query($sql_criteria);

while ($row_criteria = $data_criteria->fetch_object()) {
    $criteria_data[$row_criteria->idk] = array($row_criteria->nama_k, $row_criteria->jenis_k);
    $bobot[$row_criteria->idk] = $row_criteria->bobot;
}
?>

<?php
$i = 1;
$decision_matrix = array();
// Mengubah query untuk melakukan JOIN antara tabel perangkingan dan kriteria
$sql_decision_matrix = 'SELECT perangkingan.*, kriteria.nama_k 
                       FROM perangkingan 
                       JOIN kriteria ON perangkingan.idk = kriteria.idk 
                       WHERE kriteria.metode = "SAW"';
$data_decision_matrix = $conn->query($sql_decision_matrix);

while ($row_decision_matrix = $data_decision_matrix->fetch_object()) {
    $j = $row_decision_matrix->idk;
    $v = $row_decision_matrix->value;
    $nama_k = $row_decision_matrix->nama_k;
    $decision_matrix[$row_decision_matrix->iddaftar][$j] = array(
        'value' => $v,
        'nama_k' => $nama_k
    );
}
?>

<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">Penilaian SAW</h1>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="print_saw.php" target="_blank" class="block rounded-md bg-indigo-600 px-3 py-2 text-center font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Print, PDF & EXCEL</a>
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
                                <th scope="col" class="px-3 py-3.5 text-center font-semibold text-gray-900" colspan="<?php echo count($criteria_data); ?>">Kriteria</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($decision_matrix as $iddaftar => $criteria_values) : ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3  font-medium text-gray-900 sm:pl-6"><?php echo $i++ ?></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-900"><?= isset($alternatives[$iddaftar]) ? $alternatives[$iddaftar] : ''; ?></td>
                                    <?php foreach ($criteria_values as $idk => $data) : ?>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-900 text-center">
                                            <b>
                                                <?= $data['nama_k'] ?>
                                            </b>
                                            <br>
                                            <?= $data['value'] ?>
                                            <br>
                                            <a href="?page=penilaian_saw&action=update&idd=<?= $iddaftar ?>&idk=<?= $idk ?>">
                                                <span class="text-sm">Edit</span>
                                            </a>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-900 text-center">
                                        <a onclick="return confirm('Yakin Ingin Menghapus Data ini ?')" class="btn btn-danger" href="?page=penilaian_saw&action=hapus&iddaftar=<?php echo $iddaftar; ?>">
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