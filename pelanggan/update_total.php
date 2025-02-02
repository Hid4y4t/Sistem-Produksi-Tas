<?php
// Sambungkan ke database jika belum terhubung
include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan melalui POST
    $produk_id = $_POST['produk_id'];
    $jumlah = $_POST['jumlah'];

    // Query untuk mendapatkan harga produk
    $queryProduk = "SELECT harga FROM produk WHERE id_produk = '$produk_id'";
    $resultProduk = mysqli_query($conn, $queryProduk);
    $hargaProduk = mysqli_fetch_assoc($resultProduk)['harga'];

    // Hitung total
    $total = $hargaProduk * $jumlah;

    // Kirim total sebagai JSON ke JavaScript
    echo json_encode(['total' => $total]);

    // Tutup koneksi database
    mysqli_close($conn);
}
?>
