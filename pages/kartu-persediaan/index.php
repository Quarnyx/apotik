<div class="container-fluid">

    <!-- start page title -->
    <?php
    $maintitle = "Laporan";
    $title = 'Kartu Persediaan';
    include 'config.php';
    $sql = "SELECT
    pb.tanggal_masuk AS date,
    pb.kode_pembelian AS kode,
    pb.jumlah AS jumlah_beli,
    pb.harga_beli,
		pj.jumlah AS jumlah_jual,
    pj.harga_jual
    FROM pembelian pb
    LEFT JOIN penjualan pj ON pj.tanggal_penjualan = pb.tanggal_masuk AND pj.id_produk=pb.id_produk
    UNION
    SELECT
    pj.tanggal_penjualan AS date,
    pj.kode_penjualan AS kode,
		pb.jumlah AS jumlah_beli,
    pb.harga_beli,
    pj.jumlah AS jumlah_jual,
    pj.harga_jual
    FROM penjualan pj
    LEFT JOIN pembelian pb ON pb.tanggal_masuk = pj.tanggal_penjualan AND pb.id_produk=pj.id_produk
    ORDER BY date ASC";
    $result = $conn->query($sql);


    ?>
    <?php include 'layouts/breadcrumb.php';

    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kartu Persediaan</h4>
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Kode</th>
                                    <th colspan="3">Masuk</th>
                                    <th colspan="3">Keluar</th>
                                    <th colspan="3">Persediaan</th>
                                </tr>
                                <tr>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row['date'] ?></td>
                                        <td><?= $row['kode'] ?></td>
                                        <td><?= $row['jumlah_beli'] ?></td>
                                        <td><?= $row['harga_beli'] ?></td>
                                        <td><?= $row['harga_beli'] * $row['jumlah_beli'] ?></td>
                                        <td><?= $row['jumlah_jual'] ?></td>
                                        <td><?= $row['harga_jual'] ?></td>
                                        <td><?= $row['harga_jual'] * $row['jumlah_jual'] ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>