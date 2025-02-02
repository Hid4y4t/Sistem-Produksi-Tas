<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php' ?>

<body>
    <?php include 'root/navbar.php' ?>
    <?php include 'root/hero.php' ?>

    <main id="main">
        <section id="about" class="about" style="background-color: rgb(231, 228, 228);">
            <div class="container">

                <div class="section-title">
                    <h2>Produk</h2>
                </div>

                <div class="row content">
                    <?php include 'root/menu.php' ?>
                    <div class="col-lg-10 pt-4 pt-lg-0">
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

                            // Fungsi tambah ke favorit
                            function tambahKeFavorite($id_produk, $conn) {
                                // Pastikan session id_pelanggan sudah di-set
                                if (!isset($_SESSION['id_pelanggan'])) {
                                    die("Error: Session id_pelanggan belum di-set.");
                                }

                                $id_pelanggan = $_SESSION['id_pelanggan'];

                                // Cek apakah produk sudah ada di favorit untuk pelanggan tertentu
                                $cekFavoriteQuery = "SELECT * FROM favorite WHERE id_produk ='$id_produk' AND id_pelanggan = '$id_pelanggan'";
                                $cekFavoriteResult = mysqli_query($conn, $cekFavoriteQuery);

                                if ($cekFavoriteResult && mysqli_num_rows($cekFavoriteResult) > 0) {
                                    // Jika produk sudah ada di favorit, beri tahu pengguna
                                    $_SESSION['notif'] = "Produk sudah ada di favorit Anda.";
                                } else {
                                    // Jika produk belum ada di favorit, tambahkan ke tabel favorit
                                    $insertFavoriteQuery = "INSERT INTO favorite (id_produk, id_pelanggan) VALUES ('$id_produk', '$id_pelanggan')";
                                    mysqli_query($conn, $insertFavoriteQuery);
                                    $_SESSION['notif'] = "Produk berhasil ditambahkan ke dalam favorit Anda.";
                                }
                            }

                            // Menangani penambahan ke chart saat ikon keranjang ditekan
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_ke_chart'])) {
                                tambahKeChart($_POST['id_produk'], $conn);
                                // Redirect untuk menghindari reload form
                                header('Location: ' . $_SERVER['REQUEST_URI']);
                                exit();
                            }

                            // Menangani penambahan ke favorit saat ikon bintang ditekan
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_ke_favorite'])) {
                                tambahKeFavorite($_POST['id_produk'], $conn);
                                // Redirect untuk menghindari reload form
                                header('Location: ' . $_SERVER['REQUEST_URI']);
                                exit();
                            }

                            // Query untuk mengambil data produk
                            $query = "SELECT * FROM produk";
                            $result = mysqli_query($conn, $query);

                            // Memeriksa apakah query berhasil dijalankan
                            if (!$result) {
                                die("Query gagal: " . mysqli_error($conn));
                            }
// ...

// Menampilkan data produk
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="col-md-4 mt-md-2">';
    echo '<div class="card " style="width: 18rem;">';
    echo '<img src="../assets/galeri/' . $row['foto'] . '" class="card-img-top" alt="...">';
    echo '<div class="card-body">';
    echo '<p class="card-text" style="color: grey;">' . $row['nama_produk'] . '</p>';
    echo '<h5>Rp ' . number_format($row['harga']) . '</h5>';
    echo '<div class="button-buy">'; // Menghapus style di sini

    // Tombol Favorit
    $checkFavoriteQuery = "SELECT * FROM favorite WHERE id_produk ='{$row['id_produk']}' AND id_pelanggan = '$id_pelanggan'";
    $checkFavoriteResult = mysqli_query($conn, $checkFavoriteQuery);

    echo '<div class="button-container">'; // Menambahkan elemen container
    echo '<form method="post" onsubmit="return confirmAddToFavorites()">';
    echo '<input type="hidden" name="id_produk" value="' . $row['id_produk'] . '">';

    if ($checkFavoriteResult && mysqli_num_rows($checkFavoriteResult) > 0) {
        // Produk sudah ada di favorit, nonaktifkan tombol
        echo '<button type="button" name="tambah_ke_favorite" class="favorite-btn" disabled><i class="bx bx-star"></i></button>';
    } else {
        // Produk belum ada di favorit, tampilkan tombol
        echo '<button type="submit" name="tambah_ke_favorite" class="favorite-btn"><i class="bx bx-star"></i></button>';
    }

    echo '</form>';
    echo '</div>'; // Menutup elemen container

    // Tombol Keranjang
    echo '<form method="post" onsubmit="return confirmAddToCart()">';
    echo '<input type="hidden" name="id_produk" value="' . $row['id_produk'] . '">';
    echo '<button type="submit" name="tambah_ke_chart" class="cart-btn"><i class="bx bx-basket"></i></button>';
    echo '</form>';

    echo '</div>'; // Menutup .button-buy
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

// ...

                            // Menampilkan notifikasi jika ada
                            if (isset($_SESSION['notif'])) {
                                echo '<script>alert("' . $_SESSION['notif'] . '");</script>';
                                unset($_SESSION['notif']); // Hapus notifikasi setelah ditampilkan
                            }

                            // Menutup koneksi database
                            mysqli_close($conn);
                            ?>

                            <script>
                                // Fungsi untuk menampilkan konfirmasi tambah ke keranjang
                                function confirmAddToCart() {
                                    return confirm("Produk akan ditambahkan ke dalam keranjang. Lanjutkan?");
                                }

                                // Fungsi untuk menampilkan konfirmasi tambah ke favorit
                                function confirmAddToFavorites() {
                                    return confirm("Tambahkan produk ke dalam favorit?");
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
