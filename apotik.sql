/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : 127.0.0.1:3306
 Source Schema         : apotik_baru

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 29/10/2024 11:34:47
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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of akun
-- ----------------------------
INSERT INTO `akun` VALUES (1, 'Kas', 'Aktiva Lancar', 1, '10001');
INSERT INTO `akun` VALUES (2, 'Persediaan Obat', 'Aktiva Tetap', 1, '10002');
INSERT INTO `akun` VALUES (5, 'HPP', 'Beban', 1, '20001');
INSERT INTO `akun` VALUES (7, 'Penjualan Obat', 'Pendapatan', 1, '30001');
INSERT INTO `akun` VALUES (8, 'Modal', 'Modal', 1, '40001');
INSERT INTO `akun` VALUES (9, 'Gaji Karyawan', 'Beban', 1, '20002');
INSERT INTO `akun` VALUES (10, 'Biaya Listrik', 'Beban', NULL, '50001');

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
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inventory
-- ----------------------------
INSERT INTO `inventory` VALUES (6, 3, '2024-09-01', '2024-09-30', 2400.00, 4980, 'PBL-001');
INSERT INTO `inventory` VALUES (11, 9, '2024-10-02', '2027-10-01', 45000.00, 19, 'PBL-003');
INSERT INTO `inventory` VALUES (12, 18, '2024-09-06', '2025-03-27', 8500.00, 11, 'PBL-004');
INSERT INTO `inventory` VALUES (14, 19, '2024-10-07', '2026-12-30', 5000.00, 17, 'PBL-005');
INSERT INTO `inventory` VALUES (17, 8, '2024-10-01', '2025-10-31', 3000.00, 27, 'PBL-007');
INSERT INTO `inventory` VALUES (19, 8, '2024-10-20', '2024-10-23', 3000.00, 7, 'PBL-009');

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
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES (16, 3, '2024-09-01', '2024-09-30', 'PBL-001', 1, 5000, 2400.00, 4);
INSERT INTO `pembelian` VALUES (17, 4, '2024-08-11', '2024-09-30', 'PBL-002', 1, 5, 4000.00, 3);
INSERT INTO `pembelian` VALUES (21, 9, '2024-10-02', '2027-10-01', 'PBL-003', 1, 20, 45000.00, 9);
INSERT INTO `pembelian` VALUES (22, 18, '2024-09-06', '2025-03-27', 'PBL-004', 1, 15, 8500.00, 8);
INSERT INTO `pembelian` VALUES (24, 19, '2024-10-07', '2026-12-30', 'PBL-005', 1, 20, 5000.00, 3);
INSERT INTO `pembelian` VALUES (25, 4, '2024-10-03', '2025-12-25', 'PBL-006', 1, 10, 4000.00, 3);
INSERT INTO `pembelian` VALUES (27, 8, '2024-10-01', '2025-10-31', 'PBL-007', 1, 25, 3000.00, 4);
INSERT INTO `pembelian` VALUES (28, 15, '2024-10-22', '2025-03-15', 'PBL-008', 1, 15, 15000.00, 8);
INSERT INTO `pembelian` VALUES (29, 8, '2024-10-20', '2024-10-23', 'PBL-009', 1, 7, 3000.00, 4);

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengguna
-- ----------------------------
INSERT INTO `pengguna` VALUES (1, 'admin', '$2y$10$IFurjz8bw3a2t0HlX2rV4.iEsMpop3E0HXz/HIoLUW/LPFI8IlC6.', 'Admin', 'Tono');
INSERT INTO `pengguna` VALUES (3, 'kasir', '$2y$10$Ddagf9A4tN3Qy.qINH3RdenJOqnIeI.jYo1IseA6WiYpiIIZsPVQm', 'Kasir', 'Kasir');
INSERT INTO `pengguna` VALUES (4, 'pimpinan', '$2y$10$/KBuun9s13fMm1/EI.yKEeGUGr0K/.jAjeFRodTPUocVQNUl/1.wG', 'Pimpinan', 'Pimpinan');

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
  `kode_pembelian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`) USING BTREE,
  INDEX `id_produk`(`id_produk` ASC) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
INSERT INTO `penjualan` VALUES (6, 3, 'INV-001', 10, 5000.00, 1, '2024-09-11', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (19, 8, 'INV-002', 3, 3500.00, 3, '2024-10-17', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (20, 4, 'INV-003', 2, 4000.00, 3, '2024-10-05', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (21, 8, 'INV-004', 4, 3500.00, 3, '2024-10-17', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (22, 18, 'INV-005', 4, 9500.00, 3, '2024-10-10', 'Resep Dokter', NULL);
INSERT INTO `penjualan` VALUES (23, 9, 'INV-006', 1, 49500.00, 3, '2024-10-10', 'Resep Dokter', NULL);
INSERT INTO `penjualan` VALUES (24, 9, 'INV-007', 5, 49500.00, 3, '2024-10-11', 'Resep Dokter', NULL);
INSERT INTO `penjualan` VALUES (25, 19, 'INV-008', 3, 5500.00, 3, '2024-10-12', 'Resep Dokter', NULL);
INSERT INTO `penjualan` VALUES (26, 3, 'INV-009', 5, 25000.00, 3, '2024-10-22', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (27, 3, 'INV-009', 5, 25000.00, 3, '2024-10-22', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (28, 4, 'INV-009', 5, 15000.00, 3, '2024-10-22', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (29, 15, 'INV-010', 15, 24750.00, 3, '2024-10-24', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (30, 4, 'INV-011', 3, 9000.00, 3, '2024-10-24', 'Resep Dokter', NULL);
INSERT INTO `penjualan` VALUES (31, 15, 'INV-012', 2, 24750.00, 3, '2024-10-24', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (32, 4, 'INV-013', 2, 6000.00, 3, '2024-10-24', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (33, 15, 'INV-014', 2, 15000.00, 3, '2024-10-25', 'Bukan Resep', NULL);
INSERT INTO `penjualan` VALUES (34, 8, 'INV-015', 1, 3500.00, 3, '2024-10-29', 'Bukan Resep', 'PBL-007');

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
  `golongan_obat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (3, 'Ultraflu', 'Obat Flu', 2500.00, 3000.00, 'PRD-001', 'Strip', 'assets/images/product/ultraflu.jfif', NULL);
INSERT INTO `produk` VALUES (4, 'Paramex', 'Obat Sakit Kepala', 250000.00, 300000.00, 'PRD-002', 'Kapsul', 'assets/images/product/paramex.webp', 'Obat Luar');
INSERT INTO `produk` VALUES (8, 'Oskadon', 'Obat Sakit Kepala', 3000.00, 3500.00, 'PRD-006', 'Strip', 'assets/images/product/oskadon.jpg', NULL);
INSERT INTO `produk` VALUES (9, 'Apialys syrup 100ml', 'Obat Multivitamin', 45000.00, 49500.00, 'PRD-007', 'Botolan', 'assets/images/product/Apialys Syrup.jfif', NULL);
INSERT INTO `produk` VALUES (11, 'Curcuma Plus Syrup 60ml', 'Obat Multivitamin', 15000.00, 16500.00, 'PRD-008', 'Botolan', 'assets/images/product/curcuma plus syrup.jfif', NULL);
INSERT INTO `produk` VALUES (12, 'Hufagrip Flu Syrup 60ml', 'Obat Flu dan Batuk', 22000.00, 24200.00, 'PRD-009', 'Botol', 'assets/images/product/hufagripp.jfif', NULL);
INSERT INTO `produk` VALUES (13, 'Mylanta Syrup 50ml', 'Obat Maag (Antasida)', 16000.00, 17600.00, 'PRD-010', 'Botol', 'assets/images/product/mylanta.jpg', NULL);
INSERT INTO `produk` VALUES (14, 'Siladex Antitussive Syrup 100ml', 'Obat Batuk Tidak Berdahak', 15500.00, 17050.00, 'PRD-011', 'Botol', 'assets/images/product/syladex.jpeg', NULL);
INSERT INTO `produk` VALUES (15, 'OBH Combi Syrup 100ml (Rasa Menthol)', 'Obat Flu dan Batuk', 22500.00, 24750.00, 'PRD-012', 'Botol', 'assets/images/product/obh combi plus.png', NULL);
INSERT INTO `produk` VALUES (16, 'Hydrocortison Cream Biru 15gr', 'Obat Ruam', 5000.00, 5500.00, 'PRD-013', 'Tube', 'assets/images/product/hydrocortison.jpg', NULL);
INSERT INTO `produk` VALUES (17, 'Peditox Hexachorocyclohexane', 'Obat Kutu Rambut', 10000.00, 11000.00, 'PRD-014', 'Botol', 'assets/images/product/peditox.png', NULL);
INSERT INTO `produk` VALUES (18, 'Ketoconazole Cream 10gr', 'Obat Antijamur', 8500.00, 9350.00, 'PRD-015', 'Tube', 'assets/images/product/ketoconazole-krim-1.jpg', NULL);
INSERT INTO `produk` VALUES (19, 'Acyclovir Cream 5gr', 'Obat Herpes Simplex', 5000.00, 5500.00, 'PRD-016', 'Tube', 'assets/images/product/Aciclovir_1.png', NULL);
INSERT INTO `produk` VALUES (20, 'Salep 88 6gr', 'Obat Ruam dan Gatal', 12000.00, 13200.00, 'PRD-017', 'Pot', 'assets/images/product/SALEP 88.jpeg', NULL);
INSERT INTO `produk` VALUES (21, 'Bodrex Tablet', 'Obat Sakit Kepala', 10000.00, 11000.00, 'PRD-018', 'Dus', 'assets/images/product/Bodrex-Tablet-600x600.jpg', NULL);
INSERT INTO `produk` VALUES (23, 'Promag', 'Obat Mag', 2500.00, 2750.00, 'PRD-019', 'Strip', 'assets/images/product/mylanta.jpg', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (3, 'Kimia Farma', '089898322123', 'Jl. Siliwangi No. 53 Semarang');
INSERT INTO `supplier` VALUES (4, 'Phapros Tbk', '082382323256', 'Jl. Pahlawan No. 79 Jakarta Selatan');
INSERT INTO `supplier` VALUES (6, 'Marin Liza Farmasi', '082543786910', 'Jl Pekayon No 211 Kota Bekasi, Jawa Barat');
INSERT INTO `supplier` VALUES (7, 'Hani Bina Sukses', '083816805883', 'Jl Sultan Agung No. 86 Candisari, Semarang');
INSERT INTO `supplier` VALUES (8, 'Tri Sapta Jaya', '083441424545', 'JL Citarum No. 153 Karawang, Jawa Barat');
INSERT INTO `supplier` VALUES (9, 'Indo Farma', '082242622221', 'Jl Alamanda Atas, Tembalang, Semarang');

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
) ENGINE = InnoDB AUTO_INCREMENT = 103 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (68, 'Modal Awal Apotek Graha Medika', 'JRNL7808', 20000000.00, 1, 8, '2024-08-01');
INSERT INTO `transaksi` VALUES (69, 'Pembelian obat masuk-PBL 002\r\n', 'JRNL2954', 20000.00, 2, 1, '2024-08-11');
INSERT INTO `transaksi` VALUES (70, 'Beban gaji karyawan bulan Agustus', 'JRNL3477', 800000.00, 9, 1, '2024-08-28');
INSERT INTO `transaksi` VALUES (71, 'Pembelian obat masuk-PBL 001', 'JRNL3077', 12500000.00, 2, 1, '2024-09-01');
INSERT INTO `transaksi` VALUES (72, 'Pembelian obat masuk-PBL 003', 'JRNL4348', 127500.00, 2, 1, '2024-09-06');
INSERT INTO `transaksi` VALUES (73, 'Penjualan obat keluar-INV 001', 'JRNL7541', 50000.00, 1, 7, '2024-09-11');
INSERT INTO `transaksi` VALUES (74, 'Pembelian obat masuk-PBL 007', 'JRNL4921', 75000.00, 2, 1, '2024-10-01');
INSERT INTO `transaksi` VALUES (75, 'Pembelian obat masuk-PBL 004', 'JRNL3289', 900000.00, 2, 1, '2024-10-02');
INSERT INTO `transaksi` VALUES (76, 'Pembelian obat masuk-PBL 006', 'JRNL5268', 40000.00, 2, 1, '2024-10-03');
INSERT INTO `transaksi` VALUES (77, 'Penjualan obat keluar-INV 003', 'JRNL2072', 8000.00, 1, 7, '2024-10-05');
INSERT INTO `transaksi` VALUES (78, 'Pembelian obat masuk-PBL 005', 'JRNL6523', 100000.00, 2, 1, '2024-10-07');
INSERT INTO `transaksi` VALUES (79, 'Penjualan obat keluar-INV 005', 'JRNL4899', 38000.00, 1, 7, '2024-10-10');
INSERT INTO `transaksi` VALUES (80, 'Penjualan obat keluar-INV 006', 'JRNL7767', 49500.00, 1, 7, '2024-10-10');
INSERT INTO `transaksi` VALUES (81, 'Penjualan obat keluar-INV 007', 'JRNL9630', 247500.00, 1, 7, '2024-10-11');
INSERT INTO `transaksi` VALUES (82, 'Penjualan obat keluar-INV 008', 'JRNL8218', 16500.00, 1, 7, '2024-10-12');
INSERT INTO `transaksi` VALUES (83, 'Penjualan obat keluar-INV 002', 'JRNL8973', 10500.00, 1, 7, '2024-10-17');
INSERT INTO `transaksi` VALUES (84, 'Penjualan obat keluar-INV 004', 'JRNL4967', 14000.00, 1, 7, '2024-10-17');
INSERT INTO `transaksi` VALUES (85, 'PenjualanINV-009', 'INV-009', 125000.00, 5, 2, '2024-10-22');
INSERT INTO `transaksi` VALUES (86, 'PenjualanINV-009', 'INV-009', 125000.00, 5, 2, '2024-10-22');
INSERT INTO `transaksi` VALUES (87, 'PenjualanINV-009', 'INV-009', 75000.00, 5, 2, '2024-10-22');
INSERT INTO `transaksi` VALUES (88, 'PenjualanINV-009', 'INV-009', 12500.00, 1, 7, '2024-10-22');
INSERT INTO `transaksi` VALUES (89, 'PembelianPBL-008', 'PBL-008', 225000.00, 2, 1, '2024-10-22');
INSERT INTO `transaksi` VALUES (90, 'PenjualanINV-010', 'INV-010', 371250.00, 5, 2, '2024-10-24');
INSERT INTO `transaksi` VALUES (91, 'PenjualanINV-010', 'INV-010', 337500.00, 1, 7, '2024-10-24');
INSERT INTO `transaksi` VALUES (92, 'PenjualanINV-011', 'INV-011', 27000.00, 5, 2, '2024-10-24');
INSERT INTO `transaksi` VALUES (93, 'PenjualanINV-011', 'INV-011', 7500.00, 1, 7, '2024-10-24');
INSERT INTO `transaksi` VALUES (94, 'PenjualanINV-012', 'INV-012', 49500.00, 5, 2, '2024-10-24');
INSERT INTO `transaksi` VALUES (95, 'PenjualanINV-012', 'INV-012', 45000.00, 1, 7, '2024-10-24');
INSERT INTO `transaksi` VALUES (96, 'PembelianPBL-009', 'PBL-009', 21000.00, 2, 1, '2024-10-20');
INSERT INTO `transaksi` VALUES (97, 'PenjualanINV-013', 'INV-013', 12000.00, 5, 2, '2024-10-24');
INSERT INTO `transaksi` VALUES (98, 'PenjualanINV-013', 'INV-013', 5000.00, 1, 7, '2024-10-24');
INSERT INTO `transaksi` VALUES (99, 'PenjualanINV-014', 'INV-014', 30000.00, 5, 2, '2024-10-25');
INSERT INTO `transaksi` VALUES (100, 'PenjualanINV-014', 'INV-014', 45000.00, 1, 7, '2024-10-25');
INSERT INTO `transaksi` VALUES (101, 'PenjualanINV-015', 'INV-015', 3500.00, 5, 2, '2024-10-29');
INSERT INTO `transaksi` VALUES (102, 'PenjualanINV-015', 'INV-015', 3000.00, 1, 7, '2024-10-29');

-- ----------------------------
-- View structure for jurnal
-- ----------------------------
DROP VIEW IF EXISTS `jurnal`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `jurnal` AS select `t`.`tanggal_transaksi` AS `tanggal_transaksi`,`t`.`deskripsi` AS `deskripsi`,`t`.`kode_transaksi` AS `kode_transaksi`,`a1`.`nama_akun` AS `nama_akun`,`a1`.`jenis_akun` AS `jenis_akun`,`t`.`id_transaksi` AS `id_transaksi`,(case when (`t`.`id_akun_debit` = `a1`.`id_akun`) then `t`.`total` else 0 end) AS `debit`,(case when (`t`.`id_akun_kredit` = `a1`.`id_akun`) then `t`.`total` else 0 end) AS `kredit` from (`transaksi` `t` join `akun` `a1` on(((`t`.`id_akun_debit` = `a1`.`id_akun`) or (`t`.`id_akun_kredit` = `a1`.`id_akun`)))) order by `t`.`tanggal_transaksi`;

-- ----------------------------
-- View structure for v_inventory
-- ----------------------------
DROP VIEW IF EXISTS `v_inventory`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_inventory` AS select `inventory`.`id_inventory` AS `id_inventory`,`inventory`.`id_produk` AS `id_produk`,`inventory`.`tanggal_masuk` AS `tanggal_masuk`,`inventory`.`tanggal_kadaluarsa` AS `tanggal_kadaluarsa`,`inventory`.`harga_beli` AS `harga_beli`,`inventory`.`jumlah` AS `jumlah`,`inventory`.`kode_pembelian` AS `kode_pembelian`,`produk`.`nama_produk` AS `nama_produk`,`produk`.`kode_produk` AS `kode_produk`,`produk`.`harga_jual` AS `harga_jual` from (`inventory` join `produk` on((`inventory`.`id_produk` = `produk`.`id_produk`)));

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
