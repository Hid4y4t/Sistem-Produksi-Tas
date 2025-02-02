<?php
session_start();
require_once '../koneksi/koneksi.php'; // Ganti dengan path yang sesuai ke file koneksi.php

if (isset($_POST['jumlah_barang'], $_POST['deadline'], $_POST['kode_produk'])) {
    $jumlah_barang = $_POST['jumlah_barang'];
    $deadline = $_POST['deadline'];
    $kode_produk = $_POST['kode_produk'];

    $id_pelanggan = $_SESSION['id_pelanggan']; // Ambil ID Pelanggan dari session

    // Query untuk memasukkan data baru ke tabel order_pelanggan
    $sqlInsert = "INSERT INTO order_pelanggan (kode_pelanggan, kode_barang, jumlah_barang, deadline, tanggal_input)
                  VALUES ('$id_pelanggan', '$kode_produk', '$jumlah_barang', '$deadline', NOW())";

    if ($conn->query($sqlInsert) === TRUE) {
        // Data berhasil disimpan, Anda dapat melakukan tindakan lain, seperti mengirim notifikasi atau mengarahkan ke halaman lain
        header("Location: notification.php"); // Ganti dengan halaman yang sesuai
    } else {
        echo "Error: " . $sqlInsert . "<br>" . $conn->error;
    }
} else {
    echo "Data tidak lengkap. Silakan isi semua field.";
}

$conn->close();
?>
