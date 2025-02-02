<?php
require_once '../koneksi/koneksi.php';

if (isset($_GET['id_produk'])) {
    $produk_id = $_GET['id_produk'];

    // Mengambil nama file foto sebelum menghapus data produk
    $sqlGetFoto = "SELECT foto FROM produk WHERE id_produk='$produk_id'";
    $result = $conn->query($sqlGetFoto);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fotoFilename = $row['foto'];

        // Hapus data produk dari tabel
        $sqlDeleteProduk = "DELETE FROM produk WHERE id_produk='$produk_id'";
        if ($conn->query($sqlDeleteProduk) === TRUE) {
            // Hapus juga foto dari folder jika ada
            if (!empty($fotoFilename)) {
                $fotoPath = "../assets/galeri/" . $fotoFilename; // Ganti dengan path sesuai kebutuhan
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
            header("Location: produk.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

$conn->close();
?>
