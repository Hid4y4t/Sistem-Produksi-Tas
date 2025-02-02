<?php
session_start(); // Pastikan session sudah dimulai

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../koneksi/koneksi.php';

    // Pastikan session id_pelanggan sudah di-set
    if (!isset($_SESSION['id_pelanggan'])) {
        die("Error: Session id_pelanggan belum di-set.");
    }

    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Ambil id_produk dari data yang dikirim melalui POST
    $id_produk = $_POST['id_produk'];

    // Query untuk menghapus produk dari tabel favorite
    $hapusFavoriteQuery = "DELETE FROM keranjang WHERE id_produk = '$id_produk' AND id_pelanggan = '$id_pelanggan'";
    
    if (mysqli_query($conn, $hapusFavoriteQuery)) {
        // Berhasil dihapus
        echo "Produk berhasil dihapus dari favorit.";
    } else {
        // Gagal dihapus
        echo "Error: " . mysqli_error($conn);
    }

    // Menutup koneksi database
    mysqli_close($conn);
} else {
    // Jika bukan metode POST, redirect ke halaman lain atau keluarkan pesan kesalahan
    header("Location: ../index.php");
    exit();
}
?>
