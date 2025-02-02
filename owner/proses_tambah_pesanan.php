<?php
include('../koneksi/koneksi.php');

if (isset($_POST['pesanan_masuk'], $_POST['deadline'], $_POST['id_pelanggan'], $_POST['kode_produk'], $_POST['harga_produk'], $_POST['jumlah_produk'])) {
    $pesanan_masuk = $_POST['pesanan_masuk'];
    $deadline = $_POST['deadline'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $kode_produk = $_POST['kode_produk'];
    $harga_produk = $_POST['harga_produk'];
    $jumlah_produk = $_POST['jumlah_produk'];

    // Ambil total pesanan saat ini dari database
    $sqlTotalPesanan = "SELECT COUNT(*) as total FROM data_table";
    $resultTotalPesanan = $conn->query($sqlTotalPesanan);
    $rowTotalPesanan = $resultTotalPesanan->fetch_assoc();
    $totalPesanan = $rowTotalPesanan['total'];

    // Buat ID pesanan dengan format PSXXX
    // $nextID = $totalPesanan + 1;
    // $id_pesanan = 'PS' . str_pad($nextID, 3, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO data_table (pesanan_masuk, deadline, id_pelanggan, kode_produk, harga_produk, jumlah_produk, tanggal_input3)
            VALUES ($pesanan_masuk, $deadline, '$id_pelanggan', '$kode_produk', $harga_produk, $jumlah_produk, NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: pesanan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Data tidak lengkap. Silakan kembali ke halaman sebelumnya.";
}

$conn->close();
?>
