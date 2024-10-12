<div class="container-fluid">

    <!-- start page title -->
    <?php
    $maintitle = "Laporan";
    $title = 'Laporan Persediaan';
    ?>
    <?php include 'layouts/breadcrumb.php'; ?>
    <div class="row d-print-none">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter Tanggal</h5>
                </div><!-- end card header -->
                <?php
                function tanggal($tanggal)
                {
                    $bulan = array(
                        1 => 'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    );
                    $split = explode('-', $tanggal);
                    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
                }
                $daritanggal = "";
                $sampaitanggal = "";

                if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
                    $daritanggal = $_GET['dari_tanggal'];
                    $sampaitanggal = $_GET['sampai_tanggal'];
                }

                ?>
                <div class="card-body">
                    <form action="" method="get" class="row g-3">
                        <input type="hidden" name="page" value="laporan-persediaan">
                        <div class="col-md-6">
                            <label for="validationDefault01" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" id="validationDefault01" required=""
                                name="dari_tanggal">
                        </div>
                        <div class="col-md-6">
                            <label for="validationDefault02" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="validationDefault02" required=""
                                name="sampai_tanggal">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Pilih</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div>
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row align-self-center">
                    <div class="text-center d-flex align-items-center">
                        <div>
                            <img src="assets/images/logo-sm.png" width="100px" alt="brand" />
                        </div>
                        <div class="ms-3">
                            <h1>APOTIK</h1>
                            <h1><b>GRAHA MEDIKA</b></h1>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 text-center">
                        <h6>Jl. Lkr. Barat Ps. Kendal pasar No.5 Blok H, Pekauman, Pakauman, Kec. Kendal, Kabupaten
                            Kendal, Jawa Tengah 51314
                        </h6>
                    </div>
                </div>
                <hr style="border-width: 2px; border-color: black; border-style: solid;">
                <h4 class="text-center mt-3 mb-3"><b>LAPORAN PERSEDIAAN</b><br>Periode <?php
                if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) {
                    echo tanggal($_GET['dari_tanggal']) . " s.d " . tanggal($_GET['sampai_tanggal']);
                } else {
                    echo "Semua";
                }
                ?></h4>
                <hr>
                <div class="card-body">

                    <div class="table-responsive">
                        <h4 class="text-center mt-3 mb-3">Pembelian</h4>
                        <table id="tabel-data" class="table table-bordered table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "config.php";
                                $total = 0;
                                $harga_beli = 0;
                                $harga_jual = 0;
                                if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
                                    $kondisi = "WHERE tanggal_masuk BETWEEN '$_GET[dari_tanggal]' AND '$_GET[sampai_tanggal]'";
                                } else {
                                    $kondisi = "";
                                }

                                $query = mysqli_query($conn, "SELECT SUM(jumlah) AS total, kode_produk, nama_produk, tanggal_masuk, harga_beli FROM v_pembelian $kondisi GROUP BY kode_produk");
                                while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?= $data['kode_produk'] ?></td>
                                        <td><?= $data['nama_produk'] ?></td>
                                        <td><?= $data['tanggal_masuk'] ?></td>
                                        <td>Rp. <?= number_format($data['harga_beli'], 0, ',', '.') ?></td>
                                        <td><?= $data['total'] ?></td>
                                        <td>Rp. <?= number_format($data['harga_beli'] * $data['total'], 0, ',', '.') ?>
                                        </td>

                                    </tr>
                                    <?php
                                    $total += ($data['harga_beli'] * $data['total']);
                                }
                                ?>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>Total</td>
                                    <td>Rp. <?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <h4 class="text-center mt-3 mb-3">Penjualan</h4>
                        <table id="tabel-data" class="table table-bordered table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "config.php";
                                $total = 0;
                                $harga_beli = 0;
                                $harga_jual = 0;
                                if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
                                    $kondisi = "WHERE tanggal_penjualan BETWEEN '$_GET[dari_tanggal]' AND '$_GET[sampai_tanggal]'";
                                } else {
                                    $kondisi = "";
                                }

                                $query = mysqli_query($conn, "SELECT SUM(jumlah) AS total, kode_produk, nama_produk, tanggal_penjualan, harga_jual FROM v_penjualan $kondisi GROUP BY kode_produk");
                                while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?= $data['kode_produk'] ?></td>
                                        <td><?= $data['nama_produk'] ?></td>
                                        <td><?= $data['tanggal_penjualan'] ?></td>
                                        <td>Rp. <?= number_format($data['harga_jual'], 0, ',', '.') ?></td>
                                        <td><?= $data['total'] ?></td>
                                        <td>Rp. <?= number_format($data['harga_jual'] * $data['total'], 0, ',', '.') ?>
                                        </td>

                                    </tr>
                                    <?php
                                    $total += ($data['harga_jual'] * $data['total']);
                                }
                                ?>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>Total</td>
                                    <td>Rp. <?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row align-self-center">

                            <div class="d-flex">
                                <div class="col-sm-6" style="align-self:self-end">
                                    <div class="mt-3" style="text-align:center;">
                                        <div class="mt-6">
                                            <p class="font-weight-bold">Admin</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mt-3" style="text-align:center;">
                                        <p class="font-weight-bold">Kendal, <?= tanggal(date('Y-m-d')) ?><br>Mengetahui,
                                        </p>
                                        <div class="" style="margin-top: 80px;">
                                            <p class="font-weight-bold">Pimpinan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-4 mb-1">
                        <div class="text-end d-print-none">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i
                                    class="mdi mdi-printer me-1"></i> Print</a>
                        </div>
                    </div>
                </div> <!-- end card body-->

            </div> <!-- end card -->

        </div><!-- end col-->
    </div>
    <!-- end row-->

</div>
<script>
</script>