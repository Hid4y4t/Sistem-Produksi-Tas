<?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

$id = $_POST['id'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$username = $_POST['username'];
$jabatan = $_POST['jabatan'];

// Cek apakah ada file foto yang diupload
if ($_FILES['foto']['name']) {
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($foto_tmp, '../folder_foto/' . $foto);
    $sql = "UPDATE karyawan SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', no_hp = '$no_hp', username = '$username', jabatan = '$jabatan', foto = '$foto' WHERE id = '$id'";
} else {
    $sql = "UPDATE karyawan SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', no_hp = '$no_hp', username = '$username', jabatan = '$jabatan' WHERE id = '$id'";
}

// Cek apakah ada password baru yang diinput
if (!empty($_POST['password_baru'])) {
    $password_baru = hash('sha256', $_POST['password_baru']); // Menggunakan SHA-256 untuk mengenkripsi password baru
    $sql = "UPDATE user SET password = '$password_baru' WHERE id = '$id'";
}

if ($conn->query($sql) === TRUE) {
    header("Location: pengguna.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
