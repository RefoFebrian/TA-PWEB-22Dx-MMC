-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2023 at 07:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(10) NOT NULL,
  `hari` text NOT NULL,
  `jam` text NOT NULL,
  `mesin` text NOT NULL,
  `ruangan` text NOT NULL,
  `status_jadwal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `hari`, `jam`, `mesin`, `ruangan`, `status_jadwal`) VALUES
(1, 'SENIN', '08.00-12.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(2, 'SENIN', '14.00-18.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(3, 'SENIN', '08.00-12.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(4, 'SENIN', '14.00-18.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(5, 'SELASA', '08.00-12.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(6, 'SELASA', '14.00-18.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(7, 'SELASA', '08.00-12.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(8, 'SELASA', '14.00-18.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(9, 'SENIN', '08.00-12.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(10, 'SENIN', '14.00-18.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(11, 'RABU', '08.00-12.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(12, 'RABU', '14.00-18.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(13, 'RABU', '08.00-12.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(14, 'RABU', '14.00-18.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(15, 'RABU', '08.00-12.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(16, 'RABU', '14.00-18.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(17, 'KAMIS', '08.00-12.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(18, 'KAMIS', '14.00-18.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(19, 'KAMIS', '08.00-12.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(20, 'KAMIS', '14.00-18.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(21, 'KAMIS', '08.00-12.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(22, 'KAMIS', '14.00-18.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(23, 'JUMAT', '08.00-12.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(24, 'JUMAT', '14.00-18.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(25, 'JUMAT', '08.00-12.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(26, 'JUMAT', '14.00-18.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(27, 'JUMAT', '08.00-12.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(28, 'JUMAT', '14.00-18.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(29, 'SABTU', '08.00-12.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(30, 'SABTU', '14.00-18.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(31, 'SABTU', '08.00-12.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(32, 'SABTU', '14.00-18.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(33, 'SABTU', '08.00-12.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(34, 'SABTU', '14.00-18.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(35, 'MINGGU', '08.00-12.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(36, 'MINGGU', '14.00-18.00', 'MESIN-A', 'RUANGAN-X', 'AKTIF'),
(37, 'MINGGU', '08.00-12.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(38, 'MINGGU', '14.00-18.00', 'MESIN-B', 'RUANGAN-X', 'AKTIF'),
(39, 'MINGGU', '08.00-12.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(40, 'MINGGU', '14.00-18.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(41, 'SELASA', '08.00-12.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF'),
(42, 'SELASA', '14.00-18.00', 'MESIN-C', 'RUANGAN-X', 'AKTIF');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_perawatan`
--

CREATE TABLE `jadwal_perawatan` (
  `id_penjadwalan` int(50) NOT NULL,
  `ID_Pasien` int(11) DEFAULT NULL,
  `ID_Staf` int(11) DEFAULT NULL,
  `Mesin` varchar(255) NOT NULL,
  `Hari` varchar(255) NOT NULL,
  `Jam` varchar(255) NOT NULL,
  `id_jadwal` int(10) NOT NULL,
  `status_perawatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int(11) NOT NULL,
  `Nama_layanan` varchar(255) DEFAULT NULL,
  `Harga` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `Nama_Obat` varchar(255) DEFAULT NULL,
  `Jenis_Obat` varchar(255) DEFAULT NULL,
  `Harga` int(100) DEFAULT NULL,
  `Stok` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `Nama_Obat`, `Jenis_Obat`, `Harga`, `Stok`) VALUES
(1, ')aL%f/', 'TABLET/KAPSUL', 10000, 80),
(2, '9)+c4g@w>3\'Ka', 'CAIR/BOTOL', 30000, 28);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `ID_Pasien` int(11) NOT NULL,
  `no_rekammedis` varchar(255) NOT NULL,
  `nm_pasien` varchar(255) NOT NULL,
  `tl_pasien` varchar(255) NOT NULL,
  `Alamat_pasien` varchar(255) NOT NULL,
  `telp_pasien` varchar(255) NOT NULL,
  `no_asuransi` varchar(255) NOT NULL,
  `Informasi_Asuransi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`ID_Pasien`, `no_rekammedis`, `nm_pasien`, `tl_pasien`, `Alamat_pasien`, `telp_pasien`, `no_asuransi`, `Informasi_Asuransi`) VALUES
(1, '=y~?}I', '1\ZY=<x/Sx: :CI', '2\0[\\Jcn6\"', 'j,+', 'W-vPEwyvtuj', '(x{	7%', '@tOSy'),
(8, 'iO\']/3', '!v70\Z-GGS}{Om', 'QgT[\\\rdXp0', 'm`:@f-j[', '*kLxd', 'Q+r	', '@tOSy');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `ID_Pasien` int(11) DEFAULT NULL,
  `Tanggal_Pembayaran` date DEFAULT NULL,
  `id_layanan` int(11) DEFAULT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `Jumlah_Pembayaran` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_user`, `username`, `pass`) VALUES
(1, '|Ro}', 'dsq:l]W@G~{'),
(5, ':JZrV', 'DY1t\\');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_medis`
--

CREATE TABLE `riwayat_medis` (
  `id_riwayatmedis` int(50) NOT NULL,
  `ID_Pasien` int(11) NOT NULL,
  `ID_Staf` int(11) NOT NULL,
  `Tanggal_Pemeriksaan` varchar(255) NOT NULL,
  `Diagnosis` text NOT NULL,
  `Hasil_Pemeriksaan` text NOT NULL,
  `Perawatan_Yang_Direkomendasikan` text NOT NULL,
  `Catatan_Tambahan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_medis`
--

INSERT INTO `riwayat_medis` (`id_riwayatmedis`, `ID_Pasien`, `ID_Staf`, `Tanggal_Pemeriksaan`, `Diagnosis`, `Hasil_Pemeriksaan`, `Perawatan_Yang_Direkomendasikan`, `Catatan_Tambahan`) VALUES
(1, 1, 1, 'hl\"	\\Ba^7%', ',qEJM73@nn', '\\FA\'%iT,', 'Ofys\ZNO=gf(`M}WOXxh', '}B[hAX\r{');

-- --------------------------------------------------------

--
-- Table structure for table `staf_klinik`
--

CREATE TABLE `staf_klinik` (
  `ID_Staf` int(11) NOT NULL,
  `nm_staf` varchar(255) DEFAULT NULL,
  `tl_staf` varchar(255) DEFAULT NULL,
  `Jabatan` varchar(255) DEFAULT NULL,
  `telp_staf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staf_klinik`
--

INSERT INTO `staf_klinik` (`ID_Staf`, `nm_staf`, `tl_staf`, `Jabatan`, `telp_staf`) VALUES
(1, '	*vTqq__D-%-!g^Sf', ':bXwF[\07%', '^h#%zUi+', 'W-v!\Z8'),
(2, '90B!G\n>FR', 't-2[\\`\r7%', 'bwO[', '(x{	K-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD UNIQUE KEY `id_jadwal` (`id_jadwal`);

--
-- Indexes for table `jadwal_perawatan`
--
ALTER TABLE `jadwal_perawatan`
  ADD PRIMARY KEY (`id_penjadwalan`),
  ADD UNIQUE KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `ID_Pasien` (`ID_Pasien`),
  ADD KEY `ID_Staf` (`ID_Staf`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`),
  ADD UNIQUE KEY `id_layanan` (`id_layanan`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD UNIQUE KEY `id_obat` (`id_obat`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`ID_Pasien`),
  ADD UNIQUE KEY `ID_Pasien` (`ID_Pasien`) USING BTREE;

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD KEY `ID_Pasien` (`ID_Pasien`),
  ADD KEY `id_layanan` (`id_layanan`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `riwayat_medis`
--
ALTER TABLE `riwayat_medis`
  ADD PRIMARY KEY (`id_riwayatmedis`),
  ADD KEY `ID_Pasien` (`ID_Pasien`),
  ADD KEY `ID_Staf` (`ID_Staf`) USING BTREE;

--
-- Indexes for table `staf_klinik`
--
ALTER TABLE `staf_klinik`
  ADD PRIMARY KEY (`ID_Staf`),
  ADD UNIQUE KEY `ID_Staf` (`ID_Staf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `jadwal_perawatan`
--
ALTER TABLE `jadwal_perawatan`
  MODIFY `id_penjadwalan` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `ID_Pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riwayat_medis`
--
ALTER TABLE `riwayat_medis`
  MODIFY `id_riwayatmedis` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staf_klinik`
--
ALTER TABLE `staf_klinik`
  MODIFY `ID_Staf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_perawatan`
--
ALTER TABLE `jadwal_perawatan`
  ADD CONSTRAINT `jadwal_perawatan_ibfk_1` FOREIGN KEY (`ID_Pasien`) REFERENCES `pasien` (`ID_Pasien`),
  ADD CONSTRAINT `jadwal_perawatan_ibfk_2` FOREIGN KEY (`ID_Staf`) REFERENCES `staf_klinik` (`ID_Staf`),
  ADD CONSTRAINT `jadwal_perawatan_ibfk_3` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`ID_Pasien`) REFERENCES `pasien` (`ID_Pasien`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`),
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);

--
-- Constraints for table `riwayat_medis`
--
ALTER TABLE `riwayat_medis`
  ADD CONSTRAINT `riwayat_medis_ibfk_1` FOREIGN KEY (`ID_Pasien`) REFERENCES `pasien` (`ID_Pasien`),
  ADD CONSTRAINT `riwayat_medis_ibfk_2` FOREIGN KEY (`ID_Staf`) REFERENCES `staf_klinik` (`ID_Staf`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
