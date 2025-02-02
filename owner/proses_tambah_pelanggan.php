<?php
require_once '../koneksi/koneksi.php';

// Mengecek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengambil ID pelanggan terakhir dari database
    $sqlGetLastId = "SELECT id_pelanggan FROM pelanggan ORDER BY id_pelanggan DESC LIMIT 1";
    $result = $conn->query($sqlGetLastId);
    $new_id = "PLG001"; // ID default jika belum ada data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['id_pelanggan'];
        $last_number = intval(substr($last_id, 3)); // Mengambil angka dari ID terakhir
        $new_number = $last_number + 1;
        $new_id = "PLG" . str_pad($new_number, 3, "0", STR_PAD_LEFT); // Membuat ID baru dengan format "PLGXXX"
    }

    // Hash password menggunakan SHA-256
    $hashedPassword = hash('sha256', $password);

    // Menyiapkan query untuk memasukkan data baru ke tabel pelanggan
    $sqlInsertPelanggan = "INSERT INTO pelanggan (id_pelanggan, nama, alamat, no_telepon, username, password) VALUES ('$new_id', '$nama', '$alamat', '$no_telepon', '$username', '$hashedPassword')";

    if ($conn->query($sqlInsertPelanggan) === TRUE) {
        header("Location: pelanggan.php");
        exit();
    } else {
        echo "Error: " . $sqlInsertPelanggan . "<br>" . $conn->error;
    }
}

$conn->close();
?>
