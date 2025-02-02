<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php' ?>

<body>
    <?php include 'root/navbar.php' ?>
  
    <?php

include '../koneksi/koneksi.php';

function getDataPelangganFromDatabase($id_pelanggan) {
    global $conn;
    $query = "SELECT * FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function updateDataPelanggan($id_pelanggan, $nama, $username, $no_telepon, $alamat, $password) {
    global $conn;

    // Hash password hanya jika ada perubahan
    $hashedPassword = empty($password) ? '' : password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE pelanggan SET nama = '$nama', username = '$username', no_telepon = '$no_telepon', alamat = '$alamat'";
    
    // Tambahkan password ke query hanya jika ada perubahan
    if (!empty($password)) {
        $query .= ", password = '$hashedPassword'";
    }

    $query .= " WHERE id_pelanggan = '$id_pelanggan'";
    $result = mysqli_query($conn, $query);

    return $result;
}
if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $dataPelanggan = getDataPelangganFromDatabase($id_pelanggan);

    if (!$dataPelanggan) {
        // Redirect atau lakukan tindakan lain jika data pelanggan tidak ditemukan
        header("Location: login.php");
        exit();
    }
} else {
    // Redirect atau lakukan tindakan lain jika sesi tidak ada
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
  
    $password = $_POST['password'];

    // Lanjutkan perubahan data
    if (updateDataPelanggan($id_pelanggan, $nama, $username, $no_telepon, $alamat,  $password)) {
        $_SESSION['notif'] = "Data pelanggan berhasil diperbarui.";
        $showNotification = true;
    } else {
        $_SESSION['notif'] = "Gagal memperbarui data pelanggan.";
    }

    // Redirect untuk menghindari reload form
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$showNotification = false;
?>
    <main id="main">
        <section section id="about" class="about" style="background-color: rgb(231, 228, 228);">
            <div class="container">

                <div class="section-title">
                    <h2>Account Detail</h2>

                </div>

                <div class="row content">
                    <?php include 'root/menu.php' ?>
                    <div class="col-lg-10 pt-4 pt-lg-0">
                        <a href="index.php"><i class="bi bi-caret-left"></i> Back</a> <br>
                        <h4 style="font-weight: bold;">Acount</h4>
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="row mb-3">
                                        <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nama" value="<?php echo $dataPelanggan['nama']; ?>"
                                                class="form-control" id="inputNama">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="username"
                                                value="<?php echo $dataPelanggan['username']; ?>" class="form-control"
                                                id="inputUsername">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputNoHp" class="col-sm-2 col-form-label">No Hp</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="no_telepon"
                                                value="<?php echo $dataPelanggan['no_telepon']; ?>" class="form-control"
                                                id="inputNoHp">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="alamat"
                                                value="<?php echo $dataPelanggan['alamat']; ?>" class="form-control"
                                                id="inputAlamat">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password" class="form-control"
                                                id="inputPassword" placeholder="Masukkan passwordjikaingin di rubah">
                                        </div>
                                    </div>

                                    <center>
                                        <button type="submit" name="submit" class="btn btn-primary">Simpan
                                            Perubahan</button>
                                    </center>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
        </section>
    </main>
    <?php include 'root/footer.php' ?>
</body>

</html>