<?php
require_once('../koneksi/koneksi.php');
require('assets/fpdf186/fpdf.php');

// Fungsi untuk mengonversi angka menjadi format rupiah
function formatRupiah($angka){
    $rupiah = "Rp " . number_format($angka,0,',','.');
    return $rupiah;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data invoice dan informasi produk menggunakan JOIN
    $query = "SELECT ps.*, p.nama_produk, p.harga
              FROM proses_selesai ps
              JOIN produk p ON ps.kode_produk = p.id_produk
              WHERE ps.id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Membuat objek FPDF dengan ukuran kertas A5
        $pdf = new FPDF('P', 'mm', 'A5');
        $pdf->AddPage();

        // Set font untuk header
        $pdf->SetFont('Arial', 'B', 12);

        // Header - UD HARTONO COLLECTION, Alamat, Nomor Telepon
        $pdf->Cell(0, 5, 'UD HARTONO COLLECTION', 0, 1, 'C');
        
        // Set font untuk data invoice
        $pdf->SetFont('Arial', '', 10);
        
        $pdf->Cell(0, 5, 'Kuyudan RT 05 RW 05 Makamhaji', 0, 1, 'C');
        $pdf->Cell(0, 3, 'Kartasura, Sukoharjo, Jawa Tengah 57161', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Telepon: 0856-9869-8756', 0, 1, 'C');
        $pdf->Cell(0, 5, '----------------------------------------', 0, 1, 'C');

        // Set font untuk data invoice
        $pdf->SetFont('Arial', 'B', 9);

        // Data Invoice - ID Pelanggan, No Pesanan, Tanggal Masuk, Tanggal Selesai
        $pdf->Cell(0, 5, 'ID Pelanggan: ' . $row['id_pelanggan'], 0, 1, 'L');
        $pdf->Cell(0, 5, 'No Pesanan: ' . $row['pesanan_masuk'], 0, 1, 'L');
        $pdf->Cell(0, 5, 'Tanggal Masuk: ' . $row['tanggal_input'], 0, 1, 'L');
     
        $pdf->Ln(); // Pindah ke baris baru

        // Tulisan "Invoice" di tengah halaman
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');

        // Set font untuk tabel
        $pdf->SetFont('Arial', 'B', 9);

        // Header Tabel - No, Nama Produk, Kode Produk, Harga Satuan, Jumlah, Harga Total
        $pdf->Cell(10, 8, 'No', 1);
        $pdf->Cell(35, 8, 'Nama Produk', 1);
        $pdf->Cell(25, 8, 'Kode Produk', 1);
        $pdf->Cell(25, 8, 'Harga Satuan', 1);
        $pdf->Cell(15, 8, 'Jumlah', 1);
        $pdf->Cell(30, 8, 'Harga Total', 1);
        $pdf->Ln(); // Pindah ke baris baru

        // Data Tabel - Isi dengan data produk dan harga
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 8, '1', 1);
        $pdf->Cell(35, 8, $row['nama_produk'], 1); // Menampilkan nama produk dari tabel produk
        $pdf->Cell(25, 8, $row['kode_produk'], 1);
        $pdf->Cell(25, 8, formatRupiah($row['harga_produk']), 1); // Menampilkan harga satuan dari tabel produk dalam format rupiah
        $pdf->Cell(15, 8, $row['jumlah_produk'], 1);
        $pdf->Cell(30, 8, formatRupiah($row['jumlah_produk'] * $row['harga_produk']), 1); // Menghitung dan menampilkan harga total dalam format rupiah
        $pdf->Ln(); // Pindah ke baris baru

        // Total Harga di bagian bawah tabel
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Total Harga: ' . formatRupiah($row['jumlah_produk'] * $row['harga_produk']), 0, 1, 'R');

        // Save PDF to a file
        $pdf->Output('invoice_' . $id . '.pdf', 'F');

        // Return the file path for redirection
        echo 'invoice_' . $id . '.pdf';
    } else {
        echo 'Query error: ' . mysqli_error($conn);
        die('Data invoice tidak ditemukan.');
    }
} else {
    echo 'Parameter ID tidak ditemukan.';
}

mysqli_close($conn);
?>
