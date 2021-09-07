-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 13, 2021 at 07:13 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_service`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `approve_saran` (IN `id` INT(11))  BEGIN
UPDATE service_order SET saran_approve = 1 WHERE no_order = id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jasa_service`
--

CREATE TABLE `jasa_service` (
  `id_jasa_service` int(11) NOT NULL,
  `nama_service` varchar(255) NOT NULL,
  `jenis_service` varchar(255) NOT NULL,
  `harga` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jasa_service`
--

INSERT INTO `jasa_service` (`id_jasa_service`, `nama_service`, `jenis_service`, `harga`) VALUES
(3, 'Service 2', 'Jenis 2', 500000),
(4, 'Service 3', 'Jenis 3', 400000);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id_part` int(11) NOT NULL,
  `nama_part` varchar(255) NOT NULL,
  `kode_part` varchar(255) NOT NULL,
  `jenis_part` varchar(255) NOT NULL,
  `harga` int(25) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id_part`, `nama_part`, `kode_part`, `jenis_part`, `harga`, `stok`) VALUES
(1, 'Part x', 'KodePartx', 'Jenis x', 150000, 20),
(2, 'Part 2', 'KodePart2', 'Jenis 2', 200000, 25),
(3, 'Part 3', 'KodePart3', 'Jenis 3', 250000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_order`
--

CREATE TABLE `service_order` (
  `no_order` int(11) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `nomor_plat` varchar(20) NOT NULL,
  `nomor_rangka` varchar(255) NOT NULL,
  `tipe_mobil` varchar(255) NOT NULL,
  `id_jasa_service` int(11) NOT NULL,
  `id_part` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `saran_approve` tinyint(1) NOT NULL,
  `total` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_order`
--

INSERT INTO `service_order` (`no_order`, `nama_pemilik`, `nomor_plat`, `nomor_rangka`, `tipe_mobil`, `id_jasa_service`, `id_part`, `jumlah`, `harga`, `saran_approve`, `total`) VALUES
(1234, 'Wahyu', 'BM 1234 RI', 'Rangka1', 'Tipe1', 3, 3, 2, 250000, 1, 1000000),
(12345, 'Mahfuzan', 'BM 1234 RU', 'Rangka2', 'Tipe2', 3, 1, 1, 150000, 0, 500000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Kepala Teknisi', 'kepalateknisi@gmail.com', 'fffbbeabc3ac58e2a1ad62700033a883', 2),
(6, 'MRA', 'mra@gmail.com', '86b546be98d8f58d4dedfb8be7423a19', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jasa_service`
--
ALTER TABLE `jasa_service`
  ADD PRIMARY KEY (`id_jasa_service`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id_part`);

--
-- Indexes for table `service_order`
--
ALTER TABLE `service_order`
  ADD PRIMARY KEY (`no_order`),
  ADD KEY `id_jasa_service` (`id_jasa_service`),
  ADD KEY `id_part` (`id_part`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jasa_service`
--
ALTER TABLE `jasa_service`
  MODIFY `id_jasa_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id_part` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_order`
--
ALTER TABLE `service_order`
  ADD CONSTRAINT `service_order_ibfk_1` FOREIGN KEY (`id_jasa_service`) REFERENCES `jasa_service` (`id_jasa_service`),
  ADD CONSTRAINT `service_order_ibfk_2` FOREIGN KEY (`id_part`) REFERENCES `parts` (`id_part`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
