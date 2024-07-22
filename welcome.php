<?php
// Query untuk menghitung jumlah data di tabel mahasiswa
$sql = "SELECT COUNT(*) as jumlah FROM mahasiswa";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mengambil data hasil query
    $row = $result->fetch_assoc();
    $total_mahasiswa = $row['jumlah'];
} else {
    $total_mahasiswa = 0;
}

// Query untuk menghitung jumlah data di tabel pendaftaran
$sql = "SELECT COUNT(*) as jumlah FROM pendaftaran";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mengambil data hasil query
    $row = $result->fetch_assoc();
    $total_pendaftaran = $row['jumlah'];
} else {
    $total_pendaftaran = 0;
}

// Query untuk menghitung jumlah data di tabel users
$sql = "SELECT COUNT(*) as jumlah FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mengambil data hasil query
    $row = $result->fetch_assoc();
    $total_users = $row['jumlah'];
} else {
    $total_users = 0;
}

// Menutup koneksi
$conn->close();
?>
<?php
if ($_SESSION['level'] == "Admin") {
?>
    <div class="space-y-16 py-8 xl:space-y-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Dashboard</h2>
                </div>
                <ul role="list" class="mt-6 grid gap-x-6 gap-y-8 justify-center items-center text-center lg:grid-cols-3 xl:gap-x-8">
                    <li class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                            <img src="https://tailwindui.com/img/logos/48x48/tuple.svg" alt="Tuple" class="h-12 w-12 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10">
                            <div class="text-sm font-medium leading-6 text-gray-900">Mahasiswa</div>
                        </div>
                        <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                            <div class="flex justify-between gap-x-4 py-3">
                                <dt class="text-gray-500">Total</dt>
                                <dd class="flex items-start gap-x-2">
                                    <div class="font-medium text-gray-900"><?php echo $total_mahasiswa; ?></div>
                                </dd>
                            </div>
                        </dl>
                    </li>
                    <li class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                            <img src="https://tailwindui.com/img/logos/48x48/reform.svg" alt="Reform" class="h-12 w-12 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10">
                            <div class="text-sm font-medium leading-6 text-gray-900">Pendaftar Beasiswa</div>
                        </div>
                        <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                            <div class="flex justify-between gap-x-4 py-3">
                                <dt class="text-gray-500">Total</dt>
                                <dd class="flex items-start gap-x-2">
                                    <div class="font-medium text-gray-900"><?php echo $total_pendaftaran; ?></div>
                                </dd>
                            </div>
                        </dl>
                    </li>
                    <li class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                            <img src="https://tailwindui.com/img/logos/48x48/reform.svg" alt="Reform" class="h-12 w-12 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10">
                            <div class="text-sm font-medium leading-6 text-gray-900">Users</div>
                        </div>
                        <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                            <div class="flex justify-between gap-x-4 py-3">
                                <dt class="text-gray-500">Total</dt>
                                <dd class="flex items-start gap-x-2">
                                    <div class="font-medium text-gray-900"><?php echo $total_users; ?></div>
                                </dd>
                            </div>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
    </div>



    <div class="bg-white px-6 py-32 lg:px-8">
        <p class="text-xl font-bold leading-7">Perkenalan</p>
        <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Metode SAW</h1>
            <p class="mt-6 leading-8">Metode SAW (Simple Additive Weighting) adalah metode pengambilan keputusan multikriteria yang digunakan untuk mengevaluasi dan memilih alternatif terbaik berdasarkan beberapa kriteria yang telah ditentukan. Metode ini menggabungkan nilai dari setiap kriteria yang telah dinormalisasi dan diberi bobot sesuai dengan kepentingannya. Prosesnya melibatkan:</p>
            <div class="mt-6 max-w-2xl">
                <p>1. Normalisasi: Mengubah nilai kriteria menjadi skala yang sebanding.<br>
                    2. Pembobotan: Mengalikan nilai normalisasi dengan bobot kriteria.<br>
                    3. Agregasi: Menjumlahkan nilai berbobot untuk mendapatkan skor total.<br>
                    4. Rangking: Menentukan urutan alternatif berdasarkan skor total.</p>
            </div>
        </div>

        <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Metode ARAS</h1>
            <p class="mt-6 leading-8">Metode ARAS (Additive Ratio Assessment) adalah metode pengambilan keputusan multikriteria yang menilai dan memilih alternatif terbaik melalui perbandingan aditif dari nilai-nilai kriteria. Metode ini melibatkan:</p>
            <div class="mt-6 max-w-2xl">
                <p>1. Normalisasi: Membandingkan nilai setiap alternatif terhadap total nilai kriteria.<br>
                    2. Agregasi: Menjumlahkan nilai normalisasi untuk setiap alternatif untuk mendapatkan skor agregat.<br>
                    3. Rangking: Menentukan urutan alternatif berdasarkan skor agregat, di mana alternatif dengan skor tertinggi adalah yang terbaik.</p>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
if ($_SESSION['level'] == "Mahasiswa") {
?>

    <div class="bg-white px-6 py-32 lg:px-8">
        <p class="text-xl font-bold leading-7">Langkah Langkah</p>
        <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Pendaftaran</h1>
            <div class="mt-6 max-w-2xl">
                <p>1. Lengkapi indentitas diri anda di halaman profile.<br>
                    2. Upload dokumen yang dibutuhkan.<br>3. Tunggu proses validasi.
                </p>
            </div>
        </div>
    </div>
<?php
}
?>