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
<!-- Tampilan Matriks Keputusan (X) -->
<div class="px-4 sm:px-6 lg:px-8 mt-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">1. Matriks Keputusan (X)</h1>
        </div>
    </div>
    <table class="mt-8 min-w-full divide-y divide-gray-200 border border-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="<?php echo count($nama_jenis_k); ?>">Kriteria</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($keputusan as $idd => $row) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $u++; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        if (isset($alternatif[$idd])) {
                            echo $alternatif[$idd];
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                    <?php foreach ($row as $idk => $nilai) : ?>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <?php
                            echo "<b>";
                            echo $nama_jenis_k[$idk][0]; // Tampilkan nama kriteria
                            echo '</b>';
                            echo '<br>';
                            echo $nilai; // Tampilkan nilai
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Proses Matriks Normalisasi(R) -->
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
<!-- Tampilan Matriks Normalisasi(R) -->
<!--  -->
<div class="px-4 sm:px-6 lg:px-8 mt-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">2. Matriks Normalisasi (R)</h1>
        </div>
    </div>
    <table class="mt-8 min-w-full divide-y divide-gray-200 border border-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="<?php echo count($nama_jenis_k); ?>">Kriteria</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($normalisasi as $idd => $row) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $u1++; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo isset($alternatif[$idd]) ? $alternatif[$idd] : ''; ?></td>
                    <?php foreach ($row as $idk => $nilainormalisasi) : ?>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <?php
                            echo "<b>";
                            echo $nama_jenis_k[$idk][0]; // Tampilkan nama kriteria
                            echo '</b>';
                            echo '<br>';
                            echo $nilainormalisasi; // Tampilkan nilai
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Proses Matriks Ternormalisasi Terbobot (D) -->
<?php
$u2 = 1;
$ternormalisasi = array();
foreach ($normalisasi as $idd => $barisnormalisasi) {
    foreach ($barisnormalisasi as $idk => $nilainormalisasi) {
        $ternormalisasi[$idd][$idk] = $nilainormalisasi * $bobot[$idk];
    }
}
?>
<!-- Tampilan Matriks Ternormalisasi Terbobot (D) -->
<!--  -->
<div class="px-4 sm:px-6 lg:px-8 mt-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">3. Matriks Ternormalisasi Terbobot (D)</h1>
        </div>
    </div>
    <table class="mt-8 min-w-full divide-y divide-gray-200 border border-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="<?php echo count($nama_jenis_k); ?>">Kriteria</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($ternormalisasi as $idd => $row) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $u2++; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo isset($alternatif[$idd]) ? $alternatif[$idd] : ''; ?></td>
                    <?php foreach ($row as $idk => $nilaiternormalisasi) : ?>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <?php
                            echo "<b>";
                            echo $nama_jenis_k[$idk][0]; // Tampilkan nama kriteria
                            echo '</b>';
                            echo '<br>';
                            echo $nilaiternormalisasi; // Tampilkan nilai
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Proses Nilai Fungsi Optimum (S) -->
<?php
$u3 = 1;
$optimumS = array();
foreach ($ternormalisasi as $idd => $baristernormalisasi) {
    $optimumS[$idd] = array_sum($baristernormalisasi);
}
?>
<!-- Tampilan Nilai Fungsi Optimum (S) -->
<!--  -->
<div class="px-4 sm:px-6 lg:px-8 mt-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">4. Nilai Fungsi Optimum (S)</h1>
        </div>
    </div>
    <table class="mt-8 min-w-full divide-y divide-gray-200 border border-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Fungsi Optimum</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($optimumS as $idd => $detail) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $u3++; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo isset($alternatif[$idd]) ? $alternatif[$idd] : ''; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $detail; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Proses Nilai Utilitas (K)
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
<!-- Tampilan Nilai Utilitas (K) -->
<!--  -->
<div class="px-4 sm:px-6 lg:px-8 mt-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-xl leading-6 text-gray-900">5. Perangkingan ARAS</h1>
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