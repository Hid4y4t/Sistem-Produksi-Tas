<?php
require_once('../koneksi/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $pesanan_masuk = $_POST['pesanan_masuk'];
    $deadline = $_POST['deadline'];
    $harga_produk = $_POST['harga_produk'];
    $jumlah_produk = $_POST['jumlah_produk'];

    // Menyiapkan query untuk update data pesanan
    $sqlUpdatePesanan = "UPDATE data_table SET pesanan_masuk = '$pesanan_masuk', deadline = '$deadline', harga_produk = '$harga_produk', jumlah_produk = '$jumlah_produk' WHERE id = '$id'";

    if ($conn->query($sqlUpdatePesanan) === TRUE) {
        header("Location: pesanan.php");
        exit();
    } else {
        echo "Error: " . $sqlUpdatePesanan . "<br>" . $conn->error;
    }
} else {
    echo "Data tidak lengkap. Silakan kembali ke halaman sebelumnya.";
}

$conn->close();
?>
