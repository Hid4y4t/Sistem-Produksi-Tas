<?php
include '../koneksi/koneksi.php';
if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Query untuk mengambil semua data dari tabel data_table berdasarkan id_pelanggan
    $queryData = "SELECT * FROM data_table WHERE id_pelanggan = '$id_pelanggan' ORDER BY tanggal_input3 DESC";
    $resultData = mysqli_query($conn, $queryData);

    if ($resultData) {
        // Loop through the query result and display data
        while ($rowData = mysqli_fetch_assoc($resultData)) {
            echo createNotification($rowData, 'data_table');
        }
    } else {
        echo 'Data tidak ditemukan.';
    }

    mysqli_close($conn);
} else {
    echo 'Session id_pelanggan belum di-set.';
}

// Fungsi untuk membuat notifikasi
function createNotification($row, $table) {
    echo '<div class="notif">';
    echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Envelope:">';
    echo '<use xlink:href="#envelope-fill" />';
    echo '</svg>';
    echo '<a href="#">';
    echo '<div class="alert alert-success d-flex align-items-center" role="alert">';
    echo '<div class="">';
    echo '<h4>Pesanan Dalam Antrian</h4>';
    echo '<p>' . $row['tanggal_input3'] . '</p>';
    echo '</div>';
    echo '<button class="btn btn-primary ms-auto" onclick="showPopup(\'' . $row['kode_produk'] . '\', ' . $row['jumlah_produk'] . ', ' . $row['harga_produk'] . ', \'' . $table . '\')">Lihat</button>';
    echo '</div>';
    echo '</a>';
    echo '</div>';
}
?>