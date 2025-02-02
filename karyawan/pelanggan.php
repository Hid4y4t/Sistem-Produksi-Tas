<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Pelanggan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Data Pelanggan</li>
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
                                    <h5 class="card-title">Data Pelanggan</h5>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#verticalycentered">
                                        Tambah Pelanggan
                                    </button>
                                    <div class="modal fade" id="verticalycentered" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Pelanggan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="proses_tambah_pelanggan.php" method="post">
                                                        <div class="row mb-3">
                                                            <label for="inputText"
                                                                class="col-sm-2 col-form-label">Nama</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="nama"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputEmail"
                                                                class="col-sm-2 col-form-label">Alamat</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="alamat"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputPassword"
                                                                class="col-sm-2 col-form-label">Nomor Hp</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    name="no_telepon" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputPassword"
                                                                class="col-sm-2 col-form-label">Username</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="username"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputPassword"
                                                                class="col-sm-2 col-form-label">Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="password"
                                                                    required>
                                                            </div>
                                                        </div>


                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <button type="submit" class="btn btn-primary">Submit
                                                                    Form</button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Table with stripped rows -->



                                    <?php
                                    include('../koneksi/koneksi.php');

                                    $sqlPelanggan = "SELECT * FROM pelanggan";
                                    $resultPelanggan = $conn->query($sqlPelanggan);

                                    if ($resultPelanggan->num_rows > 0) {
                                        echo "<table class='table datatable'>
                                                <thead>
                                                    <th>ID Pelanggan</th>
                                                    <th>Nama Pelanggan</th>
                                                    <th>Alamat</th>
                                                    <th>No Telepon</th>
                                                    <th>Action</th>
                                                </thead>";

                                        while ($rowPelanggan = $resultPelanggan->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $rowPelanggan['id_pelanggan'] . "</td>
                                                    <td>" . $rowPelanggan['nama'] . "</td>
                                                    <td>" . $rowPelanggan['alamat'] . "</td>
                                                    <td>" . $rowPelanggan['no_telepon'] . "</td>
                                                    <td>
                                                        <a href='edit_pelanggan.php?id=" . $rowPelanggan['id_pelanggan'] . "' class='btn btn-primary'><i class='bi bi-arrow-clockwise me-1'></i> Edit</a>
                                                       
                                                    </td>
                                                </tr>";
                                        }

                                        echo "</table>";
                                    } else {
                                        echo "Tidak ada data pelanggan.";
                                    }

                                    $conn->close();
                                    ?>

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