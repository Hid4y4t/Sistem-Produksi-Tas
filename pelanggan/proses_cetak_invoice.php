<?php
// proses_cetak_invoice.php
require_once('../koneksi/koneksi.php');
require('assets/fpdf186/fpdf.php');

// Fungsi untuk format harga dalam rupiah
function formatRupiah($angka){
    $rupiah = number_format($angka, 0, ',', '.');
    return 'Rp ' . $rupiah;
}

if (isset($_POST['selected_ids']) && is_array($_POST['selected_ids'])) {
    // Inisialisasi data pelanggan dan nomor pesanan
    $firstCustomerId = null;
    $firstCustomerName = null;
    $orderNumbers = array();

    // Inisialisasi total harga
    $totalHarga = 0;

    // Iterasi data terpilih
    foreach ($_POST['selected_ids'] as $id) {
        // Query untuk mendapatkan data invoice dan informasi produk menggunakan JOIN
        $query = "SELECT ps.*, p.nama_produk, p.harga, pl.id_pelanggan, pl.nama
                  FROM proses_selesai ps
                  JOIN produk p ON ps.kode_produk = p.id_produk
                  JOIN pelanggan pl ON ps.id_pelanggan = pl.id_pelanggan
                  WHERE ps.id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Menambahkan ke total harga
            $totalHarga += $row['jumlah_produk'] * $row['harga_produk'];

            // Mengisi data pelanggan jika belum diisi
            if ($firstCustomerId === null) {
                $firstCustomerId = $row['id_pelanggan'];
                $firstCustomerName = $row['nama'];
            }

            // Menambahkan nomor pesanan ke array
            $orderNumbers[] = $row['pesanan_masuk'];
        } else {
            echo 'Query error: ' . mysqli_error($conn);
            die('Data invoice tidak ditemukan.');
        }
    }

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
    $pdf->Cell(0, 5, '-------------------------------------------------------------------------------', 0, 1, 'C');

    // Set font untuk data invoice
    $pdf->SetFont('Arial', 'B', 9);

    // Menampilkan data pelanggan pada cetakan invoice
    if ($firstCustomerId !== null) {
        $pdf->Ln(); // Pindah ke baris baru
        $pdf->Cell(0, 5, 'ID Pelanggan: ' . $firstCustomerId , 0, 1, 'L');
        $pdf->Cell(0, 5, 'Nama Pelanggan: ' . $firstCustomerName , 0, 1, 'L');
    }

    // Menampilkan nomor pesanan dengan tanda koma
    $pdf->Cell(0, 5, 'No Pesanan: ' . implode(', ', $orderNumbers), 0, 1, 'L');
    $pdf->Ln(); // Pindah ke baris baru

    // Tulisan "Invoice" di tengah halaman
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');

    // Set font untuk data invoice
    $pdf->SetFont('Arial', 'B', 8);

    // Set header untuk tabel
    $pdf->Cell(10, 8, 'No', 1);
    $pdf->Cell(35, 8, 'Nama Produk', 1);
    $pdf->Cell(20, 8, 'Kode Produk', 1);
    $pdf->Cell(25, 8, 'Harga Satuan', 1);
    $pdf->Cell(15, 8, 'Jumlah', 1);
    $pdf->Cell(30, 8, 'Harga Total', 1);

    $pdf->Ln(); // Pindah ke baris baru

    // Set font untuk isi tabel
    $pdf->SetFont('Arial', '', 8);

    // Iterasi data terpilih
    $counter = 1;
    foreach ($_POST['selected_ids'] as $id) {
        // Query untuk mendapatkan data invoice dan informasi produk menggunakan JOIN
        $query = "SELECT ps.*, p.nama_produk, p.harga, pl.id_pelanggan
                  FROM proses_selesai ps
                  JOIN produk p ON ps.kode_produk = p.id_produk
                  JOIN pelanggan pl ON ps.id_pelanggan = pl.id_pelanggan
                  WHERE ps.id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Menampilkan data pada tabel
            $pdf->Cell(10, 8, $counter++, 1);
            $pdf->Cell(35, 8, $row['nama_produk'], 1);
            $pdf->Cell(20, 8, $row['kode_produk'], 1);
            $pdf->Cell(25, 8, formatRupiah($row['harga_produk']), 1);
            $pdf->Cell(15, 8, $row['jumlah_produk'], 1);
            $pdf->Cell(30, 8, formatRupiah($row['jumlah_produk'] * $row['harga_produk']), 1);
           
            $pdf->Ln(); // Pindah ke baris baru
        } else {
            echo 'Query error: ' . mysqli_error($conn);
            die('Data invoice tidak ditemukan.');
        }
    }

    // Set font untuk total harga
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Total Harga: ' . formatRupiah($totalHarga), 0, 1, 'R');

    // Save PDF to a file
    $pdf->Output('invoice_multiple.pdf', 'F');

    // Output file PDF langsung ke browser
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="invoice_multiple.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    @readfile('invoice_multiple.pdf');

    // Hapus file setelah dioutput
    unlink('invoice_multiple.pdf');
} else {
    echo 'Tidak ada data yang dipilih.';
}

mysqli_close($conn);
?>
