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
        <?php

        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-lg-4">
                <div class="card border border-success">
                    <div class="card-header bg-transparent border-success">
                        <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Kode
                            <?= $row['kode_pembelian'] ?>
                        </h5>
                    </div>
                    <div class="card-body">
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