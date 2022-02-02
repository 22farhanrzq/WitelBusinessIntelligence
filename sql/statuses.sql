-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2021 at 07:53 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interntelkom2`
--

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `kode` smallint(6) NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kendala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`kode`, `kategori`, `nama_kendala`, `created_at`, `updated_at`) VALUES
(101, 'Kendala Teknisi', 'Polongan', NULL, NULL),
(102, 'Kendala Teknisi', 'Full Fisik', NULL, NULL),
(103, 'Kendala Teknisi', 'ODP No Power', NULL, NULL),
(104, 'Kendala Teknisi', 'ODP Jauh', NULL, NULL),
(105, 'Kendala Teknisi', 'Underspec', NULL, NULL),
(106, 'Kendala Teknisi', 'Tidak Ada Tiang', NULL, NULL),
(107, 'Kendala Teknisi', 'Real Full Fisik', NULL, NULL),
(108, 'Kendala Teknisi', 'ODP Belum Go Live', NULL, NULL),
(110, 'Kendala Teknisi', 'Jalur Rawan Gangguan', NULL, NULL),
(111, 'Kendala Teknisi', 'ONT Habis', NULL, NULL),
(201, 'Kendala Pelanggan', 'Reschedule by Pelanggan', NULL, NULL),
(202, 'Kendala Pelanggan', 'PIC RNA', NULL, NULL),
(203, 'Kendala Pelanggan', 'Alamat Tidak Ditemukan', NULL, NULL),
(204, 'Kendala Pelanggan', 'Kendala IKR/IKG', NULL, NULL),
(205, 'Kendala Pelanggan', 'Kendala Ijin', NULL, NULL),
(206, 'Kendala Pelanggan', 'Belum Deal Harga', NULL, NULL),
(211, 'Kendala Pelanggan', 'Reschedule by Teknisi', NULL, NULL),
(302, 'Kendala Pelanggan', 'Cancel by Pelanggan', NULL, NULL),
(303, 'Kendala Pelanggan', 'Beda Segment', NULL, NULL),
(305, 'Kendala Pelanggan', 'Double Order', NULL, NULL),
(401, 'Kendala Pelanggan', 'Done HR', NULL, NULL),
(402, 'Kendala Pelanggan', 'Done Install', NULL, NULL),
(403, 'Kendala Pelanggan', 'ACTCOMP', NULL, NULL),
(404, 'Kendala Pelanggan', 'FO ACT', NULL, NULL),
(500, 'PS', 'Provisioning Success', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`kode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
