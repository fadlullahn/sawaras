<?php
$u = 1;
$iu = 1;
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
$sql_criteria = 'SELECT * FROM kriteria WHERE metode = "SAW"';
$data_criteria = $conn->query($sql_criteria);
while ($row_criteria = $data_criteria->fetch_object()) {
    $criteria_data[$row_criteria->idk] = array($row_criteria->nama_k, $row_criteria->jenis_k);
    $bobot[$row_criteria->idk] = $row_criteria->bobot;
}
?>

<?php
$decision_matrix = array();
$sql_decision_matrix = 'SELECT perangkingan.*, kriteria.nama_k FROM perangkingan 
                       JOIN kriteria ON perangkingan.idk = kriteria.idk
                       WHERE perangkingan.idk IN (SELECT idk FROM kriteria WHERE metode = "SAW")';
$data_decision_matrix = $conn->query($sql_decision_matrix);
$min_values = array();
$max_values = array();
$sql_kriteria_values = 'SELECT idk, MIN(nilai_min) AS nilai_min, MAX(nilai_max) AS nilai_max FROM kriteria WHERE metode = "SAW" GROUP BY idk';
$data_kriteria_values = $conn->query($sql_kriteria_values);

while ($row_kriteria_values = $data_kriteria_values->fetch_object()) {
    $min_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_min;
    $max_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_max;
}

while ($row_decision_matrix = $data_decision_matrix->fetch_object()) {
    $j = $row_decision_matrix->idk;
    $v = $row_decision_matrix->value;
    $decision_matrix[$row_decision_matrix->iddaftar][$j] = array(
        'value' => $v,
        'nama_k' => $row_decision_matrix->nama_k
    );
}
?>

<?php
$normalized_matrix = array();
foreach ($decision_matrix as $i => $x_i) {
    $normalized_matrix[$i] = array();
    foreach ($x_i as $j => $x_ij) {
        if ($criteria_data[$j][1] == 'cost') {
            $normalized_matrix[$i][$j] = $min_values[$j] / $x_ij['value'];
        } else {
            $normalized_matrix[$i][$j] = $x_ij['value'] / $max_values[$j];
        }
    }
}
?>

<?php
$preference_values = array();
foreach ($normalized_matrix as $i => $r_i) {
    $preference_values[$i] = 0;
    foreach ($r_i as $j => $r_ij) {
        $preference_values[$i] += $bobot[$j] * $r_ij;
    }
}

arsort($preference_values);
?>
<div class="flex">
    <div class="px-4 sm:px-6 lg:px-8 mt-8 w-1/2">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="font-bold text-xl leading-6 text-gray-900">1. Perangkingan SAW</h1>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left  font-semibold text-gray-900 sm:pl-6">Rank</th>
                                    <th scope="col" class="px-3 py-3.5 text-left  font-semibold text-gray-900">Nama</th>
                                    <th scope="col" class="px-3 py-3.5 text-left  font-semibold text-gray-900">Preferensi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <?php
                                $rank = 1;
                                foreach ($preference_values as $i => $preference) : ?>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3  font-medium text-gray-900 sm:pl-6"><?= $rank ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-900"><?= $alternatives[$i] ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-900"><?= $preference ?></td>
                                    </tr>
                                <?php
                                    $rank++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <?php
    // Proses Mengambil Data Pendaftaran
    $u = 1;
    $alternatif = array();
    $sqlp = 'SELECT iddaftar, name FROM pendaftaran';
    $data = $conn->query($sqlp);
    // Kemudian Mengisi Array $alternatif Dengan Data Dari Database
    while ($row = $data->fetch_object()) {
        $alternatif[$row->iddaftar] = $row->name;
    }
    // Proses Mengambil Data Bobot Dan Jenis Kriteria
    $nama_jenis_k = array();
    $sqlk = 'SELECT * FROM kriteria WHERE metode = "ARAS"';
    $data = $conn->query($sqlk);
    while ($row = $data->fetch_object()) {
        $nama_jenis_k[$row->idk] = array($row->nama_k, $row->jenis_k);
        $bobot[$row->idk] = $row->bobot;
    }
    ?>
    <!-- Proses Matriks Keputusan (X) -->
    <?php
    $keputusan = array();
    $nilaiterbaik = array();
    $sqlpk = 'SELECT perangkingan.* , kriteria.nama_k
        FROM perangkingan 
        JOIN kriteria ON perangkingan.idk = kriteria.idk
        WHERE perangkingan.idk IN (SELECT idk FROM kriteria WHERE metode = "ARAS") ORDER BY iddaftar ASC';
    $data = $conn->query($sqlpk);
    while ($row = $data->fetch_object()) {
        $idd = intval($row->iddaftar);
        $idk = intval($row->idk);
        $nilai = $row->value;

        if (!isset($keputusan[$idd][$idk])) {
            $keputusan[$idd][$idk] = $nilai;
        }

        if (!isset($nilaiterbaik[$idk])) $nilaiterbaik[$idk] = ($nama_jenis_k[$idk][1] == 'cost') ? 10 : 0;
        $nilaiterbaik[$idk] = ($nama_jenis_k[$idk][1] == 'cost') ? ($nilaiterbaik[$idk] < $nilai ? $nilaiterbaik[$idk] : $nilai) : ($nilaiterbaik[$idk] > $nilai ? $nilaiterbaik[$idk] : $nilai);
    }
    array_unshift($keputusan, $nilaiterbaik);
    ?>

    <?php
    $u1 = 1;
    $total = array();
    foreach ($keputusan as $idd => $nilaialternatif) {
        foreach ($nilaialternatif as $idk => $nilaiakurat) {
            if (!isset($total[$idk])) $total[$idk] = 0;
            $total[$idk] += ($nama_jenis_k[$idk][1] == 'cost' && $nilaiakurat != 0) ? 1 / $nilaiakurat : ($nilaiakurat != 0 ? $nilaiakurat : 1);
        }
    }

    $normalisasi = array();
    foreach ($keputusan as $idd => $nilaialternatif) {
        foreach ($nilaialternatif as $idk => $nilaiakurat) {
            $normalisasi[$idd][$idk] = ($nama_jenis_k[$idk][1] == 'cost' && $nilaiakurat != 0 && $total[$idk] != 0) ? ((1 / $nilaiakurat) / $total[$idk]) : (($nilaiakurat != 0 && $total[$idk] != 0) ? ($nilaiakurat / $total[$idk]) : 0);
        }
    }
    ?>

    <?php
    $u2 = 1;
    $ternormalisasi = array();
    foreach ($normalisasi as $idd => $barisnormalisasi) {
        foreach ($barisnormalisasi as $idk => $nilainormalisasi) {
            $ternormalisasi[$idd][$idk] = $nilainormalisasi * $bobot[$idk];
        }
    }
    ?>

    <?php
    $u3 = 1;
    $optimumS = array();
    foreach ($ternormalisasi as $idd => $baristernormalisasi) {
        $optimumS[$idd] = array_sum($baristernormalisasi);
    }
    ?>

    <?php
    $utilitasK = array();
    foreach ($optimumS as $idd => $barisoptimumS) {
        if ($idd != 0) {
            $utilitasK[$idd] = ($optimumS[0] != 0) ? $barisoptimumS / $optimumS[0] : 0;
        }
    }
    arsort($utilitasK);
    $pilih = key($utilitasK);
    $detail = reset($utilitasK);

    ?>
    <div class="px-4 sm:px-6 lg:px-8 mt-8 w-1/2">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="font-bold text-xl leading-6 text-gray-900">2. Perangkingan ARAS</h1>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left  font-semibold text-gray-900 sm:pl-6">Rank</th>
                                    <th scope="col" class="px-3 py-3.5 text-left  font-semibold text-gray-900">Nama Mahasiswa</th>
                                    <th scope="col" class="px-3 py-3.5 text-left  font-semibold text-gray-900">Optimal Balance (%)</th>
                                </tr>
                            </thead>
                            <?php
                            $rank = 1;
                            foreach ($utilitasK as $nama => $utilitas) : ?>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3  font-medium text-gray-900 sm:pl-6"><?php echo $rank; ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-900"><?php echo $alternatif[$nama]; ?></td>

                                        <td class="whitespace-nowrap px-3 py-4 text-gray-900"><?php echo $utilitas * 100 . "%"; ?></td>
                                    </tr>
                                    <?php
                                    ?>
                                <?php
                                $rank++;
                            endforeach; ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>