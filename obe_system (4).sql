-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2025 at 04:10 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `obe_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int NOT NULL,
  `nidn` varchar(30) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fakultas_id` int NOT NULL,
  `prodi_id` int NOT NULL,
  `users_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nidn`, `nama_dosen`, `email`, `fakultas_id`, `prodi_id`, `users_id`) VALUES
(2, '2202115', 'Rizal Efendi', 'rizal@scriptmlbb.com', 2, 1, 3),
(4, '121212', 'wahyu', 'tes@wahyu.com', 2, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `dosen_pengampu_mk`
--

CREATE TABLE `dosen_pengampu_mk` (
  `id` int NOT NULL,
  `id_mk` int NOT NULL,
  `id_dosen` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` int NOT NULL,
  `kode_fakultas` varchar(20) NOT NULL,
  `nama_fakultas` varchar(100) NOT NULL,
  `universitas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `kode_fakultas`, `nama_fakultas`, `universitas`) VALUES
(2, '1234', 'Kedokteran', 'Brawijaya ');

-- --------------------------------------------------------

--
-- Table structure for table `kaprodi`
--

CREATE TABLE `kaprodi` (
  `id_kaprodi` int NOT NULL,
  `prodi_id` int NOT NULL,
  `tahun_aktif` varchar(10) NOT NULL,
  `id_dosen` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kaprodi`
--

INSERT INTO `kaprodi` (`id_kaprodi`, `prodi_id`, `tahun_aktif`, `id_dosen`) VALUES
(2, 1, '2025', 4);

-- --------------------------------------------------------

--
-- Table structure for table `kurikulum`
--

CREATE TABLE `kurikulum` (
  `IdKurikulum` int NOT NULL,
  `kdprodi` char(4) NOT NULL,
  `NamaKurikulum` varchar(100) NOT NULL,
  `TahunMulai` year NOT NULL,
  `TahunSelesai` year DEFAULT NULL,
  `Status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `Deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kurikulum`
--

INSERT INTO `kurikulum` (`IdKurikulum`, `kdprodi`, `NamaKurikulum`, `TahunMulai`, `TahunSelesai`, `Status`, `Deskripsi`) VALUES
(1, '1', 'Kurikulum KampusMerdeka', 2024, 2026, 'Aktif', 'deskripsinya');

-- --------------------------------------------------------

--
-- Table structure for table `kurikulum_mk`
--

CREATE TABLE `kurikulum_mk` (
  `id` int NOT NULL,
  `IdKurikulum` int NOT NULL,
  `id_mk` int NOT NULL,
  `sks_teori` int DEFAULT '0',
  `sks_praktek` int DEFAULT '0',
  `kategori` enum('Wajib','Pilihan') DEFAULT 'Wajib',
  `semester` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kurikulum_mk`
--

INSERT INTO `kurikulum_mk` (`id`, `IdKurikulum`, `id_mk`, `sks_teori`, `sks_praktek`, `kategori`, `semester`) VALUES
(4, 1, 1, 2, 2, 'Pilihan', 1),
(5, 1, 2, 3, 2, 'Wajib', 2),
(6, 1, 3, 2, 0, 'Wajib', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_mk` int NOT NULL,
  `kdprodi` char(4) NOT NULL,
  `KodeMK` varchar(15) NOT NULL,
  `IdKurikulum` int NOT NULL,
  `NamaMK` varchar(100) DEFAULT NULL,
  `Subjects` varchar(100) DEFAULT NULL,
  `Sks` int DEFAULT NULL,
  `Semester` int DEFAULT NULL,
  `Jenis` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_mk`, `kdprodi`, `KodeMK`, `IdKurikulum`, `NamaMK`, `Subjects`, `Sks`, `Semester`, `Jenis`) VALUES
(1, '123', 'SI2311002', 63, 'Algoritma dan Pemrograman', 'Algorithm and Programming', 2, 1, 'Wajib'),
(2, '123', 'MK-01', 0, 'Algoritma dan Pemrograman', 'Algorithm and Programming', 2, 2, 'Wajib'),
(3, '123', 'SI2311005', 0, 'Bahaasa Ingris', 'English Language', 2, 1, 'Wajib');

-- --------------------------------------------------------

--
-- Table structure for table `mk_prasyarat`
--

CREATE TABLE `mk_prasyarat` (
  `id` int NOT NULL,
  `id_mk` int NOT NULL,
  `id_mk_prasyarat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mk_prasyarat`
--

INSERT INTO `mk_prasyarat` (`id`, `id_mk`, `id_mk_prasyarat`) VALUES
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `obe_bk`
--

CREATE TABLE `obe_bk` (
  `idbk` int NOT NULL,
  `kdprodi` char(4) NOT NULL,
  `kodebk` varchar(20) NOT NULL,
  `bahan_kajian` text NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_bk`
--

INSERT INTO `obe_bk` (`idbk`, `kdprodi`, `kodebk`, `bahan_kajian`, `deskripsi`) VALUES
(1, '1', 'BK01', 'tes aja', 'haloo'),
(2, '1', 'BK02', 'kajian aja', 'yeaahhy');

-- --------------------------------------------------------

--
-- Table structure for table `obe_bk_mk`
--

CREATE TABLE `obe_bk_mk` (
  `id` int NOT NULL,
  `idbk` int NOT NULL,
  `id_mk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_bk_mk`
--

INSERT INTO `obe_bk_mk` (`id`, `idbk`, `id_mk`) VALUES
(1, 1, 1),
(2, 2, 1),
(4, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `obe_cpl`
--

CREATE TABLE `obe_cpl` (
  `idcpl` int NOT NULL,
  `kdprodi` char(4) NOT NULL,
  `kodecpl` varchar(20) NOT NULL,
  `cpl` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_cpl`
--

INSERT INTO `obe_cpl` (`idcpl`, `kdprodi`, `kodecpl`, `cpl`) VALUES
(2, '1', 'CPL01', '	\r\nMampu memahami dan menggunakan berbagai metodologi 2'),
(3, '1', 'CPL02', 'ggug'),
(4, '1', 'CPL03', 'Mampu merancang, mengamankan basis data serta meng...\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `obe_cpl_bk`
--

CREATE TABLE `obe_cpl_bk` (
  `id` int NOT NULL,
  `idcpl` int NOT NULL,
  `idbk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_cpl_bk`
--

INSERT INTO `obe_cpl_bk` (`id`, `idcpl`, `idbk`) VALUES
(1, 2, 1),
(8, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `obe_cpl_cpmk`
--

CREATE TABLE `obe_cpl_cpmk` (
  `id` int NOT NULL,
  `idcpl` int NOT NULL,
  `idcpmk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_cpl_cpmk`
--

INSERT INTO `obe_cpl_cpmk` (`id`, `idcpl`, `idcpmk`) VALUES
(1, 2, 1),
(3, 3, 3),
(4, 2, 3),
(5, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `obe_cpl_mk`
--

CREATE TABLE `obe_cpl_mk` (
  `id` int NOT NULL,
  `idcpl` int NOT NULL,
  `id_mk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_cpl_mk`
--

INSERT INTO `obe_cpl_mk` (`id`, `idcpl`, `id_mk`) VALUES
(5, 2, 1),
(6, 3, 1),
(7, 4, 1),
(10, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `obe_cpmk`
--

CREATE TABLE `obe_cpmk` (
  `idcpmk` int NOT NULL,
  `id_mk` int NOT NULL,
  `kodecpmk` varchar(30) NOT NULL,
  `cpmk` text NOT NULL,
  `bobot` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_cpmk`
--

INSERT INTO `obe_cpmk` (`idcpmk`, `id_mk`, `kodecpmk`, `cpmk`, `bobot`) VALUES
(1, 1, 'CPMK1', 'HALOOO NNSAANNASA', 50),
(3, 1, 'CPMK1', 'jnjk', 20),
(4, 1, 'ik02', 'xxzx', 20);

-- --------------------------------------------------------

--
-- Table structure for table `obe_cpmk_mk`
--

CREATE TABLE `obe_cpmk_mk` (
  `id` int NOT NULL,
  `idcpmk` int NOT NULL,
  `id_mk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_cpmk_mk`
--

INSERT INTO `obe_cpmk_mk` (`id`, `idcpmk`, `id_mk`) VALUES
(2, 1, 2),
(3, 1, 3),
(4, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `obe_pl`
--

CREATE TABLE `obe_pl` (
  `idpl` int NOT NULL,
  `kdprodi` char(4) NOT NULL,
  `kodepl` varchar(20) NOT NULL,
  `pl` varchar(100) NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_pl`
--

INSERT INTO `obe_pl` (`idpl`, `kdprodi`, `kodepl`, `pl`, `deskripsi`) VALUES
(1, '1', 'PL01', 'Analis Sistem', 'halo'),
(2, '1', 'PL02', 'Analis Sistem', 'asasasasas');

-- --------------------------------------------------------

--
-- Table structure for table `obe_pl_cpl`
--

CREATE TABLE `obe_pl_cpl` (
  `id` int NOT NULL,
  `idpl` int NOT NULL,
  `idcpl` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_pl_cpl`
--

INSERT INTO `obe_pl_cpl` (`id`, `idpl`, `idcpl`) VALUES
(6, 2, 4),
(8, 1, 4),
(9, 2, 3),
(10, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps`
--

CREATE TABLE `obe_rps` (
  `id_rps` int NOT NULL,
  `id_mk` int NOT NULL,
  `deskripsi` text,
  `koordinator_pengembang` varchar(100) DEFAULT NULL,
  `url_elearning` varchar(255) DEFAULT NULL,
  `tanggal_penyusunan` date DEFAULT NULL,
  `otorisasi` varchar(100) DEFAULT NULL,
  `id_kaprodi` int DEFAULT NULL,
  `id_dosen` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps`
--

INSERT INTO `obe_rps` (`id_rps`, `id_mk`, `deskripsi`, `koordinator_pengembang`, `url_elearning`, `tanggal_penyusunan`, `otorisasi`, `id_kaprodi`, `id_dosen`) VALUES
(1, 1, 's', 'Rizal Efendi', 's', '2025-11-01', '', 2, 2),
(2, 3, 'jk', 'Rizal Efendi', '', '2025-11-01', '', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_cpmk`
--

CREATE TABLE `obe_rps_cpmk` (
  `id_rps_cpmk` int NOT NULL,
  `id_rps` int NOT NULL,
  `kode_cpmk` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `bobot` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_cpmk`
--

INSERT INTO `obe_rps_cpmk` (`id_rps_cpmk`, `id_rps`, `kode_cpmk`, `deskripsi`, `bobot`) VALUES
(1, 1, 'CPM1', 'TES', '10.00'),
(4, 2, 'CPK 01', 'SASA', '20.00');

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_indikator`
--

CREATE TABLE `obe_rps_indikator` (
  `id_indikator` int NOT NULL,
  `id_rps_cpmk` int DEFAULT NULL,
  `id_subcpmk` int DEFAULT NULL,
  `kode_indikator` varchar(50) DEFAULT NULL,
  `indikator` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_indikator`
--

INSERT INTO `obe_rps_indikator` (`id_indikator`, `id_rps_cpmk`, `id_subcpmk`, `kode_indikator`, `indikator`) VALUES
(1, 4, NULL, 'IK01 TES', 'YAA');

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_materi`
--

CREATE TABLE `obe_rps_materi` (
  `id_materi` int NOT NULL,
  `id_rps` int NOT NULL,
  `urutan` int DEFAULT NULL,
  `materi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_materi`
--

INSERT INTO `obe_rps_materi` (`id_materi`, `id_rps`, `urutan`, `materi`) VALUES
(1, 1, 1, 'TES'),
(3, 2, 3, 'IJIJ');

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_media`
--

CREATE TABLE `obe_rps_media` (
  `id_media` int NOT NULL,
  `id_rps` int NOT NULL,
  `media` varchar(255) DEFAULT NULL,
  `jenis` enum('Perangkat Keras','Perangkat Lunak') DEFAULT 'Perangkat Keras'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_media`
--

INSERT INTO `obe_rps_media` (`id_media`, `id_rps`, `media`, `jenis`) VALUES
(1, 1, 'knkl', 'Perangkat Keras'),
(2, 2, 'KLK', 'Perangkat Keras');

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_penilaian`
--

CREATE TABLE `obe_rps_penilaian` (
  `id_penilaian` int NOT NULL,
  `id_rps` int NOT NULL,
  `bentuk` varchar(255) DEFAULT NULL,
  `bobot` int NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_penilaian`
--

INSERT INTO `obe_rps_penilaian` (`id_penilaian`, `id_rps`, `bentuk`, `bobot`, `keterangan`) VALUES
(1, 1, 'jk', 0, 'nm'),
(2, 2, 'JK', 7, 'KK');

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_pertemuan`
--

CREATE TABLE `obe_rps_pertemuan` (
  `id_pertemuan` int NOT NULL,
  `id_rps` int NOT NULL,
  `minggu_ke` int DEFAULT NULL,
  `id_rps_cpmk` int DEFAULT NULL,
  `id_subcpmk` int DEFAULT NULL,
  `id_penilaian` int DEFAULT NULL,
  `id_materi` int DEFAULT NULL,
  `id_pustaka` int DEFAULT NULL,
  `id_media` int DEFAULT NULL,
  `sinkronus` text,
  `asinkronus` text,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_pertemuan`
--

INSERT INTO `obe_rps_pertemuan` (`id_pertemuan`, `id_rps`, `minggu_ke`, `id_rps_cpmk`, `id_subcpmk`, `id_penilaian`, `id_materi`, `id_pustaka`, `id_media`, `sinkronus`, `asinkronus`, `keterangan`) VALUES
(1, 1, 1, 1, NULL, 1, 1, 1, 1, 'a', 'asa', 'asa'),
(2, 2, 6, 4, NULL, 2, 3, 2, 2, '', '', 'BN');

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_pustaka`
--

CREATE TABLE `obe_rps_pustaka` (
  `id_pustaka` int NOT NULL,
  `id_rps` int NOT NULL,
  `kode_pustaka` varchar(50) DEFAULT NULL,
  `pustaka` text,
  `jenis` enum('Utama','Pendukung') DEFAULT 'Utama'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_pustaka`
--

INSERT INTO `obe_rps_pustaka` (`id_pustaka`, `id_rps`, `kode_pustaka`, `pustaka`, `jenis`) VALUES
(1, 1, 'bh', 'n', 'Utama'),
(2, 2, 'J', 'J', 'Utama');

-- --------------------------------------------------------

--
-- Table structure for table `obe_rps_subcpmk`
--

CREATE TABLE `obe_rps_subcpmk` (
  `id_subcpmk` int NOT NULL,
  `id_rps_cpmk` int NOT NULL,
  `kode_sub` varchar(50) DEFAULT NULL,
  `sub_cpmk` text,
  `bobot` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obe_rps_subcpmk`
--

INSERT INTO `obe_rps_subcpmk` (`id_subcpmk`, `id_rps_cpmk`, `kode_sub`, `sub_cpmk`, `bobot`) VALUES
(1, 4, 'SCPMK', 'YAA', '20.00');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int NOT NULL,
  `kode_prodi` varchar(20) NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `fakultas_id` int NOT NULL,
  `jenjang` varchar(10) DEFAULT 'S1',
  `akreditasi` varchar(10) DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `kode_prodi`, `nama_prodi`, `fakultas_id`, `jenjang`, `akreditasi`) VALUES
(1, '123', 'Sistem Informasi', 2, 'S1', '-');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','dosen') NOT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `role`, `is_active`) VALUES
(1, 'admin', '$2y$10$54a.29JzrOK8xBJdCyqJw.Lr/yJJbWIgeiCo0BckHFGyvf3kukpi.', 'admin', 1),
(3, '2202115', '$2y$10$XuSse0XME4l.GpNA1JrFFuRuophPCS6asK/9Nj90.cDnQbQtGggbe', 'dosen', 1),
(5, '121212', '$2y$10$IiFRi6UUFlCNjifDYUXzs.VOTR.y7FGrRkuoignc3aReUwIFGcvWm', 'dosen', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD KEY `fakultas_id` (`fakultas_id`),
  ADD KEY `prodi_id` (`prodi_id`),
  ADD KEY `fk_dosen_users` (`users_id`);

--
-- Indexes for table `dosen_pengampu_mk`
--
ALTER TABLE `dosen_pengampu_mk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mk` (`id_mk`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `kaprodi`
--
ALTER TABLE `kaprodi`
  ADD PRIMARY KEY (`id_kaprodi`),
  ADD KEY `prodi_id` (`prodi_id`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indexes for table `kurikulum`
--
ALTER TABLE `kurikulum`
  ADD PRIMARY KEY (`IdKurikulum`);

--
-- Indexes for table `kurikulum_mk`
--
ALTER TABLE `kurikulum_mk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IdKurikulum` (`IdKurikulum`),
  ADD KEY `id_mk` (`id_mk`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_mk`),
  ADD UNIQUE KEY `KodeMK` (`KodeMK`);

--
-- Indexes for table `mk_prasyarat`
--
ALTER TABLE `mk_prasyarat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mk` (`id_mk`),
  ADD KEY `id_mk_prasyarat` (`id_mk_prasyarat`);

--
-- Indexes for table `obe_bk`
--
ALTER TABLE `obe_bk`
  ADD PRIMARY KEY (`idbk`);

--
-- Indexes for table `obe_bk_mk`
--
ALTER TABLE `obe_bk_mk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idbk` (`idbk`),
  ADD KEY `id_mk` (`id_mk`);

--
-- Indexes for table `obe_cpl`
--
ALTER TABLE `obe_cpl`
  ADD PRIMARY KEY (`idcpl`);

--
-- Indexes for table `obe_cpl_bk`
--
ALTER TABLE `obe_cpl_bk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcpl` (`idcpl`),
  ADD KEY `idbk` (`idbk`);

--
-- Indexes for table `obe_cpl_cpmk`
--
ALTER TABLE `obe_cpl_cpmk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcpl` (`idcpl`),
  ADD KEY `idcpmk` (`idcpmk`);

--
-- Indexes for table `obe_cpl_mk`
--
ALTER TABLE `obe_cpl_mk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcpl` (`idcpl`),
  ADD KEY `id_mk` (`id_mk`);

--
-- Indexes for table `obe_cpmk`
--
ALTER TABLE `obe_cpmk`
  ADD PRIMARY KEY (`idcpmk`),
  ADD KEY `id_mk` (`id_mk`);

--
-- Indexes for table `obe_cpmk_mk`
--
ALTER TABLE `obe_cpmk_mk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcpmk` (`idcpmk`),
  ADD KEY `id_mk` (`id_mk`);

--
-- Indexes for table `obe_pl`
--
ALTER TABLE `obe_pl`
  ADD PRIMARY KEY (`idpl`);

--
-- Indexes for table `obe_pl_cpl`
--
ALTER TABLE `obe_pl_cpl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpl` (`idpl`),
  ADD KEY `idcpl` (`idcpl`);

--
-- Indexes for table `obe_rps`
--
ALTER TABLE `obe_rps`
  ADD PRIMARY KEY (`id_rps`),
  ADD KEY `id_mk` (`id_mk`),
  ADD KEY `id_kaprodi` (`id_kaprodi`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indexes for table `obe_rps_cpmk`
--
ALTER TABLE `obe_rps_cpmk`
  ADD PRIMARY KEY (`id_rps_cpmk`),
  ADD KEY `id_rps` (`id_rps`);

--
-- Indexes for table `obe_rps_indikator`
--
ALTER TABLE `obe_rps_indikator`
  ADD PRIMARY KEY (`id_indikator`),
  ADD KEY `id_rps_cpmk` (`id_rps_cpmk`),
  ADD KEY `id_subcpmk` (`id_subcpmk`);

--
-- Indexes for table `obe_rps_materi`
--
ALTER TABLE `obe_rps_materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_rps` (`id_rps`);

--
-- Indexes for table `obe_rps_media`
--
ALTER TABLE `obe_rps_media`
  ADD PRIMARY KEY (`id_media`),
  ADD KEY `id_rps` (`id_rps`);

--
-- Indexes for table `obe_rps_penilaian`
--
ALTER TABLE `obe_rps_penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_rps` (`id_rps`);

--
-- Indexes for table `obe_rps_pertemuan`
--
ALTER TABLE `obe_rps_pertemuan`
  ADD PRIMARY KEY (`id_pertemuan`),
  ADD KEY `id_rps` (`id_rps`),
  ADD KEY `id_rps_cpmk` (`id_rps_cpmk`),
  ADD KEY `id_subcpmk` (`id_subcpmk`),
  ADD KEY `id_penilaian` (`id_penilaian`),
  ADD KEY `id_materi` (`id_materi`),
  ADD KEY `id_pustaka` (`id_pustaka`),
  ADD KEY `id_media` (`id_media`);

--
-- Indexes for table `obe_rps_pustaka`
--
ALTER TABLE `obe_rps_pustaka`
  ADD PRIMARY KEY (`id_pustaka`),
  ADD KEY `id_rps` (`id_rps`);

--
-- Indexes for table `obe_rps_subcpmk`
--
ALTER TABLE `obe_rps_subcpmk`
  ADD PRIMARY KEY (`id_subcpmk`),
  ADD KEY `id_rps_cpmk` (`id_rps_cpmk`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `fakultas_id` (`fakultas_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dosen_pengampu_mk`
--
ALTER TABLE `dosen_pengampu_mk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id_fakultas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kaprodi`
--
ALTER TABLE `kaprodi`
  MODIFY `id_kaprodi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kurikulum`
--
ALTER TABLE `kurikulum`
  MODIFY `IdKurikulum` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kurikulum_mk`
--
ALTER TABLE `kurikulum_mk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id_mk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mk_prasyarat`
--
ALTER TABLE `mk_prasyarat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `obe_bk`
--
ALTER TABLE `obe_bk`
  MODIFY `idbk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `obe_bk_mk`
--
ALTER TABLE `obe_bk_mk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `obe_cpl`
--
ALTER TABLE `obe_cpl`
  MODIFY `idcpl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `obe_cpl_bk`
--
ALTER TABLE `obe_cpl_bk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `obe_cpl_cpmk`
--
ALTER TABLE `obe_cpl_cpmk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `obe_cpl_mk`
--
ALTER TABLE `obe_cpl_mk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `obe_cpmk`
--
ALTER TABLE `obe_cpmk`
  MODIFY `idcpmk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `obe_cpmk_mk`
--
ALTER TABLE `obe_cpmk_mk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `obe_pl`
--
ALTER TABLE `obe_pl`
  MODIFY `idpl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obe_pl_cpl`
--
ALTER TABLE `obe_pl_cpl`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `obe_rps`
--
ALTER TABLE `obe_rps`
  MODIFY `id_rps` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obe_rps_cpmk`
--
ALTER TABLE `obe_rps_cpmk`
  MODIFY `id_rps_cpmk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `obe_rps_indikator`
--
ALTER TABLE `obe_rps_indikator`
  MODIFY `id_indikator` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `obe_rps_materi`
--
ALTER TABLE `obe_rps_materi`
  MODIFY `id_materi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `obe_rps_media`
--
ALTER TABLE `obe_rps_media`
  MODIFY `id_media` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obe_rps_penilaian`
--
ALTER TABLE `obe_rps_penilaian`
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obe_rps_pertemuan`
--
ALTER TABLE `obe_rps_pertemuan`
  MODIFY `id_pertemuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obe_rps_pustaka`
--
ALTER TABLE `obe_rps_pustaka`
  MODIFY `id_pustaka` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obe_rps_subcpmk`
--
ALTER TABLE `obe_rps_subcpmk`
  MODIFY `id_subcpmk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id_fakultas`) ON DELETE CASCADE,
  ADD CONSTRAINT `dosen_ibfk_2` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id_prodi`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_dosen_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_users_dosen` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dosen_pengampu_mk`
--
ALTER TABLE `dosen_pengampu_mk`
  ADD CONSTRAINT `dosen_pengampu_mk_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE,
  ADD CONSTRAINT `dosen_pengampu_mk_ibfk_2` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`) ON DELETE CASCADE;

--
-- Constraints for table `kaprodi`
--
ALTER TABLE `kaprodi`
  ADD CONSTRAINT `kaprodi_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id_prodi`) ON DELETE CASCADE,
  ADD CONSTRAINT `kaprodi_ibfk_2` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`) ON DELETE CASCADE;

--
-- Constraints for table `kurikulum_mk`
--
ALTER TABLE `kurikulum_mk`
  ADD CONSTRAINT `kurikulum_mk_ibfk_1` FOREIGN KEY (`IdKurikulum`) REFERENCES `kurikulum` (`IdKurikulum`) ON DELETE CASCADE,
  ADD CONSTRAINT `kurikulum_mk_ibfk_2` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE;

--
-- Constraints for table `mk_prasyarat`
--
ALTER TABLE `mk_prasyarat`
  ADD CONSTRAINT `mk_prasyarat_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE,
  ADD CONSTRAINT `mk_prasyarat_ibfk_2` FOREIGN KEY (`id_mk_prasyarat`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_bk_mk`
--
ALTER TABLE `obe_bk_mk`
  ADD CONSTRAINT `obe_bk_mk_ibfk_1` FOREIGN KEY (`idbk`) REFERENCES `obe_bk` (`idbk`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_bk_mk_ibfk_2` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_cpl_bk`
--
ALTER TABLE `obe_cpl_bk`
  ADD CONSTRAINT `obe_cpl_bk_ibfk_1` FOREIGN KEY (`idcpl`) REFERENCES `obe_cpl` (`idcpl`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_cpl_bk_ibfk_2` FOREIGN KEY (`idbk`) REFERENCES `obe_bk` (`idbk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_cpl_cpmk`
--
ALTER TABLE `obe_cpl_cpmk`
  ADD CONSTRAINT `obe_cpl_cpmk_ibfk_1` FOREIGN KEY (`idcpl`) REFERENCES `obe_cpl` (`idcpl`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_cpl_cpmk_ibfk_2` FOREIGN KEY (`idcpmk`) REFERENCES `obe_cpmk` (`idcpmk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_cpl_mk`
--
ALTER TABLE `obe_cpl_mk`
  ADD CONSTRAINT `obe_cpl_mk_ibfk_1` FOREIGN KEY (`idcpl`) REFERENCES `obe_cpl` (`idcpl`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_cpl_mk_ibfk_2` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_cpmk`
--
ALTER TABLE `obe_cpmk`
  ADD CONSTRAINT `obe_cpmk_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_cpmk_mk`
--
ALTER TABLE `obe_cpmk_mk`
  ADD CONSTRAINT `obe_cpmk_mk_ibfk_1` FOREIGN KEY (`idcpmk`) REFERENCES `obe_cpmk` (`idcpmk`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_cpmk_mk_ibfk_2` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_pl_cpl`
--
ALTER TABLE `obe_pl_cpl`
  ADD CONSTRAINT `obe_pl_cpl_ibfk_1` FOREIGN KEY (`idpl`) REFERENCES `obe_pl` (`idpl`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_pl_cpl_ibfk_2` FOREIGN KEY (`idcpl`) REFERENCES `obe_cpl` (`idcpl`) ON DELETE CASCADE;

--
-- Constraints for table `obe_rps`
--
ALTER TABLE `obe_rps`
  ADD CONSTRAINT `obe_rps_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_rps_ibfk_2` FOREIGN KEY (`id_kaprodi`) REFERENCES `kaprodi` (`id_kaprodi`) ON DELETE SET NULL,
  ADD CONSTRAINT `obe_rps_ibfk_3` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`) ON DELETE SET NULL;

--
-- Constraints for table `obe_rps_cpmk`
--
ALTER TABLE `obe_rps_cpmk`
  ADD CONSTRAINT `obe_rps_cpmk_ibfk_1` FOREIGN KEY (`id_rps`) REFERENCES `obe_rps` (`id_rps`) ON DELETE CASCADE;

--
-- Constraints for table `obe_rps_indikator`
--
ALTER TABLE `obe_rps_indikator`
  ADD CONSTRAINT `obe_rps_indikator_ibfk_1` FOREIGN KEY (`id_rps_cpmk`) REFERENCES `obe_rps_cpmk` (`id_rps_cpmk`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_rps_indikator_ibfk_2` FOREIGN KEY (`id_subcpmk`) REFERENCES `obe_rps_subcpmk` (`id_subcpmk`) ON DELETE CASCADE;

--
-- Constraints for table `obe_rps_materi`
--
ALTER TABLE `obe_rps_materi`
  ADD CONSTRAINT `obe_rps_materi_ibfk_1` FOREIGN KEY (`id_rps`) REFERENCES `obe_rps` (`id_rps`) ON DELETE CASCADE;

--
-- Constraints for table `obe_rps_media`
--
ALTER TABLE `obe_rps_media`
  ADD CONSTRAINT `obe_rps_media_ibfk_1` FOREIGN KEY (`id_rps`) REFERENCES `obe_rps` (`id_rps`) ON DELETE CASCADE;

--
-- Constraints for table `obe_rps_penilaian`
--
ALTER TABLE `obe_rps_penilaian`
  ADD CONSTRAINT `obe_rps_penilaian_ibfk_1` FOREIGN KEY (`id_rps`) REFERENCES `obe_rps` (`id_rps`) ON DELETE CASCADE;

--
-- Constraints for table `obe_rps_pertemuan`
--
ALTER TABLE `obe_rps_pertemuan`
  ADD CONSTRAINT `obe_rps_pertemuan_ibfk_1` FOREIGN KEY (`id_rps`) REFERENCES `obe_rps` (`id_rps`) ON DELETE CASCADE,
  ADD CONSTRAINT `obe_rps_pertemuan_ibfk_2` FOREIGN KEY (`id_rps_cpmk`) REFERENCES `obe_rps_cpmk` (`id_rps_cpmk`) ON DELETE SET NULL,
  ADD CONSTRAINT `obe_rps_pertemuan_ibfk_3` FOREIGN KEY (`id_subcpmk`) REFERENCES `obe_rps_subcpmk` (`id_subcpmk`) ON DELETE SET NULL,
  ADD CONSTRAINT `obe_rps_pertemuan_ibfk_4` FOREIGN KEY (`id_penilaian`) REFERENCES `obe_rps_penilaian` (`id_penilaian`) ON DELETE SET NULL,
  ADD CONSTRAINT `obe_rps_pertemuan_ibfk_5` FOREIGN KEY (`id_materi`) REFERENCES `obe_rps_materi` (`id_materi`) ON DELETE SET NULL,
  ADD CONSTRAINT `obe_rps_pertemuan_ibfk_6` FOREIGN KEY (`id_pustaka`) REFERENCES `obe_rps_pustaka` (`id_pustaka`) ON DELETE SET NULL,
  ADD CONSTRAINT `obe_rps_pertemuan_ibfk_7` FOREIGN KEY (`id_media`) REFERENCES `obe_rps_media` (`id_media`) ON DELETE SET NULL;

--
-- Constraints for table `obe_rps_pustaka`
--
ALTER TABLE `obe_rps_pustaka`
  ADD CONSTRAINT `obe_rps_pustaka_ibfk_1` FOREIGN KEY (`id_rps`) REFERENCES `obe_rps` (`id_rps`) ON DELETE CASCADE;

--
-- Constraints for table `obe_rps_subcpmk`
--
ALTER TABLE `obe_rps_subcpmk`
  ADD CONSTRAINT `obe_rps_subcpmk_ibfk_1` FOREIGN KEY (`id_rps_cpmk`) REFERENCES `obe_rps_cpmk` (`id_rps_cpmk`) ON DELETE CASCADE;

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_ibfk_1` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id_fakultas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
