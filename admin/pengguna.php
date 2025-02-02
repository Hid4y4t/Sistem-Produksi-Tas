<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Karyawan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Data Karwayan</li>
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
                                    <h5 class="card-title">Data Karyawan</h5>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#verticalycentered">
                                        Tambah Karyawan
                                    </button>
                                    <div class="modal fade" id="verticalycentered" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Karyawan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="proses_simpan_karyawan.php" method="post" enctype="multipart/form-data">
                                                        <div class="row mb-3">
                                                            <label for="inputText"
                                                                class="col-sm-2 col-form-label">Nama</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="nama"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-select" name="jenis_kelamin" 
                                                                    aria-label="Default select example">
                                                                    <option selected>Open this select menu</option>
                                                                    <option value="Laki-laki">Laki-laki</option>
                                                                    <option value="Perempuan">Perempuan</option>
                                                                    
                                                                </select>
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
                                                                    name="no_hp" required>
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
                                                            <label class="col-sm-2 col-form-label">Jabatan</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-select" name="jabatan" 
                                                                    aria-label="Default select example">
                                                                    <option selected>Open this select menu</option>
                                                                   
                                                                    <option value="Karyawan">Karyawan</option>
                                                                    <option value="Admin">Admin</option>
                                                                    <option value="Owner">Owner</option>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputPassword"
                                                                class="col-sm-2 col-form-label">foto</label>
                                                            <div class="col-sm-10">
                                                                <input type="file" class="form-control" name="foto"
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

                                    $sqlKaryawan = "SELECT * FROM karyawan";
                                    $resultKaryawan = $conn->query($sqlKaryawan);

                                    if ($resultKaryawan->num_rows > 0) {
                                        echo "<table class='table datatable'>
                                                <thead>
                                                    <th>ID Karyawan</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Alamat</th>
                                                    <th>No Telepon</th>
                                                    <th>foto</th>
                                                    <th>Action</th>
                                                </thead>";

                                        while ($rowKaryawan = $resultKaryawan->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $rowKaryawan['id'] . "</td>
                                                    <td>" . $rowKaryawan['nama'] . "</td>
                                                    <td>" . $rowKaryawan['jenis_kelamin'] . "</td>
                                                    <td>" . $rowKaryawan['alamat'] . "</td>
                                                    <td>" . $rowKaryawan['no_hp'] . "</td>
                                                    <td> <img style='max-width:20%;' src='". $rowKaryawan['foto'] . "'><td>
                                                    <td>
                                                        <a href='edit_karyawan.php?id=" . $rowKaryawan['id'] . "' class='btn btn-primary'><i class='bi bi-arrow-clockwise me-1'></i> Edit</a>
                                                        <a href='proses_hapus_karyawan.php?id=" . $rowKaryawan['id'] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'><i class='bi bi-trash me-1'></i> Hapus</a>
                                                    </td>
                                                </tr>";
                                        }

                                        echo "</table>";
                                    } else {
                                        echo "Tidak ada data .";
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