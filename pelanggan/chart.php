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
                   
                        <h4 style="font-weight: bold;">Chart</h4> <br>
                        <div id="notification"
                            style="display: none; background-color: #4CAF50; color: white; text-align: center; padding: 20px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 999;">
                            Barang berhasil dikirim!
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <?php
                                include '../koneksi/koneksi.php';

                                // Pastikan session id_pelanggan sudah di-set
                                if (!isset($_SESSION['id_pelanggan'])) {
                                    die("Error: Session id_pelanggan belum di-set.");
                                }

                                $id_pelanggan = $_SESSION['id_pelanggan'];

                                // Variable totalHarga diinisialisasi dengan nilai 0
                                $totalHarga = 0;

                                // Query untuk mendapatkan data keranjang berdasarkan id_pelanggan
                                $queryKeranjang = "SELECT * FROM keranjang WHERE id_pelanggan = '$id_pelanggan'";
                                $resultKeranjang = mysqli_query($conn, $queryKeranjang);

                                // Loop melalui hasil query dan tampilkan data keranjang
                                while ($rowKeranjang = mysqli_fetch_assoc($resultKeranjang)) {
                                    $id_produk = $rowKeranjang['id_produk'];

                                    // Query untuk mendapatkan data produk berdasarkan id_produk
                                    $queryProduk = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
                                    $resultProduk = mysqli_query($conn, $queryProduk);
                                    $rowProduk = mysqli_fetch_assoc($resultProduk);

                                    // Tampilkan data produk sebagai satu blok
                                    echo '<div class="data-chart" style="background-color: white; border-radius: 10px; padding: 10px; display: flex; align-items: center; justify-content: space-between;">';
                                  
                                    echo '<div class="form-check">';
                                    echo '<input class="form-check-input" style="width: 20px; height: 20px;" type="radio" name="produk_id" value="' . $rowProduk['id_produk'] . '" data-harga="' . $rowProduk['harga'] . '">';
                                  
                                    echo '</div>';
                             
                                    echo '<img style="width: 15%; border-radius: 10px; margin-left: 20px;" src="../assets/galeri/' . $rowProduk['foto'] . '" alt="">';
                                    echo '<h5 style="margin-left: 40px;"><b>' . $rowProduk['nama_produk'] . '</b></h5>';
                                    echo '<h5 style="margin-left: 40px;">Rp ' . number_format($rowProduk['harga']) . '</h5>';
                                    echo '<b> Jumlah :</b> <input id="jumlah_' . $rowProduk['id_produk'] . '" style="width: 60px; border-radius: 10px; padding: 10px;" type="number" name="jumlah" value="' . $rowKeranjang['jumlah'] . '">';
                                    echo '<b> Deadline :</b> <input style="width: 60px; border-radius: 10px; padding: 10px;" type="number" name="deadline" value="7"> ';
                                    echo '<button class="hapus-btn" style="background-color: aqua; border: none; border-radius: 5px;" data-id="' . $rowProduk['id_produk'] . '"><i class="bi bi-x"></i></button>';

    
                                    echo '</div>';
                                    echo '<br>';

                                    // Hitung totalHarga untuk setiap produk
                                    $totalHarga += $rowProduk['harga'] * $rowKeranjang['jumlah'];
                                }

                                // Menampilkan totalHarga di luar loop
                                echo '<div class="kirim" style="background-color: white; border-radius: 10px; padding: 10px; display: flex; align-items: center; justify-content: center;">';
                                echo '<h4 style="flex: 1;"><b id="total">Total: Rp ' . number_format($totalHarga) . '</b></h4>';
                                echo '<button id="btnKirim" style="background-color: blue; border: none; color: white; padding: 10px; border-radius: 10px;">Kirim</button>';
                                echo '</div>';

                                // Menutup koneksi database
                                mysqli_close($conn);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'root/footer.php' ?>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
    const radioButtons = document.querySelectorAll('.form-check-input[type="radio"]');
    const totalElement = document.getElementById('total');
    const hapusButtons = document.querySelectorAll('.hapus-btn');

    radioButtons.forEach(function (radioButton) {
        radioButton.addEventListener('change', function () {
            calculateTotal();
            updateTotal();
        });
    });

    hapusButtons.forEach(function (hapusButton) {
        hapusButton.addEventListener('click', function () {
            const idProduk = hapusButton.dataset.id;
            confirmAndRemoveFromFavorites(idProduk);
        });
    });


        // Menambah event listener untuk input jumlah
        const jumlahInputs = document.querySelectorAll('input[name="jumlah"]');
        jumlahInputs.forEach(function(jumlahInput) {
            jumlahInput.addEventListener('change', function() {
                updateTotal();
            });
        });


        function confirmAndRemoveFromFavorites(idProduk) {
        const confirmation = confirm("Hapus produk dari favorit?");
        if (confirmation) {
            // Kirim data ke server menggunakan AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'proses_hapus_favorite.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Tanggapan dari server
                    console.log(xhr.responseText);

                    // Tampilkan notifikasi atau tindakan lanjutan setelah penghapusan berhasil
                    // Contoh: reload halaman
                    location.reload();
                }
            };

            // Kumpulkan data sebagai string URL-encoded
            const data = 'id_produk=' + idProduk;

            // Kirim data
            xhr.send(data);
        }
    }
        function calculateTotal() {
            let totalHarga = 0;
            radioButtons.forEach(function(radioButton) {
                if (radioButton.checked) {
                    const jumlahInput = document.getElementById('jumlah_' + radioButton.value);
                    const hargaProduk = parseFloat(radioButton.dataset.harga);
                    const jumlah = parseFloat(jumlahInput.value);
                    totalHarga += hargaProduk * jumlah;
                }
            });

            totalElement.innerText = "Total: Rp " + totalHarga.toLocaleString();
        }

        function updateTotal() {
            let totalHarga = 0;
            radioButtons.forEach(function(radioButton) {
                if (radioButton.checked) {
                    const jumlahInput = document.getElementById('jumlah_' + radioButton.value);
                    const hargaProduk = parseFloat(radioButton.dataset.harga);
                    const jumlah = parseFloat(jumlahInput.value);
                    totalHarga += hargaProduk * jumlah;
                }
            });

            totalElement.innerText = "Total: Rp " + totalHarga.toLocaleString();
        }

        // Panggil calculateTotal saat halaman dimuat
        calculateTotal();

    });

    document.addEventListener("DOMContentLoaded", function() {
        const btnKirim = document.getElementById('btnKirim');
        const notification = document.getElementById('notification');

        btnKirim.addEventListener('click', function() {
            // Ambil data yang diperlukan
            const radioChecked = document.querySelector('.form-check-input[type="radio"]:checked');
            const jumlahInput = document.getElementById('jumlah_' + radioChecked.value);
            const deadlineInput = document.querySelector('input[name="deadline"]');
            const kodeProduk = radioChecked.value;
            const jumlahBarang = jumlahInput.value;
            const deadline = deadlineInput.value;

            // Kirim data ke server menggunakan AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'proses_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Tanggapan dari server
                    console.log(xhr.responseText);

                    // Tampilkan notifikasi jika barang berhasil dikirim
                    showNotification();

                    // Tambahkan logika atau tindakan lanjutan setelah proses berhasil
                }
            };

            // Kumpulkan data sebagai string URL-encoded
            const data = 'jumlah_barang=' + jumlahBarang + '&deadline=' + deadline + '&kode_produk=' +
                kodeProduk;

            // Kirim data
            xhr.send(data);
        });

        // Fungsi untuk menampilkan notifikasi
        function showNotification() {
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000); // Notifikasi akan disembunyikan setelah 3 detik
        }
    });
    </script>



</body>

</html>