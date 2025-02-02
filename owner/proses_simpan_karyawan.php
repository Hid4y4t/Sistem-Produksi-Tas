<?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

// Mengambil ID terakhir dari tabel user
$sqlLastId = "SELECT id FROM karyawan ORDER BY id DESC LIMIT 1";
$resultLastId = $conn->query($sqlLastId);

$lastId = 0;
if ($resultLastId->num_rows > 0) {
    $row = $resultLastId->fetch_assoc();
    $lastId = intval(substr($row['id'], 3)); // Mengambil angka setelah "KHC"
}

// Membangkitkan ID baru dengan format "KHCxxx"
$newId = "KHC" . str_pad($lastId + 1, 3, "0", STR_PAD_LEFT);

// Menangkap data dari form
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$username = $_POST['username'];
$password = hash('sha256', $_POST['password']); // Meng-hash password
$jabatan = $_POST['jabatan'];

// Proses upload foto
$target_dir = "../assets/karyawan/"; // Folder tujuan penyimpanan foto
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

// Query untuk menyimpan data ke database
$sqlInsert = "INSERT INTO karyawan (id, nama, jenis_kelamin, alamat, no_hp, username, password, foto, jabatan) 
              VALUES ('$newId', '$nama', '$jenis_kelamin', '$alamat', '$no_hp', '$username', '$password', '$target_file', '$jabatan')";

if ($conn->query($sqlInsert) === TRUE) {
    header("Location: pengguna.php");
} else {
    echo "Error: " . $sqlInsert . "<br>" . $conn->error;
}

$conn->close();
?>
