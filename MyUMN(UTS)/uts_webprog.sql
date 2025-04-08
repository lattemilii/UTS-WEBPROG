-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 05:28 PM
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
-- Database: `uts_webprog`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `NIK` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `gelar` varchar(10) NOT NULL,
  `lulusan` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `user_input` varchar(100) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`NIK`, `nama`, `email`, `DOB`, `gelar`, `lulusan`, `no_telp`, `user_input`, `tanggal_input`) VALUES
('L014837', 'Lee Heesung', 'lee.heesung@lecturer.umn.ac.id', '2001-12-10', 'Ir. ', 'Seoul University', '087628461957', 'shellen.putri@admin.umn.ac.id', '2025-04-02 17:29:34'),
('L123456', 'Hyunjin Hwang', 'hyunjin.hwang@lecturer.umn.ac.id', '2000-02-20', 'Dr.', 'MIT', '018232764248', 'shellen.putri@admin.umn.ac.id', '2025-04-02 17:38:26'),
('L213154', 'Jay Park', 'jay.park@lecturer.umn.ac.id', '2002-04-20', 'Ph.D.', 'Toronto University', '017832647924', 'shellen.putri@admin.umn.ac.id', '2025-04-02 17:40:43'),
('L397574', 'Nakamura Kazuha', 'nakamura.kazuha@lecturer.umn.ac.id', '2003-08-09', 'S.S.', 'Harvard University', '012947827484', 'najy.nabil@admin.umn.ac.id', '2025-04-02 17:42:23'),
('L674932', 'Kim Chaewon', 'kim.chaewon@lecturer.umn.ac.id', '2000-08-01', 'S.T.', 'Yonsei University', '018247846250', 'najy.nabil@admin.umn.ac.id', '2025-04-02 17:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id_krs` int(10) NOT NULL,
  `NIK_Dosen` varchar(50) NOT NULL,
  `Kode_Matkul` varchar(20) NOT NULL,
  `NIM_Mahasiswa` varchar(50) NOT NULL,
  `hari_matkul` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_matkul` time NOT NULL,
  `ruangan` varchar(10) NOT NULL,
  `user_input` varchar(100) NOT NULL,
  `tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id_krs`, `NIK_Dosen`, `Kode_Matkul`, `NIM_Mahasiswa`, `hari_matkul`, `jam_matkul`, `ruangan`, `user_input`, `tanggal_input`) VALUES
(16, 'L014837', 'CE432', '00000092747', 'Senin', '08:00:00', 'C302', 'najy.nabil@admin.umn.ac.id', '2025-04-03'),
(20, 'L123456', 'IF260', '000000383865', 'Selasa', '10:00:00', 'D1205', 'najy.nabil@admin.umn.ac.id', '2025-04-03'),
(21, 'L213154', 'IF330', '00000174938', 'Rabu', '13:00:00', 'C606', 'emily.francesca@admin.umn.ac.id', '2025-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `NIM` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `tahun_masuk` varchar(11) NOT NULL,
  `prodi` varchar(20) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `user_input` varchar(100) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`NIM`, `nama`, `email`, `DOB`, `tahun_masuk`, `prodi`, `alamat`, `no_telp`, `user_input`, `tanggal_input`) VALUES
('000000383865', 'Tom Hardy', 'tom.hardy@student.umn.ac.id', '2004-04-04', '2022', 'Teknik Elektro', 'Jl. Hammersmith', '081927856375', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:33:12'),
('000000584928', 'Florence Hugh', 'florence.hugh@student.umn.ac.id', '2002-03-01', '2023', 'Informatika', 'Jl. Hayward', '018265379845', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:34:52'),
('000000638563', 'Hugh Jackman', 'hugh.jackman@student.umn.ac.id', '2004-12-10', '2022', 'Manajemen', 'Jl. Sydney', '083865375895', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:42:32'),
('00000067853', 'Brad Pitt', 'brad.pitt@student.umn.ac.id', '2004-07-28', '2023', 'Strategic Communicat', 'Jl. Springfield', '012894786292', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:15:18'),
('00000087274', 'Zendaya', 'zendaya@student.umn.ac.id', '2004-06-05', '2021', 'Perhotelan', 'Jl. Oakland', '081992573856', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:21:07'),
('00000092743', 'Johnny Depp', 'johnny.depp@student.umn.ac.id', '2004-04-23', '2024', 'Film & Animasi', 'Jl. Owensboro', '018247398567', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:27:41'),
('00000092747', 'Angelina Jolie', 'angelina.jolie@student.umn.ac.id', '2001-09-06', '2021', 'Arsitektur', 'Jl. Los Angeles', '018287539350', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:17:46'),
('00000092773', 'Ryan Reynolds', 'ryan.reynolds@student.umn.ac.id', '2003-10-23', '2024', 'Akuntansi', 'Jl. Vancouver', '018927859386', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:45:49'),
('00000093783', 'Chris Evans', 'chris.evans@student.umn.ac.id', '2003-06-13', '2024', 'Teknik Fisika', 'Jl, Boston ', '019272385651', 'najy.nabil@admin.umn.ac.id', '2025-04-03 16:31:17'),
('00000174938', 'Tom Holland', 'tom.holland@student.umn.ac.id', '2004-07-04', '2024', 'Teknik Komputer', 'Jl. London', '018924892186', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:13:14'),
('00000192573', 'Keanu Reeves', 'keanu.reeves@student.umn.ac.id', '2003-01-09', '2023', 'Informatika', 'Jl. Melbourne', '019278548293', 'najy.nabil@admin.umn.ac.id', '2025-04-03 16:04:58'),
('00000193758', 'Henry Cavill', 'henry.cavill@student.umn.ac.id', '2001-05-05', '2024', 'Perhotelan', 'Jl. Saint Heller', '012975385980', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:38:29'),
('00000237653', 'Chris Pratt', 'chris.pratt@student.umn.ac.id', '2004-04-17', '2023', 'Film & Animasi', 'Jl. Hayward', '019275365372', 'najy.nabil@admin.umn.ac.id', '2025-04-03 16:01:30'),
('00000284627', 'Chris Hemsworth', 'chris.hemsworth1@student.umn.ac.id', '2006-09-04', '2025', 'Sistem Informasi', 'Jl. Melbourne', '018232764248', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:12:00'),
('00000285637', 'Robert Downey', 'robert.downey@student.umn.ac.id', '2002-08-06', '2022', 'Jurnalistik', 'Jl. Malibu', '091728673958', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:28:48'),
('00000293856', 'Paul Rudd', 'paul.rudd@student.umn.ac.id', '2002-06-04', '2024', 'Strategic Communicat', 'Jl. Passaic', '019275468398', 'najy.nabil@admin.umn.ac.id', '2025-04-03 16:36:59'),
('00000297823', 'Tom Cruise', 'tom.cruise@student.umn.ac.id', '2004-03-07', '2023', 'Sistem Informasi', 'Jl. Syracuse', '019275483495', 'najy.nabil@admin.umn.ac.id', '2025-04-03 15:56:01'),
('00000298536', 'Gal Gadot', 'gal.gadot@student.umn.ac.id', '2005-04-30', '2021', 'Teknik Komputer', 'Jl. Springfield', '081825839585', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:39:39'),
('00000372758', 'Andrew Garfiled', 'andrew.garfiled@student.umn.ac.id', '2005-08-20', '2024', 'DKV', 'Jl. Los Angeles', '019275839580', 'najy.nabil@admin.umn.ac.id', '2025-04-03 15:49:49'),
('00000385974', 'Will Smith', 'will.smith@student.umn.ac.id', '2003-11-23', '2022', 'DKV', 'Jl. Philadelphia', '018297853955', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:19:41'),
('00000387236', 'Emma Stone', 'emma.stone@student.umn.ac.id', '2006-11-06', '2025', 'Perhotelan', 'Jl. Scottsdale', '019275423856', 'najy.nabil@admin.umn.ac.id', '2025-04-03 15:57:02'),
('00000428654', 'Natalie Portman', 'natalie.portman@student.umn.ac.id', '2001-06-09', '2023', 'Sistem Informasi', 'Jl. Sydney', '018274986983', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:43:43'),
('00000483289', 'Benedict Wong', 'benedict.wong@student.umn.ac.id', '2003-03-07', '2025', 'Akuntansi', 'Jl. Manchester', '012975863985', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:36:50'),
('00000563298', 'Leonardo diCaprio', 'leonardo.dicaprio@student.umn.ac.id', '2004-04-09', '2023', 'Manajemen', 'Jl. Los Angeles', '018284637985', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:25:53'),
('00000574829', 'Margot Robbie', 'margot.robbie@student.umn.ac.id', '2002-02-07', '2022', 'Informatika', 'Jl. Dalby', '092386437875', 'najy.nabil@admin.umn.ac.id', '2025-04-03 15:52:01'),
('00000728653', 'Jason Momoa', 'jason.momoa@student.umn.ac.id', '2001-10-25', '2023', 'Teknik Fisika', 'Jl. Honolulu', '019937637561', 'shellen.putri@admin.umn.ac.id', '2025-04-03 15:29:58'),
('00000772563', 'Dwayne Johnson', 'dwayne.johnson@student.umn.ac.id', '2006-02-05', '2024', 'Film & Animasi', 'Jl. Hayward', '091735648538', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:47:58'),
('00000829437', 'Benedict Cumberbatch', 'benedict.cumberbatch@student.umn.ac.id', '2004-07-19', '2023', 'Teknik Fisika', 'Jl. London', '092748365787', 'najy.nabil@admin.umn.ac.id', '2025-04-03 15:51:00'),
('00000829438', 'Timothee Chalamet', 'timothee.chalamet@student.umn.ac.id', '2004-02-14', '2023', 'Arsitektur', 'Jl. Norway', '019275389581', 'najy.nabil@admin.umn.ac.id', '2025-04-03 16:39:17'),
('00000883653', 'Scarlett Johansson', 'scarlett.johansson@student.umn.ac.id', '2002-11-22', '2025', 'Strategic Communicat', 'Jl. Manhattan', '091728576855', 'emily.francesca@admin.umn.ac.id', '2025-04-03 15:40:51'),
('0000097375', 'Vin Diesel', 'vin.diesel@student.umn.ac.id', '2001-07-18', '2024', 'Jurnalistik', 'Jl. Alameda', '019274293855', 'najy.nabil@admin.umn.ac.id', '2025-04-03 16:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `kode_matkul` varchar(50) NOT NULL,
  `nama_matkul` varchar(30) NOT NULL,
  `sks` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `user_input` varchar(100) NOT NULL,
  `tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`kode_matkul`, `nama_matkul`, `sks`, `semester`, `user_input`, `tanggal_input`) VALUES
('CE432', 'Microprocessor System', 3, 4, 'shellen.putri@admin.umn.ac.id', '2025-04-02'),
('IF260', 'Operating System', 3, 4, 'najy.nabil@admin.umn.ac.id', '2025-04-02'),
('IF330', 'Web Programming', 3, 4, 'emily.francesca@admin.umn.ac.id', '2025-04-02'),
('UM194', 'Pancasila', 2, 1, 'najy.nabil@admin.umn.ac.id', '2025-04-02'),
('UM387', 'English 2', 2, 3, 'emily.francesca@admin.umn.ac.id', '2025-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `NIM` varchar(50) NOT NULL,
  `NIK` varchar(50) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL,
  `user_input` varchar(100) DEFAULT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `NIM`, `NIK`, `role`, `user_input`, `tanggal_input`) VALUES
('emily.francesca@admin.umn.ac.id', '$2y$10$7NAiGvTPw98dR9nW7.E2qulR/eJZ7iIzK2kS6CHUzsHj0bTHJU60q', '', '', 'admin', NULL, '0000-00-00 00:00:00'),
('shellen.putri@admin.umn.ac.id', '$2y$10$GKFEu7hPAx0c./jMQ5Gypu9Umk8xQLMmSKbZCOb3jxwhQmox/4sF.', '', '', 'admin', NULL, '0000-00-00 00:00:00'),
('najy.nabil@admin.umn.ac.id', '$2y$10$TNObsjYcfV8PZm1CntkbWOIXYET4yGL51q46BX2/Fvrb6AGJfhqMm', '', '', 'admin', NULL, '0000-00-00 00:00:00'),
('lee.heesung@lecturer.umn.ac.id', '$2y$10$k4i8CYTcPPJvfhljUDKzmOEb5dZlGJyXwknVRI8i7G9oWRqGlcC3G', '', 'L014837', 'dosen', NULL, '0000-00-00 00:00:00'),
('hyunjin.hwang@lecturer.umn.ac.id', '$2y$10$DdkXfJi/GJu/BBcdvbEaHOxU55ClL9R1DBM1fj332XrofWsxpHn8C', '', 'L123456', 'dosen', NULL, '0000-00-00 00:00:00'),
('jay.park@lecturer.umn.ac.id', '$2y$10$RMn4lAp/lwPVF3e1r9s6k./swpKfgN0.8qARXR8sAlry0L36Cyicu', '', 'L213154', 'dosen', NULL, '0000-00-00 00:00:00'),
('nakamura.kazuha@lecturer.umn.ac.id', '$2y$10$NOcZDPwMqs85udVpuXYaxOullReXlYwxOkzJ21dnFgJJRIwwZ.TS2', '', 'L397574', 'dosen', NULL, '0000-00-00 00:00:00'),
('kim.chaewon@lecturer.umn.ac.id', '$2y$10$tUIvttqdT38rDTHR3vRojeuvZkegc.YcCzZ7mTZGLmhONbkoirQSu', '', 'L674932', 'dosen', NULL, '0000-00-00 00:00:00'),
('@student.umn.ac.id', '$2y$10$AW9BXjKS6WLtQrDonlmQWOghiQiToGeJiCUoAvCUZ3Ws4jucX1CoG', '00000182376', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('1@student.umn.ac.id', '$2y$10$O.hjCQ0fVEhwv0hnoV/dFe1E9RGvMnwurFjGJtFo.49JqjEfQOE4S', '00000192774', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('chris.hemsworth@student.umn.ac.id', '$2y$10$2EQbhCkDUGEg2zhT.nx1RuwxoccLipbG6WjgzbCeKv/et1R2YGEJW', '00000284264', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('chris.hemsworth1@student.umn.ac.id', '$2y$10$iFi/QKOi1Ae18oKvg8YajeBBDoTw3KdWovyRJQP4HlP3KqVp.amF2', '00000284627', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('tom.holland@student.umn.ac.id', '$2y$10$9mOxSeW71Hy8aoXVZt5Mk.NW/R1Uutci19U29OVlvu7idY7n84MAC', '00000174938', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('brad.pitt@student.umn.ac.id', '$2y$10$WwlFI6Y7kmVlMSMuQpOYaeJwpt/Uf.0ZgZRxsZsjzv96MSi6c3Kq.', '00000067853', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('angelina.jolie@student.umn.ac.id', '$2y$10$o2tdIBvDHdJUae10edwDe.SbaErLF9/6H9bN6HgbN9NI1xTOjWfNu', '00000092747', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('will.smith@student.umn.ac.id', '$2y$10$9u1qhhZ7xt4XHVVKYcP0D.xJCSIAxfUQoJOj7/fP.thACR5.6Dn/2', '00000385974', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('zendaya@student.umn.ac.id', '$2y$10$KP/uqUCv0HCTiRvMmXi/beOuUOyDRthgb/ui3svFO31hraI902Lh.', '00000087274', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('leonardo.dicaprio@student.umn.ac.id', '$2y$10$4HQdV/juH202uxIflqjxzeUrWCY.XcXEH7xBC9sSF0fX6UIHUzLEG', '00000563298', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('johnny.depp@student.umn.ac.id', '$2y$10$txEnkiQo6cg29RSREvh1luwL9NdB/8evFPe.VDQZ2Xc7r3eralZP6', '00000092743', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('robert.downey@student.umn.ac.id', '$2y$10$ziwRUfFKUxCogg2MummpiujVdpDRUwdZuveurJdcJUgeRLZ91d7o.', '00000285637', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('jason.momoa@student.umn.ac.id', '$2y$10$o8rzVQdj9xy2Py46G7Lpt.if4htvvIHdfDcpzSMhbwrEQwP345Woi', '00000728653', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('tom.hardy@student.umn.ac.id', '$2y$10$N141yZOLL8H8Iq9yTAv8A.F3o5Df5ew.vR/gm/DK2PyGRzBNL8knG', '000000383865', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('florence.hugh@student.umn.ac.id', '$2y$10$jBLdUcYt77UaaOXHgrgHl.H7KlZY2wLGDpBKaRyKwfkTBJ8lgweAi', '000000584928', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('benedict.wong@student.umn.ac.id', '$2y$10$DztTkqj60MgKXZsnWcHFSevcgOPENcwPNHiAtUyutrCK5uN214VNG', '00000483289', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('henry.cavill@student.umn.ac.id', '$2y$10$IEIlO8AvI/96QGkoHJs3tOxLOs2/pKoy6d6tKImHL9t04.cl8rffG', '00000193758', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('gal.gadot@student.umn.ac.id', '$2y$10$tvZusypL5nmTUu4GYzpineZMOBSOSn3/UqmwIiXRAMkI7BNCIZI3u', '00000298536', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('scarleet.johansson@student.umn.ac.id', '$2y$10$.Pvt0xRsppT/zdjZnNRsVOy4yvJS7PicOraD/6HPdv6j.eNA2Puci', '00000883653', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('hugh.jackman@student.umn.ac.id', '$2y$10$2STA.dQFyBmg/tHhPfLjM.IteL4kwnwAoWyeWeF0tWRWrozDckfrK', '000000638563', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('natalie.portman@student.umn.ac.id', '$2y$10$tsmGIH8xcW.1l6POH7YQuO1f42op38qLFN3bvpxIc5ujwK0R4akuG', '00000428654', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('ryan.reynolds@student.umn.ac.id', '$2y$10$1CwY3XbwT8JU/RMGINZyU.hkN3JW1j6M2ob4ODf0PFskMOJ12LTwq', '00000092773', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('dwayne.johnson@student.umn.ac.id', '$2y$10$dlNzNI56QUkKJjxFLprcTOVdpiaBy4nIU9tUR5EL/73r9e.KtI7Qi', '00000772563', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('andrew.garfiled@student.umn.ac.id', '$2y$10$UrLXncI2mSuOUt4BdX9UZOoKaWYsHkQvQ0/fUli6Dm7rhb4sGKAW.', '00000372758', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('benedict.cumberbatch@student.umn.ac.id', '$2y$10$4k80CXbukF4pbOFWRK5/Wu6Ix4Xdb5Le5uIMQlo4INybGaxjfIxxy', '00000829437', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('margot.robbie@student.umn.ac.id', '$2y$10$jOl5tNfv2gICBGAAFGpQ5uQj.V8ToFucXbTz9FwKm.96zTnga.dHa', '00000574829', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('tom.cruise@student.umn.ac.id', '$2y$10$yc3c5GiNZNiidPtn2gF1wOuX0izGwBzUzHZFzBURpVVaVxyfqdQqm', '00000297823', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('emma.stone@student.umn.ac.id', '$2y$10$aQPDh4ClqD9rEJoCQPq/S.zyw9QtFzSHHgX/QwZ4sdUnMTgx9XCMO', '00000387236', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('chris.pratt@student.umn.ac.id', '$2y$10$UKL.SKphw7SU5JnbpuEJpuAQps5iUc8iosuSEzi20KTVDsYHz/kEi', '00000237653', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('vin.diesel@student.umn.ac.id', '$2y$10$uLLAByygRKD9ojeLryvrsu4bBO8yaGU8FaHZwKJNWYjbic0e6UicS', '0000097375', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('keanu.reeves@student.umn.ac.id', '$2y$10$XaNPFTkisL/95YAfC.2/EOiJJJuSBWza.Vn.ySCMUnkw7uojqHYmi', '00000192573', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('chris.evans@student.umn.ac.id', '$2y$10$gOUyZdj2jGxneQ8MHP1m7Oic/XxtVmMyobcjAf8omtO8mnRN5Y/aW', '00000093783', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('paul.rudd@student.umn.ac.id', '$2y$10$Bk.vsNDL81DHGJgmsbn.weKB4b.EGp3EMv4OiMAGhsF.fSJH/BLU2', '00000293856', '', 'mahasiswa', NULL, '0000-00-00 00:00:00'),
('timothee.chalamet@student.umn.ac.id', '$2y$10$RJ9ZAfqhdVrg0x6FmK4RnunH3CKrVtyOHojOT2lvRMaEmHXCjpah6', '00000829438', '', 'mahasiswa', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_krs_dosen`
-- (See below for the actual view)
--
CREATE TABLE `v_krs_dosen` (
`Kode_Matkul` varchar(20)
,`Nama_Matkul` varchar(30)
,`sks` int(11)
,`Hari_Matkul` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
,`Jam_Matkul` time
,`Ruangan` varchar(10)
,`NIK_Dosen` varchar(50)
,`Email_Dosen` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_krs_mahasiswa`
-- (See below for the actual view)
--
CREATE TABLE `v_krs_mahasiswa` (
`Kode_Matkul` varchar(20)
,`Nama_Matkul` varchar(30)
,`sks` int(11)
,`Hari_Matkul` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
,`Jam_Matkul` time
,`Ruangan` varchar(10)
,`Nama_dosen` varchar(50)
,`Email_Mahasiswa` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `v_krs_dosen`
--
DROP TABLE IF EXISTS `v_krs_dosen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_krs_dosen`  AS SELECT `k`.`Kode_Matkul` AS `Kode_Matkul`, `m`.`nama_matkul` AS `Nama_Matkul`, `m`.`sks` AS `sks`, `k`.`hari_matkul` AS `Hari_Matkul`, `k`.`jam_matkul` AS `Jam_Matkul`, `k`.`ruangan` AS `Ruangan`, `d`.`NIK` AS `NIK_Dosen`, `d`.`email` AS `Email_Dosen` FROM ((`krs` `k` join `mata_kuliah` `m` on(`k`.`Kode_Matkul` = `m`.`kode_matkul`)) join `dosen` `d` on(`k`.`NIK_Dosen` = `d`.`NIK`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_krs_mahasiswa`
--
DROP TABLE IF EXISTS `v_krs_mahasiswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_krs_mahasiswa`  AS SELECT `k`.`Kode_Matkul` AS `Kode_Matkul`, `m`.`nama_matkul` AS `Nama_Matkul`, `m`.`sks` AS `sks`, `k`.`hari_matkul` AS `Hari_Matkul`, `k`.`jam_matkul` AS `Jam_Matkul`, `k`.`ruangan` AS `Ruangan`, `d`.`nama` AS `Nama_dosen`, `mh`.`email` AS `Email_Mahasiswa` FROM (((`krs` `k` join `mata_kuliah` `m` on(`k`.`Kode_Matkul` = `m`.`kode_matkul`)) join `dosen` `d` on(`k`.`NIK_Dosen` = `d`.`NIK`)) join `mahasiswa` `mh` on(`k`.`NIM_Mahasiswa` = `mh`.`NIM`)) ;

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
  ADD PRIMARY KEY (`id_krs`),
  ADD UNIQUE KEY `NIK_Dosen` (`NIK_Dosen`),
  ADD UNIQUE KEY `Kode_Matkul` (`Kode_Matkul`),
  ADD UNIQUE KEY `NIM_Mahasiswa` (`NIM_Mahasiswa`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`NIM`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`kode_matkul`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id_krs` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`NIK_Dosen`) REFERENCES `dosen` (`NIK`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `krs_ibfk_3` FOREIGN KEY (`Kode_Matkul`) REFERENCES `mata_kuliah` (`kode_matkul`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `krs_ibfk_4` FOREIGN KEY (`NIM_Mahasiswa`) REFERENCES `mahasiswa` (`NIM`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
