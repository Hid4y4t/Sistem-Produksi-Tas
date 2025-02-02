<?php
include('../koneksi/koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data pesanan berdasarkan ID
    $sqlHapusPesanan = "DELETE FROM data_table WHERE id = '$id'";

    if ($conn->query($sqlHapusPesanan) === TRUE) {
        header("Location: pesanan.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID pesanan tidak valid.";
}

$conn->close();
?>
