<?php

$idk = $_GET['idk'];

$sql = "DELETE FROM kriteria WHERE idk='$idk'";
if ($conn->query($sql) === TRUE) {
    echo 'Data Berhasil Dihapus';
}
$conn->close();
