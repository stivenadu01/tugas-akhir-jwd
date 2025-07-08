-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Agu 2024 pada 13.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tugas_akhir1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(32) NOT NULL,
  `terjual` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `foto`, `terjual`) VALUES
(1, 'Baju Pria', 'BajuPria.jpg', '500'),
(2, 'Celana Pria', 'CelanaPria.jpg', '0'),
(3, 'Baju Wanita', 'BajuWanita.jpg', '500'),
(4, 'Sepatu', 'Sepatu.jpg', '700');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_pemesan` varchar(255) NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `alamat` varchar(64) NOT NULL,
  `jumlah_produk` int(16) NOT NULL,
  `total_pembayaran` int(32) NOT NULL,
  `metode_pembayaran` varchar(16) NOT NULL,
  `waktu_pesanan` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('SEDANG DIKEMAS','DALAM PENGIRIMAN','SUDAH DITERIMA') NOT NULL DEFAULT 'SEDANG DIKEMAS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `id_kategori`, `id_produk`, `username`, `nama_pemesan`, `no_hp`, `alamat`, `jumlah_produk`, `total_pembayaran`, `metode_pembayaran`, `waktu_pesanan`, `status`) VALUES
(27, 4, 5, 'stiven', 'stiven', '081338609228', 'Kupang', 200, 60000000, 'cod', '2024-08-16 18:40:24', 'SUDAH DITERIMA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(32) NOT NULL,
  `foto` varchar(32) NOT NULL,
  `details` varchar(500) NOT NULL,
  `stok` enum('Tersedia','Habis') NOT NULL DEFAULT 'Tersedia',
  `terjual` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `id_kategori`, `nama`, `harga`, `foto`, `details`, `stok`, `terjual`) VALUES
(1, 4, 'Sepatu Pria Hitam', 140000, 'H9fUESNHk5.jpg', 'abcd', 'Tersedia', '0'),
(3, 4, 'Sepatu Wanita', 120000, '8KL3NOsDyk.jpg', 'abcd', 'Tersedia', '0'),
(4, 4, 'Sepatu Pria Coklat ', 299000, 'sVE0RtOLCp.jpg', 'abcd', 'Tersedia', '0'),
(5, 4, 'Sepatu Putih', 300000, 'jKuc4TCD71.jpg', 'abcd\r\n', 'Tersedia', '700'),
(6, 1, 'Kaos Import Lengan Pendek', 79000, '4H6FptqQY5.jpeg', 'abcd', 'Tersedia', '500'),
(7, 1, 'Kaos Oversize', 90000, 'eIY9YQOPTo.jpg', '', 'Tersedia', '0'),
(8, 1, 'Kaos Tribal', 99000, '8xRlrnWhEZ.jpeg', '', 'Tersedia', '0'),
(9, 1, 'Jersey Mesi Argentina', 120000, 'e3klNDH2An.jpg', 'abcd', 'Tersedia', '0'),
(10, 1, 'Jersey Futsal Hitam', 170000, 'FlbTNMwPCJ.jpg', '', 'Tersedia', '0'),
(11, 1, 'Jersey City', 120000, 'Ps57SncsVZ.jpg', '', 'Tersedia', '0'),
(12, 1, 'JB black', 110000, 'NkrOcyGNdv.jpg', '', 'Tersedia', '0'),
(13, 2, 'Celana Pendek', 129000, 'Tpq2dn6M4k.jpg', '', 'Tersedia', '0'),
(14, 2, 'Celana  Pendek Pria', 100000, 'mFxs2YmdoE.jpg', '', 'Tersedia', '0'),
(15, 2, 'Celana  Pendek Pria Hitam', 100000, 'vGzI57PZB1.jpg', '', 'Tersedia', '0'),
(16, 3, 'Baju Wanita Coklat', 79000, 'tPHWo56dZl.jpg', '', 'Tersedia', '500'),
(18, 1, 'Baju Bola Hitam Putih', 119000, 'svYwdOp3k4.jpg', '', 'Tersedia', '0'),
(19, 2, 'Celana Pendek Hitam', 100000, 'FawjN6lg2Z.jpg', '', 'Tersedia', '0'),
(22, 1, 'Baju Puma 1', 130000, 'gmd0zsQhee.jpg', '', 'Tersedia', ''),
(23, 1, 'Baju Pria 2', 199000, '1uckJixU1a.jpg', '', 'Tersedia', ''),
(24, 4, 'Sepatu 2', 390000, 'RRpVmmhuo1.jpeg', '', 'Tersedia', ''),
(25, 1, 'Baju PRia', 190000, '8RgVtsOZ6S.jpeg', '', 'Tersedia', ''),
(26, 1, 'Baju Laki Laki', 100000, 'HtZMyu8YUa.jpeg', '', 'Tersedia', ''),
(27, 4, 'Sendal 1', 90000, 'PPUvsfAH7q.jpeg', '', 'Tersedia', ''),
(28, 2, 'Celana Panjang Putih', 70000, 'fPtZ4FEDtM.jpg', '', 'Tersedia', ''),
(29, 1, 'Baju Hitam Pria', 123000, '7BgmaHe46g.jpg', '', 'Tersedia', ''),
(30, 1, 'Sepatu KEren', 199000, 'xoRgfbjv04.jpg', '', 'Tersedia', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `alamat` varchar(64) NOT NULL,
  `waktu_registrasi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `no_hp`, `alamat`, `waktu_registrasi`) VALUES
('stiven', '$2y$10$LAiNx7UX9c7U.8Th15.F5e8wICq5.MsepHDvTZ5reUS0BP/jVt1Ea', 'stivenadu01@gmail.com', '081338609228', 'Kupang', '2024-08-14 22:00:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_admin`
--

CREATE TABLE `user_admin` (
  `username` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_admin`
--

INSERT INTO `user_admin` (`username`, `password`, `pw`) VALUES
('admin', '$2y$10$MRneZb9J6Ov3dVAhUbZUEu/f8JdixMdURYO2P1gwZmk/2KGwYG.0O', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemesanan_ibfk_1` (`id_kategori`),
  ADD KEY `pemesanan_ibfk_2` (`id_produk`),
  ADD KEY `pemesanan_ibfk_3` (`username`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kategori_produk` (`id_kategori`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_3` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_kategori_produk` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
