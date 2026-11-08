-- phpMyAdmin SQL Dump
-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2026 at 10:59 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Buku Tulis Sinar Dunia 38 Lembar', 3500, 120, 1),
(2, 'BRG002', 'Pulpen Standard AE7 0.5 Black', 2500, 250, 1),
(3, 'BRG003', 'Penghapus Joyko Hitam', 2000, 80, 2),
(4, 'BRG004', 'Penggaris Besi 30 cm', 6000, 50, 2),
(5, 'BRG005', 'Kertas HVS A4 Natural 75gr', 45000, 40, 3),
(6, 'BRG006', 'Spidol Boardmarker Snowman Hitam', 8500, 90, 4),
(7, 'BRG007', 'Tipe-X Kertas Kertas Joyko Roller', 7000, 65, 5),
(8, 'BRG008', 'Map Dokumen Clear Holder A4 20P', 15000, 30, 6),
(9, 'BRG009', 'Stapler Joyko HD-10', 12000, 45, 7),
(10, 'BRG010', 'Gunting Sedang Joyko', 9500, 35, 8);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Ahmad Dahlan', 'L', '082111222331', 'Jl. Kenjeran No. 10, Surabaya'),
('PLG002', 'Bambang Sudarsono', 'L', '082111222332', 'Jl. Manukan Kulon No. 4, Surabaya'),
('PLG003', 'Citra Kirana', 'P', '082111222333', 'Jl. Manyar Kertoarjo No. 18, Surabaya'),
('PLG004', 'Dina Mariana', 'P', '082111222334', 'Jl. Dharmahusada No. 25, Surabaya'),
('PLG005', 'Erik Setiawan', 'L', '082111222335', 'Jl. Kutai No. 8, Surabaya'),
('PLG006', 'Fanny Anggraeni', 'P', '082111222336', 'Jl. Barata Jaya No. 12, Surabaya'),
('PLG007', 'Gilang Ramadhan', 'L', '082111222337', 'Jl. Ngagel Jaya No. 40, Surabaya'),
('PLG008', 'Hany Wulandari', 'P', '082111222338', 'Jl. Menur Pumpungan No. 3, Surabaya'),
('PLG009', 'Irfan Hakim', 'L', '082111222339', 'Jl. Gubeng Pojok No. 7, Surabaya'),
('PLG010', 'Joko Susilo', 'L', '082111222340', 'Jl. Tambaksari No. 19, Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-03-01 10:15:00', 10500, 'TUNAI', 1),
(2, '2026-03-01 11:30:00', 45000, 'TRANSFER', 2),
(3, '2026-03-02 09:20:00', 17000, 'EDC', 3),
(4, '2026-03-02 14:45:00', 19000, 'TUNAI', 4),
(5, '2026-03-03 13:10:00', 20500, 'TRANSFER', 5),
(6, '2026-03-03 16:05:00', 30000, 'EDC', 6),
(7, '2026-03-04 08:50:00', 5000, 'TUNAI', 7),
(8, '2026-03-04 15:25:00', 21500, 'EDC', 8),
(9, '2026-03-05 10:40:00', 90000, 'TRANSFER', 9),
(10, '2026-03-05 17:15:00', 14000, 'TUNAI', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT. Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT. Segar Segar', '0845454663', 'Surabaya'),
(4, 'CV. Sumber Makmur', '081298765431', 'Sidoarjo'),
(5, 'PT. Berkah Sentosa', '081298765432', 'Gresik'),
(6, 'CV. Jaya Abadi', '081298765433', 'Malang'),
(7, 'PT. Logistik Prima', '081298765434', 'Surabaya'),
(8, 'CV. Mitra Sejahtera', '081298765435', 'Mojokerto'),
(9, 'PT. Bintang Terang', '081298765436', 'Pasuruan'),
(10, 'CV. Cahaya Mandiri', '081298765437', 'Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text,
  `total` int NOT NULL DEFAULT '0',
  `pelanggan_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-03-01', 'Belanja alat tulis kantor', 10500, 'PLG001'),
(2, '2026-03-01', 'Pembelian keperluan perlengkapan', 45000, 'PLG002'),
(3, '2026-03-02', 'Pesanan ATK sekolah', 17000, 'PLG003'),
(4, '2026-03-02', 'Belanja rutin mingguan', 19000, 'PLG004'),
(5, '2026-03-03', 'Pembelian spidol dan buku', 20500, 'PLG005'),
(6, '2026-03-03', 'Perlengkapan arsip kantor', 30000, 'PLG006'),
(7, '2026-03-04', 'Beli eceran', 5000, 'PLG007'),
(8, '2026-03-04', 'Kebutuhan sekretariat', 21500, 'PLG008'),
(9, '2026-03-05', 'Pembelian kertas tambahan', 90000, 'PLG009'),
(10, '2026-03-05', 'Kebutuhan ujian siswa', 14000, 'PLG010');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 3500, 3),
(2, 5, 45000, 1),
(3, 6, 8500, 2),
(4, 7, 7000, 1),
(4, 9, 12000, 1),
(5, 1, 3500, 1),
(5, 6, 8500, 2),
(6, 8, 15000, 2),
(7, 2, 2500, 2),
(8, 9, 12000, 1),
(8, 10, 9500, 1),
(9, 5, 45000, 2),
(10, 7, 7000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator Utama', 'Jl. Pemuda No. 1, Surabaya', '081234567890', 1),
(2, 'kasir1', 'de28f8f7998f23ab4194b51a6029416f', 'Budi Santoso', 'Jl. Basuki Rahmat No. 12, Surabaya', '081234567891', 2),
(3, 'kasir2', 'de28f8f7998f23ab4194b51a6029416f', 'Siti Nurhaliza', 'Jl. Diponegoro No. 45, Surabaya', '081234567892', 2),
(4, 'gudang1', 'cbb7449d78314665f9e7c7dd0a18a68a', 'Agus Prayitno', 'Jl. Ahmad Yani No. 88, Sidoarjo', '081234567893', 3),
(5, 'gudang2', 'cbb7449d78314665f9e7c7dd0a18a68a', 'Rian Hidayat', 'Jl. Pahlawan No. 23, Gresik', '081234567894', 3),
(6, 'manajer', '5fbb69663039903931daf8b26344b76b', 'Dewi Lestari', 'Jl. Darmo No. 101, Surabaya', '081234567895', 1),
(7, 'kasir3', 'de28f8f7998f23ab4194b51a6029416f', 'Eko Prasetyo', 'Jl. Mayjend Sungkono No. 15, Surabaya', '081234567896', 2),
(8, 'kasir4', 'de28f8f7998f23ab4194b51a6029416f', 'Fitri Handayani', 'Jl. Kertajaya No. 67, Surabaya', '081234567897', 2),
(9, 'supervisor', '6ade4163a398335a0a2abced430cf869', 'Hendra Wijaya', 'Jl. Jemursari No. 30, Surabaya', '081234567898', 1),
(10, 'audit', 'd33542b8458db8cabd9843fe7c1e8784', 'Indah Permata', 'Jl. Rungkut Industri No. 5, Surabaya', '081234567899', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_barang_supplier` (`supplier_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pembayaran_transaksi` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transaksi_pelanggan` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `fk_detail_barang` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `fk_detail_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
