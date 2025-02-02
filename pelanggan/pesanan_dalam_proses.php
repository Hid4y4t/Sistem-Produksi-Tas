<?php
include '../koneksi/koneksi.php';

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Query untuk mengambil semua data dari tabel antrian berdasarkan id_pelanggan
    $queryAntrian = "SELECT * FROM antrian WHERE id_pelanggan = '$id_pelanggan' ORDER BY tanggal_input2 DESC";
    $resultAntrian = mysqli_query($conn, $queryAntrian);

    if ($resultAntrian) {
        // Loop through the query result and display data
        while ($rowAntrian = mysqli_fetch_assoc($resultAntrian)) {
            echo createAntrianNotification($rowAntrian);
        }
    } else {
        echo 'Data tidak ditemukan.';
    }

    mysqli_close($conn);
} else {
    echo 'Session id_pelanggan belum di-set.';
}

// Fungsi untuk membuat notifikasi untuk antrian
function createAntrianNotification($row) {
    echo '<div class="notif">';
    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Envelope:">';
    echo '<use xlink:href="#envelope-fill" />';
    echo '</svg>';
    echo '<a href="#">';
    echo '<div class="alert alert-success d-flex align-items-center" role="alert">';
    echo '<div class="">';
    echo '<h4>Pesanan dalam Proses</h4>';
    echo '<p>' . $row['tanggal_input2'] . '</p>';
    echo '</div>';
    echo '<button class="btn btn-primary ms-auto" onclick="showPopup(\'' . $row['kode_produk'] . '\', ' . $row['jumlah_produk'] . ', ' . $row['harga_produk'] . ', \'antrian\')">Lihat</button>';
    echo '</div>';
    echo '</a>';
    echo '</div>';
}
?>