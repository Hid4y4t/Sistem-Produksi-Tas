<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>

<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>
    <main id="main" class="main">



    <div class="card">
            

            <div class="card-body pb-0">
            <h5 class="card-title">Daftar Produk Terlaris</h5>

            <div id="productUsageChart" style="min-height: 400px;"></div>
            <?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

// Query untuk mendapatkan data produk yang paling banyak digunakan
$sqlProductUsage = "SELECT p.nama_produk, COUNT(ps.kode_produk) AS jumlah_produk
                    FROM proses_selesai ps
                    JOIN produk p ON ps.kode_produk = p.id_produk
                    GROUP BY p.id_produk
                    ORDER BY jumlah_produk DESC
                    LIMIT 5"; // Ambil 5 produk yang paling banyak digunakan
$resultProductUsage = $conn->query($sqlProductUsage);

if ($resultProductUsage) { // Periksa apakah query berhasil dieksekusi
    $productData = array();

    if ($resultProductUsage->num_rows > 0) {
        while ($row = $resultProductUsage->fetch_assoc()) {
            $productData[] = $row;
        }
    }
} else {
    echo "Error executing query: " . $conn->error;
}


?>

<script>
        // Mengambil data produk yang paling banyak digunakan dari PHP
        var productData = <?php echo json_encode($productData); ?>;

        // Menginisialisasi grafik ECharts
        var productUsageChart = echarts.init(document.querySelector("#productUsageChart"));

        // Menyiapkan data untuk grafik pie
        var pieData = productData.map(function(item) {
            return {
                value: item.jumlah_produk,
                name: item.nama_produk
            };
        });

        // Mengatur opsi grafik pie
        var options = {
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            series: [{
                name: 'Product Usage',
                type: 'pie',
                radius: '55%',
                data: pieData
            }]
        };

        // Mengatur opsi ke grafik
        productUsageChart.setOption(options);
    </script>

        <div class="pagetitle">
            <h1>Laporan Pendapatan</h1>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="row">
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Uang Pada Pesanan yang belum Di Proses</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <?php
                                        require_once '../koneksi/koneksi.php';

                                        // Mengambil total jumlah harga_produk dari data_table
                                        $sqlTotalHarga = "SELECT SUM(harga_produk) AS total_harga FROM data_table";
                                        $resultTotalHarga = $conn->query($sqlTotalHarga);

                                        if ($resultTotalHarga) {
                                            $rowTotalHarga = $resultTotalHarga->fetch_assoc();
                                            $totalHarga = $rowTotalHarga['total_harga'];

                                            // Mengubah format total harga menjadi format mata uang (Rupiah)
                                            $formattedTotalHarga = "Rp " . number_format($totalHarga, 2, ',', '.');

                                            echo "<h6> $formattedTotalHarga</h6>";
                                        } else {
                                            echo "Tidak ada data harga produk.";
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Uang Pada Pesanan yang Sedang di Proses</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <?php
                                    require_once '../koneksi/koneksi.php';
                                    // Mengambil total jumlah harga_produk dari data_table
                                    $sqlTotalHarga = "SELECT SUM(harga_produk) AS total_harga FROM antrian";
                                    $resultTotalHarga = $conn->query($sqlTotalHarga);

                                    if ($resultTotalHarga) {
                                        $rowTotalHarga = $resultTotalHarga->fetch_assoc();
                                        $totalHarga = $rowTotalHarga['total_harga'];

                                        // Mengubah format total harga menjadi format mata uang (Rupiah)
                                        $formattedTotalHarga = "Rp " . number_format($totalHarga, 2, ',', '.');

                                        echo "<h6> $formattedTotalHarga</h6>";
                                    } else {
                                        echo "Tidak ada data harga produk.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Uang Pada Pesanan yang sudah Selesai</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <div class="container">
                                        <?php
                                        require_once '../koneksi/koneksi.php';
                                        // Mengambil total jumlah harga_produk dari data_table
                                        $sqlTotalHarga = "SELECT SUM(harga_produk) AS total_harga FROM proses_selesai";
                                        $resultTotalHarga = $conn->query($sqlTotalHarga);
                                        if ($resultTotalHarga) {
                                            $rowTotalHarga = $resultTotalHarga->fetch_assoc();
                                            $totalHarga = $rowTotalHarga['total_harga'];

                                            // Mengubah format total harga menjadi format mata uang (Rupiah)
                                            $formattedTotalHarga = "Rp " . number_format($totalHarga, 2, ',', '.');

                                            echo "<h6> $formattedTotalHarga</h6>";
                                        } else {
                                            echo "Tidak ada data harga produk.";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pagetitle">
                    <h1>Laporan Pesanan</h1>
                </div><!-- End Page Title -->
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                Pesanan Masuk Belum Proses
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
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
                                                            <th>Nilai Tertinggi</th>
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
                                                            <td>" . $rowData['nilai_tertinggi'] . "</td>
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
                    <!-- Accordion Item #2 (Pesanan Dalam Proses) -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                aria-controls="flush-collapseTwo">
                                Pesanan Dalam Proses
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="container">
                                    <div class="container">
                                        <?php
                                            require_once '../koneksi/koneksi.php';

                                            // Mengambil jumlah data antrian
                                            $sqlJumlahAntrian = "SELECT COUNT(*) AS total_antrian FROM antrian";
                                            $resultJumlahAntrian = $conn->query($sqlJumlahAntrian);

                                            if ($resultJumlahAntrian) {
                                                $rowJumlahAntrian = $resultJumlahAntrian->fetch_assoc();
                                                $totalAntrian = $rowJumlahAntrian['total_antrian'];

                                                echo "<h3>Jumlah Data Antrian: $totalAntrian</h3>";
                                            } else {
                                                echo "Tidak ada data antrian.";
                                            }
                                            ?>

                                        <table class="table datatable">
                                            <thead>
                                                <tr>

                                                    <th>Selesai Eksekusi</th>
                                                    <th>Pesanan Masuk</th>
                                                    <th>Deadline</th>
                                                    <th>Nilai Tertinggi</th>
                                                    <th>ID Pelanggan</th>
                                                    <th>Kode Produk</th>
                                                    <th>Harga Produk</th>
                                                    <th>Jumlah Produk</th>
                                                    <th>Tanggal Input</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        // Query untuk mengambil data antrian
                                                        $sqlAntrian = "SELECT * FROM antrian";
                                                        $resultAntrian = $conn->query($sqlAntrian);

                                                        if ($resultAntrian && $resultAntrian->num_rows > 0) {
                                                            while ($rowAntrian = $resultAntrian->fetch_assoc()) {
                                                                echo "<tr>
                                                                    
                                                                        <td>" . $rowAntrian['selesai_eksekusi'] . "</td>
                                                                        <td>" . $rowAntrian['pesanan_masuk'] . "</td>
                                                                        <td>" . $rowAntrian['deadline'] . "</td>
                                                                        <td>" . $rowAntrian['nilai_tertinggi'] . "</td>
                                                                        <td>" . $rowAntrian['id_pelanggan'] . "</td>
                                                                        <td>" . $rowAntrian['kode_produk'] . "</td>
                                                                        <td>" . $rowAntrian['harga_produk'] . "</td>
                                                                        <td>" . $rowAntrian['jumlah_produk'] . "</td>
                                                                        <td>" . $rowAntrian['tanggal_input2'] . "</td>
                                                                    </tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='10'>Tidak ada data antrian.</td></tr>";
                                                        }
                                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion Item #3 (Total Selesai Proses) -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    Selesai Proses
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="container">
                                        <?php
                                        require_once '../koneksi/koneksi.php';

                                        // Mengambil jumlah data proses_selesai
                                        $sqlJumlahProsesSelesai = "SELECT COUNT(*) AS total_proses_selesai FROM proses_selesai";
                                        $resultJumlahProsesSelesai = $conn->query($sqlJumlahProsesSelesai);

                                        if ($resultJumlahProsesSelesai) {
                                            $rowJumlahProsesSelesai = $resultJumlahProsesSelesai->fetch_assoc();
                                            $totalProsesSelesai = $rowJumlahProsesSelesai['total_proses_selesai'];

                                            echo "<h3>Jumlah Data Proses Selesai: $totalProsesSelesai</h3>";
                                        } else {
                                            echo "Tidak ada data proses selesai.";
                                        }
                                        ?>

                                        <table class="table datatable">
                                            <thead>
                                                <tr>

                                                    <th>Selesai Eksekusi</th>
                                                    <th>Pesanan Masuk</th>
                                                    <th>Deadline</th>

                                                    <th>ID Pelanggan</th>
                                                    <th>Kode Produk</th>
                                                    <th>Harga Produk</th>
                                                    <th>Jumlah Produk</th>
                                                    <th>Tanggal Input</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Query untuk mengambil data proses_selesai
                                                $sqlProsesSelesai = "SELECT * FROM proses_selesai";
                                                $resultProsesSelesai = $conn->query($sqlProsesSelesai);

                                                if ($resultProsesSelesai && $resultProsesSelesai->num_rows > 0) {
                                                    while ($rowProsesSelesai = $resultProsesSelesai->fetch_assoc()) {
                                                        echo "<tr>
                                                            
                                                                <td>" . $rowProsesSelesai['selesai_eksekusi'] . "</td>
                                                                <td>" . $rowProsesSelesai['pesanan_masuk'] . "</td>
                                                                <td>" . $rowProsesSelesai['deadline'] . "</td>
                                                            
                                                                <td>" . $rowProsesSelesai['id_pelanggan'] . "</td>
                                                                <td>" . $rowProsesSelesai['kode_produk'] . "</td>
                                                                <td>" . $rowProsesSelesai['harga_produk'] . "</td>
                                                                <td>" . $rowProsesSelesai['jumlah_produk'] . "</td>
                                                                <td>" . $rowProsesSelesai['tanggal_input'] . "</td>
                                                            </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='10'>Tidak ada data proses selesai.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

               
                <div class="pagetitle">
                <br><br>
                    <h1> Data Pelanggan</h1>
                </div><!-- End Page Title -->
                <div class="container">
    <?php
    include('../koneksi/koneksi.php');

    // Mengambil total jumlah pelanggan
    $sqlTotalPelanggan = "SELECT COUNT(*) AS total_pelanggan FROM pelanggan";
    $resultTotalPelanggan = $conn->query($sqlTotalPelanggan);

    if ($resultTotalPelanggan->num_rows > 0) {
        $rowTotalPelanggan = $resultTotalPelanggan->fetch_assoc();
        $totalPelanggan = $rowTotalPelanggan['total_pelanggan'];

        echo "<h3>Total Pelanggan: $totalPelanggan</h3>";
    } else {
        echo "Tidak ada data pelanggan.";
    }
    ?>
</div>

<div class="container">
    <?php
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
</div>

        </section>

    </main><!-- End #main -->
    <?php include 'root/footer.php'; ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include 'root/js.php'; ?>
</body>

</html>