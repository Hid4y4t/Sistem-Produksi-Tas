<?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

// Ambil data dari form
$id_order = $_POST['id_order'];
$pesanan_masuk = $_POST['pesanan_masuk'];
$deadline = $_POST['deadline'];
$id_pelanggan = $_POST['id_pelanggan'];
$kode_produk = $_POST['kode_produk'];
$harga_produk = $_POST['harga_produk'];
$jumlah_produk = $_POST['jumlah_produk'];

// Mulai transaksi
$conn->begin_transaction();

// Query untuk memasukkan data baru ke data_table
$sqlInsert = "INSERT INTO data_table (pesanan_masuk, deadline, id_pelanggan, kode_produk, harga_produk, jumlah_produk, tanggal_input3)
              VALUES ($pesanan_masuk, $deadline, '$id_pelanggan', '$kode_produk', $harga_produk, $jumlah_produk, NOW())";

if ($conn->query($sqlInsert) === TRUE) {
    // Query untuk menghapus data pesanan lama
    $sqlDelete = "DELETE FROM order_pelanggan WHERE id = '$id_order'";

    if ($conn->query($sqlDelete) === TRUE) {
        // Commit transaksi jika berhasil
        $conn->commit();
        header("Location: pesanan.php");
    } else {
        // Rollback transaksi jika terjadi kesalahan
        $conn->rollback();
        echo "Error deleting old order: " . $conn->error;
    }
} else {
    // Rollback transaksi jika terjadi kesalahan
    $conn->rollback();
    echo "Error inserting new order: " . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
