-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jan 2024 pada 02.15
-- Versi server: 10.3.15-MariaDB
-- Versi PHP: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ud_hartono_collection`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `id` int(11) NOT NULL,
  `selesai_eksekusi` int(11) NOT NULL,
  `pesanan_masuk` int(11) NOT NULL,
  `deadline` int(11) NOT NULL,
  `nilai_tertinggi` float NOT NULL,
  `id_pelanggan` varchar(11) DEFAULT NULL,
  `kode_produk` varchar(50) DEFAULT NULL,
  `harga_produk` decimal(10,2) DEFAULT NULL,
  `jumlah_produk` int(11) DEFAULT NULL,
  `tanggal_input2` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_table`
--

CREATE TABLE `data_table` (
  `id` int(11) NOT NULL,
  `selesai_eksekusi` int(11) DEFAULT NULL,
  `pesanan_masuk` int(11) NOT NULL,
  `deadline` int(11) NOT NULL,
  `nilai_tertinggi` decimal(10,2) GENERATED ALWAYS AS ((`pesanan_masuk` - `selesai_eksekusi` + `deadline`) / `deadline`) STORED,
  `id_pelanggan` varchar(11) DEFAULT NULL,
  `kode_produk` varchar(50) DEFAULT NULL,
  `harga_produk` decimal(10,2) DEFAULT NULL,
  `jumlah_produk` int(11) DEFAULT NULL,
  `tanggal_input3` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `favorite`
--

CREATE TABLE `favorite` (
  `id_favorite` int(11) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `id_pelanggan` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` varchar(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `jenis_kelamin`, `alamat`, `no_hp`, `username`, `password`, `foto`, `jabatan`) VALUES
('KHC001', 'sayus', 'Laki-laki', 'a', '123', 'a', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', '../assets/karyawan/997B98495B1DDC1B21.jpg', 'Owner'),
('KHC002', 'b', 'Laki-laki', 'b', '2', 'b', '3e23e8160039594a33894f6564e1b1348bbd7a0088d42c4acb73eeaed59c009d', '../assets/karyawan/1_5IYtIe5OwxeoYXi226J-Uw.jpeg', 'Admin'),
('KHC003', 'c', 'Perempuan', 'c', '1', 'c', '2e7d2c03a9507ae265ecf5b5356885a53393a2029d241394997265a1a25aefc6', '../assets/karyawan/stampel 2.png', 'Karyawan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_chart` int(11) NOT NULL,
  `id_produk` varchar(111) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `id_pelanggan` varchar(111) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id_chart`, `id_produk`, `jumlah`, `id_pelanggan`) VALUES
(8, 'PR001', 2, 'PLG004'),
(9, 'PR003', 1, 'PLG004');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_pelanggan`
--

CREATE TABLE `order_pelanggan` (
  `id` int(11) NOT NULL,
  `kode_pelanggan` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `deadline` int(11) NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order_pelanggan`
--

INSERT INTO `order_pelanggan` (`id`, `kode_pelanggan`, `kode_barang`, `jumlah_barang`, `deadline`, `tanggal_input`) VALUES
(36, 'PLG004', 'PR003', 2, 7, '2023-12-02 22:30:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `no_telepon`, `username`, `password`) VALUES
('PLG004', 'qq', 'qq', '11', 'qq', 'd5ce2b19fbda14a25deac948154722f33efd37b369a32be8f03ec2be8ef7d3a5'),
('PLG005', 'ayub', 'suko harjo kota', '0254842512514', 'aass', 'ef18b90aec166cb245d316f5489d09fac8c3edc58496095c375b59989d6fabc1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `tanggal_input` date NOT NULL,
  `terakhir_diupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `deskripsi`, `harga`, `tanggal_input`, `terakhir_diupdate`, `foto`) VALUES
('PR001', 'Tas Kulit Payet', 'tas dengan payet ', '200000.00', '2023-12-02', '2023-12-02 15:47:02', 'pngwing.com (29).png'),
('PR002', 'Tas Jinjing', 'tersedia warna pink', '1000000.00', '2023-12-02', '2023-12-01 17:00:00', 'pngwing.com (30).png'),
('PR003', 'Tas LV', 'Ts dengan Logo LV', '500000.00', '2023-12-02', '2023-12-01 17:00:00', 'pngwing.com (28).png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proses_selesai`
--

CREATE TABLE `proses_selesai` (
  `id` int(11) NOT NULL,
  `selesai_eksekusi` int(11) NOT NULL,
  `pesanan_masuk` int(11) NOT NULL,
  `deadline` int(11) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `harga_produk` decimal(10,2) NOT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `tanggal_input` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proses_selesai`
--

INSERT INTO `proses_selesai` (`id`, `selesai_eksekusi`, `pesanan_masuk`, `deadline`, `id_pelanggan`, `kode_produk`, `harga_produk`, `jumlah_produk`, `tanggal_input`) VALUES
(39, 7, 3, 7, 'PLG004', 'PR003', '3000.00', 1, '2024-01-24 21:34:46');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_table`
--
ALTER TABLE `data_table`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id_favorite`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_chart`);

--
-- Indeks untuk tabel `order_pelanggan`
--
ALTER TABLE `order_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `proses_selesai`
--
ALTER TABLE `proses_selesai`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `data_table`
--
ALTER TABLE `data_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id_favorite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_chart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `order_pelanggan`
--
ALTER TABLE `order_pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `proses_selesai`
--
ALTER TABLE `proses_selesai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
