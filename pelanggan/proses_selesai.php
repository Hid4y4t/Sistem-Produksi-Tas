<?php
include '../koneksi/koneksi.php';

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Query untuk mengambil semua data dari tabel proses_selesai berdasarkan id_pelanggan
    $queryProsesSelesai = "SELECT * FROM proses_selesai WHERE id_pelanggan = '$id_pelanggan' ORDER BY tanggal_input DESC";
    $resultProsesSelesai = mysqli_query($conn, $queryProsesSelesai);

    if ($resultProsesSelesai) {
        // Loop through the query result and display data
        while ($rowProsesSelesai = mysqli_fetch_assoc($resultProsesSelesai)) {
            echo createProsesSelesaiNotification($rowProsesSelesai);
        }
    } else {
        echo 'Data tidak ditemukan.';
    }

    mysqli_close($conn);
} else {
    echo 'Session id_pelanggan belum di-set.';
}

// Fungsi untuk membuat notifikasi untuk proses_selesai
function createProsesSelesaiNotification($row) {
    echo '<div class="notif">';
    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Envelope:">';
    echo '<use xlink:href="#envelope-fill" />';
    echo '</svg>';
    echo '<a href="#">';
    echo '<div class="alert alert-success d-flex align-items-center" role="alert">';
    echo '<div class="">';
    echo '<h4>Pesanan Sudah Selesai</h4>';
    echo '<p>' . $row['tanggal_input'] . '</p>';
    echo '</div>';
    echo '<button class="btn btn-primary ms-auto" onclick="showPopup(\'' . $row['kode_produk'] . '\', ' . $row['jumlah_produk'] . ', ' . $row['harga_produk'] . ', \'proses_selesai\')">Lihat</button>';
    echo '<button class="btn btn-success ms-2" onclick="cetakInvoice(\'' . $row['id'] . '\')">Cetak Invoice</button>';
    echo '</div>';
    echo '</a>';
    echo '</div>';
}

?>