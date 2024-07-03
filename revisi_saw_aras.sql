-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 28 Mei 2024 pada 02.52
-- Versi Server: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `revisi_saw_aras`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen`
--

CREATE TABLE `dokumen` (
  `id` int(11) NOT NULL,
  `gid` int(11) DEFAULT NULL,
  `kid` int(11) DEFAULT NULL,
  `gname` varchar(255) DEFAULT NULL,
  `glok` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `dokumen`
--

INSERT INTO `dokumen` (`id`, `gid`, `kid`, `gname`, `glok`) VALUES
(5, 2147483647, 1, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f312f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(6, 2147483647, 6, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f362f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(7, 2147483647, 2, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f322f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(8, 2147483647, 7, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f372f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(9, 2147483647, 30, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f33302f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(10, 2147483647, 31, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f33312f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(11, 2147483647, 32, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f33322f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(12, 2147483647, 33, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f33332f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(13, 2147483647, 34, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f33342f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(14, 2147483647, 35, 'Screenshot_2024-03-31-10-27-32-79_40deb401b9ffe8e1df2f1cc5ba480b12 - Sulfa 087704.jpg', 0x75706c6f6164732f303931303538313232323032322f33352f53637265656e73686f745f323032342d30332d33312d31302d32372d33322d37395f3430646562343031623966666538653164663266316363356261343830623132202d2053756c6661203038373730342e6a7067),
(15, 221280118, 1, 'Screenshot 2024-04-14 203127.png', 0x75706c6f6164732f3232313238303131382f312f53637265656e73686f7420323032342d30342d3134203230333132372e706e67),
(16, 221280118, 2, 'Screenshot 2024-04-14 203239.png', 0x75706c6f6164732f3232313238303131382f322f53637265656e73686f7420323032342d30342d3134203230333233392e706e67),
(17, 221280118, 30, 'Screenshot 2024-04-14 203205.png', 0x75706c6f6164732f3232313238303131382f33302f53637265656e73686f7420323032342d30342d3134203230333230352e706e67);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `idk` tinyint(4) NOT NULL,
  `metode` enum('SAW','ARAS') NOT NULL,
  `nama_k` varchar(100) NOT NULL,
  `jenis_k` set('benefit','cost') DEFAULT NULL,
  `bobot` float NOT NULL,
  `nilai_min` decimal(10,2) NOT NULL,
  `nilai_max` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`idk`, `metode`, `nama_k`, `jenis_k`, `bobot`, `nilai_min`, `nilai_max`) VALUES
(1, 'SAW', 'IPK', 'benefit', 0.457, '0.00', '4.00'),
(2, 'SAW', 'KTI', 'benefit', 0.257, '0.00', '10.00'),
(6, 'ARAS', 'IPK', 'benefit', 0.457, '0.00', '4.00'),
(7, 'ARAS', 'KTI', 'benefit', 0.257, '0.00', '10.00'),
(30, 'SAW', 'BI', 'benefit', 0.156, '1.00', '5.00'),
(31, 'SAW', 'Organisasi', 'benefit', 0.09, '2.00', '4.00'),
(32, 'SAW', 'Sertifikat Prestasi', 'benefit', 0.04, '1.00', '5.00'),
(33, 'ARAS', 'BI', 'benefit', 0.156, '1.00', '5.00'),
(34, 'ARAS', 'Organisasi', 'benefit', 0.09, '2.00', '4.00'),
(35, 'ARAS', 'Sertifikat Prestasi', 'benefit', 0.04, '1.00', '5.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(20) NOT NULL,
  `nama_mahasiswa` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `fak` varchar(25) DEFAULT NULL,
  `prodi` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama_mahasiswa`, `alamat`, `telp`, `fak`, `prodi`) VALUES
('0910580121039', 'Adinda Salman', 'Sidrap', '082335366156', 'FKIP', 'Teknologi Pendidikan'),
('0910580322001', 'RIRIN HAFID', 'Sidrap', '083132019978', 'FISIP', 'Ilmu Pemerintahan'),
('0910580322022', 'PERAWATI UMAR', 'Parepare', '08968526271', 'FISIP', 'Ilmu Pemerintahan'),
('09105803322071', 'Citra Dwi Amaliah', 'Mario', '081318243441', 'FISIP', 'Ilmu Pemerintahan'),
('0910580422010', 'Ayu Andira', 'Sidrap', '087725492174', 'FISIP', 'Administrasi Publik'),
('0910580422038', 'Sarina', 'Sidrap', '082250718805', 'FISIP', 'Administrasi Publik'),
('0910580422046', 'Desty Kurnia Sari', 'Parepare', '0862357237632', 'FISIP', 'Administrasi Publik'),
('0910580422051', 'Shamsuria', 'Sidrap', '082363508755', 'FISIP', 'Administrasi Publik'),
('0910580422058', 'Putri Regina', 'Sidrap', '082250920896', 'FISIP', 'Administrasi Publik'),
('0910580422069', 'Nurul Hiqmah', 'Mario', '087844363218', 'FISIP', 'Administrasi Publik'),
('0910580422076', 'Nur istiqomah', 'Sidrap', '081933001157', 'FISIP', 'Administrasi Publik'),
('0910580422126', 'Adistyara Rhesaputri', 'Sidrap', '089512050660', 'FISIP', 'Administrasi Publik'),
('0910580422141', 'Sinar Baharuddin', 'Sidrap', '085299582937', 'FISIP', 'Administrasi Publik'),
('0910580422165', 'Aswan.A', 'Sidrap', '081235587302', 'FISIP', 'Administrasi Publik'),
('091058062202', 'Muh agussalim', 'Sidrap', '0865621882163', 'Sains dan teknologi', 'Peternakan'),
('0910580823001', 'Muh Darul Arqam', 'Parepare', '082141559394', 'Sains dan teknologi', 'Teknologi Hasil Pertanian'),
('0910581022013', 'Nadyah Harnol M. Lolo', 'Sidrap', '088704670904', 'Sains dan teknologi', 'Agroteknologi'),
('0910581221041', 'Naya Dwiyanti', 'Sidrap', '081805161893', 'Ilmu Kesehatan', 'Administrasi Kesehatan'),
('0910581222022', 'Sulfa', 'Sidrap', '088242841912', 'Ilmu Kesehatan', 'Administrasi Kesehatan'),
('0910581222046', 'Syura Atiqah Bte Burhan', 'Sidrap', '085395208200', 'Ilmu Kesehatan', 'Administrasi Kesehatan'),
('103', 'TES', 'Kediri', '', '', ''),
('221280118', 'Fadlullah', 'Parepare', '085256953376', 'Teknik', 'Informatika');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `iddaftar` smallint(4) NOT NULL,
  `nim` int(20) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`iddaftar`, `nim`, `name`) VALUES
(6, 0, 'Sarina'),
(5, 0, 'Ayu Andira'),
(4, 0, 'Citra Dwi Amaliah'),
(2, 0, 'RIRIN HAFID'),
(1, 0, 'Adinda Salman'),
(3, 0, 'PERAWATI UMAR'),
(7, 0, 'Desty Kurnia Sari'),
(8, 0, 'Shamsuria'),
(9, 0, 'Putri Regina'),
(10, 0, 'Nurul Hiqmah'),
(11, 0, 'Nur istiqomah'),
(12, 0, 'Adistyara Rhesaputri'),
(13, 0, 'Sinar Baharuddin'),
(14, 0, 'Aswan.A'),
(15, 0, 'Muh agussalim'),
(16, 0, 'Muh Darul Arqam'),
(17, 0, 'Nadyah Harnol M. Lolo'),
(18, 0, 'Naya Dwiyanti'),
(19, 0, 'Sulfa'),
(20, 0, 'Syura Atiqah Bte Burhan'),
(21, 221280118, 'Fadlullah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perangkingan`
--

CREATE TABLE `perangkingan` (
  `iddaftar` smallint(5) UNSIGNED NOT NULL,
  `idk` tinyint(3) UNSIGNED NOT NULL,
  `value` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `perangkingan`
--

INSERT INTO `perangkingan` (`iddaftar`, `idk`, `value`) VALUES
(3, 35, 3.25),
(3, 34, 3),
(3, 33, 5),
(3, 32, 3.25),
(3, 31, 3),
(3, 30, 5),
(3, 7, 2),
(3, 6, 1),
(3, 2, 2),
(3, 1, 1),
(1, 35, 3),
(1, 34, 0),
(1, 33, 0),
(1, 32, 3.74),
(1, 31, 1),
(1, 30, 5),
(1, 7, 0),
(1, 6, 0),
(1, 2, 4),
(1, 1, 1),
(2, 35, 0),
(2, 34, 0),
(2, 33, 0),
(2, 32, 3.89),
(2, 31, 1),
(2, 30, 5),
(2, 7, 0),
(2, 6, 0),
(2, 2, 2),
(2, 1, 1),
(4, 1, 3.7),
(4, 2, 3),
(4, 6, 0),
(4, 7, 0),
(4, 30, 5),
(4, 31, 4),
(4, 32, 1),
(4, 33, 0),
(4, 34, 0),
(4, 35, 0),
(5, 1, 3.75),
(5, 2, 1),
(5, 6, 0),
(5, 7, 0),
(5, 30, 5),
(5, 31, 4),
(5, 32, 1),
(5, 33, 0),
(5, 34, 0),
(5, 35, 0),
(6, 1, 3.63),
(6, 2, 1),
(6, 6, 0),
(6, 7, 0),
(6, 30, 5),
(6, 31, 2),
(6, 32, 1),
(6, 33, 0),
(6, 34, 0),
(6, 35, 0),
(7, 1, 3.75),
(7, 2, 1),
(7, 6, 0),
(7, 7, 0),
(7, 30, 5),
(7, 31, 2),
(7, 32, 1),
(7, 33, 0),
(7, 34, 0),
(7, 35, 0),
(8, 1, 3.58),
(8, 2, 1),
(8, 6, 0),
(8, 7, 0),
(8, 30, 5),
(8, 31, 2),
(8, 32, 1),
(8, 33, 0),
(8, 34, 0),
(8, 35, 0),
(9, 1, 3.61),
(9, 2, 1),
(9, 6, 0),
(9, 7, 0),
(9, 30, 5),
(9, 31, 2),
(9, 32, 1),
(9, 33, 0),
(9, 34, 0),
(9, 35, 0),
(10, 1, 3.72),
(10, 2, 1),
(10, 6, 0),
(10, 7, 0),
(10, 30, 5),
(10, 31, 2),
(10, 32, 1),
(10, 33, 0),
(10, 34, 0),
(10, 35, 0),
(11, 1, 3.63),
(11, 2, 1),
(11, 6, 0),
(11, 7, 0),
(11, 30, 5),
(11, 31, 2),
(11, 32, 1),
(11, 33, 0),
(11, 34, 0),
(11, 35, 0),
(12, 1, 3.72),
(12, 2, 1),
(12, 6, 0),
(12, 7, 0),
(12, 30, 5),
(12, 31, 2),
(12, 32, 1),
(12, 33, 0),
(12, 34, 0),
(12, 35, 0),
(13, 1, 3),
(13, 2, 1),
(13, 6, 0),
(13, 7, 0),
(13, 30, 5),
(13, 31, 2),
(13, 32, 1),
(13, 33, 0),
(13, 34, 0),
(13, 35, 0),
(14, 1, 3.52),
(14, 2, 1),
(14, 6, 0),
(14, 7, 0),
(14, 30, 5),
(14, 31, 2),
(14, 32, 3),
(14, 33, 0),
(14, 34, 0),
(14, 35, 0),
(15, 1, 3.46),
(15, 2, 1),
(15, 6, 0),
(15, 7, 0),
(15, 30, 5),
(15, 31, 4),
(15, 32, 1),
(15, 33, 0),
(15, 34, 0),
(15, 35, 0),
(16, 1, 4),
(16, 2, 1),
(16, 6, 0),
(16, 7, 0),
(16, 30, 5),
(16, 31, 4),
(16, 32, 1),
(16, 33, 0),
(16, 34, 0),
(16, 35, 0),
(17, 1, 0),
(17, 2, 1),
(17, 6, 0),
(17, 7, 0),
(17, 30, 5),
(17, 31, 4),
(17, 32, 1),
(17, 33, 0),
(17, 34, 0),
(17, 35, 0),
(18, 1, 0),
(18, 2, 1),
(18, 6, 0),
(18, 7, 0),
(18, 30, 5),
(18, 31, 2),
(18, 32, 1),
(18, 33, 0),
(18, 34, 0),
(18, 35, 0),
(19, 1, 0),
(19, 2, 1),
(19, 6, 0),
(19, 7, 0),
(19, 30, 5),
(19, 31, 4),
(19, 32, 1),
(19, 33, 0),
(19, 34, 0),
(19, 35, 0),
(20, 1, 0),
(20, 2, 1),
(20, 6, 0),
(20, 7, 0),
(20, 30, 5),
(20, 31, 4),
(20, 32, 1),
(20, 33, 0),
(20, 34, 0),
(20, 35, 0),
(21, 1, 10.3),
(21, 2, 2.1),
(21, 6, 4.7),
(21, 7, 0),
(21, 30, 5.8),
(21, 31, 700),
(21, 32, 102),
(21, 33, 0),
(21, 34, 0),
(21, 35, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `pass` text,
  `level` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
(6, '0910580121039', '594280c6ddc94399a392934cac9d80d5', 'Mahasiswa'),
(7, '0910581222022', 'a9d4f7624a59fe1edbf26d33ed64f869', 'Mahasiswa'),
(9, '221280118', '5f4dcc3b5aa765d61d8327deb882cf99', 'Mahasiswa'),
(10, '0910580422038', '7afad0914cb08fcc4a454b32d7d1e833', 'Mahasiswa'),
(11, '0910581221041', '3c3b0e2e88a2ba701d0b6ca94da48d06', 'Admin'),
(12, '103', '6974ce5ac660610b44d9b9fed0ff9548', 'Mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`idk`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`) USING BTREE;

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`iddaftar`);

--
-- Indexes for table `perangkingan`
--
ALTER TABLE `perangkingan`
  ADD PRIMARY KEY (`iddaftar`,`idk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `idk` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `iddaftar` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
