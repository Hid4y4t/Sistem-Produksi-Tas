<?php 

require_once '../koneksi/koneksi.php';

// Mengambil semua data produk dari database
$sqlGetProduk = "SELECT * FROM produk";
$result = $conn->query($sqlGetProduk);

$produkData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produkData[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Produk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Data Produk</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">



                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data Produk</h5>

                                    <!-- Table with stripped rows -->
                                    <table class="table datatable">
                                        <thead>
                                            <tr>


                                                <th >Kode Produk</th>
                                                <th >Nama Produk</th>
                                                <th >Harga</th>
                                                <th >Keterangan</th>
                                                <th >Foto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($produkData as $produk) : ?>
                                            <tr>

                                                <td><?php echo $produk['id_produk']; ?></td>
                                                <td><?php echo $produk['nama_produk']; ?></td>
                                                <td>Rp<?php echo $produk['harga']; ?></td>
                                                <td><?php echo $produk['deskripsi']; ?></td>

                                                <td><img style="max-width: 20%;"
                                                        src="../assets/galeri/<?php echo $produk['foto']; ?>" alt="">
                                                </td>
                                               

                                            </tr>

                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->


            </div>
        </section>

    </main><!-- End #main -->
    <?php include 'root/footer.php'; ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include 'root/js.php'; ?>
</body>

</html>