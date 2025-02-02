<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php' ?>

<body>
    <?php include 'root/navbar.php' ?>
  

    <main id="main">
        <section id="about" class="about" style="background-color: rgb(231, 228, 228);">
            <div class="container">

                <div class="section-title">
                    <h2>Produk</h2>
                </div>

                <div class="row content">
                    <?php include 'root/menu.php' ?>
                    <div class="col-lg-10 pt-4 pt-lg-0">
                    <a href="index.php"><i class="bi bi-caret-left"></i> Back</a> <br>
                        <h4 style="font-weight: bold;">Favorite</h4> <br>

                        <div class="row">
                        <?php
include '../koneksi/koneksi.php';

// Fungsi tambah ke chart
function tambahKeChart($id_produk, $conn) {
    // Pastikan session id_pelanggan sudah di-set
    if (!isset($_SESSION['id_pelanggan'])) {
        die("Error: Session id_pelanggan belum di-set.");
    }

    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Cek apakah produk sudah ada di chart untuk pelanggan tertentu
    $cekChartQuery = "SELECT * FROM keranjang WHERE id_produk ='$id_produk' AND id_pelanggan = '$id_pelanggan'";
    $cekChartResult = mysqli_query($conn, $cekChartQuery);

    if ($cekChartResult && mysqli_num_rows($cekChartResult) > 0) {
        // Jika produk sudah ada, tingkatkan jumlahnya
        $updateChartQuery = "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_produk = '$id_produk' AND id_pelanggan = '$id_pelanggan'";
        mysqli_query($conn, $updateChartQuery);
        $_SESSION['notif'] = "Produk berhasil ditambahkan ke dalam keranjang.";
    } else {
        // Jika produk belum ada, tambahkan ke chart dengan jumlah 1
        $insertChartQuery = "INSERT INTO keranjang (id_produk, jumlah, id_pelanggan) VALUES ('$id_produk', 1, '$id_pelanggan')";
        mysqli_query($conn, $insertChartQuery);
        $_SESSION['notif'] = "Produk berhasil ditambahkan ke dalam keranjang.";
    }
}

// Fungsi hapus dari favorit
function hapusDariFavorite($id_produk, $conn) {
    // Pastikan session id_pelanggan sudah di-set
    if (!isset($_SESSION['id_pelanggan'])) {
        die("Error: Session id_pelanggan belum di-set.");
    }

    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Hapus produk dari tabel favorite
    $hapusFavoriteQuery = "DELETE FROM favorite WHERE id_produk ='$id_produk' AND id_pelanggan = '$id_pelanggan'";
    mysqli_query($conn, $hapusFavoriteQuery);
    $_SESSION['notif'] = "Produk berhasil dihapus dari favorit Anda.";
}

// Menangani penambahan ke chart saat ikon keranjang ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_ke_chart'])) {
    tambahKeChart($_POST['id_produk'], $conn);
    // Redirect untuk menghindari reload form
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

// Menangani penghapusan dari favorit saat ikon hati ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_dari_favorite'])) {
    hapusDariFavorite($_POST['id_produk'], $conn);
    
    exit();
}

// Query untuk mengambil produk dari tabel favorite berdasarkan id_pelanggan
$queryFavorite = "SELECT f.*, p.nama_produk, p.harga, p.foto FROM favorite f
                  JOIN produk p ON f.id_produk = p.id_produk
                  WHERE f.id_pelanggan = '$id_pelanggan'";
$resultFavorite = mysqli_query($conn, $queryFavorite);

// Memeriksa apakah query berhasil dijalankan
if (!$resultFavorite) {
    die("Query gagal: " . mysqli_error($conn));
}

// Menampilkan produk yang ada di tabel favorite
echo '<div class="row">'; // Memulai baris
$counter = 0; // Inisialisasi counter
while ($row = mysqli_fetch_assoc($resultFavorite)) {
    $counter++; // Menambahkan counter

    echo '<div class="col-md-4 mt-md-2">';
    echo '<div class="card " style="width: 18rem;">';
    echo '<img src="../assets/galeri/' . $row['foto'] . '" class="card-img-top" alt="...">';
    echo '<div class="card-body">';
    echo '<p class="card-text" style="color: grey;">' . $row['nama_produk'] . '</p>';
    echo '<h5>Rp ' . number_format($row['harga']) . '</h5>';
    echo '<div class="button-buy">';

    // Tombol Hapus dari Favorit
    echo '<div class="button-container">';
    echo '<form method="post" onsubmit="return confirmRemoveFromFavorites()">';
    echo '<input type="hidden" name="id_produk" value="' . $row['id_produk'] . '">';
    echo '<button type="submit" name="hapus_dari_favorite" class="favorite-btn"><i class="bx bx-heart"></i></button>';
    echo '</form>';
    echo '</div>';

    // Tombol Tambah ke Keranjang
    echo '<form method="post" onsubmit="return confirmAddToCart()">';
    echo '<input type="hidden" name="id_produk" value="' . $row['id_produk'] . '">';
    echo '<button type="submit" name="tambah_ke_chart" class="cart-btn"><i class="bx bx-basket"></i></button>';
    echo '</form>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    // Memeriksa apakah sudah mencapai setiap 3 produk
    if ($counter % 3 == 0) {
        echo '</div>'; // Menutup baris setiap 3 produk
        echo '<div class="row mt-4">'; // Membuka baris baru
    }
}

echo '</div>'; // Menutup baris terakhir

// Menampilkan notifikasi jika ada
if (isset($_SESSION['notif'])) {
    echo '<script>alert("' . $_SESSION['notif'] . '");</script>';
    unset($_SESSION['notif']); // Hapus notifikasi setelah ditampilkan
}
// Menutup koneksi database
mysqli_close($conn);

ob_end_flush(); // Mengakhiri output buffering dan mengirimkan output ke browser
?>

<script>
    // Fungsi untuk menampilkan konfirmasi hapus dari favorit
    function confirmRemoveFromFavorites() {
        return confirm("Hapus produk dari favorit?");
    }

    // Fungsi untuk menampilkan konfirmasi tambah ke keranjang
    function confirmAddToCart() {
        return confirm("Produk akan ditambahkan ke dalam keranjang. Lanjutkan?");
    }
</script>


                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" class="cta">
            <div class="container">
                <div class="text-center">
                    <a class="cta-btn" href="#">New & Trend</a>
                </div>
            </div>
        </section><!-- End Cta Section -->
    </main>

    <?php include 'root/footer.php' ?>
</body>

</html>