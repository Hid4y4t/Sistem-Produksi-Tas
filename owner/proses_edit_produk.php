<?php
require_once('../koneksi/koneksi.php');

if(isset($_POST['id_produk'], $_POST['nama_produk'], $_POST['deskripsi'], $_POST['harga'])) {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // Upload foto baru jika ada
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $target_path = "../assets/galeri/";
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_path . $foto);

        // Hapus foto lama jika ada
        $sqlGetFoto = "SELECT foto FROM produk WHERE id_produk = '$id_produk'";
        $resultGetFoto = $conn->query($sqlGetFoto);
        if($resultGetFoto->num_rows > 0) {
            $rowFoto = $resultGetFoto->fetch_assoc();
            $foto_lama = $rowFoto['foto'];
            if($foto_lama != null) {
                unlink($target_path . $foto_lama);
            }
        }

        // Update data produk dengan foto baru
        $sqlUpdateProduk = "UPDATE produk SET nama_produk = '$nama_produk', deskripsi = '$deskripsi', harga = $harga, foto = '$foto' WHERE id_produk = '$id_produk'";
    } else {
        // Update data produk tanpa mengubah foto
        $sqlUpdateProduk = "UPDATE produk SET nama_produk = '$nama_produk', deskripsi = '$deskripsi', harga = $harga WHERE id_produk = '$id_produk'";
    }

    if($conn->query($sqlUpdateProduk) === TRUE) {
        header("Location: produk.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Data tidak lengkap. Silakan kembali ke halaman sebelumnya.";
}

$conn->close();
?>
