<?php

$nim = $_GET['nim'];

$sql = "DELETE FROM mahasiswa WHERE nim='$nim'";
if ($conn->query($sql) === TRUE) {
    echo 'Data Berhasil Dihapus';
}
$conn->close();
