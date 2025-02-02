<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Pelanggan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Edit Pelanggan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
            <?php
    include('../koneksi/koneksi.php');
    
    if (isset($_GET['id'])) {
        $id_pelanggan = $_GET['id'];
        $sqlPelanggan = "SELECT * FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'";
        $resultPelanggan = $conn->query($sqlPelanggan);
        
        if ($resultPelanggan->num_rows > 0) {
            $rowPelanggan = $resultPelanggan->fetch_assoc();
            ?>
            <form class="row g-3" action="proses_edit_pelanggan.php" method="post">
                <div class="col-md-12">
                <input type="hidden" name="id_pelanggan" value="<?php echo $rowPelanggan['id_pelanggan']; ?>">
                  <label for="inputName5" class="form-label">Username</label>
                  <input type="text" name="username" value="<?php echo $rowPelanggan['username']; ?>" required class="form-control" id="inputName5">
                </div>
                <div class="col-md-12">
                  <label for="inputEmail5" class="form-label">Password</label>
                  <input type="password" name="password" value="<?php echo $rowPelanggan['password']; ?>" required class="form-control" id="inputEmail5">
                </div>
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Nama</label>
                  <input type="text" name="nama" value="<?php echo $rowPelanggan['nama']; ?>" required class="form-control" id="inputName5">
                </div>
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">Alamat</label>
                  <input type="text" name="alamat" value="<?php echo $rowPelanggan['alamat']; ?>" required class="form-control" id="inputEmail5">
                </div>
                <div class="col-md-6">
                  <label for="inputPassword5" class="form-label">No Telpon</label>
                  <input type="text" name="no_telepon" value="<?php echo $rowPelanggan['no_telepon']; ?>" required class="form-control" id="inputPassword5">
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

              <?php
        } else {
            echo "Data pelanggan tidak ditemukan.";
        }
    } else {
        echo "ID pelanggan tidak valid.";
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