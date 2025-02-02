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
                                                  
                                                </thead>";

                                        while ($rowKaryawan = $resultKaryawan->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $rowKaryawan['id'] . "</td>
                                                    <td>" . $rowKaryawan['nama'] . "</td>
                                                    <td>" . $rowKaryawan['jenis_kelamin'] . "</td>
                                                    <td>" . $rowKaryawan['alamat'] . "</td>
                                                    <td>" . $rowKaryawan['no_hp'] . "</td>
                                                    <td> <img style='max-width:20%;' src='". $rowKaryawan['foto'] . "'><td>
                                                   
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