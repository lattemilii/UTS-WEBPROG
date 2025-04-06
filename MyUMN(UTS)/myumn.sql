-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 08:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myumn`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `NIK` varchar(255) NOT NULL,
  `Nama` varchar(255) DEFAULT NULL,
  `Gelar` varchar(255) DEFAULT NULL,
  `Lulusan` varchar(255) DEFAULT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `Telp` varchar(255) DEFAULT NULL,
  `User_Input` varchar(255) DEFAULT NULL,
  `Tanggal_Input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`NIK`, `Nama`, `Gelar`, `Lulusan`, `dob`, `email`, `Telp`, `User_Input`, `Tanggal_Input`) VALUES
('L123456', 'Hyunjin Hwang', 'Dr.', 'MIT', '2000-02-20', 'hyunjin.hwang@lecturer.umn.ac.id', '087812345678', 'emily.francesca@admin.umn.ac.id', '2025-04-01 15:16:48'),
('L194837', 'Lee Heeseung', 'Ir.', 'Seoul University', '2001-10-15', 'lee.heeseung@lecturer.umn.ac.id', '087628461957', 'emily.francesca@admin.umn.ac.id', '2025-04-01 15:18:37'),
('L213154', 'Jay Park', 'Ph.D', 'Toronto University', '2002-04-20', 'jay.park@lecturer.umn.ac.id', '087628461957', 'emily.francesca@admin.umn.ac.id', '2025-04-01 15:18:24');

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id` int(11) NOT NULL,
  `NIK_Dosen` varchar(255) DEFAULT NULL,
  `Kode_Matkul` varchar(255) DEFAULT NULL,
  `NIM_Mahasiswa` varchar(255) DEFAULT NULL,
  `Hari_Matkul` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `Jam_Matkul` time DEFAULT NULL,
  `Ruangan` varchar(255) DEFAULT NULL,
  `User_Input` varchar(255) DEFAULT NULL,
  `Tanggal_Input` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id`, `NIK_Dosen`, `Kode_Matkul`, `NIM_Mahasiswa`, `Hari_Matkul`, `Jam_Matkul`, `Ruangan`, `User_Input`, `Tanggal_Input`) VALUES
(1, 'L123456', 'IF330', '000000135724', 'Senin', '08:00:00', 'C302', 'emily.francesca@admin.umn.ac.id', '2025-04-01'),
(2, 'L213154', 'CE432', '000000789954', 'Selasa', '13:00:00', 'C304', 'emily.francesca@admin.umn.ac.id', '2025-04-01'),
(3, 'L194837', 'UM223', '000000139485', 'Senin', '14:00:00', 'C304', 'emily.francesca@admin.umn.ac.id', '2025-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `NIM` varchar(255) NOT NULL,
  `Nama` varchar(255) DEFAULT NULL,
  `Tahun_Masuk` varchar(255) DEFAULT NULL,
  `Prodi` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `Telp` varchar(255) DEFAULT NULL,
  `User_Input` varchar(255) DEFAULT NULL,
  `Tanggal_Input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`NIM`, `Nama`, `Tahun_Masuk`, `Prodi`, `dob`, `email`, `Alamat`, `Telp`, `User_Input`, `Tanggal_Input`) VALUES
('000000135724', 'Nishimura Riki', '2023', 'Teknik Komputer', '2005-12-09', 'nishimura.riki@student.umn.ac.id', 'Jl. Enhypen', '087812345678', 'emily.francesca@admin.umn.ac.id', '2025-04-01 15:17:57'),
('000000135725', 'Hector Salamanca', '2023', 'Teknik Elektro', '2005-05-01', 'hector.salamanca@student.umn.ac.id', 'Jl. Sana Sini', '08758374837', 'emily.francesca@admin.umn.ac.id', '2025-04-01 17:31:43'),
('000000139485', 'Han Jisung', '2023', 'DKV', '2000-09-14', 'han.jisung@student.umn.ac.id', 'Jl. Quokka', '087865438765', 'emily.francesca@admin.umn.ac.id', '2025-04-01 15:19:45'),
('000000789954', 'Yang Jungwon', '2022', 'Film & Animasi', '2004-02-09', 'yang.jungwon@student.umn.ac.id', 'Jl. Scientia', '234234236565', 'emily.francesca@admin.umn.ac.id', '2025-04-01 15:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `Kode_Matkul` varchar(255) NOT NULL,
  `Nama_Matkul` varchar(255) NOT NULL,
  `sks` int(11) NOT NULL,
  `Semester` int(11) NOT NULL,
  `User_Input` varchar(255) NOT NULL,
  `Tanggal_Input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`Kode_Matkul`, `Nama_Matkul`, `sks`, `Semester`, `User_Input`, `Tanggal_Input`) VALUES
('CE432', 'Microprocessor System', 3, 4, 'emily.francesca@admin.umn.ac.id', '2025-04-01'),
('IF330', 'Web Programming', 3, 4, 'emily.francesca@admin.umn.ac.id', '2025-04-01'),
('MAN421', 'Management Information System', 3, 2, 'emily.francesca@admin.umn.ac.id', '2025-04-01'),
('UM223', 'English 2', 2, 3, 'emily.francesca@admin.umn.ac.id', '2025-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL,
  `NIK` varchar(255) NOT NULL,
  `NIM` varchar(255) NOT NULL,
  `User_Input` varchar(255) DEFAULT NULL,
  `Tanggal_Input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `role`, `NIK`, `NIM`, `User_Input`, `Tanggal_Input`) VALUES
('emily.francesca@admin.umn.ac.id', '$2y$10$7zOGAzRGymdL/AdMz4UefucX64AyLeubrIkrLakDC5vMAOYWOO6QW', 'admin', '', '', NULL, '2025-04-01 20:08:27'),
('nishimura.riki@student.umn.ac.id', '$2y$10$QvY.02SrQiheNi1M8Huc5ucuVEYawTmofsQjDxR9njzm4djqKb3Ti', 'mahasiswa', '', '000000135724', 'emily.francesca@admin.umn.ac.id', '2025-04-01 20:17:57'),
('hector.salamanca@student.umn.ac.id', '$2y$10$aFo8iES6B6BXqgAE2GdjQuBDF52kNUOfouwcrvh82ffSQFWCGaIXG', 'mahasiswa', '', '000000135725', NULL, '2025-04-01 22:31:43'),
('han.jisung@student.umn.ac.id', '$2y$10$Jf9HGN1q28HsJvOqMoJmWOlHNAwRWAV.MwyvG1Mhh8qzaU8DWyra6', 'mahasiswa', '', '000000139485', 'emily.francesca@admin.umn.ac.id', '2025-04-01 20:19:45'),
('yang.jungwon@student.umn.ac.id', '$2y$10$hss4HHG2WEN8XaUhbuBuWu93umQ6/YttvjA9vMsrH2vmlKp0iGgOK', 'mahasiswa', '', '000000789954', 'emily.francesca@admin.umn.ac.id', '2025-04-01 20:19:11'),
('hyunjin.hwang@lecturer.umn.ac.id', '$2y$10$6TbuWOOtOVkJgKdEYFL8le6iyY5GxS3AsvqluaufvrFo.sI3AyaFS', 'dosen', 'L123456', '', 'emily.francesca@admin.umn.ac.id', '2025-04-01 20:16:48'),
('lee.heeseung@lecturer.umn.ac.id', '$2y$10$XcNYJal0xZgwVBpRY38SWOVC4D1Sea26UiLufBJ5Mre5sA9byfhbW', 'dosen', 'L194837', '', 'emily.francesca@admin.umn.ac.id', '2025-04-01 20:18:37'),
('jay.park@lecturer.umn.ac.id', '$2y$10$NUdvyUmm6mh6smf.aiyYMezf9MWl5plQ2N9jXfIUck8rRp.6KIGse', 'dosen', 'L213154', '', 'emily.francesca@admin.umn.ac.id', '2025-04-01 20:18:24');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_krs_dosen`
-- (See below for the actual view)
--
CREATE TABLE `v_krs_dosen` (
`Kode_Matkul` varchar(255)
,`Nama_Matkul` varchar(255)
,`sks` int(11)
,`Hari_Matkul` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
,`Jam_Matkul` time
,`Ruangan` varchar(255)
,`NIK_Dosen` varchar(255)
,`Email_Dosen` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_krs_mahasiswa`
-- (See below for the actual view)
--
CREATE TABLE `v_krs_mahasiswa` (
`Kode_Matkul` varchar(255)
,`Nama_Matkul` varchar(255)
,`sks` int(11)
,`Hari_Matkul` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
,`Jam_Matkul` time
,`Ruangan` varchar(255)
,`Nama_Dosen` varchar(255)
,`Email_Mahasiswa` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `v_krs_dosen`
--
DROP TABLE IF EXISTS `v_krs_dosen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_krs_dosen`  AS SELECT `krs`.`Kode_Matkul` AS `Kode_Matkul`, `mata_kuliah`.`Nama_Matkul` AS `Nama_Matkul`, `mata_kuliah`.`sks` AS `sks`, `krs`.`Hari_Matkul` AS `Hari_Matkul`, `krs`.`Jam_Matkul` AS `Jam_Matkul`, `krs`.`Ruangan` AS `Ruangan`, `krs`.`NIK_Dosen` AS `NIK_Dosen`, `dosen`.`email` AS `Email_Dosen` FROM ((`krs` join `mata_kuliah` on(`krs`.`Kode_Matkul` = `mata_kuliah`.`Kode_Matkul`)) join `dosen` on(`krs`.`NIK_Dosen` = `dosen`.`NIK`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_krs_mahasiswa`
--
DROP TABLE IF EXISTS `v_krs_mahasiswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_krs_mahasiswa`  AS SELECT `krs`.`Kode_Matkul` AS `Kode_Matkul`, `mata_kuliah`.`Nama_Matkul` AS `Nama_Matkul`, `mata_kuliah`.`sks` AS `sks`, `krs`.`Hari_Matkul` AS `Hari_Matkul`, `krs`.`Jam_Matkul` AS `Jam_Matkul`, `krs`.`Ruangan` AS `Ruangan`, `dosen`.`Nama` AS `Nama_Dosen`, `mahasiswa`.`email` AS `Email_Mahasiswa` FROM (((`krs` join `mata_kuliah` on(`krs`.`Kode_Matkul` = `mata_kuliah`.`Kode_Matkul`)) join `mahasiswa` on(`krs`.`NIM_Mahasiswa` = `mahasiswa`.`NIM`)) join `dosen` on(`krs`.`NIK_Dosen` = `dosen`.`NIK`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`NIK`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NIK_Dosen` (`NIK_Dosen`,`Kode_Matkul`,`NIM_Mahasiswa`,`Hari_Matkul`),
  ADD KEY `Kode_Matkul` (`Kode_Matkul`),
  ADD KEY `NIM_Mahasiswa` (`NIM_Mahasiswa`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`NIM`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`Kode_Matkul`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`NIK`,`NIM`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`NIK`) REFERENCES `users` (`NIK`) ON DELETE CASCADE;

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`NIK_Dosen`) REFERENCES `dosen` (`NIK`) ON DELETE CASCADE,
  ADD CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`Kode_Matkul`) REFERENCES `mata_kuliah` (`Kode_Matkul`) ON DELETE CASCADE,
  ADD CONSTRAINT `krs_ibfk_3` FOREIGN KEY (`NIM_Mahasiswa`) REFERENCES `mahasiswa` (`NIM`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
