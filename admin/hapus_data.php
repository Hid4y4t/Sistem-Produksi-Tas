<?php
require_once('../koneksi/koneksi.php');

// Pastikan ID yang diterima dari permintaan GET adalah angka
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Hapus data berdasarkan ID
if ($id > 0) {
    $sqlHapus = "DELETE FROM proses_selesai WHERE id = $id";
    if ($conn->query($sqlHapus) === TRUE) {
        header("Location: pesanan.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

$conn->close();
?>
