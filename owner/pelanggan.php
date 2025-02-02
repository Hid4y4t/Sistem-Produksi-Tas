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
                                                  
                                                </thead>";

                                        while ($rowPelanggan = $resultPelanggan->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $rowPelanggan['id_pelanggan'] . "</td>
                                                    <td>" . $rowPelanggan['nama'] . "</td>
                                                    <td>" . $rowPelanggan['alamat'] . "</td>
                                                    <td>" . $rowPelanggan['no_telepon'] . "</td>
                                                   
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