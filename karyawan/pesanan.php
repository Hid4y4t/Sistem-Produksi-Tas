<?php 
require_once '../koneksi/koneksi.php';

// Query untuk mengambil data dari tabel order_pelanggan beserta informasi pelanggan dan barang
$sqlSelect = "SELECT op.id, p.nama, b.nama_produk, op.jumlah_barang, op.deadline, op.tanggal_input 
              FROM order_pelanggan op
              JOIN pelanggan p ON op.kode_pelanggan = p.id_pelanggan
              JOIN produk b ON op.kode_barang = b.id_produk";
$result = $conn->query($sqlSelect);

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Pesanan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Data Pesanan</li>
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
                                     <h5 class="card-title">Data Pesanan Masuk</h5>
                                <table class="table datatable">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Deadline</th>
                                    <th>Tanggal Input</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['nama_produk'] . "</td>";
                                        echo "<td>" . $row['jumlah_barang'] . "</td>";
                                        echo "<td>" . $row['deadline'] . "</td>";
                                        echo "<td>" . $row['tanggal_input'] . "</td>";
                                        echo "<td>
                                                <a href='masukan_orderan.php?id=" . $row['id'] . " '>Masukan Ke Data Pesanan</a> ||
                                                <a href='hapus_order.php?id=" . $row['id'] . " onclick='return confirm('Apakah Anda yakin ingin menghapus data ini?')'>Hapus</a>

                                            
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Tidak ada data order pelanggan.</td></tr>";
                                }
                                ?>
                            </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data Pesanan</h5>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#verticalycentered">
                                        Tambah Pesanan
                                    </button>
                                    <div class="modal fade" id="verticalycentered" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Pesanan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="proses_tambah_pesanan.php" method="post">
                                                        <div class="row mb-4">
                                                            <label for="inputText"
                                                                class="col-sm-4 col-form-label">Urutan</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="pesanan_masuk" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputEmail"
                                                                class="col-sm-4 col-form-label">Deadline</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="deadline" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputPassword"
                                                                class="col-sm-4 col-form-label">Pelanggan</label>
                                                            <div class="col-sm-8">
                                                                <select name="id_pelanggan" required
                                                                    class="form-control">
                                                                    <?php
                                                                    require_once '../koneksi/koneksi.php';

                                                                    $sqlPelanggan = "SELECT id_pelanggan, nama FROM pelanggan";
                                                                    $resultPelanggan = $conn->query($sqlPelanggan);

                                                                    if ($resultPelanggan->num_rows > 0) {
                                                                        while ($rowPelanggan = $resultPelanggan->fetch_assoc()) {
                                                                            echo "<option value='" . $rowPelanggan['id_pelanggan'] . "'>" . $rowPelanggan['nama'] . "</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputText"
                                                                class="col-sm-4 col-form-label">Produk</label>
                                                            <div class="col-sm-8">
                                                                <select name="kode_produk" class="form-control">
                                                                    <?php
                                                                    $sqlProduk = "SELECT id_produk, nama_produk FROM produk";
                                                                    $resultProduk = $conn->query($sqlProduk);

                                                                    if ($resultProduk->num_rows > 0) {
                                                                        while ($rowProduk = $resultProduk->fetch_assoc()) {
                                                                            echo "<option value='" . $rowProduk['id_produk'] . "'>" . $rowProduk['nama_produk'] . "</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputEmail"
                                                                class="col-sm-4 col-form-label">Jumlah Produk</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="jumlah_produk" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputEmail"
                                                                class="col-sm-4 col-form-label">Harga Produk</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="harga_produk" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">
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

                                    $sqlPesanan = "SELECT * FROM data_table";
                                    $resultPesanan = $conn->query($sqlPesanan);

                                    if ($resultPesanan->num_rows > 0) {
                                        echo "<table class='table datatable'>
                                                <thead>
                                                    <th>ID</th>
                                                    <th>Pesanan Masuk</th>
                                                    <th>Deadline</th>
                                                    <th>ID Pelanggan</th>
                                                    <th>Kode Produk</th>
                                                    <th>Harga Produk</th>
                                                    <th>Jumlah Produk</th>
                                                    <th>Action</th>
                                                </thead>";

                                        while ($rowPesanan = $resultPesanan->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $rowPesanan['id'] . "</td>
                                                    <td>" . $rowPesanan['pesanan_masuk'] . "</td>
                                                    <td>" . $rowPesanan['deadline'] . "</td>
                                                    <td>" . $rowPesanan['id_pelanggan'] . "</td>
                                                    <td>" . $rowPesanan['kode_produk'] . "</td>
                                                    <td>" . $rowPesanan['harga_produk'] . "</td>
                                                    <td>" . $rowPesanan['jumlah_produk'] . "</td>
                                                    <td>
                                                        <a href='edit_pesanan.php?id=".$rowPesanan['id'] . "' class='btn btn-primary'><i class='bi bi-pencil'></i> Edit</a>
                                                        <a href='hapus_pesanan.php?id=".$rowPesanan['id'] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pesanan ini?\")'><i class='bi bi-trash'></i> Hapus</a>
                                                    </td>
                                                </tr>";
                                        }

                                        echo "</table>";
                                    } else {
                                        echo "Tidak ada data pesanan.";
                                    }

                                    // $conn->close();
                                    ?>

                                    <!-- End Table with stripped rows -->




                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5>Daftar Pesanan Selesai Di Proses</h5>
                                    </div>

                                    <?php
                                    require_once('../koneksi/koneksi.php');
                                    $sqlProsesSelesai = "SELECT * FROM proses_selesai";
                                    $resultProsesSelesai = $conn->query($sqlProsesSelesai);
                                    if ($resultProsesSelesai->num_rows > 0) {
                                        echo "<table class='table datatable'>
                                                <thead>
                                                    <th>Selesai Eksekusi</th>
                                                    <th>Pesanan Masuk</th>
                                                    <th>Deadline</th>
                                                    <th>ID Pelanggan</th>
                                                    <th>Kode Produk</th>
                                                    <th>Harga Produk</th>
                                                    <th>Jumlah Produk</th>
                                                </thead>";
                                        while ($rowProsesSelesai = $resultProsesSelesai->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $rowProsesSelesai['selesai_eksekusi'] . "</td>
                                                    <td>" . $rowProsesSelesai['pesanan_masuk'] . "</td>
                                                    <td>" . $rowProsesSelesai['deadline'] . "</td>
                                                    <td>" . $rowProsesSelesai['id_pelanggan'] . "</td>
                                                    <td>" . $rowProsesSelesai['kode_produk'] . "</td>
                                                    <td>" . $rowProsesSelesai['harga_produk'] . "</td>
                                                    <td>" . $rowProsesSelesai['jumlah_produk'] . "</td>
                                                </tr>";
                                        }
                                        echo "</table>";
                                    } else {
                                        echo "Tidak ada data pada tabel proses_selesai.";
                                    }
                                    $conn->close();
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