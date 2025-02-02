<?php
require_once '../koneksi/koneksi.php'; // Mengimpor koneksi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $username = $_POST['username'];
    $jabatan = $_POST['jabatan'];

    // Query untuk mendapatkan data pengguna yang akan diedit
    $sqlUser = "SELECT * FROM karyawan WHERE id = '$id'";
    $resultUser = $conn->query($sqlUser);
    $userData = $resultUser->fetch_assoc();

    if (!$userData) {
        echo "Data tidak ditemukan.";
        exit;
    }

    // Cek apakah ada upload gambar baru
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "../assets/karyawan/"; // Folder tujuan penyimpanan foto
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        // Query update dengan ganti foto
        $sqlUpdate = "UPDATE karyawan SET 
                        nama = '$nama', 
                        jenis_kelamin = '$jenis_kelamin', 
                        alamat = '$alamat', 
                        no_hp = '$no_hp', 
                        username = '$username', 
                        foto = '$target_file', 
                        jabatan = '$jabatan' 
                      WHERE id = '$id'";
    } else {
        // Query update tanpa ganti foto
        $sqlUpdate = "UPDATE karyawan SET 
                        nama = '$nama', 
                        jenis_kelamin = '$jenis_kelamin', 
                        alamat = '$alamat', 
                        no_hp = '$no_hp', 
                        username = '$username', 
                        jabatan = '$jabatan' 
                      WHERE id = '$id'";
    }

    if ($conn->query($sqlUpdate) === TRUE) {
        header("Location: pengguna.php");
    } else {
        echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Jika tidak ada data POST, tampilkan formulir edit
    $id = $_GET['id'];

    $sqlUser = "SELECT * FROM karyawan WHERE id = '$id'";
    $resultUser = $conn->query($sqlUser);
    $userData = $resultUser->fetch_assoc();

    if (!$userData) {
        echo "Data tidak ditemukan.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Karyawan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Edit Karyawan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
            <?php
    include('../koneksi/koneksi.php');
    
    if (isset($_GET['id'])) {
        $id_karyawan = $_GET['id'];
        $sqlkaryawan = "SELECT * FROM karyawan WHERE id = '$id_karyawan'";
        $resultkaryawan = $conn->query($sqlkaryawan);
        
        if ($resultkaryawan->num_rows > 0) {
            $rowkaryawan = $resultkaryawan->fetch_assoc();
            ?>
           <form class="row g-3" action="" method="post" enctype="multipart/form-data">
                
                <div class="col-md-12">
                <input type="hidden" name="id" value="<?php echo $rowkaryawan['id']; ?>">
                      <label for="inputName5" class="form-label">Nama</label>
                      <input type="text" name="nama" value="<?php echo $rowkaryawan['nama']; ?>" required class="form-control" id="inputName5">
                    </div>
                    <div class="col-md-12">
                      <label for="inputName5" class="form-label">Jenis_kelamin</label>
                      <input type="text" name="jenis_kelamin" value="<?php echo $rowkaryawan['jenis_kelamin']; ?>" required class="form-control" id="inputName5">
                    </div>
                <div class="col-md-12">
                    
                      <label for="inputName5" class="form-label">Username</label>
                      <input type="text" name="username" value="<?php echo $rowkaryawan['username']; ?>" required class="form-control" id="inputName5">
                    </div>
                    <div class="col-md-12">
                      <label for="inputEmail5" class="form-label">Password</label>
                      <input type="password" name="password" value="<?php echo $rowkaryawan['password']; ?>" required class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-12">
                      <label for="inputEmail5" class="form-label">Password</label>
                      <input type="password_baru" name="password"   class="form-control" id="inputEmail5">
                    </div>
                    
                    <div class="col-md-6">
                      <label for="inputEmail5" class="form-label">Alamat</label>
                      <input type="text" name="alamat" value="<?php echo $rowkaryawan['alamat']; ?>" required class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-6">
                      <label for="inputPassword5" class="form-label">No Telpon</label>
                      <input type="text" name="no_hp" value="<?php echo $rowkaryawan['no_hp']; ?>" required class="form-control" id="inputPassword5">
                    </div>
                    <div class="col-md-6">
                      <label for="inputEmail5" class="form-label">Jabatan</label>
                      <input type="text" name="jabatan" value="<?php echo $rowkaryawan['jabatan']; ?>" required class="form-control" id="inputEmail5">
                    </div>
                     <div class="col-md-6">
                      <label for="inputPassword5" class="form-label">foto</label>
                     <img style="max-width: 20%;" src="<?php echo $rowkaryawan['foto']; ?>" alt="">
                    </div>
                    <div class="col-md-12">
                      <label for="inputPassword5" class="form-label"></label>
                      <input type="file" name="foto"   class="form-control" id="inputPassword5">
                    </div>
                    
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                  </form>

              <?php
        } else {
            echo "Data karyawan tidak ditemukan.";
        }
    } else {
        echo "ID karyawan tidak valid.";
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