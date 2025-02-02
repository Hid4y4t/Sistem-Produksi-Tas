<?php
session_start();
require_once 'koneksi/koneksi.php'; // Ganti dengan path yang sesuai ke file koneksi.php

if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']); // Meng-hash password

    // Query untuk memeriksa login
    $sqlLogin = "SELECT * FROM pelanggan WHERE username = '$username' AND password = '$password'";
    $resultLogin = $conn->query($sqlLogin);

    if ($resultLogin->num_rows == 1) {
        $row = $resultLogin->fetch_assoc();
        
        // Set session data untuk pelanggan yang berhasil login
        $_SESSION['id_pelanggan'] = $row['id_pelanggan'];
        $_SESSION['nama_pelanggan'] = $row['nama']; // Ganti dengan kolom yang sesuai
        // Anda bisa menambahkan data session lain yang diperlukan
        
        header("Location: pelanggan/index.php"); // Ganti dengan halaman yang sesuai
    } else {
        // Jika login gagal, Anda dapat mengarahkan kembali ke halaman login
        header("Location: index.php"); // Ganti dengan halaman login yang sesuai
    }
} else {
    // Jika data tidak lengkap, Anda dapat mengarahkan kembali ke halaman login
    header("Location: index.php"); // Ganti dengan halaman login yang sesuai
}

$conn->close();
?>
