<?php
// Koneksi ke database
require_once '../koneksi/koneksi.php';

// Memastikan data terisi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_pesanan = $_POST["kode_pesanan"];
    $id_pelanggan = $_POST["id_pelanggan"];
    $id_produk = $_POST["id_produk"];
    $harga_produk = $_POST["harga_produk"];
    $jumlah_produk = $_POST["jumlah_produk"];
    $deadline = $_POST["deadline"];
    $pesanan_masuk = $_POST["pesanan_masuk"];


    // Mendapatkan data terbesar dari selesai_eksekusi sebelumnya
    $sql_max_selesai_eksekusi = "SELECT MAX(selesai_eksekusi) AS max_selesai_eksekusi FROM pemesanan";
    $result = $conn->query($sql_max_selesai_eksekusi);
    $row = $result->fetch_assoc();
    $max_selesai_eksekusi_sebelumnya = $row["max_selesai_eksekusi"] ?? 0;

    // Menentukan mulai_eksekusi
    $mulai_eksekusi = max($max_selesai_eksekusi_sebelumnya, 0);

    // Menentukan selesai_eksekusi
    $selesai_eksekusi = $deadline + $mulai_eksekusi;

    // Memasukkan data ke tabel pemesanan
    $sql_insert_pemesanan = "INSERT INTO pemesanan (kode_pesanan, id_pelanggan, id_produk, harga_produk, jumlah_produk, pesanan_masuk, deadline, mulai_eksekusi, selesai_eksekusi) 
                            VALUES ('$kode_pesanan', '$id_pelanggan', '$id_produk', '$harga_produk', '$jumlah_produk', '$pesanan_masuk', '$deadline', '$mulai_eksekusi', '$selesai_eksekusi')";
    if ($conn->query($sql_insert_pemesanan) === TRUE) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql_insert_pemesanan . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
?>
