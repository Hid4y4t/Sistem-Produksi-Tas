<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Produk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Edit Produk</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <?php
    require_once('../koneksi/koneksi.php');

    if(isset($_GET['id'])) {
        $id_produk = $_GET['id'];

        // Query untuk mengambil data produk berdasarkan ID
        $sqlGetProduk = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
        $resultGetProduk = $conn->query($sqlGetProduk);

        if($resultGetProduk->num_rows > 0) {
            $rowProduk = $resultGetProduk->fetch_assoc();
            ?>
                <form action="proses_edit_produk.php" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">'
                        <input type="hidden" name="id_produk" value="<?php echo $rowProduk['id_produk']; ?>">
                            <input type="text" class="form-control" name="nama_produk" value="<?php echo $rowProduk['nama_produk']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Harga Produk</label>
                        <div class="col-sm-10">
                            <input type="number" name="harga" value="<?php echo $rowProduk['harga']; ?>" required class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Keterangan
                            Produk</label>
                        <div class="col-sm-10">
                            <input type="text" name="deskripsi" value="<?php echo $rowProduk['deskripsi']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Edit foto Produk</label>
                        <div class="col-sm-10">
                            <input type="file" name="foto" accept="image/*"  class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label"> </label>
                        <div class="col-sm-10">
                            <img style="max-width: 20%;" src="../assets/galeri/<?php echo $rowProduk['foto']; ?>" alt="" srcset="">
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" name="submit" class="btn btn-primary">Submit
                                Form</button>
                        </div>
                    </div>

                </form>
                <?php
        } else {
            echo "Produk tidak ditemukan.";
        }
    }
    $conn->close();
    ?>

            </div>
        </section>

    </main><!-- End #main -->
    <?php include 'root/footer.php'; ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include 'root/js.php'; ?>
</body>

</html>