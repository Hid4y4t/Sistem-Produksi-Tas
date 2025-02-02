<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Pelanggan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Edit Pelanggan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <?php
    include('../koneksi/koneksi.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Ambil data pesanan berdasarkan ID
        $sqlGetPesanan = "SELECT * FROM data_table WHERE id = '$id'";
        $result = $conn->query($sqlGetPesanan);
        $row = $result->fetch_assoc();

        if (!$row) {
            echo "Data pesanan tidak ditemukan.";
            exit();
        }
    } else {
        echo "ID pesanan tidak valid.";
        exit();
    }
    ?>
                <form class="row g-3" action="proses_edit_pesanan.php" method="post">
                    <div class="col-md-12">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <label for="inputName5" class="form-label">Pesanan Masuk</label>
                        <input type="number" name="pesanan_masuk" value="<?php echo $row['pesanan_masuk']; ?>" required
                            class="form-control" id="inputName5">
                    </div>
                    <div class="col-md-12">
                        <label for="inputEmail5" class="form-label">Deadline</label>
                        <input type="number" name="deadline" value="<?php echo $row['deadline']; ?>" required
                            class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-12">
                        <label for="inputName5" class="form-label">Pelanggan</label>
                        <input type="text" name="id_pelanggan" value="<?php echo $row['id_pelanggan']; ?>" readonly
                            class="form-control" id="inputName5">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail5" class="form-label">Produk</label>
                        <input type="text" name="kode_produk" value="<?php echo $row['kode_produk']; ?>" readonly
                            class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Harga Produk</label>
                        <input type="number" name="harga_produk" value="<?php echo $row['harga_produk']; ?>" required
                            class="form-control" id="inputPassword5">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Jumlah Produk</label>
                        <input type="number" name="jumlah_produk" value="<?php echo $row['jumlah_produk']; ?>" required
                            class="form-control" id="inputPassword5">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
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