<?php

switch ($_GET['page'] ?? '') {
    case '':
    case 'dashboard':
        include 'pages/dashboard.php';
        break;
    case 'pengguna':
        include 'pages/pengguna/index.php';
        break;
    case 'supplier':
        include 'pages/supplier/index.php';
        break;
    case 'produk':
        include 'pages/produk/index.php';
        break;
    case 'akun':
        include 'pages/akun/index.php';
        break;
    case 'pembelian':
        include 'pages/pembelian/index.php';
        break;
    case 'penjualan':
        include 'pages/penjualan/index.php';
        break;
    case 'jurnal':
        include 'pages/jurnal/index.php';
        break;
    case 'laporan-penjualan':
        include 'pages/laporan-penjualan/index.php';
        break;
    case 'laporan-pembelian':
        include 'pages/laporan-pembelian/index.php';
        break;
    case 'kartu-persediaan':
        include 'pages/kartu-persediaan/index.php';
        break;
    case 'laporan-supplier':
        include 'pages/laporan-supplier/index.php';
        break;

    default:
        include 'page/404.php';
        break;
}