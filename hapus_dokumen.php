<?php

$id = $_GET['id'];

$sql = "DELETE FROM dokumen WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    header("Location:?page=dokumen");
}
$conn->close();
