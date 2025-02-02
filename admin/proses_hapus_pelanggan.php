<?php
include('../koneksi/koneksi.php');

if (isset($_GET['id'])) {
    $id_pelanggan = $_GET['id'];

    $sqlHapus = "DELETE FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'";

    if ($conn->query($sqlHapus) === TRUE) {
        header("Location: pelanggan.php");
        exit();
    } else {
        echo "Error: " . $sqlHapus . "<br>" . $conn->error;
    }
}

$conn->close();
?>
