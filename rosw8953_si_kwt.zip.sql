-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Jul 2021 pada 11.29
-- Versi server: 10.2.38-MariaDB-cll-lve
-- Versi PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rosw8953_si_kwt`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail`
--

CREATE TABLE `detail` (
  `id` int(20) NOT NULL,
  `id_user` int(20) NOT NULL,
  `alamat_lengkap` varchar(50) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `no_telpon` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail`
--

INSERT INTO `detail` (`id`, `id_user`, `alamat_lengkap`, `kode_pos`, `no_telpon`, `date`) VALUES
(1, 3, 'gresik', '732131', '085747477', '2021-06-19'),
(2, 4, 'kaltim', '62283', '0981234567', '2021-06-19'),
(3, 5, 'tes', '345', '2345678', '2021-07-06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `id_pembayaran` int(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `iklan`
--

CREATE TABLE `iklan` (
  `id` int(20) NOT NULL,
  `file` varchar(50) DEFAULT '0',
  `status` enum('utama','none') DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT '0',
  `date` varchar(50) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `iklan`
--

INSERT INTO `iklan` (`id`, `file`, `status`, `keterangan`, `date`) VALUES
(2, '2-1624333114.jpg', 'utama', 'ssssss', '22 Juni 2021'),
(4, 'download-1624620818.jpg', NULL, '', '25 Juni 2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `informasi`
--

CREATE TABLE `informasi` (
  `id` int(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `id_jenis_informasi` int(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `date` varchar(20) NOT NULL,
  `gambar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `informasi`
--

INSERT INTO `informasi` (`id`, `nama`, `id_jenis_informasi`, `keterangan`, `date`, `gambar`) VALUES
(7, 'Bank Mandiri', 3, 'silahkan transfer ke rekening 123 12312 123ff', '24 Juni 2021', NULL),
(8, 'Cara Pembelian', 1, 'adasdasda asdasd asdasd', '19 Juni 2021', NULL),
(11, 'Profile', 4, 'nama siapapun itu aku tidak tahu yang penting tahu', '20 Juni 2021', NULL),
(12, 'Kontak', 5, 'bila sakit berlanjut silahkan hubungi dokter', '20 Juni 2021', NULL),
(16, 'coba gambar', 2, 'tesssss', '25 Juni 2021', '2-1624630154.jpg'),
(17, 'Kerja Bakti Rutin', 2, 'Kegiatan kerja bakti ini dilaksanakan setiap sebulan 2 kali.', '27 Juni 2021', '09e60054-2d2b-4702-8839-4b46f83557a7---copy-162476');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jasa_pengiriman`
--

CREATE TABLE `jasa_pengiriman` (
  `id` int(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `biaya` int(20) NOT NULL,
  `berat` int(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jasa_pengiriman`
--

INSERT INTO `jasa_pengiriman` (`id`, `nama`, `keterangan`, `biaya`, `berat`, `date`) VALUES
(1, 'JNT', 'okoko', 20000, 1, '03 Juli 2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_informasi`
--

CREATE TABLE `jenis_informasi` (
  `id` int(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_informasi`
--

INSERT INTO `jenis_informasi` (`id`, `nama`, `date`) VALUES
(1, 'Cara Pesan', '1 Maret 2021'),
(2, 'Info KWT', '1 Maret 2021'),
(3, 'Informasi Bank', '1 Maret 2021'),
(4, 'Profil', '1 Maret 2021 '),
(5, 'Kontak', '1 Maret 2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_produk`
--

CREATE TABLE `jenis_produk` (
  `id` int(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_produk`
--

INSERT INTO `jenis_produk` (`id`, `nama`, `satuan`, `date`) VALUES
(8, 'Jagung Garing', 'Ons', '18 Juni 2021'),
(9, 'Pecel Endok', 'Kg', '18 Juni 2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kota`
--

CREATE TABLE `kota` (
  `id` int(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `id_provinsi` int(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `kode_pos` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kota`
--

INSERT INTO `kota` (`id`, `nama`, `id_provinsi`, `type`, `kode_pos`) VALUES
(18, 'Balangan', 13, 'Kabupaten', '71611'),
(19, 'Balikpapan', 15, 'Kota', '76111'),
(33, 'Banjar', 13, 'Kabupaten', '70619'),
(35, 'Banjarbaru', 13, 'Kota', '70712'),
(36, 'Banjarmasin', 13, 'Kota', '70117'),
(43, 'Barito Kuala', 13, 'Kabupaten', '70511'),
(44, 'Barito Selatand', 14, 'Kabupaten', '73711'),
(45, 'Barito Timurd', 14, 'Kabupaten', '73671'),
(46, 'Barito Utarad', 14, 'Kabupaten', '73881'),
(61, 'Bengkayang', 12, 'Kabupaten', '79213'),
(66, 'Berau', 15, 'Kabupaten', '77311'),
(89, 'Bontang', 15, 'Kota', '75313'),
(96, 'Bulungan (Bulongan)', 16, 'Kabupaten', '77211'),
(136, 'Gunung Masd', 14, 'Kabupaten', '74511'),
(143, 'Hulu Sungai Selatan', 13, 'Kabupaten', '71212'),
(144, 'Hulu Sungai Tengah', 13, 'Kabupaten', '71313'),
(145, 'Hulu Sungai Utara', 13, 'Kabupaten', '71419'),
(167, 'Kapuasd', 14, 'Kabupaten', '73583'),
(168, 'Kapuas Hulu', 12, 'Kabupaten', '78719'),
(174, 'Katingand', 14, 'Kabupaten', '74411'),
(176, 'Kayong Utara', 12, 'Kabupaten', '78852'),
(195, 'Ketapang', 12, 'Kabupaten', '78874'),
(203, 'Kotabaru', 13, 'Kabupaten', '72119'),
(205, 'Kotawaringin Barat', 14, 'Kabupaten', '74119'),
(206, 'Kotawaringin Timur', 14, 'Kabupaten', '74364'),
(208, 'Kubu Raya', 12, 'Kabupaten', '78311'),
(214, 'Kutai Barat', 15, 'Kabupaten', '75711'),
(215, 'Kutai Kartanegara', 15, 'Kabupaten', '75511'),
(216, 'Kutai Timur', 15, 'Kabupaten', '75611'),
(221, 'Lamandaud', 14, 'Kabupaten', '74611'),
(228, 'Landak', 12, 'Kabupaten', '78319'),
(257, 'Malinau', 16, 'Kabupaten', '77511'),
(279, 'Melawi', 12, 'Kabupaten', '78619'),
(296, 'Murung Rayad', 14, 'Kabupaten', '73911'),
(311, 'Nunukan', 16, 'Kabupaten', '77421'),
(326, 'Palangka Rayad', 14, 'Kota', '73112'),
(341, 'Paser', 15, 'Kabupaten', '76211'),
(354, 'Penajam Paser Utara', 15, 'Kabupaten', '76311'),
(364, 'Pontianak', 12, 'Kabupaten', '78971'),
(365, 'Pontianak', 12, 'Kota', '78112'),
(371, 'Pulang Pisaud', 14, 'Kabupaten', '74811'),
(387, 'Samarinda', 15, 'Kota', '75133'),
(388, 'Sambas', 12, 'Kabupaten', '79453'),
(391, 'Sanggau', 12, 'Kabupaten', '78557'),
(395, 'Sekadau', 12, 'Kabupaten', '79583'),
(405, 'Seruyand', 14, 'Kabupaten', '74211'),
(415, 'Singkawang', 12, 'Kota', '79117'),
(417, 'Sintang', 12, 'Kabupaten', '78619'),
(432, 'Sukamarad', 14, 'Kabupaten', '74712'),
(446, 'Tabalong', 13, 'Kabupaten', '71513'),
(450, '\"Tana Tidung\"\"\"', 16, 'Kabupaten', '77611'),
(452, 'Tanah Bumbu', 13, 'Kabupaten', '72211'),
(454, 'Tanah Laut', 13, 'Kabupaten', '70811'),
(466, 'Tapin', 13, 'Kabupaten', '71119'),
(467, 'Tarakan', 16, 'Kota', '77114');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `file` varchar(50) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `id_transaksi` int(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `file`, `keterangan`, `tgl_bayar`, `id_transaksi`, `date`) VALUES
(1, 'produk2-1624118544.jpg', 'asdas', '1 Maret 2020', 7, '1 Maret 2020'),
(4, 'logo2-removebg-preview.png', 'kk', '20-01-22', 9, '2021-06-20'),
(16, 'foto-1624185853.png', 'sdfghjkl', '20-01-22', 14, '2021-06-20'),
(17, 'ktp-1624185952.jpg', 'kkkk', '20-01-22', 16, '2021-06-20'),
(18, 'foto-1624189412.png', 'j', '20-01-22', 15, '2021-06-20'),
(20, 'foto-1624189823.png', 'kkooko', '20-01-22', 17, '2021-06-20'),
(21, 'produk2-1624249060.jpg', 'okoko', '2021-10-10', 18, '2021-06-21'),
(22, 'img_20210616_073314_622-1625300588.jpg', 'ajhdbd', '3', 35, '2021-07-03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `harga` int(20) NOT NULL,
  `id_jenis_produk` int(20) NOT NULL,
  `stok` int(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `keterangan`, `harga`, `id_jenis_produk`, `stok`, `date`, `file`) VALUES
(3, 'Sayur Mayur', 'asdasdssss', 0, 9, 43, '22 Juni 2021', 'produk1-1624331568.jpg'),
(5, 'Sayur Mayur', 'asdasdssss', 51001, 9, 43, '22 Juni 2021', 'produk2-1624118544-1624331586.jpg'),
(6, 'Sayur Mayur', 'asdasdssss', 51000, 8, 43, '19 Juni 2021', 'produk2-1624118544.jpg'),
(8, 'Gedang', 'gedang bisa untuk di buat gedang goreng', 50000, 8, 50, '22 Juni 2021', 'produk1-1624333855.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(20) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `provinsi`
--

INSERT INTO `provinsi` (`id`, `nama`) VALUES
(12, 'Kalimantan Barat'),
(13, 'Kalimantan Selatan'),
(14, 'Kalimantan Tengah'),
(15, 'Kalimantan Timur'),
(16, 'Kalimantan Utara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(20) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `nama`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(20) UNSIGNED NOT NULL,
  `id_detail` int(20) NOT NULL,
  `id_produk` int(20) NOT NULL,
  `jml_order` int(20) NOT NULL,
  `jml_bayar` int(20) NOT NULL,
  `id_informasi` int(20) NOT NULL,
  `total_bayar` int(20) DEFAULT NULL,
  `id_jasa_pengiriman` int(20) DEFAULT NULL,
  `date` varchar(20) NOT NULL,
  `status` enum('menunggu pembayaran','verifikasi pembayaran','pesanan diproses','pesanan dikirim','pesanan diterima','selesai','ditolak','dibatalkan') DEFAULT NULL,
  `ongkir` int(20) DEFAULT NULL,
  `id_kota` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_detail`, `id_produk`, `jml_order`, `jml_bayar`, `id_informasi`, `total_bayar`, `id_jasa_pengiriman`, `date`, `status`, `ongkir`, `id_kota`) VALUES
(14, 2, 3, 2, 102000, 7, NULL, 1, '2021-04-20', 'menunggu pembayaran', 500000, 432),
(16, 2, 3, 99, 5049000, 7, NULL, 1, '2021-05-20', 'selesai', 30000, 454),
(17, 2, 3, 2, 102000, 7, NULL, 1, '2021-06-20', 'selesai', 2000, 432),
(18, 2, 6, 10, 510000, 7, NULL, 1, '2021-06-21', 'selesai', 30000, 167),
(21, 2, 8, 100, 5000000, 7, NULL, 1, '2021-06-22', 'menunggu pembayaran', 50000, 365),
(28, 2, 3, 10, 510000, 7, NULL, 1, '2021-06-22', 'menunggu pembayaran', NULL, 417),
(33, 2, 3, 2, 102000, 7, NULL, 1, '2021-07-03', 'menunggu pembayaran', NULL, 19),
(35, 2, 3, 2, 102000, 7, NULL, 1, '2021-07-03', 'pesanan diproses', 21, 19),
(38, 3, 3, 1, 51000, 7, NULL, 1, '2021-07-06', 'menunggu pembayaran', NULL, 371);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `text_passowd` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama_lengkap`, `email`, `username`, `password`, `role_id`, `date`, `text_passowd`) VALUES
(3, 'admin', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '1 Maret 2020', 'admin'),
(4, 'user', 'user@gmail.com', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 2, '1 Maret 2020', 'user'),
(5, 'tes', 'tes@gmail.com', 'tes', '28b662d883b6d76fd96e4ddc5e9ba780', 2, '2021-07-05', 'tes');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pembayaran` (`id_pembayaran`);

--
-- Indeks untuk tabel `iklan`
--
ALTER TABLE `iklan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jenis_informasi` (`id_jenis_informasi`);

--
-- Indeks untuk tabel `jasa_pengiriman`
--
ALTER TABLE `jasa_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_informasi`
--
ALTER TABLE `jenis_informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_produk`
--
ALTER TABLE `jenis_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jenis_produk` (`id_jenis_produk`);

--
-- Indeks untuk tabel `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_detail` (`id_detail`),
  ADD KEY `id_informasi` (`id_informasi`),
  ADD KEY `id_jasa_pengiriman` (`id_jasa_pengiriman`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `FK_transaksi_kota` (`id_kota`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail`
--
ALTER TABLE `detail`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `iklan`
--
ALTER TABLE `iklan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `jasa_pengiriman`
--
ALTER TABLE `jasa_pengiriman`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_informasi`
--
ALTER TABLE `jenis_informasi`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jenis_produk`
--
ALTER TABLE `jenis_produk`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `detail_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD CONSTRAINT `informasi_ibfk_1` FOREIGN KEY (`id_jenis_informasi`) REFERENCES `jenis_informasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kota`
--
ALTER TABLE `kota`
  ADD CONSTRAINT `kota_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id`);

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_jenis_produk`) REFERENCES `jenis_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `FK_transaksi_kota` FOREIGN KEY (`id_kota`) REFERENCES `kota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_detail`) REFERENCES `detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_informasi`) REFERENCES `informasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_jasa_pengiriman`) REFERENCES `jasa_pengiriman` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_4` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
