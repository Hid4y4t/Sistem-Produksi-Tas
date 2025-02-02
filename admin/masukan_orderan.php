<?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

// Mengecek apakah parameter ID diberikan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data order pelanggan berdasarkan ID
    $sqlSelect = "SELECT op.*, pl.nama, pr.nama_produk FROM order_pelanggan op
                  JOIN pelanggan pl ON op.kode_pelanggan = pl.id_pelanggan
                  JOIN produk pr ON op.kode_barang = pr.id_produk
                  WHERE op.id = '$id'";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }


} else {
    echo "ID tidak diberikan.";
    exit();
}

// Proses update data order pelanggan
if (isset($_POST['update'])) {
    $kode_pelanggan = $_POST['kode_pelanggan'];
    $kode_produk = $_POST['kode_produk'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $deadline = $_POST['deadline'];

    // Query untuk melakukan update data
    $sqlUpdate = "UPDATE order_pelanggan SET kode_pelanggan = '$kode_pelanggan', kode_produk = '$kode_produk',
                  jumlah_barang = '$jumlah_barang', deadline = '$deadline' WHERE id = '$id'";

    if ($conn->query($sqlUpdate) === TRUE) {
        header("Location: daftar_orderan.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Query untuk mengambil data pelanggan
$sqlPelanggan = "SELECT * FROM pelanggan";
$resultPelanggan = $conn->query($sqlPelanggan);

// Query untuk mengambil data produk
$sqlProduk = "SELECT * FROM produk";
$resultProduk = $conn->query($sqlProduk);

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Masukan Pesanan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Masukan Pesanan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">


                <!-- ------------------------------------------------ -->

                <form action="proses_tambah_pesanan_orderan.php" method="post">
                    <div class="row mb-4">
                        <label for="inputText" class="col-sm-4 col-form-label">Urutan</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="id_order" value="<?php echo $row['id']; ?>">
                            <input type="number" name="pesanan_masuk" required class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-4 col-form-label">Deadline</label>
                        <div class="col-sm-8">
                            <input type="number" name="deadline" value="<?php echo $row['deadline']; ?>" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-4 col-form-label">Pelanggan</label>
                        <div class="col-sm-8">
                            <input type="text" name="id_pelanggan" value="<?php echo $row['kode_pelanggan']; ?>"
                                required class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">Produk</label>
                        <div class="col-sm-8">
                            <input type="text" name="kode_produk" value="<?php echo $row['kode_barang']; ?>" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-4 col-form-label">Jumlah Produk</label>
                        <div class="col-sm-8">
                            <input type="number" name="jumlah_produk" value="<?php echo $row['jumlah_barang']; ?>"
                                required class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-4 col-form-label">Harga Produk</label>
                        <div class="col-sm-8">
                            <input type="number" name="harga_produk" required class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit
                                Form</button>
                        </div>
                    </div>

                </form>

            </div>
        </section>

    </main><!-- End #main -->
    <?php include 'root/footer.php'; ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include 'root/js.php'; ?>
</body>

</html>