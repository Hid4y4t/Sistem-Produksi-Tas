<?php
require_once '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $username = $_POST['username'];

    // Cek apakah password diubah
    if (!empty($_POST['password'])) {
        $password = sha1($_POST['password']);
        $sqlUpdatePelanggan = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', no_telepon='$no_telepon', username='$username', password='$password' WHERE id_pelanggan='$id_pelanggan'";
    } else {
        $sqlUpdatePelanggan = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', no_telepon='$no_telepon', username='$username' WHERE id_pelanggan='$id_pelanggan'";
    }

    if ($conn->query($sqlUpdatePelanggan) === TRUE) {
        header("Location: pelanggan.php");
        exit();
    } else {
        echo "Error: " . $sqlUpdatePelanggan . "<br>" . $conn->error;
    }
}

$conn->close();
?>
