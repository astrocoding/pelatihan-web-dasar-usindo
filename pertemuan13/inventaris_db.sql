-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 24 Jan 2026 pada 07.36
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` int(50) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `jumlah` int(200) NOT NULL,
  `kondisi` varchar(20) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `harga_satuan` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `kode_barang`, `nama_barang`, `kategori`, `lokasi`, `jumlah`, `kondisi`, `tanggal_masuk`, `harga_satuan`) VALUES
(3, 'BRG003', 'Kursi Ergonomis', 'Furniture', 'Ruang Staff', 15, 'Baik', '2026-01-02', 0.00),
(4, 'BRG04', 'Komputer', 'Elektronik', 'Lab', 10, 'baik', '2026-01-10', 2000000.00),
(5, 'BRG06', 'Komputer Ryzen 7', 'Elektronik/PC', 'Lab. Development', 1000, 'Baik', '2026-01-17', 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `jenis_transaksi` enum('masuk','keluar') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `penanggung_jawab` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `item_id`, `jenis_transaksi`, `jumlah`, `tanggal_transaksi`, `keterangan`, `penanggung_jawab`) VALUES
(2, 3, 'keluar', 1, '2026-01-10', 'Ada yang berkurang', 'Zaenal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `nama_lengkap`, `created_at`, `updated_at`) VALUES
(1, 'zaenalalfian', '$2y$10$h3TL5qzVML7g/EEGPW6FqeIgPzEtXl9MsALL7Id94EK/1KgDxBYZK', 'zaenalalfian20@gmail.com', 'Zaenal Alfian', '2026-01-17 09:24:12', '2026-01-17 09:24:12'),
(2, 'john', '$2y$10$K.3fRCN.4ZI3t4GXiVfT7u7bphC/tSmMfFlpBOGOYn8wLdlD5FoRK', 'john@gmail.com', 'John Doe', '2026-01-17 09:56:43', '2026-01-17 09:56:43'),
(5, 'admin', '$2y$10$kVvLBDq9eLZmwyf60iZkWuYcdo2m.mMy/6g0MZ7dwIbGGLdoYOD1W', 'admin@gmail.com', 'Admin', '2026-01-17 10:07:40', '2026-01-17 10:07:40');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_laporan_barang`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_laporan_barang` (
`id` int(50)
,`kode_barang` varchar(50)
,`nama_barang` varchar(100)
,`total_transaksi` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_laporan_barang`
--
DROP TABLE IF EXISTS `view_laporan_barang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_barang`  AS SELECT `i`.`id` AS `id`, `i`.`kode_barang` AS `kode_barang`, `i`.`nama_barang` AS `nama_barang`, count(`t`.`id`) AS `total_transaksi` FROM (`items` `i` left join `transactions` `t` on(`i`.`id` = `t`.`item_id`)) GROUP BY `i`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
