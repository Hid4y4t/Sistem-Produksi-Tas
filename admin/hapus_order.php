<?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data order pelanggan berdasarkan ID
    $sqlDelete = "DELETE FROM order_pelanggan WHERE id = '$id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: pesanan.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID tidak diberikan.";
}

$conn->close();
?>
