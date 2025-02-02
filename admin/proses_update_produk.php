<?php
require_once '../koneksi/koneksi.php';

// Mengambil data dari form
if (isset($_POST['submit'])) {
    $produk_id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // Update data produk berdasarkan ID
    $sqlUpdateProduk = "UPDATE produk SET nama_produk='$nama_produk', deskripsi='$deskripsi', harga=$harga WHERE id_produk=$produk_id";
    if ($conn->query($sqlUpdateProduk) === TRUE) {
        // Upload file foto jika ada
        if ($_FILES['foto']['name']) {
            $target_dir = "../assets/galeri/";
            $target_file = $target_dir . basename($_FILES['foto']['name']);
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
            
            // Update nama file foto dalam database
            $sqlUpdateFoto = "UPDATE produk SET foto='" . $_FILES['foto']['name'] . "' WHERE id_produk=$produk_id";
            $conn->query($sqlUpdateFoto);
        }

        header("Location: produk.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>