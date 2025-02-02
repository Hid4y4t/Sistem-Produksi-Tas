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

                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#verticalycentered">
                                        <i class='bi bi-bag-plus me-1'></i>    Tambah Produk
                                    </button>

                                    <div class="modal fade" id="verticalycentered" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Produk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="proses_tambah_produk.php" method="post"
                                                        enctype="multipart/form-data">
                                                        <div class="row mb-3">
                                                            <label for="inputText"
                                                                class="col-sm-2 col-form-label">Nama</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    name="nama_produk" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputEmail"
                                                                class="col-sm-2 col-form-label">Harga Produk</label>
                                                            <div class="col-sm-10">
                                                                <input type="number" name="harga" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputPassword"
                                                                class="col-sm-2 col-form-label">Keterangan
                                                                Produk</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="deskripsi"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputPassword"
                                                                class="col-sm-2 col-form-label">foto Produk</label>
                                                            <div class="col-sm-10">
                                                                <input type="file" name="foto" accept="image/*" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>


                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-outline-primary"><i class='bi bi-bag-plus me-1'></i> Tambah Produk</button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Table with stripped rows -->
                                    <table class="table datatable table-striped">
                                        <thead>
                                            <tr>


                                                <th scope="col">Kode Produk</th>
                                                <th scope="col">Nama Produk</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Foto</th>

                                                <th scope="col">Action</th>
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
                                                <td>
                                                    <a
                                                        href="edit_produk.php?id=<?php echo $produk['id_produk']; ?>">Edit</a>
                                                    ||

                                                    <a href="hapus_produk.php?id_produk=<?php echo $produk['id_produk']; ?>"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>




                                                </td>

                                            </tr>


                                            <div class="modal fade" id="edit" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Pesanan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="row mb-3">
                                                                    <label for="inputText"
                                                                        class="col-sm-2 col-form-label">Nama</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputEmail"
                                                                        class="col-sm-2 col-form-label">Harga
                                                                        Produk</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputPassword"
                                                                        class="col-sm-2 col-form-label">Keterangan
                                                                        Produk</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputPassword"
                                                                        class="col-sm-2 col-form-label">foto
                                                                        Produk</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="file" class="form-control">
                                                                    </div>
                                                                </div>


                                                                <div class="row mb-3">
                                                                    <label class="col-sm-2 col-form-label"></label>
                                                                    <div class="col-sm-10">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Submit
                                                                            Form</button>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

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