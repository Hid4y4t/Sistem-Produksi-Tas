<?php



require_once '../koneksi/koneksi.php';
// Fungsi untuk mengupdate semua data "selesai_eksekusi" di tabel data_table
function updateAllSelesaiEksekusi($selesai_eksekusi) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE data_table SET selesai_eksekusi = '$selesai_eksekusi'";

    if ($conn->query($sql) === TRUE) {
        echo "Semua data berhasil diupdate.";
    } else {
        echo "Error updating records: " . $conn->error;
    }

    $conn->close();
}

// Fungsi untuk mendapatkan data dari tabel data_table yang diurutkan berdasarkan nilai_tertinggi
function getSortedData() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT *, ((selesai_eksekusi - pesanan_masuk) + deadline) / deadline AS nilai_tertinggi FROM data_table ORDER BY nilai_tertinggi DESC";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();
    return $data;
}

// Fungsi untuk mendapatkan data dari tabel antrian
function getAntrianData() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM antrian";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();
    return $data;
}
// Fungsi untuk memindahkan data ke tabel antrian dan menghapus data dari tabel data_table berdasarkan ID
function moveToAntrian($id) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ambil data berdasarkan ID dari tabel data_table
    $sqlData = "SELECT * FROM data_table WHERE id = $id";
    $resultData = $conn->query($sqlData);

    if ($resultData->num_rows > 0) {
        $rowData = $resultData->fetch_assoc();

        // Hitung nilai selesai_eksekusi untuk dimasukkan ke tabel antrian
        $selesai_eksekusi_antrian = $rowData['deadline'] + $rowData['selesai_eksekusi'];

        // Pindahkan data ke tabel antrian
        $sqlAntrian = "INSERT INTO antrian (selesai_eksekusi, pesanan_masuk, deadline, nilai_tertinggi, id_pelanggan, kode_produk, harga_produk, jumlah_produk, tanggal_input2) VALUES ($selesai_eksekusi_antrian, " . $rowData['pesanan_masuk'] . ", " . $rowData['deadline'] . ", " . $rowData['nilai_tertinggi'] . ", '" . $rowData['id_pelanggan'] . "', '" . $rowData['kode_produk'] . "', " . $rowData['harga_produk'] . ", " . $rowData['jumlah_produk'] . ", NOW())";
        if ($conn->query($sqlAntrian) === TRUE) {
            // Hapus data dari tabel data_table berdasarkan ID
            $sqlHapus = "DELETE FROM data_table WHERE id = '$id'";
            if ($conn->query($sqlHapus) === TRUE) {
               
            } else {
                echo "Error deleting record from Data Table: " . $conn->error;
            }
        } else {
            echo "Error inserting record to Antrian: " . $conn->error;
        }
        
    }

    $conn->close();
}


// Fungsi untuk memindahkan data dari tabel antrian ke tabel proses_selesai dan menghapus dari tabel antrian
function moveToProsesSelesai($id) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ambil data berdasarkan ID dari tabel antrian
    $sqlAntrian = "SELECT * FROM antrian WHERE id = $id";
    
    $resultAntrian = $conn->query($sqlAntrian);

    if ($resultAntrian->num_rows > 0) {
        $rowAntrian = $resultAntrian->fetch_assoc();

        // Pindahkan data ke tabel proses_selesai
        $sqlProsesSelesai = "INSERT INTO proses_selesai (selesai_eksekusi, pesanan_masuk, deadline, id_pelanggan, kode_produk, harga_produk, jumlah_produk, tanggal_input) VALUES (" . $rowAntrian['selesai_eksekusi'] . ", " . $rowAntrian['pesanan_masuk'] . ", " . $rowAntrian['deadline'] . ", '" . $rowAntrian['id_pelanggan'] . "', '" . $rowAntrian['kode_produk'] . "', " . $rowAntrian['harga_produk'] . ", " . $rowAntrian['jumlah_produk'] . ", NOW())";

        if ($conn->query($sqlProsesSelesai) === TRUE) {
            // Hapus data dari tabel antrian berdasarkan ID
            $sqlHapusAntrian = "DELETE FROM antrian WHERE id = '$id'";

            if ($conn->query($sqlHapusAntrian) === TRUE) {
                echo "Data berhasil diproses selesai dan dipindahkan ke tabel Proses Selesai.";
            } else {
                echo "Error deleting record from Antrian: " . $conn->error;
            }
        } else {
            echo "Error inserting record to Proses Selesai: " . $conn->error;
        }
    }

    $conn->close();
}


// Cek apakah ada data yang dikirimkan dari form pencarian
if (isset($_POST['selesai_eksekusi'])) {
    $selesai_eksekusi = $_POST['selesai_eksekusi'];

    // Panggil fungsi untuk mengupdate data
    updateAllSelesaiEksekusi($selesai_eksekusi);
}

// Cek apakah ada data yang dikirimkan dari tombol Move to Antrian
if (isset($_POST['move_to_antrian'])) {
    $id_to_move = $_POST['id_to_move'];

    // Panggil fungsi untuk memindahkan data ke tabel antrian dan menghapus dari tabel data_table berdasarkan ID
    moveToAntrian($id_to_move);
}

// Cek apakah ada data yang dikirimkan dari tombol Proses Selesai
if (isset($_POST['proses_selesai'])) {
    $id_to_proses = $_POST['id_to_proses'];

    // Panggil fungsi untuk memindahkan data dari tabel antrian ke tabel proses_selesai dan menghapus dari tabel antrian berdasarkan ID
    moveToProsesSelesai($id_to_proses);
}

// Dapatkan data yang sudah diurutkan
$sortedData = getSortedData();

// Dapatkan data antrian
$antrianData = getAntrianData();


// Fungsi untuk mendapatkan nilai terakhir dari kolom "selesai_eksekusi" pada tabel antrian
function getLastSelesaiEksekusi() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT selesai_eksekusi FROM antrian ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    $lastSelesaiEksekusi = 0; // Nilai default

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastSelesaiEksekusi = $row['selesai_eksekusi'];
    }

    $conn->close();
    return $lastSelesaiEksekusi;
}
$lastSelesaiEksekusi = getLastSelesaiEksekusi();

// Fungsi untuk mendapatkan nilai terakhir dari kolom "selesai_eksekusi" pada tabel proses_selesai
function getLastProsesSelesaiSelesaiEksekusi() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT selesai_eksekusi FROM proses_selesai ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    $lastSelesaiEksekusi = 0; // Nilai default

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastSelesaiEksekusi = $row['selesai_eksekusi'];
    }

    $conn->close();
    return $lastSelesaiEksekusi;
}
$lastProsesSelesaiSelesaiEksekusi = getLastProsesSelesaiSelesaiEksekusi();

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk menghitung jumlah baris (data) dalam tabel antrian
$sql = "SELECT COUNT(*) AS total_data FROM antrian";
$result = $conn->query($sql);

$totalData1 = 0; // Nilai default

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalData1 = $row['total_data'];
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
            <h1>Data Jadwal</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Data Jadwal</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-xxl-4 col-xl-12">

                            <div class="card info-card customers-card">


                                <div class="card-body">
                                    <h5 class="card-title"></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-table"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $totalData1; ?></h6>
                                            <span class="text-danger small pt-1 fw-bold">Pesanan Masih Dalam Proses
                                                Belum Selesai</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->

                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Daftar Antrian</h5>

                                    <!-- Table with stripped rows -->
                                    <table class="table datatable">
                                        <thead>
                                            <tr>


                                                <th scope="col">Nama </th>
                                                <th scope="col">ID Produk</th>
                                                <th scope="col">Jumlah Produk</th>
                                                <th scope="col">Harga Produk</th>
                                                <th scope="col">Masuk</th>
                                                <th scope="col">Deadline</th>
                                                <th scope="col">Selesai</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($antrianData as $antrian) : ?>

                                            <tr>

                                                <td><?php echo $antrian['id_pelanggan']; ?></td>
                                                <td><?php echo $antrian['kode_produk']; ?></td>
                                                <td><?php echo $antrian['jumlah_produk']; ?></td>
                                                <td><?php echo $antrian['harga_produk']; ?></td>
                                                <td><?php echo $antrian['pesanan_masuk']; ?></td>

                                                <td><?php echo $antrian['deadline']; ?></td>
                                                <td>Hari Ke <?php echo $antrian['selesai_eksekusi']; ?></td>
                                                <td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="id_to_proses"
                                                            value="<?php echo $antrian['id']; ?>">
                                                        <input type="submit" name="proses_selesai"
                                                            value="Proses Selesai">
                                                    </form>
                                                </td>

                                            </tr>
                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">


                                    <h5 class="card-title">Data Jadwal</h5>
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        Pesanan Trakhir Pada Antrian: Hari ke <b><?php echo $lastSelesaiEksekusi; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                        Pesanan Trakhir Pada Proses Selesai: Hari ke
                                        <b><?php echo $lastProsesSelesaiSelesaiEksekusi; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>

                                    <form action="" method="post">
                                        <label for="selesai_eksekusi">Masukkan data trakhir Selesai Eksekusi:</label>
                                        <input type="number" name="selesai_eksekusi" required>

                                        <input type="submit" value="Update Data">
                                    </form>

                                    <!-- Table with stripped rows -->
                                    <table class="table ">
                                        <thead>
                                            <tr>


                                                <th scope="col">ID Pelanggan </th>
                                                <th scope="col">ID Produk</th>
                                                <th scope="col">Jumlah Produk</th>
                                                <th scope="col">Harga Produk</th>
                                                <th scope="col">Masuk</th>
                                                <th scope="col">Deadline</th>
                                                <th scope="col">Prioritas</th>

                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sortedData as $data) : ?>
                                            <tr>

                                                <td><?php echo $data['id_pelanggan']; ?></td>
                                                <td><?php echo $data['kode_produk']; ?></td>
                                                <td><?php echo $data['jumlah_produk']; ?></td>
                                                <td><?php echo $data['harga_produk']; ?></td>
                                                <td><?php echo $data['pesanan_masuk']; ?></td>

                                                <td><?php echo $data['deadline']; ?></td>
                                                <td><?php echo $data['nilai_tertinggi']; ?></td>

                                                <td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="id_to_move"
                                                            value="<?php echo $data['id']; ?>">
                                                        <input type="submit" name="move_to_antrian"
                                                            value="Move to Antrian">
                                                    </form>

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