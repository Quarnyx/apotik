<div class="container-fluid">

    <!-- start page title -->
    <?php
    $maintitle = "Laporan";
    $title = 'Kartu Persediaan';
    include 'config.php';
    $sql = "SELECT * FROM v_inventory ORDER BY tanggal_masuk ASC";
    $result = $conn->query($sql);


    ?>
    <?php include 'layouts/breadcrumb.php';

    ?>
    <div class="row">
        <div class="mt-3 mb-3 d-print-none">
            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i
                    class="mdi mdi-printer me-1"></i> Print</a>
        </div>
        <?php

        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-md-4 col-lg-4 col-4">
                <div class="card border border-success">
                    <div class="card-header bg-transparent border-success">
                        <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Kode
                            <?= $row['kode_pembelian'] ?>
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title"><?= $row['kode_produk'] ?> - <?= $row['nama_produk'] ?></h5>
                        <p class="card-text">
                            <b>Stok</b> : <?= $row['jumlah'] ?>
                            <br>
                            <b>Harga</b> : <?= $row['harga_beli'] ?>
                            <br>
                            <b>Tanggal Masuk</b> : <?= $row['tanggal_masuk'] ?>
                            <br>
                            <b>Tanggal Kadaluarsa</b> : <?= $row['tanggal_kadaluarsa'] ?>
                        </p>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
</div>