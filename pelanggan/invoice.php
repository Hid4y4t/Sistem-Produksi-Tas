<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php' ?>

<body>
    <?php include 'root/navbar.php' ?>


    <main id="main">
        <section section id="about" class="about" style="background-color: rgb(231, 228, 228);">
            <div class="container">

                <div class="section-title">
                    <!-- <h2>Favorite</h2> -->

                </div>

                <div class="row content">
                    <?php include 'root/menu.php' ?>
                    <div class="col-lg-10 pt-4 pt-lg-0">
                        <a href="index.php"><i class="bi bi-caret-left"></i> Back</a> <br>
                        <h4 style="font-weight: bold;"> Invoice</h4> <br>

                        <h2>Data Invoice</h2>
                        <?php
// tampil_data.php
require_once('../koneksi/koneksi.php');

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Query untuk mendapatkan data dari tabel proses_selesai dengan JOIN tabel produk
    $query = "SELECT ps.*, p.nama_produk
              FROM proses_selesai ps
              JOIN produk p ON ps.kode_produk = p.id_produk
              WHERE ps.id_pelanggan = '$id_pelanggan'";
    $result = mysqli_query($conn, $query);
} else {
    // Handle jika ID pelanggan tidak di-set
    echo "ID pelanggan tidak tersedia.";
}

?>
                        <div class="card">
                            <div class="card-body">
                                <form action="proses_cetak_invoice.php" method="post">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>

                                                <th>Nama Produk</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Jumlah Produk</th>
                                                <th>Cetak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                       
                        echo '<td>' . $row['nama_produk'] . '</td>';
                        echo '<td>' . $row['tanggal_input'] . '</td>';
                        echo '<td>' . $row['jumlah_produk'] . '</td>';
                        echo '<td><input type="checkbox" name="selected_ids[]" value="' . $row['id'] . '"></td>';
                        echo '</tr>';
                    }
                    ?>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-success">Cetak Invoice Terpilih</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js">
    </script>


    <script>
    function cetakInvoice(id) {
        // Kirim permintaan pencetakan invoice ke skrip PHP';
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Redirect ke file PDF yang dibuat';
                window.open(this.responseText, "_blank");
            }
        };
        xhr.open("GET", "cetak_invoice.php?id=" + id, true);
        xhr.send();
    }
    </script>
    <?php include 'root/footer.php' ?>
</body>

</html>