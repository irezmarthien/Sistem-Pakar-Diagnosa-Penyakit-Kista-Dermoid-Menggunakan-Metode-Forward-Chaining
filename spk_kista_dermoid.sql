-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Feb 2026 pada 12.20
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
-- Database: `spk_kista_dermoid`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `kode_gejala` varchar(5) NOT NULL,
  `nama_gejala` varchar(255) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`kode_gejala`, `nama_gejala`, `kategori`, `keterangan`) VALUES
('G01', 'Nyeri panggul', 'Nyeri', 'Nyeri di perut bawah atau panggul'),
('G02', 'Nyeri perut mendadak', 'Nyeri Akut', 'Mengarah ke kemungkinan torsio (terpluntir)'),
('G03', 'Perut terasa penuh / tertekan', 'Tekanan', 'Akibat pembesaran kista'),
('G04', 'Pembesaran abdomen', 'Fisik', 'Perut tampak membesar tidak sesuai usia kehamilan'),
('G05', 'Ketidaknyamanan saat beraktivitas', 'Fungsional', 'Nyeri bertambah saat bergerak'),
('G06', 'Mual dan muntah berlebih', 'Sistemik', 'Dapat muncul akibat komplikasi'),
('G07', 'Nyeri saat perubahan posisi', 'Nyeri', 'Nyeri meningkat saat berdiri/duduk'),
('G08', 'Tidak ada gejala (Asimtomatik)', 'Asimtomatik', 'Kista ditemukan melalui pemeriksaan USG rutin'),
('G09', 'Tes', 'Tes', 'Tes');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id_konsultasi` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `usia_kehamilan` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `kode_penyakit` varchar(5) DEFAULT NULL,
  `tingkat_risiko` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsultasi_detail`
--

CREATE TABLE `konsultasi_detail` (
  `id_detail` int(11) NOT NULL,
  `id_konsultasi` int(11) DEFAULT NULL,
  `kode_gejala` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `kode_penyakit` varchar(5) NOT NULL,
  `nama_penyakit` varchar(255) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tingkat_risiko` enum('Rendah','Sedang','Tinggi') NOT NULL,
  `solusi` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`kode_penyakit`, `nama_penyakit`, `lokasi`, `deskripsi`, `tingkat_risiko`, `solusi`, `keterangan`) VALUES
('P01', 'Kista Dermoid Ovarium', 'Ovarium (indung telur)', NULL, 'Tinggi', NULL, 'Jenis kista dermoid paling sering ditemukan pada ibu hamil'),
('P02', 'Kista Dermoid Kepala dan Leher', 'Kepala, leher, sekitar mata', NULL, 'Rendah', NULL, 'Biasanya kongenital, tidak berhubungan langsung dengan kehamilan'),
('P03', 'Kista Dermoid Spinal', 'Sepanjang tulang belakang', NULL, 'Sedang', NULL, 'Jarang terjadi, dapat menekan saraf'),
('P04', 'Kista Dermoid Intrakranial', 'Rongga otak', NULL, 'Tinggi', NULL, 'Sangat jarang, berisiko neurologis tinggi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_konsultasi`
--

CREATE TABLE `riwayat_konsultasi` (
  `id_konsultasi` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `gejala` text DEFAULT NULL,
  `hasil_diagnosa` varchar(100) DEFAULT NULL,
  `tingkat_risiko` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rules`
--

CREATE TABLE `rules` (
  `id_rule` int(11) NOT NULL,
  `kode_penyakit` varchar(5) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rules`
--

INSERT INTO `rules` (`id_rule`, `kode_penyakit`, `keterangan`) VALUES
(1, 'P01', 'Diagnosa Kista Dermoid Ovarium pada Ibu Hamil'),
(2, 'P02', 'Diagnosa Kista Dermoid area Ekstragenital (Kepala/Leher)'),
(3, 'P03', 'Diagnosa Kista Dermoid Spinal (Tulang Belakang)'),
(4, 'P04', 'Diagnosa Kista Dermoid Intrakranial (Otak)');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule_detail`
--

CREATE TABLE `rule_detail` (
  `id_rule_detail` int(11) NOT NULL,
  `id_rule` int(11) DEFAULT NULL,
  `kode_gejala` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rule_detail`
--

INSERT INTO `rule_detail` (`id_rule_detail`, `id_rule`, `kode_gejala`) VALUES
(1, 1, 'G01'),
(2, 1, 'G04'),
(3, 1, 'G07'),
(4, 1, 'G08'),
(5, 2, 'G04'),
(6, 2, 'G08'),
(7, 3, 'G05'),
(8, 3, 'G08'),
(9, 4, 'G06'),
(10, 4, 'G08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `tanggal_lahir`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Wati', '1998-12-13', 'wati@gmail.com', '$2y$10$v.f8uRpVCMEGRhNZpajhUuGhon05fh7xD4PgG58D6pyGJH4Umj9HC', 'user', '2026-01-13 10:11:41'),
(2, 'Mirda', '2003-07-14', 'mirda@gmail.com', '$2y$10$eq23l7wSXXUea12S2Gaq4uMAkXEs7ZKXILISqMwXsivHfzTH4niQy', 'user', '2026-01-14 06:33:00'),
(3, 'admin', '2026-01-14', 'a@gmail.com', '$2y$10$g7K/AdoeD5U1Z1J3M9cr6OaO4kTI86oL1Kmz6V116.qzTV1cfIGwy', 'admin', '2026-01-14 09:04:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`kode_gejala`);

--
-- Indeks untuk tabel `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id_konsultasi`),
  ADD KEY `kode_penyakit` (`kode_penyakit`),
  ADD KEY `fk_konsultasi_user` (`id_user`);

--
-- Indeks untuk tabel `konsultasi_detail`
--
ALTER TABLE `konsultasi_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_konsultasi` (`id_konsultasi`),
  ADD KEY `kode_gejala` (`kode_gejala`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`kode_penyakit`);

--
-- Indeks untuk tabel `riwayat_konsultasi`
--
ALTER TABLE `riwayat_konsultasi`
  ADD PRIMARY KEY (`id_konsultasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `kode_penyakit` (`kode_penyakit`);

--
-- Indeks untuk tabel `rule_detail`
--
ALTER TABLE `rule_detail`
  ADD PRIMARY KEY (`id_rule_detail`),
  ADD KEY `id_rule` (`id_rule`),
  ADD KEY `kode_gejala` (`kode_gejala`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id_konsultasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `konsultasi_detail`
--
ALTER TABLE `konsultasi_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_konsultasi`
--
ALTER TABLE `riwayat_konsultasi`
  MODIFY `id_konsultasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rules`
--
ALTER TABLE `rules`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `rule_detail`
--
ALTER TABLE `rule_detail`
  MODIFY `id_rule_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD CONSTRAINT `fk_konsultasi_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `konsultasi_ibfk_1` FOREIGN KEY (`kode_penyakit`) REFERENCES `penyakit` (`kode_penyakit`);

--
-- Ketidakleluasaan untuk tabel `konsultasi_detail`
--
ALTER TABLE `konsultasi_detail`
  ADD CONSTRAINT `konsultasi_detail_ibfk_1` FOREIGN KEY (`id_konsultasi`) REFERENCES `konsultasi` (`id_konsultasi`),
  ADD CONSTRAINT `konsultasi_detail_ibfk_2` FOREIGN KEY (`kode_gejala`) REFERENCES `gejala` (`kode_gejala`);

--
-- Ketidakleluasaan untuk tabel `riwayat_konsultasi`
--
ALTER TABLE `riwayat_konsultasi`
  ADD CONSTRAINT `riwayat_konsultasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `rules`
--
ALTER TABLE `rules`
  ADD CONSTRAINT `rules_ibfk_1` FOREIGN KEY (`kode_penyakit`) REFERENCES `penyakit` (`kode_penyakit`);

--
-- Ketidakleluasaan untuk tabel `rule_detail`
--
ALTER TABLE `rule_detail`
  ADD CONSTRAINT `rule_detail_ibfk_1` FOREIGN KEY (`id_rule`) REFERENCES `rules` (`id_rule`),
  ADD CONSTRAINT `rule_detail_ibfk_2` FOREIGN KEY (`kode_gejala`) REFERENCES `gejala` (`kode_gejala`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
