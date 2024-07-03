<?php
if (isset($_POST['update'])) {
    $iddaftar = $_POST['iddaftar'];
    $idk = $_POST['idk'];
    $value = $_POST['value'];

    $sql_update = "UPDATE perangkingan SET value = ? WHERE iddaftar = ? AND idk = ?";
    $stmt = $conn->prepare($sql_update);

    if ($stmt) {
        $stmt->bind_param("dii", $value, $iddaftar, $idk);

        if ($stmt->execute()) {
            echo "Perubahan berhasil disimpan.";
            echo '<script>window.history.go(-2);</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else if (isset($_GET['idd']) && isset($_GET['idk'])) {
    $iddaftar = $_GET['idd'];
    $idk = $_GET['idk'];

    $sql_pendaftaran_data = "SELECT nim FROM pendaftaran WHERE iddaftar = $iddaftar";
    $result_pendaftaran_data = $conn->query($sql_pendaftaran_data);

    if ($result_pendaftaran_data->num_rows > 0) {
        $rowPendaftaran = $result_pendaftaran_data->fetch_assoc();

        $sql_perangkingan = "SELECT * FROM perangkingan WHERE iddaftar = $iddaftar AND idk = $idk";
        $result_perangkingan = $conn->query($sql_perangkingan);

        if ($result_perangkingan->num_rows > 0) {
            $perangkingan = $result_perangkingan->fetch_object();

            $sql_dokumen_data = "SELECT gname FROM dokumen WHERE kid = $idk AND gid = '{$rowPendaftaran['nim']}'";
            $result_dokumen_data = $conn->query($sql_dokumen_data);

            $rowDokumen = null;

            if ($result_dokumen_data->num_rows > 0) {
                $rowDokumen = $result_dokumen_data->fetch_assoc();
            }

?>
            <form action="" method="post">
                <div class="space-y-12 sm:space-y-16">
                    <div class="items-center justify-center grid grid-cols-3">
                        <h2 class="font-bold leading-7 text-gray-900 text-center">Input Penilaian</h2>
                        <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                            <div class="flex">
                                <h5 style="margin-right: 20px;">Lihat Dokumen</h5>
                                <?php if ($rowDokumen) : ?>
                                    <a href='uploads/<?php echo $rowPendaftaran['nim']; ?>/<?php echo $idk; ?>/<?php echo $rowDokumen['gname']; ?>' target='_blank'>
                                        <span class="font-bold" style="color: red;">Lihat</span>
                                    </a> <br> <br>
                                <?php else : ?>
                                    <p>Data dokumen tidak ditemukan.</p>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="iddaftar" value="<?= $perangkingan->iddaftar ?>">
                            <input type="hidden" name="idk" value="<?= $perangkingan->idk ?>">

                            <!-- Kondisi Bahasa Inggris dan Organisasi -->
                            <?php
                            if ($perangkingan->idk == 30 || $perangkingan->idk == 33 || $perangkingan->idk == 31 || $perangkingan->idk == 34) {
                            ?>
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="value">Nilai:</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" name="value">
                                            <option value="5" <?= ($perangkingan->value == 5) ? 'selected' : '' ?>>A</option>
                                            <option value="4" <?= ($perangkingan->value == 4) ? 'selected' : '' ?>>B</option>
                                            <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>C</option>
                                            <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>D</option>
                                            <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>E</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Kondisi KTI -->
                            <?php
                            } elseif ($perangkingan->idk == 2 || $perangkingan->idk == 7) {
                            ?>
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="value">Nilai:</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" name="value">
                                            <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>0</option>
                                            <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>1-3</option>
                                            <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>4-6</option>
                                            <option value="4" <?= ($perangkingan->value == 4) ? 'selected' : '' ?>>7-9</option>
                                            <option value="5" <?= ($perangkingan->value == 5) ? 'selected' : '' ?>>10-12</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Kondisi Prestasi -->
                            <?php
                            } elseif ($perangkingan->idk == 32 || $perangkingan->idk == 35) {
                            ?>
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="value">Nilai:</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" name="value">
                                            <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>0</option>
                                            <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>Juara Lokal</option>
                                            <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>Juara Regional</option>
                                            <option value="4" <?= ($perangkingan->value == 4) ? 'selected' : '' ?>>Juara Nasional</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Kondisi Default Input Penilaian -->
                            <?php
                            } else {
                            ?>
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:py-6">
                                    <label class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5" for="value">Nilai:</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" type="text" name="value" value="<?= $perangkingan->value ?>">
                                    </div>
                                </div>
                            <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-center gap-x-6">
                    <button class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" name="update">Simpan Perubahan</button>
                </div>
            </form>
<?php
        } else {
            echo "Data perangkingan tidak ditemukan.";
        }
    } else {
        echo "Data pendaftaran tidak ditemukan.";
    }
} else {
    echo "ID Kriteria (idk) atau ID Daftar (iddaftar) tidak ditemukan.";
}
?>