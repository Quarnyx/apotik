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

 Date: 14/11/2024 17:08:14
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
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of akun
-- ----------------------------
BEGIN;
INSERT INTO `akun` (`id_akun`, `nama_akun`, `jenis_akun`, `wajib`, `kode_akun`) VALUES (1, 'Kas', 'Aktiva Lancar', 1, '101'), (2, 'Persediaan Obat', 'Aktiva Lancar', 1, '102'), (5, 'Perlengkapan', 'Aktiva Lancar', 1, '106'), (7, 'Sewa Dibayar Dimuka', 'Aktiva Lancar', 1, '108'), (8, 'Utang Usaha', 'Kewajiban', 1, '201'), (9, 'Modal Pemilik ', 'Modal', 1, '301'), (10, 'Pendapatan Usaha', 'Pendapatan', 1, '401'), (11, 'Gaji Karyawan', 'Beban', 1, '501'), (12, 'Sewa Tempat', 'Beban', 1, '502'), (13, 'Listrik', 'Beban', 1, '503');
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
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of inventory
-- ----------------------------
BEGIN;
INSERT INTO `inventory` (`id_inventory`, `id_produk`, `tanggal_masuk`, `tanggal_kadaluarsa`, `harga_beli`, `jumlah`, `kode_pembelian`) VALUES (21, 25, '2024-09-01', '2026-09-05', 45000.00, 3, 'PBL-001'), (22, 26, '2024-09-01', '2026-09-01', 15000.00, 2, 'PBL-002'), (25, 33, '2024-09-01', '2026-09-02', 21500.00, 3, 'PBL-005'), (26, 35, '2024-09-02', '2026-10-02', 5000.00, 2, 'PBL-006'), (27, 36, '2024-09-02', '2026-10-02', 8500.00, 4, 'PBL-007'), (29, 38, '2024-09-02', '2026-10-03', 15000.00, 3, 'PBL-009'), (31, 40, '2024-09-03', '2026-09-03', 12000.00, 5, 'PBL-011'), (35, 44, '2024-09-03', '2025-09-15', 20000.00, 5, 'PBL-015'), (46, 27, '2024-09-05', '2026-09-07', 21500.00, 5, 'PBL-016'), (48, 30, '2024-10-01', '2027-10-05', 22500.00, 3, 'PBL-018'), (49, 37, '2024-10-01', '2027-10-20', 18000.00, 5, 'PBL-019'), (50, 39, '2024-10-01', '2027-10-25', 5000.00, 4, 'PBL-020'), (51, 41, '2024-10-01', '2027-12-15', 10000.00, 5, 'PBL-021'), (52, 42, '2024-10-01', '2027-10-18', 15000.00, 4, 'PBL-022'), (53, 43, '2024-10-01', '2026-10-20', 2500.00, 4, 'PBL-023'), (54, 44, '2024-10-01', '2026-12-23', 21500.00, 5, 'PBL-024'), (55, 28, '2024-10-01', '2027-12-15', 15000.00, 50, 'PBL-025'), (56, 27, '2024-11-11', '2024-11-30', 21500.00, 1, 'PBL-028');
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
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
BEGIN;
INSERT INTO `pembelian` (`id_pembelian`, `id_produk`, `tanggal_masuk`, `tanggal_kadaluarsa`, `kode_pembelian`, `id_pengguna`, `jumlah`, `harga_beli`, `id_supplier`) VALUES (31, 25, '2024-09-01', '2026-09-05', 'PBL-001', 1, 5, 45000.00, 11), (32, 26, '2024-09-01', '2026-09-01', 'PBL-002', 1, 3, 15000.00, 11), (33, 27, '2024-09-01', '2026-09-02', 'PBL-003', 1, 4, 22000.00, 11), (35, 33, '2024-09-01', '2026-09-02', 'PBL-005', 1, 7, 21500.00, 11), (36, 35, '2024-09-02', '2026-10-02', 'PBL-006', 1, 5, 5000.00, 12), (37, 36, '2024-09-02', '2026-10-02', 'PBL-007', 1, 6, 8500.00, 12), (38, 37, '2024-09-02', '2026-10-02', 'PBL-008', 1, 4, 18000.00, 12), (39, 38, '2024-09-02', '2026-10-03', 'PBL-009', 1, 10, 15000.00, 12), (40, 39, '2024-09-02', '2026-10-06', 'PBL-010', 1, 7, 5000.00, 12), (41, 40, '2024-09-03', '2026-09-03', 'PBL-011', 1, 12, 12000.00, 13), (42, 41, '2024-09-03', '2026-09-03', 'PBL-012', 1, 2, 10000.00, 14), (43, 42, '2024-09-02', '2025-09-30', 'PBL-013', 1, 3, 15000.00, 14), (44, 43, '2024-09-03', '2025-09-20', 'PBL-014', 1, 4, 2500.00, 15), (45, 44, '2024-09-03', '2025-09-15', 'PBL-015', 1, 7, 20000.00, 15), (56, 27, '2024-09-05', '2026-09-07', 'PBL-016', 1, 6, 21500.00, 11), (58, 30, '2024-10-01', '2027-10-05', 'PBL-018', 1, 5, 22500.00, 11), (59, 37, '2024-10-01', '2027-10-20', 'PBL-019', 1, 6, 18000.00, 12), (60, 39, '2024-10-01', '2027-10-25', 'PBL-020', 1, 5, 5000.00, 12), (61, 41, '2024-10-01', '2027-12-15', 'PBL-021', 1, 13, 10000.00, 14), (62, 42, '2024-10-01', '2027-10-18', 'PBL-022', 1, 7, 15000.00, 14), (63, 43, '2024-10-01', '2026-10-20', 'PBL-023', 1, 6, 2500.00, 15), (64, 44, '2024-10-01', '2026-12-23', 'PBL-024', 1, 5, 21500.00, 15), (65, 28, '2024-10-01', '2027-12-15', 'PBL-025', 1, 7, 15000.00, 11), (66, 28, '2024-09-03', '2024-11-30', 'PBL-026', 1, 100, 15000.00, 11), (67, 29, '2024-11-04', '2025-10-13', 'PBL-027', 1, 5, 15500.00, 11), (68, 27, '2024-11-11', '2024-11-30', 'PBL-028', 1, 1, 21500.00, 11);
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
  `kode_pembelian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`) USING BTREE,
  INDEX `id_produk`(`id_produk` ASC) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 96 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
BEGIN;
INSERT INTO `penjualan` (`id_penjualan`, `id_produk`, `kode_penjualan`, `jumlah`, `harga_jual`, `id_pengguna`, `tanggal_penjualan`, `kategori_obat`, `kode_pembelian`) VALUES (35, 37, 'INV-001', 1, 19800.00, 3, '2024-09-05', 'Resep Dokter', 'PBL-008'), (36, 39, 'INV-002', 2, 5500.00, 3, '2024-09-05', 'Resep Dokter', 'PBL-010'), (37, 41, 'INV-003', 2, 11000.00, 3, '2024-09-05', 'Bukan Resep', 'PBL-012'), (38, 41, 'INV-003', 1, 11000.00, 3, '2024-09-05', 'Bukan Resep', 'PBL-021'), (39, 42, 'INV-004', 2, 16500.00, 3, '2024-09-05', 'Bukan Resep', 'PBL-013'), (40, 43, 'INV-005', 1, 2750.00, 3, '2024-09-05', 'Bukan Resep', 'PBL-014'), (41, 44, 'INV-006', 2, 23650.00, 3, '2024-09-05', 'Bukan Resep', 'PBL-015'), (42, 25, 'INV-007', 1, 49500.00, 3, '2024-09-06', 'Bukan Resep', 'PBL-001'), (43, 33, 'INV-008', 2, 23650.00, 3, '2024-09-06', 'Bukan Resep', 'PBL-005'), (44, 35, 'INV-009', 1, 5500.00, 3, '2024-09-06', 'Resep Dokter', 'PBL-006'), (45, 36, 'INV-010', 1, 9350.00, 3, '2024-09-06', 'Resep Dokter', 'PBL-007'), (46, 38, 'INV-011', 1, 16500.00, 3, '2024-10-07', 'Bukan Resep', 'PBL-009'), (49, 40, 'INV-012', 2, 13200.00, 3, '2024-09-07', 'Bukan Resep', 'PBL-011'), (50, 27, 'INV-013', 2, 23650.00, 3, '2024-09-07', 'Bukan Resep', 'PBL-003'), (53, 37, 'INV-015', 1, 19800.00, 3, '2024-09-10', 'Bukan Resep', 'PBL-008'), (54, 39, 'INV-016', 1, 5500.00, 3, '2024-09-11', 'Resep Dokter', 'PBL-010'), (55, 41, 'INV-017', 2, 11000.00, 3, '2024-09-12', 'Bukan Resep', 'PBL-021'), (56, 42, 'INV-018', 1, 16500.00, 3, '2024-09-13', 'Bukan Resep', 'PBL-013'), (59, 27, 'INV-020', 2, 23650.00, 3, '2024-09-13', 'Bukan Resep', 'PBL-003'), (61, 28, 'INV-021', 1, 16500.00, 3, '2024-09-13', 'Bukan Resep', 'PBL-025'), (62, 28, 'INV-022', 2, 16500.00, 3, '2024-09-14', 'Bukan Resep', 'PBL-025'), (69, 28, 'INV-023', 25, 16500.00, 3, '2024-10-07', 'Bukan Resep', 'PBL-025'), (70, 42, 'INV-024', 2, 16500.00, 3, '2024-10-08', 'Bukan Resep', 'PBL-022'), (71, 38, 'INV-025', 3, 16500.00, 3, '2024-10-11', 'Bukan Resep', 'PBL-009'), (72, 39, 'INV-026', 1, 5500.00, 3, '2024-10-12', 'Resep Dokter', 'PBL-010'), (73, 40, 'INV-027', 2, 13200.00, 3, '2024-10-13', 'Bukan Resep', 'PBL-011'), (74, 43, 'INV-028', 2, 2750.00, 3, '2024-10-15', 'Bukan Resep', 'PBL-014'), (75, 28, 'INV-029', 10, 16500.00, 3, '2024-10-18', 'Bukan Resep', 'PBL-025'), (76, 42, 'INV-030', 1, 16500.00, 3, '2024-10-22', 'Bukan Resep', 'PBL-022'), (77, 37, 'INV-031', 2, 19800.00, 3, '2024-10-25', 'Resep Dokter', 'PBL-008'), (78, 38, 'INV-032', 1, 16500.00, 3, '2024-10-27', 'Bukan Resep', 'PBL-009'), (79, 39, 'INV-033', 3, 5500.00, 3, '2024-10-29', 'Resep Dokter', 'PBL-010'), (80, 25, 'INV-034', 2, 49500.00, 3, '2024-11-01', 'Bukan Resep', 'PBL-001'), (81, 26, 'INV-035', 1, 16500.00, 3, '2024-11-01', 'Bukan Resep', 'PBL-002'), (82, 28, 'INV-036', 9, 16500.00, 3, '2024-11-01', 'Bukan Resep', 'PBL-025'), (83, 30, 'INV-037', 2, 24750.00, 3, '2024-11-02', 'Bukan Resep', 'PBL-018'), (84, 33, 'INV-038', 2, 23650.00, 3, '2024-11-02', 'Bukan Resep', 'PBL-005'), (85, 35, 'INV-039', 1, 5500.00, 3, '2024-11-02', 'Resep Dokter', 'PBL-006'), (86, 36, 'INV-040', 1, 9350.00, 3, '2024-11-02', 'Resep Dokter', 'PBL-007'), (87, 37, 'INV-041', 1, 19800.00, 3, '2024-11-02', 'Resep Dokter', 'PBL-019'), (88, 38, 'INV-042', 2, 16500.00, 3, '2024-11-03', 'Bukan Resep', 'PBL-009'), (89, 39, 'INV-043', 1, 5500.00, 3, '2024-11-03', 'Resep Dokter', 'PBL-020'), (90, 40, 'INV-044', 3, 13200.00, 3, '2024-11-03', 'Bukan Resep', 'PBL-011'), (91, 41, 'INV-045', 4, 11000.00, 3, '2024-11-03', 'Bukan Resep', 'PBL-021'), (92, 43, 'INV-046', 1, 2750.00, 3, '2024-11-03', 'Bukan Resep', 'PBL-014'), (93, 43, 'INV-046', 2, 2750.00, 3, '2024-11-03', 'Bukan Resep', 'PBL-023'), (94, 29, 'INV-047', 5, 17050.00, 3, '2024-11-04', 'Bukan Resep', 'PBL-027'), (95, 27, 'INV-048', 1, 23650.00, 3, '2024-11-12', 'Resep Dokter', 'PBL-016');
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
  `golongan_obat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of produk
-- ----------------------------
BEGIN;
INSERT INTO `produk` (`id_produk`, `nama_produk`, `deskripsi`, `harga_beli`, `harga_jual`, `kode_produk`, `satuan`, `foto`, `golongan_obat`) VALUES (25, 'Apialys syrup 100ml', 'Obat Multivitamin', 45000.00, 49500.00, 'BOT-001', 'Botolan', 'assets/images/product/Apialys Syrup.jfif', 'Obat Dalam'), (26, 'Curcuma Plus Syrup 60ml', 'Obat Multivitamin', 15000.00, 16500.00, 'BOT-002', 'Botolan', 'assets/images/product/curcuma plus syrup.jfif', 'Obat Dalam'), (27, 'Hufagrip Flu Syrup 60ml', 'Obat Flu', 21500.00, 23650.00, 'BOT-003', 'Botolan', 'assets/images/product/hufagripp.jfif', 'Obat Dalam'), (28, 'Mylanta Syrup 50ml', 'Obat Mag', 15000.00, 16500.00, 'BOT-004', 'Botolan', 'assets/images/product/mylanta.jpg', 'Obat Dalam'), (29, 'Siladex Antitussive Syrup 100ml', 'Obat Batuk Tidak Berdahak', 15500.00, 17050.00, 'BOT-005', 'Botolan', 'assets/images/product/syladex.jpeg', 'Obat Dalam'), (30, 'OBH Combi Syrup 100ml (Rasa Menthol)', 'Obat Batuk dan Flu', 22500.00, 24750.00, 'BOT-006', 'Botolan', 'assets/images/product/obh combi plus.png', 'Pilih Golongan Obat'), (31, 'Anacetine Plus', 'Obat Batuk dan Flu', 11000.00, 12100.00, 'BOT-007', 'Botolan', 'assets/images/product/anacetine.png', 'Obat Dalam'), (32, 'Peditox Hexachorocyclohexane', 'Obat Kutu Rambut', 10000.00, 11000.00, 'BOT-008', 'Botolan', 'assets/images/product/peditox.png', 'Obat Luar'), (33, 'Minyak Kayu Putih Cap Lang 60ml', 'Obat Urut', 21500.00, 23650.00, 'BOT-009', 'Botolan', 'assets/images/product/300352957343e32e07f2b47267ba1dfa.jpg', 'Obat Luar'), (34, 'Sakatonik Activ 100ml', 'Obat Penambah Darah', 12500.00, 13750.00, 'BOT-010', 'Botolan', 'assets/images/product/sakatonik.jpg', 'Obat Dalam'), (35, 'Hydrocortison Cream Biru 15gr', 'Obat Ruam dan Gatal', 5000.00, 5500.00, 'TUB-001', 'Tube', 'assets/images/product/hydrocortison.jpg', 'Obat Luar'), (36, 'Ketoconazole Cream 10gr', 'Obat Infeksi Jamur', 8500.00, 9350.00, 'TUB-002', 'Tube', 'assets/images/product/ketoconazole-krim-1.jpg', 'Obat Luar'), (37, 'Canesten Cream 5gr', 'Obat Infeksi Jamur', 18000.00, 19800.00, 'TUB-003', 'Tube', 'assets/images/product/canesten cream.jpg', 'Obat Luar'), (38, 'Kalpanax Cream 5gr', 'Obat Anti Jamur', 15000.00, 16500.00, 'TUB-004', 'Tube', 'assets/images/product/kalpanax.jfif', 'Obat Luar'), (39, 'Acyclovir Cream 5gr', 'Obat Infeksi Virus Herpes', 5000.00, 5500.00, 'TUB-005', 'Tube', 'assets/images/product/Aciclovir_1.png', 'Obat Luar'), (40, 'Salep 88 6gr', 'Obat Gatal Ruam', 12000.00, 13200.00, 'POT-001', 'Pot', 'assets/images/product/SALEP 88.jpeg', 'Obat Luar'), (41, 'Bodrex', 'Obat Sakit Kepala', 10000.00, 11000.00, 'DUS-001', 'Dus', 'assets/images/product/Bodrex-Tablet-600x600.jpg', 'Obat Dalam'), (42, 'Entrostop Tablet', 'Obat Diare', 15000.00, 16500.00, 'DUS-002', 'Dus', 'assets/images/product/entrostop.jfif', 'Obat Dalam'), (43, 'Decolgen Tablet', 'Obat Flu', 2500.00, 2750.00, 'STR-002', 'Strip', 'assets/images/product/decolgen.jfif', 'Obat Dalam'), (44, 'Sangobion', 'Obat Suplemen Penambah Darah', 21500.00, 23650.00, 'STR-001', 'Strip', 'assets/images/product/Sangobion.jpg', 'Obat Dalam'), (45, 'Hufagrip Flu Syrup 60ml', 'Obat Flu dan Batuk', 22000.00, 24200.00, 'BOT-011', 'Botolan', 'assets/images/product/hufagripp.jfif', 'Obat Dalam');
COMMIT;

-- ----------------------------
-- Table structure for return_pembelian
-- ----------------------------
DROP TABLE IF EXISTS `return_pembelian`;
CREATE TABLE `return_pembelian`  (
  `id_return_pembelian` int NOT NULL AUTO_INCREMENT,
  `kode_pembelian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah` decimal(10, 2) NULL DEFAULT NULL,
  `harga_beli` decimal(10, 2) NULL DEFAULT NULL,
  `id_supplier` int NULL DEFAULT NULL,
  `tanggal_return` date NULL DEFAULT NULL,
  `id_produk` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_return_pembelian`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of return_pembelian
-- ----------------------------
BEGIN;
INSERT INTO `return_pembelian` (`id_return_pembelian`, `kode_pembelian`, `jumlah`, `harga_beli`, `id_supplier`, `tanggal_return`, `id_produk`) VALUES (1, 'adsaa', 1.00, 9000.00, 1, '2024-11-13', 2), (2, 'adada', 2.00, 10000.00, 1, '2024-11-13', 1), (12, 'PBL-025', 5.00, 15000.00, 11, '2024-11-13', 28), (13, 'PBL-006', 1.00, 5000.00, 12, '2024-10-18', 35);
COMMIT;

-- ----------------------------
-- Table structure for return_penjualan
-- ----------------------------
DROP TABLE IF EXISTS `return_penjualan`;
CREATE TABLE `return_penjualan`  (
  `id_return_penjualan` int NOT NULL AUTO_INCREMENT,
  `kode_penjualan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah` decimal(10, 2) NULL DEFAULT NULL,
  `harga_jual` decimal(10, 2) NULL DEFAULT NULL,
  `tanggal_return` date NULL DEFAULT NULL,
  `id_produk` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_return_penjualan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of return_penjualan
-- ----------------------------
BEGIN;
INSERT INTO `return_penjualan` (`id_return_penjualan`, `kode_penjualan`, `jumlah`, `harga_jual`, `tanggal_return`, `id_produk`) VALUES (9, 'INV-001', 1.00, 19800.00, '2024-11-14', 37);
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
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of supplier
-- ----------------------------
BEGIN;
INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `kontak_supplier`, `alamat`) VALUES (11, 'PT. Utama Farma ', '085156303106', 'Jl. Kyai Tulus, Rt: 01/RW: 01, Jetis, Kecamatan Kendal, Jawa Tengah'), (12, 'PT. Combi Putra Mandiri', '0243515291', 'Jl. Kalimas Raya No. 54 Blok A, Panggung Kidul, Kecamatan Semarang Utara, Jawa Tengah'), (13, 'PT. Antarmitra Sembada', '02476635226', 'Jl. Wr. Supratman No. Kav. 39, Gisikdrono, Kecamatan Semarang Barat, Jawa Tengah'), (14, 'PT. San Prima Sejati', '0247606612', 'Jl. Puspanjolo Tengah IX No. 5A, Cabean, Kecamatan Semarang Barat, Jawa Tengah'), (15, 'PT. Bharadah Sakti', '0243459876', 'Jl. Perintis Kemerdekaan No. 29A, Banyumanik, Kecamatan Banyumanik, Kota Semarang, Jawa Tengah'), (16, 'PT. Tempo Scan Pacifik, Tbk', '0318438397', 'Jl. Rungkut Industri I No. 16, Kedungsari, Kecamatan Tenggilis Mejoyo, Surabaya, Jawa Timur');
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
) ENGINE = InnoDB AUTO_INCREMENT = 270 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
BEGIN;
INSERT INTO `transaksi` (`id_transaksi`, `deskripsi`, `kode_transaksi`, `total`, `id_akun_debit`, `id_akun_kredit`, `tanggal_transaksi`) VALUES (68, 'Modal Awal Apotek Graha Medika', 'JRNL7808', 20000000.00, 1, 8, '2024-08-01'), (69, 'Pembelian obat masuk-PBL 002\r\n', 'JRNL2954', 20000.00, 2, 1, '2024-08-11'), (70, 'Beban gaji karyawan bulan Agustus', 'JRNL3477', 800000.00, 9, 1, '2024-08-28'), (71, 'Pembelian obat masuk-PBL 001', 'JRNL3077', 12500000.00, 2, 1, '2024-09-01'), (72, 'Pembelian obat masuk-PBL 003', 'JRNL4348', 127500.00, 2, 1, '2024-09-06'), (73, 'Penjualan obat keluar-INV 001', 'JRNL7541', 50000.00, 1, 7, '2024-09-11'), (74, 'Pembelian obat masuk-PBL 007', 'JRNL4921', 75000.00, 2, 1, '2024-10-01'), (76, 'Pembelian obat masuk-PBL 006', 'JRNL5268', 40000.00, 2, 1, '2024-10-03'), (77, 'Penjualan obat keluar-INV 003', 'JRNL2072', 8000.00, 1, 7, '2024-10-05'), (78, 'Pembelian obat masuk-PBL 005', 'JRNL6523', 100000.00, 2, 1, '2024-10-07'), (79, 'Penjualan obat keluar-INV 005', 'JRNL4899', 38000.00, 1, 7, '2024-10-10'), (80, 'Penjualan obat keluar-INV 006', 'JRNL7767', 49500.00, 1, 7, '2024-10-10'), (81, 'Penjualan obat keluar-INV 007', 'JRNL9630', 247500.00, 1, 7, '2024-10-11'), (82, 'Penjualan obat keluar-INV 008', 'JRNL8218', 16500.00, 1, 7, '2024-10-12'), (83, 'Penjualan obat keluar-INV 002', 'JRNL8973', 10500.00, 1, 7, '2024-10-17'), (84, 'Penjualan obat keluar-INV 004', 'JRNL4967', 14000.00, 1, 7, '2024-10-17'), (104, 'PembelianPBL-001', 'PBL-001', 225000.00, 2, 1, '2024-09-01'), (105, 'PembelianPBL-002', 'PBL-002', 45000.00, 2, 1, '2024-09-01'), (106, 'PembelianPBL-003', 'PBL-003', 88000.00, 2, 1, '2024-09-01'), (108, 'PembelianPBL-005', 'PBL-005', 150500.00, 2, 1, '2024-09-01'), (109, 'PembelianPBL-006', 'PBL-006', 25000.00, 2, 1, '2024-09-02'), (110, 'PembelianPBL-007', 'PBL-007', 51000.00, 2, 1, '2024-09-02'), (111, 'PembelianPBL-008', 'PBL-008', 72000.00, 2, 1, '2024-09-02'), (112, 'PembelianPBL-009', 'PBL-009', 150000.00, 2, 1, '2024-09-02'), (113, 'PembelianPBL-010', 'PBL-010', 35000.00, 2, 1, '2024-09-02'), (114, 'PembelianPBL-011', 'PBL-011', 144000.00, 2, 1, '2024-09-03'), (115, 'PembelianPBL-012', 'PBL-012', 20000.00, 2, 1, '2024-09-03'), (116, 'PembelianPBL-013', 'PBL-013', 45000.00, 2, 1, '2024-09-02'), (117, 'PembelianPBL-014', 'PBL-014', 10000.00, 2, 1, '2024-09-03'), (118, 'PembelianPBL-015', 'PBL-015', 140000.00, 2, 1, '2024-09-03'), (129, 'PembelianPBL-016', 'PBL-016', 129000.00, 2, 1, '2024-09-05'), (131, 'PembelianPBL-018', 'PBL-018', 112500.00, 2, 1, '2024-10-01'), (132, 'PembelianPBL-019', 'PBL-019', 108000.00, 2, 1, '2024-10-01'), (133, 'PembelianPBL-020', 'PBL-020', 25000.00, 2, 1, '2024-10-01'), (134, 'PembelianPBL-021', 'PBL-021', 130000.00, 2, 1, '2024-10-01'), (135, 'PembelianPBL-022', 'PBL-022', 105000.00, 2, 1, '2024-10-01'), (136, 'PembelianPBL-023', 'PBL-023', 15000.00, 2, 1, '2024-10-01'), (137, 'PembelianPBL-024', 'PBL-024', 107500.00, 2, 1, '2024-10-01'), (138, 'PenjualanINV-001', 'INV-001', 19800.00, 5, 2, '2024-09-05'), (139, 'PenjualanINV-001', 'INV-001', 18000.00, 1, 7, '2024-09-05'), (140, 'PenjualanINV-002', 'INV-002', 11000.00, 5, 2, '2024-09-05'), (141, 'PenjualanINV-002', 'INV-002', 10000.00, 1, 7, '2024-09-05'), (142, 'PenjualanINV-003', 'INV-003', 33000.00, 5, 2, '2024-09-05'), (143, 'PenjualanINV-003', 'INV-003', 30000.00, 1, 7, '2024-09-05'), (144, 'PenjualanINV-004', 'INV-004', 33000.00, 5, 2, '2024-09-05'), (145, 'PenjualanINV-004', 'INV-004', 30000.00, 1, 7, '2024-09-05'), (146, 'PenjualanINV-005', 'INV-005', 2750.00, 5, 2, '2024-09-05'), (147, 'PenjualanINV-005', 'INV-005', 2500.00, 1, 7, '2024-09-05'), (148, 'PenjualanINV-006', 'INV-006', 47300.00, 5, 2, '2024-09-05'), (149, 'PenjualanINV-006', 'INV-006', 40000.00, 1, 7, '2024-09-05'), (150, 'PenjualanINV-007', 'INV-007', 49500.00, 5, 2, '2024-09-06'), (151, 'PenjualanINV-007', 'INV-007', 45000.00, 1, 7, '2024-09-06'), (152, 'PenjualanINV-008', 'INV-008', 47300.00, 5, 2, '2024-09-06'), (153, 'PenjualanINV-008', 'INV-008', 43000.00, 1, 7, '2024-09-06'), (154, 'PenjualanINV-009', 'INV-009', 5500.00, 5, 2, '2024-09-06'), (155, 'PenjualanINV-009', 'INV-009', 5000.00, 1, 7, '2024-09-06'), (156, 'PenjualanINV-010', 'INV-010', 9350.00, 5, 2, '2024-09-06'), (157, 'PenjualanINV-010', 'INV-010', 8500.00, 1, 7, '2024-09-06'), (158, 'PenjualanINV-011', 'INV-011', 16500.00, 5, 2, '2024-10-07'), (159, 'PenjualanINV-011', 'INV-011', 15000.00, 1, 7, '2024-10-07'), (164, 'PenjualanINV-012', 'INV-012', 26400.00, 5, 2, '2024-09-07'), (165, 'PenjualanINV-012', 'INV-012', 24000.00, 1, 7, '2024-09-07'), (166, 'PenjualanINV-013', 'INV-013', 47300.00, 5, 2, '2024-09-07'), (167, 'PenjualanINV-013', 'INV-013', 44000.00, 1, 7, '2024-09-07'), (172, 'PenjualanINV-015', 'INV-015', 19800.00, 5, 2, '2024-09-10'), (173, 'PenjualanINV-015', 'INV-015', 18000.00, 1, 7, '2024-09-10'), (174, 'PenjualanINV-016', 'INV-016', 5500.00, 5, 2, '2024-09-11'), (175, 'PenjualanINV-016', 'INV-016', 5000.00, 1, 7, '2024-09-11'), (176, 'PenjualanINV-017', 'INV-017', 22000.00, 5, 2, '2024-09-12'), (177, 'PenjualanINV-017', 'INV-017', 20000.00, 1, 7, '2024-09-12'), (178, 'PenjualanINV-018', 'INV-018', 16500.00, 5, 2, '2024-09-13'), (179, 'PenjualanINV-018', 'INV-018', 15000.00, 1, 7, '2024-09-13'), (184, 'PenjualanINV-020', 'INV-020', 47300.00, 5, 2, '2024-09-13'), (185, 'PenjualanINV-020', 'INV-020', 44000.00, 1, 7, '2024-09-13'), (188, 'PembelianPBL-025', 'PBL-025', 105000.00, 2, 1, '2024-10-01'), (189, 'PenjualanINV-021', 'INV-021', 16500.00, 5, 2, '2024-09-13'), (190, 'PenjualanINV-021', 'INV-021', 15000.00, 1, 7, '2024-09-13'), (191, 'PenjualanINV-022', 'INV-022', 33000.00, 5, 2, '2024-09-14'), (192, 'PenjualanINV-022', 'INV-022', 30000.00, 1, 7, '2024-09-14'), (193, 'PembelianPBL-026', 'PBL-026', 1500000.00, 2, 1, '2024-09-03'), (204, 'PenjualanINV-023', 'INV-023', 412500.00, 5, 2, '2024-10-07'), (205, 'PenjualanINV-023', 'INV-023', 375000.00, 1, 7, '2024-10-07'), (206, 'PenjualanINV-024', 'INV-024', 33000.00, 5, 2, '2024-10-08'), (207, 'PenjualanINV-024', 'INV-024', 30000.00, 1, 7, '2024-10-08'), (208, 'PenjualanINV-025', 'INV-025', 49500.00, 5, 2, '2024-10-11'), (209, 'PenjualanINV-025', 'INV-025', 45000.00, 1, 7, '2024-10-11'), (210, 'PenjualanINV-026', 'INV-026', 5500.00, 5, 2, '2024-10-12'), (211, 'PenjualanINV-026', 'INV-026', 5000.00, 1, 7, '2024-10-12'), (212, 'PenjualanINV-027', 'INV-027', 26400.00, 5, 2, '2024-10-13'), (213, 'PenjualanINV-027', 'INV-027', 24000.00, 1, 7, '2024-10-13'), (214, 'PenjualanINV-028', 'INV-028', 5500.00, 5, 2, '2024-10-15'), (215, 'PenjualanINV-028', 'INV-028', 5000.00, 1, 7, '2024-10-15'), (216, 'PenjualanINV-029', 'INV-029', 165000.00, 5, 2, '2024-10-18'), (217, 'PenjualanINV-029', 'INV-029', 150000.00, 1, 7, '2024-10-18'), (218, 'PenjualanINV-030', 'INV-030', 16500.00, 5, 2, '2024-10-22'), (219, 'PenjualanINV-030', 'INV-030', 15000.00, 1, 7, '2024-10-22'), (220, 'PenjualanINV-031', 'INV-031', 39600.00, 5, 2, '2024-10-25'), (221, 'PenjualanINV-031', 'INV-031', 36000.00, 1, 7, '2024-10-25'), (222, 'PenjualanINV-032', 'INV-032', 16500.00, 5, 2, '2024-10-27'), (223, 'PenjualanINV-032', 'INV-032', 15000.00, 1, 7, '2024-10-27'), (224, 'PenjualanINV-033', 'INV-033', 16500.00, 5, 2, '2024-10-29'), (225, 'PenjualanINV-033', 'INV-033', 15000.00, 1, 7, '2024-10-29'), (226, 'PenjualanINV-034', 'INV-034', 99000.00, 5, 2, '2024-11-01'), (227, 'PenjualanINV-034', 'INV-034', 90000.00, 1, 7, '2024-11-01'), (228, 'PenjualanINV-035', 'INV-035', 16500.00, 5, 2, '2024-11-01'), (229, 'PenjualanINV-035', 'INV-035', 15000.00, 1, 7, '2024-11-01'), (230, 'PenjualanINV-036', 'INV-036', 148500.00, 5, 2, '2024-11-01'), (231, 'PenjualanINV-036', 'INV-036', 135000.00, 1, 7, '2024-11-01'), (232, 'PenjualanINV-037', 'INV-037', 49500.00, 5, 2, '2024-11-02'), (233, 'PenjualanINV-037', 'INV-037', 45000.00, 1, 7, '2024-11-02'), (234, 'PenjualanINV-038', 'INV-038', 47300.00, 5, 2, '2024-11-02'), (235, 'PenjualanINV-038', 'INV-038', 43000.00, 1, 7, '2024-11-02'), (236, 'PenjualanINV-039', 'INV-039', 5500.00, 5, 2, '2024-11-02'), (237, 'PenjualanINV-039', 'INV-039', 5000.00, 1, 7, '2024-11-02'), (238, 'PenjualanINV-040', 'INV-040', 9350.00, 5, 2, '2024-11-02'), (239, 'PenjualanINV-040', 'INV-040', 8500.00, 1, 7, '2024-11-02'), (240, 'PenjualanINV-041', 'INV-041', 19800.00, 5, 2, '2024-11-02'), (241, 'PenjualanINV-041', 'INV-041', 18000.00, 1, 7, '2024-11-02'), (242, 'PenjualanINV-042', 'INV-042', 33000.00, 5, 2, '2024-11-03'), (243, 'PenjualanINV-042', 'INV-042', 30000.00, 1, 7, '2024-11-03'), (244, 'PenjualanINV-043', 'INV-043', 5500.00, 5, 2, '2024-11-03'), (245, 'PenjualanINV-043', 'INV-043', 5000.00, 1, 7, '2024-11-03'), (246, 'PenjualanINV-044', 'INV-044', 39600.00, 5, 2, '2024-11-03'), (247, 'PenjualanINV-044', 'INV-044', 36000.00, 1, 7, '2024-11-03'), (248, 'PenjualanINV-045', 'INV-045', 55000.00, 5, 2, '2024-11-03'), (249, 'PenjualanINV-045', 'INV-045', 50000.00, 1, 7, '2024-11-03'), (250, 'PenjualanINV-046', 'INV-046', 8250.00, 5, 2, '2024-11-03'), (251, 'PenjualanINV-046', 'INV-046', 7500.00, 1, 7, '2024-11-03'), (252, 'PembelianPBL-027', 'PBL-027', 77500.00, 2, 1, '2024-11-04'), (253, 'PenjualanINV-047', 'INV-047', 85250.00, 5, 2, '2024-11-04'), (254, 'PenjualanINV-047', 'INV-047', 77500.00, 1, 7, '2024-11-04'), (255, 'PembelianPBL-028', 'PBL-028', 21500.00, 2, 1, '2024-11-11'), (256, 'PenjualanINV-048', 'INV-048', 23650.00, 5, 2, '2024-11-12'), (257, 'PenjualanINV-048', 'INV-048', 21500.00, 1, 7, '2024-11-12'), (264, 'Return Pembelian - PBL-006', 'RT6849', 5000.00, 1, 2, '2024-10-18');
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
-- View structure for v_return_pembelian
-- ----------------------------
DROP VIEW IF EXISTS `v_return_pembelian`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_return_pembelian` AS select `return_pembelian`.`id_return_pembelian` AS `id_return_pembelian`,`return_pembelian`.`kode_pembelian` AS `kode_pembelian`,`return_pembelian`.`jumlah` AS `jumlah`,`return_pembelian`.`harga_beli` AS `harga_beli`,`return_pembelian`.`id_supplier` AS `id_supplier`,`return_pembelian`.`tanggal_return` AS `tanggal_return`,`return_pembelian`.`id_produk` AS `id_produk`,`produk`.`nama_produk` AS `nama_produk`,`supplier`.`nama_supplier` AS `nama_supplier`,`produk`.`satuan` AS `satuan` from ((`return_pembelian` join `produk` on((`return_pembelian`.`id_produk` = `produk`.`id_produk`))) join `supplier` on((`return_pembelian`.`id_supplier` = `supplier`.`id_supplier`)));

-- ----------------------------
-- View structure for v_return_penjualan
-- ----------------------------
DROP VIEW IF EXISTS `v_return_penjualan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_return_penjualan` AS select `return_penjualan`.`id_return_penjualan` AS `id_return_penjualan`,`return_penjualan`.`kode_penjualan` AS `kode_penjualan`,`return_penjualan`.`jumlah` AS `jumlah`,`return_penjualan`.`harga_jual` AS `harga_jual`,`return_penjualan`.`tanggal_return` AS `tanggal_return`,`return_penjualan`.`id_produk` AS `id_produk`,`produk`.`nama_produk` AS `nama_produk`,`produk`.`satuan` AS `satuan` from (`return_penjualan` join `produk` on((`return_penjualan`.`id_produk` = `produk`.`id_produk`)));

-- ----------------------------
-- View structure for v_supplier
-- ----------------------------
DROP VIEW IF EXISTS `v_supplier`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_supplier` AS select `pembelian`.`id_pembelian` AS `id_pembelian`,`pembelian`.`id_produk` AS `id_produk`,`pembelian`.`tanggal_masuk` AS `tanggal_masuk`,`pembelian`.`tanggal_kadaluarsa` AS `tanggal_kadaluarsa`,`pembelian`.`kode_pembelian` AS `kode_pembelian`,`pembelian`.`id_pengguna` AS `id_pengguna`,`pembelian`.`jumlah` AS `jumlah`,`pembelian`.`harga_beli` AS `harga_beli`,`pembelian`.`id_supplier` AS `id_supplier`,`supplier`.`nama_supplier` AS `nama_supplier`,`produk`.`nama_produk` AS `nama_produk`,`produk`.`kode_produk` AS `kode_produk` from ((`supplier` join `pembelian` on((`supplier`.`id_supplier` = `pembelian`.`id_supplier`))) join `produk` on((`pembelian`.`id_produk` = `produk`.`id_produk`)));

SET FOREIGN_KEY_CHECKS = 1;
