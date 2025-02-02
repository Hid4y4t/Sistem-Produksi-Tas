<?php
require_once '../koneksi/koneksi.php';

// Mengecek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $tanggal_input = date('Y-m-d'); // Tanggal saat ini
    $terakhir_diupdate = $tanggal_input;
    
    // Mengambil ID produk terakhir dari database
    $sqlGetLastId = "SELECT id_produk FROM produk ORDER BY id_produk DESC LIMIT 1";
    $result = $conn->query($sqlGetLastId);
    $new_id = "PR001"; // ID default jika belum ada data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['id_produk'];
        $last_number = intval(substr($last_id, 2)); // Mengambil angka dari ID terakhir
        $new_number = $last_number + 1;
        $new_id = "PR" . str_pad($new_number, 3, "0", STR_PAD_LEFT); // Membuat ID baru dengan format "PRXXX"
    }

    // Upload foto
    $foto_name = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($foto_tmp, '../assets/galeri/' . $foto_name);
    }

    // Menyiapkan query untuk memasukkan data baru ke tabel produk
    $sqlInsertProduk = "INSERT INTO produk (id_produk, nama_produk, deskripsi, harga, tanggal_input, terakhir_diupdate, foto) VALUES ('$new_id', '$nama_produk', '$deskripsi', $harga, '$tanggal_input', '$terakhir_diupdate', '$foto_name')";
    
    if ($conn->query($sqlInsertProduk) === TRUE) {
        header("Location: produk.php");
        exit();
    } else {
        echo "Error: " . $sqlInsertProduk . "<br>" . $conn->error;
    }
}

$conn->close();
?>
