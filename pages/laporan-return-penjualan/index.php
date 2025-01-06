<div class="container-fluid">

    <!-- start page title -->
    <?php
    $maintitle = "Laporan";
    $title = 'Laporan Return Penjualan';
    ?>
    <?php include 'layouts/breadcrumb.php'; ?>
    <div class="row d-print-none">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter Data</h5>
                </div><!-- end card header -->
                <?php
                function bulan($bulan)
                {
                    $bulanA = array(
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
                    return $bulanA[$bulan];
                }

                ?>
                <div class="card-body">
                    <form action="" method="get" class="row g-3">
                        <input type="hidden" name="page" value="laporan-return-penjualan">
                        <div class="col-md-6">
                            <label for="validationDefault02" class="form-label">Bulan</label>
                            <select class="form-select" name="bulan" aria-label="Default select example">
                                <option selected>Pilih Bulan</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    ?>
                                    <option value="<?= $i ?>"><?= bulan($i) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
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
                <h4 class="text-center mt-3 mb-3"><b>Apotek Graha Medika</b><br><b>LAPORAN RETURN
                        PENJUALAN</b><br>Periode <?php
                        if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) {
                            echo tanggal($_GET['dari_tanggal']) . " s.d " . tanggal($_GET['sampai_tanggal']);
                        } else {
                            echo "Semua";
                        }
                        ?></h4>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="tabel-data" class="table table-bordered table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Kode Pembelian</th>
                                    <th>Nama Barang</th>
                                    <th>Tgl. Return</th>
                                    <th>Harga Jual</th>
                                    <th>Qty</th>
                                    <th>Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "config.php";
                                $tahun = date('Y');
                                if (isset($_GET['bulan'])) {
                                    $kondisi = "WHERE MONTH(tanggal_return) = '$_GET[bulan]' AND YEAR(tanggal_return) = '$tahun'";
                                } else {
                                    $kondisi = "";
                                }

                                $query = mysqli_query($conn, "SELECT * FROM v_return_penjualan $kondisi");
                                while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?= $data['kode_penjualan'] ?></td>
                                        <td><?= $data['nama_produk'] ?></td>
                                        <td><?= $data['tanggal_return'] ?></td>
                                        <td>Rp. <?= number_format($data['harga_jual'], 0, ',', '.') ?></td>
                                        <td><?= $data['jumlah'] ?></td>
                                        <td><?= $data['satuan'] ?></td>
                                        <td>Rp. <?= number_format($data['harga_jual'] * $data['jumlah'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php

                                }
                                ?>

                            </tbody>
                        </table>
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