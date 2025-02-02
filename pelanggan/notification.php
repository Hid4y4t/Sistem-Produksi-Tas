<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php' ?>

<body>
    <?php include 'root/navbar.php' ?>


    <main id="main">
        <section section id="about" class="about" style="background-color: rgb(231, 228, 228);">
            <div class="container">

                <div class="section-title">
                    <!-- <h2>Favorite</h2> -->

                </div>

                <div class="row content">
                    <?php include 'root/menu.php' ?>
                    <div class="col-lg-10 pt-4 pt-lg-0">
                    <a href="index.php"><i class="bi bi-caret-left"></i> Back</a> <br>
                        <h4 style="font-weight: bold;">Notification</h4> <br>
                        <div class="container mt-5">
       
                        <div class="dashboard">
                            <div class="card">

                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Pesanan</h5>

                                    <div class="activity">
                                        <?php
                                            require_once '../koneksi/koneksi.php'; 
                                            // Anda perlu mengganti 'id_pelanggan' dengan nama variabel yang sesuai
                                            $id_pelanggan = $_SESSION['id_pelanggan']; // Ganti dengan nama variabel sesuai dengan data pelanggan yang telah di-set saat login

                                            // Query untuk menghitung jumlah pesanan berdasarkan ID pelanggan
                                            $sqlCountPending = "SELECT COUNT(*) as total FROM order_pelanggan WHERE kode_pelanggan = '$id_pelanggan'";
                                            $sqlCountQueue = "SELECT COUNT(*) as total FROM data_table WHERE id_pelanggan = '$id_pelanggan'";
                                            $sqlCountProcessing = "SELECT COUNT(*) as total FROM antrian WHERE id_pelanggan = '$id_pelanggan'";
                                            $sqlCountCompleted = "SELECT COUNT(*) as total FROM proses_selesai WHERE id_pelanggan = '$id_pelanggan'";

                                            $resultPending = $conn->query($sqlCountPending);
                                            $resultQueue = $conn->query($sqlCountQueue);
                                            $resultProcessing = $conn->query($sqlCountProcessing);
                                            $resultCompleted = $conn->query($sqlCountCompleted);

                                            $countPending = $resultPending->fetch_assoc()['total'];
                                            $countQueue = $resultQueue->fetch_assoc()['total'];
                                            $countProcessing = $resultProcessing->fetch_assoc()['total'];
                                            $countCompleted = $resultCompleted->fetch_assoc()['total'];

                                            ?>

                                        <div class="activity-item d-flex">
                                            <div class="activite-label"><?php echo $countPending; ?> </div> &nbsp;
                                            &nbsp;
                                            <i
                                                class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                            <div class="activity-content"> &nbsp; &nbsp;
                                                pesanan belum di proses
                                            </div>
                                        </div><!-- End activity item-->

                                        <div class="activity-item d-flex">
                                            <div class="activite-label"><?php echo $countQueue; ?> </div> &nbsp; &nbsp;
                                            <i
                                                class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                            <div class="activity-content"> &nbsp; &nbsp;
                                                pesanan dalam antrian
                                            </div>
                                        </div><!-- End activity item-->

                                        <div class="activity-item d-flex">
                                            <div class="activite-label"><?php echo $countProcessing; ?> </div> &nbsp;
                                            &nbsp;
                                            <i
                                                class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                            <div class="activity-content">
                                                &nbsp; &nbsp; pesanan dalam proses
                                            </div>
                                        </div><!-- End activity item-->

                                        <div class="activity-item d-flex">
                                            <div class="activite-label"><?php echo $countCompleted; ?> </div> &nbsp;
                                            &nbsp;
                                            <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                            &nbsp; &nbsp;
                                            <div class="activity-content">
                                                pesanan selesai
                                            </div>
                                        </div><!-- End activity item-->

                                    </div>

                                </div>




                            </div>



                        </div>

                        <hr>
                        <div class="pesanan1">
                        <?php include 'pesanan_belum_diproses.php'; ?>

                        </div>

                        <div class="pesanan2">
                        <?php include 'pesanan_dalam_antrian.php'; ?>

                        </div>

                        <div class="pesanan3">
                          
                        <?php include 'pesanan_dalam_proses.php'; ?>
                        </div>

                        <div class="psesanan4">
                           <?php include 'proses_selesai.php'; ?>

                        </div>
                        </div></div></div></div></section></main>
                        <script>
                        // Tambahkan ini di bagian JavaScript
                        function showPopup(namaProduk, jumlah, harga) {
                            Swal.fire({
                                title: 'Detail Pesanan',
                                html: '<b>Nama Produk:</b> ' + namaProduk + '<br>' +
                                    '<b>Jumlah:</b> ' + jumlah + '<br>' +
                                    '<b>Total Harga:</b> Rp ' + harga,
                                icon: 'success'
                            });
                        }
                        </script>


                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js">
                        </script>


<script>
function cetakInvoice(id) {
 // Kirim permintaan pencetakan invoice ke skrip PHP';
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {
     // Redirect ke file PDF yang dibuat';
   window.open(this.responseText, "_blank");
    }
 };
 xhr.open("GET", "cetak_invoice.php?id=" + id, true);
  xhr.send();
}
</script>
<?php include 'root/footer.php' ?>
</body>

</html>