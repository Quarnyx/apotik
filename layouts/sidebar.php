<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.php" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-sm.png" alt="" height="22"> <span class="logo-txt">Graha Medika</span>
            </span>
        </a>

        <a href="index.php" class="logo logo-light">
            <span class="logo-lg">
                <img src="assets/images/logo-sm.png" alt="" height="22"> <span class="logo-txt">Graha Medika</span>
            </span>
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="?page=dashboard">
                        <i class="bx bx-tachometer icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <?php if ($_SESSION['level'] == 'Pimpinan') { ?>
                    <li class="menu-title" data-key="t-applications">Data Master</li>
                    <li>
                        <a href="?page=pengguna">
                            <i class="bx bx-user icon nav-icon"></i>
                            <span class="menu-item" data-key="t-chat">Data Pengguna</span>
                        </a>
                    </li>
                    <li class="menu-title" data-key="t-components">Laporan</li>
                    <li>
                        <a href="?page=laporan-persediaan">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Persediaan</span>
                        </a>
                    </li>

                    <li>
                        <a href="?page=kartu-persediaan">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Kartu Persediaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=jurnal">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Jurnal</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=laporan-supplier">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Supplier</span>
                        </a>
                    </li>
                    <?php
                } ?>


                <?php
                if ($_SESSION['level'] == 'Admin') {
                    ?>
                    <li>
                        <a href="?page=supplier">
                            <i class="bx bx-calendar icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">Data Supplier</span>
                        </a>
                    </li>

                    <li>
                        <a href="?page=produk">
                            <i class="bx bx-chat icon nav-icon"></i>
                            <span class="menu-item" data-key="t-chat">Data Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=akun">
                            <i class="bx bx-chat icon nav-icon"></i>
                            <span class="menu-item" data-key="t-chat">Data Akun</span>
                        </a>
                    </li>
                    <li class="menu-title" data-key="t-pages">Transaksi</li>
                    <li>
                        <a href="?page=pembelian">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Pembelian</span>
                        </a>
                    </li>
                    <li class="menu-title" data-key="t-components">Laporan</li>
                    <li>
                        <a href="?page=laporan-persediaan">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Persediaan</span>
                        </a>
                    </li>

                    <li>
                        <a href="?page=kartu-persediaan">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Kartu Persediaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=jurnal">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Jurnal</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=laporan-supplier">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Supplier</span>
                        </a>
                    </li>
                <?php } ?>
                <?php
                if ($_SESSION['level'] == 'Kasir') {
                    ?>
                    <li>
                        <a href="?page=supplier">
                            <i class="bx bx-calendar icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">Data Supplier</span>
                        </a>
                    </li>

                    <li>
                        <a href="?page=produk">
                            <i class="bx bx-chat icon nav-icon"></i>
                            <span class="menu-item" data-key="t-chat">Data Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=akun">
                            <i class="bx bx-chat icon nav-icon"></i>
                            <span class="menu-item" data-key="t-chat">Data Akun</span>
                        </a>
                    </li>
                    <li class="menu-title" data-key="t-pages">Transaksi</li>

                    <li>
                        <a href="?page=penjualan">
                            <i class="bx bx-layout icon nav-icon"></i>
                            <span class="menu-item" data-key="t-vertical">Penjualan</span>
                        </a>
                    </li>
                    <?php
                }
                ?>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->