/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : 127.0.0.1:3306
 Source Schema         : apotik

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 12/10/2024 17:56:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for akun
-- ----------------------------
DROP TABLE IF EXISTS `akun`;
CREATE TABLE `akun`  (
  `id_akun` int NOT NULL AUTO_INCREMENT,
  `nama_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jenis_akun` enum('Aktiva Lancar','Aktiva Tetap','Modal','Utang Lancar','Pendapatan','Beban','Pengeluaran','Kewajiban','Harga Pokok Penjualan','Penyusutan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wajib` tinyint(1) NULL DEFAULT NULL,
  `kode_akun` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_akun`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of akun
-- ----------------------------
BEGIN;
INSERT INTO `akun` (`id_akun`, `nama_akun`, `jenis_akun`, `wajib`, `kode_akun`) VALUES (1, 'Kas', 'Aktiva Lancar', 1, '100005'), (2, 'Persediaan', 'Aktiva Tetap', 1, '100002'), (5, 'HPP', 'Beban', 1, '10004'), (6, 'Modal', 'Modal', NULL, '500001'), (7, 'Pendapatan', 'Pendapatan', 1, '10004');
COMMIT;

-- ----------------------------
-- Table structure for inventory
-- ----------------------------
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory`  (
  `id_inventory` int NOT NULL AUTO_INCREMENT,
  `id_produk` int NULL DEFAULT NULL,
  `tanggal_masuk` date NULL DEFAULT NULL,
  `tanggal_kadaluarsa` date NULL DEFAULT NULL,
  `harga_beli` decimal(10, 2) NULL DEFAULT NULL,
  `jumlah` int NULL DEFAULT NULL,
  `kode_pembelian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_inventory`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of inventory
-- ----------------------------
BEGIN;
INSERT INTO `inventory` (`id_inventory`, `id_produk`, `tanggal_masuk`, `tanggal_kadaluarsa`, `harga_beli`, `jumlah`, `kode_pembelian`) VALUES (6, 3, '2024-09-01', '2024-09-30', 2400.00, 4990, 'PBL-001'), (7, 4, '2024-08-11', '2024-09-30', 4000.00, 2, 'PBL-002'), (8, 4, '2024-09-01', '2024-09-30', 4000.00, 6, 'PBL-003');
COMMIT;

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `id_pembelian` int NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `kode_pembelian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_pengguna` int NOT NULL,
  `jumlah` int NULL DEFAULT NULL,
  `harga_beli` decimal(10, 2) NULL DEFAULT NULL,
  `id_supplier` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembelian`) USING BTREE,
  INDEX `id_produk`(`id_produk` ASC) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  INDEX `id_supplier`(`id_supplier` ASC) USING BTREE,
  CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_ibfk_3` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
BEGIN;
INSERT INTO `pembelian` (`id_pembelian`, `id_produk`, `tanggal_masuk`, `tanggal_kadaluarsa`, `kode_pembelian`, `id_pengguna`, `jumlah`, `harga_beli`, `id_supplier`) VALUES (16, 3, '2024-09-01', '2024-09-30', 'PBL-001', 1, 5000, 2400.00, 4), (17, 4, '2024-08-11', '2024-09-30', 'PBL-002', 1, 5, 4000.00, 3), (18, 4, '2024-09-01', '2024-09-30', 'PBL-003', 1, 5, 4000.00, 3);
COMMIT;

-- ----------------------------
-- Table structure for pengguna
-- ----------------------------
DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna`  (
  `id_pengguna` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengguna`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of pengguna
-- ----------------------------
BEGIN;
INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `level`, `nama`) VALUES (1, 'admin', '$2y$10$IFurjz8bw3a2t0HlX2rV4.iEsMpop3E0HXz/HIoLUW/LPFI8IlC6.', 'Admin', 'Tono'), (3, 'kasir', '$2y$10$Ddagf9A4tN3Qy.qINH3RdenJOqnIeI.jYo1IseA6WiYpiIIZsPVQm', 'Kasir', 'Kasir'), (4, 'pimpinan', '$2y$10$/KBuun9s13fMm1/EI.yKEeGUGr0K/.jAjeFRodTPUocVQNUl/1.wG', 'Pimpinan', 'Pimpinan');
COMMIT;

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan`  (
  `id_penjualan` int NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `kode_penjualan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  `harga_jual` decimal(10, 2) NOT NULL,
  `id_pengguna` int NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `kategori_obat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`) USING BTREE,
  INDEX `id_produk`(`id_produk` ASC) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
BEGIN;
INSERT INTO `penjualan` (`id_penjualan`, `id_produk`, `kode_penjualan`, `jumlah`, `harga_jual`, `id_pengguna`, `tanggal_penjualan`, `kategori_obat`) VALUES (6, 3, 'INV-001', 10, 5000.00, 1, '2024-09-11', 'Bukan Resep'), (7, 4, 'INV-002', 2, 8000.00, 3, '2024-10-12', 'Bukan Resep');
COMMIT;

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_beli` decimal(10, 2) NOT NULL,
  `harga_jual` decimal(10, 2) NOT NULL,
  `kode_produk` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of produk
-- ----------------------------
BEGIN;
INSERT INTO `produk` (`id_produk`, `nama_produk`, `deskripsi`, `harga_beli`, `harga_jual`, `kode_produk`, `satuan`, `foto`) VALUES (3, 'Ultraflu', 'Obat Pilek', 4000.00, 5000.00, 'PRD-001', 'Botolan', NULL), (4, 'Paramex', 'Obat', 4000.00, 8000.00, 'PRD-002', 'Kapsul', NULL), (5, 'Medika', 'Obat Demam', 15000.00, 20000.00, 'PRD-003', 'Botolan', NULL), (6, 'sdasd', 'asdasda', 2400.00, 5000.00, 'PRD-004', 'Botolan', 'assets/images/product/logo-sm.png'), (7, 'Ultraflu AA', 'sadasdasdsada', 2400.00, 4000.00, 'PRD-005', 'PCS', 'assets/images/product/kendal.png');
COMMIT;

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id_supplier` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kontak_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of supplier
-- ----------------------------
BEGIN;
INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `kontak_supplier`, `alamat`) VALUES (3, 'Kimia Farma', '089898322', NULL), (4, 'Umbrella Corp', '0823823232', 'Jakarta'), (6, 'Blob', '91211313', 'Desa');
COMMIT;

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` decimal(10, 2) NOT NULL,
  `id_akun_debit` int NOT NULL,
  `id_akun_kredit` int NOT NULL,
  `tanggal_transaksi` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`) USING BTREE,
  INDEX `id_akun_debit`(`id_akun_debit` ASC) USING BTREE,
  INDEX `id_akun_kredit`(`id_akun_kredit` ASC) USING BTREE,
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_akun_debit`) REFERENCES `akun` (`id_akun`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_akun_kredit`) REFERENCES `akun` (`id_akun`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
BEGIN;
INSERT INTO `transaksi` (`id_transaksi`, `deskripsi`, `kode_transaksi`, `total`, `id_akun_debit`, `id_akun_kredit`, `tanggal_transaksi`) VALUES (19, 'PembelianPBL-001', 'PBL-001', 12000000.00, 2, 1, '2024-09-01'), (20, 'PembelianPBL-002', 'PBL-002', 20000.00, 2, 1, '2024-08-11'), (21, 'PembelianPBL-003', 'PBL-003', 20000.00, 2, 1, '2024-09-01'), (27, 'Modal Awal', 'JRNL5279', 60000000.00, 1, 6, '2024-08-01'), (28, 'PenjualanINV-001', 'INV-001', 50000.00, 5, 2, '2024-09-11'), (29, 'PenjualanINV-001', 'INV-001', 40000.00, 1, 7, '2024-09-11'), (31, 'PenjualanINV-002', 'INV-002', 16000.00, 5, 2, '2024-10-12'), (32, 'PenjualanINV-002', 'INV-002', 8000.00, 1, 7, '2024-10-12');
COMMIT;

-- ----------------------------
-- View structure for jurnal
-- ----------------------------
DROP VIEW IF EXISTS `jurnal`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `jurnal` AS select `t`.`tanggal_transaksi` AS `tanggal_transaksi`,`t`.`deskripsi` AS `deskripsi`,`t`.`kode_transaksi` AS `kode_transaksi`,`a1`.`nama_akun` AS `nama_akun`,`a1`.`jenis_akun` AS `jenis_akun`,`t`.`id_transaksi` AS `id_transaksi`,(case when (`t`.`id_akun_debit` = `a1`.`id_akun`) then `t`.`total` else 0 end) AS `debit`,(case when (`t`.`id_akun_kredit` = `a1`.`id_akun`) then `t`.`total` else 0 end) AS `kredit` from (`transaksi` `t` join `akun` `a1` on(((`t`.`id_akun_debit` = `a1`.`id_akun`) or (`t`.`id_akun_kredit` = `a1`.`id_akun`)))) order by `t`.`tanggal_transaksi`;

-- ----------------------------
-- View structure for v_inventory
-- ----------------------------
DROP VIEW IF EXISTS `v_inventory`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_inventory` AS select `inventory`.`id_inventory` AS `id_inventory`,`inventory`.`id_produk` AS `id_produk`,`inventory`.`tanggal_masuk` AS `tanggal_masuk`,`inventory`.`tanggal_kadaluarsa` AS `tanggal_kadaluarsa`,`inventory`.`harga_beli` AS `harga_beli`,`inventory`.`jumlah` AS `jumlah`,`inventory`.`kode_pembelian` AS `kode_pembelian`,`produk`.`nama_produk` AS `nama_produk`,`produk`.`kode_produk` AS `kode_produk` from (`inventory` join `produk` on((`inventory`.`id_produk` = `produk`.`id_produk`)));

-- ----------------------------
-- View structure for v_pembelian
-- ----------------------------
DROP VIEW IF EXISTS `v_pembelian`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_pembelian` AS select `pembelian`.`id_pembelian` AS `id_pembelian`,`pembelian`.`id_produk` AS `id_produk`,`pembelian`.`tanggal_masuk` AS `tanggal_masuk`,`pembelian`.`tanggal_kadaluarsa` AS `tanggal_kadaluarsa`,`pembelian`.`kode_pembelian` AS `kode_pembelian`,`pembelian`.`id_pengguna` AS `id_pengguna`,`pembelian`.`jumlah` AS `jumlah`,`pembelian`.`harga_beli` AS `harga_beli`,`pembelian`.`id_supplier` AS `id_supplier`,`produk`.`nama_produk` AS `nama_produk`,`supplier`.`nama_supplier` AS `nama_supplier`,`produk`.`kode_produk` AS `kode_produk`,`produk`.`satuan` AS `satuan` from ((`pembelian` join `produk` on((`pembelian`.`id_produk` = `produk`.`id_produk`))) join `supplier` on((`pembelian`.`id_supplier` = `supplier`.`id_supplier`)));

-- ----------------------------
-- View structure for v_penjualan
-- ----------------------------
DROP VIEW IF EXISTS `v_penjualan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_penjualan` AS select `penjualan`.`id_penjualan` AS `id_penjualan`,`penjualan`.`id_produk` AS `id_produk`,`penjualan`.`kode_penjualan` AS `kode_penjualan`,`penjualan`.`jumlah` AS `jumlah`,`penjualan`.`harga_jual` AS `harga_jual`,`penjualan`.`id_pengguna` AS `id_pengguna`,`penjualan`.`tanggal_penjualan` AS `tanggal_penjualan`,`penjualan`.`kategori_obat` AS `kategori_obat`,`produk`.`nama_produk` AS `nama_produk`,`produk`.`kode_produk` AS `kode_produk`,`produk`.`satuan` AS `satuan` from (`penjualan` join `produk` on((`penjualan`.`id_produk` = `produk`.`id_produk`)));

-- ----------------------------
-- View structure for v_supplier
-- ----------------------------
DROP VIEW IF EXISTS `v_supplier`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_supplier` AS select `pembelian`.`id_pembelian` AS `id_pembelian`,`pembelian`.`id_produk` AS `id_produk`,`pembelian`.`tanggal_masuk` AS `tanggal_masuk`,`pembelian`.`tanggal_kadaluarsa` AS `tanggal_kadaluarsa`,`pembelian`.`kode_pembelian` AS `kode_pembelian`,`pembelian`.`id_pengguna` AS `id_pengguna`,`pembelian`.`jumlah` AS `jumlah`,`pembelian`.`harga_beli` AS `harga_beli`,`pembelian`.`id_supplier` AS `id_supplier`,`supplier`.`nama_supplier` AS `nama_supplier`,`produk`.`nama_produk` AS `nama_produk`,`produk`.`kode_produk` AS `kode_produk` from ((`supplier` join `pembelian` on((`supplier`.`id_supplier` = `pembelian`.`id_supplier`))) join `produk` on((`pembelian`.`id_produk` = `produk`.`id_produk`)));

SET FOREIGN_KEY_CHECKS = 1;
