<?php
                                include '../koneksi/koneksi.php';

                                if (isset($_SESSION['id_pelanggan'])) {
                                    $id_pelanggan = $_SESSION['id_pelanggan'];

                                    // Query untuk mengambil semua data dari tabel order_pelanggan berdasarkan id_pelanggan
                                    $query = "SELECT op.*, p.nama_produk, p.harga FROM order_pelanggan op
                                            JOIN produk p ON op.kode_barang = p.id_produk
                                            WHERE op.kode_pelanggan = '$id_pelanggan'
                                            ORDER BY op.tanggal_input DESC"; // Menambahkan ORDER BY untuk mengurutkan berdasarkan tanggal_input descending
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        // Loop melalui hasil query dan tampilkan data
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // Hitung total harga
                                            $total_harga = $row['jumlah_barang'] * $row['harga'];

                                            // Tampilkan data dalam format yang sesuai dengan frontend
                                        // Tampilkan data dalam format yang sesuai dengan frontend
                                echo '<div class="notif">';
                                echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Envelope:">';
                                echo '<use xlink:href="#envelope-fill" />';
                                echo '</svg>';
                                echo '<a href="#">';
                                echo '<div class="alert alert-success d-flex align-items-center" role="alert">';
                                echo '<div class="">';
                                echo '<h4>Pesanan Belum  di Proses</h4>';
                                echo '<p>' . $row['tanggal_input'] . '</p>';
                                echo '</div>';
                                echo '<button class="btn btn-primary ms-auto" onclick="showPopup(\'' . $row['nama_produk'] . '\', ' . $row['jumlah_barang'] . ', ' . $total_harga . ')">Lihat</button>';
                                echo '</div>';
                                echo '</a>';
                                echo '</div>';

                                        }
                                    } else {
                                        // Jika terjadi error
                                        echo 'Error: ' . mysqli_error($conn);
                                    }

                                    mysqli_close($conn);
                                } else {
                                    echo 'Session id_pelanggan belum di-set.';
                                }
                                ?>