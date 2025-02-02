<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-xxl-4 col-md-3">
                            <div class="card info-card sales-card">


                                <div class="card-body">
                                    <h5 class="card-title"></h5>


                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
    include('../koneksi/koneksi.php');

    // Mengambil total jumlah pelanggan
    $sqlTotalPelanggan = "SELECT COUNT(*) AS total_pelanggan FROM pelanggan";
    $resultTotalPelanggan = $conn->query($sqlTotalPelanggan);

    if ($resultTotalPelanggan->num_rows > 0) {
        $rowTotalPelanggan = $resultTotalPelanggan->fetch_assoc();
        $totalPelanggan = $rowTotalPelanggan['total_pelanggan'];

        echo "<h3> $totalPelanggan</h3>";
    } else {
        echo "Tidak ada data pelanggan.";
    }
    ?>
                                            <span class="text-success small pt-1 fw-bold">Pelanggan </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-3">
                            <div class="card info-card revenue-card">


                                <div class="card-body">
                                    <h5 class="card-title"></h5>


                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

// Query untuk mendapatkan jumlah data pesanan
$sqlTotalPesanan = "SELECT COUNT(*) AS total_pesanan FROM data_table";
$resultTotalPesanan = $conn->query($sqlTotalPesanan);

if ($resultTotalPesanan) { // Periksa apakah query berhasil dieksekusi
    $rowTotalPesanan = $resultTotalPesanan->fetch_assoc();
    $totalPesanan = $rowTotalPesanan['total_pesanan'];
} else {
    echo "Error executing query: " . $conn->error;
}


?>
                                            <h6><?php echo $totalPesanan; ?></h6>
                                            <span class="text-success small pt-1 fw-bold">Pesanan</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-3">

                            <div class="card info-card customers-card">

                                <div class="card-body">
                                    <h5 class="card-title"></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-calendar-week"></i>
                                        </div>
                                        <div class="ps-3">

                                            <?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

// Mendapatkan tanggal awal dan akhir minggu ini
$today = date("Y-m-d");
$startOfWeek = date('Y-m-d', strtotime('this week', strtotime($today)));
$endOfWeek = date('Y-m-d', strtotime('next week', strtotime($today)));

$sqlTotalPesananMingguIni = "SELECT COUNT(*) AS total_pesanan_minggu_ini FROM data_table WHERE DATE(tanggal_input3) >= DATE(NOW()) - INTERVAL 7 DAY";

$resultTotalPesananMingguIni = $conn->query($sqlTotalPesananMingguIni);

if ($resultTotalPesananMingguIni) {
    $row = $resultTotalPesananMingguIni->fetch_assoc();
    $totalPesananMingguIni = $row['total_pesanan_minggu_ini'];
    if ($resultTotalPesananMingguIni === false) {
        echo "Error executing query: " . $conn->error;
    }
    
} else {
    echo "Error executing query: " . $conn->error;
    $totalPesananMingguIni = 0; // Atur nilai default jika query gagal
}



?>
                                            <h6><?php echo isset($totalPesananMingguIni) ? $totalPesananMingguIni : 0; ?>
                                            </h6>
                                            <span class="text-danger small pt-1 fw-bold">Pesanan Minggu Ini</span>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->
                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-3">

                            <div class="card info-card customers-card">


                                <div class="card-body">
                                    <h5 class="card-title"></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-table"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

// Mendapatkan tanggal awal dan akhir bulan ini
$firstDayOfMonth = date('Y-m-01');
$lastDayOfMonth = date('Y-m-t');

$sqlTotalPesananBulanIni = "SELECT COUNT(*) AS total_pesanan_bulan_ini FROM data_table WHERE DATE(tanggal_input3) BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";

$resultTotalPesananBulanIni = $conn->query($sqlTotalPesananBulanIni);

if ($resultTotalPesananBulanIni) {
    $row = $resultTotalPesananBulanIni->fetch_assoc();
    $totalPesananBulanIni = $row['total_pesanan_bulan_ini'];
} else {
    echo "Error executing query: " . $conn->error;
    $totalPesananBulanIni = 0; // Atur nilai default jika query gagal
}


?>

                                            <h6><?php echo isset($totalPesananBulanIni) ? $totalPesananBulanIni : 0; ?>
                                            </h6>

                                            <span class="text-danger small pt-1 fw-bold">Pesanan Bulan Ini</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->


                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data Pesanan</h5>


                                    <?php
                                        require_once '../koneksi/koneksi.php';
                                        $sqlJumlahData = "SELECT COUNT(pesanan_masuk) AS jumlah_data_pesanan_masuk FROM data_table";
                                        $resultJumlahData = $conn->query($sqlJumlahData);
                                        if ($resultJumlahData->num_rows > 0) {
                                            $rowJumlahData = $resultJumlahData->fetch_assoc();
                                            $jumlahDataPesananMasuk = $rowJumlahData['jumlah_data_pesanan_masuk'];
                                            echo "<h4>Jumlah Data Pesanan Masuk: $jumlahDataPesananMasuk</h4>";
                                            $sqlData = "SELECT * FROM data_table";
                                            $resultData = $conn->query($sqlData);
                                            if ($resultData->num_rows > 0) {
                                                echo "<table class='table datatable'>
                                                        <thead>
                                                        
                                                            <th>Selesai Eksekusi</th>
                                                            <th>Pesanan Masuk</th>
                                                            <th>Deadline</th>
                                                            
                                                            <th>ID Pelanggan</th>
                                                            <th>Kode Produk</th>
                                                            <th>Harga Produk</th>
                                                            <th>Jumlah Produk</th>
                                                            <th>Tanggal Input</th>
                                                        </thead>";

                                                while ($rowData = $resultData->fetch_assoc()) {
                                                    echo "<tr>
                                                        
                                                            <td>" . $rowData['selesai_eksekusi'] . "</td>
                                                            <td>" . $rowData['pesanan_masuk'] . "</td>
                                                            <td>" . $rowData['deadline'] . "</td>
                                                           
                                                            <td>" . $rowData['id_pelanggan'] . "</td>
                                                            <td>" . $rowData['kode_produk'] . "</td>
                                                            <td>" . $rowData['harga_produk'] . "</td>
                                                            <td>" . $rowData['jumlah_produk'] . "</td>
                                                            <td>" . $rowData['tanggal_input3'] . "</td>
                                                        </tr>";
                                                }
                                                echo "</table>";
                                            } else {
                                                echo "Tidak ada data.";
                                            }
                                        } else {
                                            echo "Tidak ada data pesanan masuk.";
                                        }
                                        ?>
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