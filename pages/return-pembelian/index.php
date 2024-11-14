<!-- start page title -->
<?php
$maintitle = "Transaksi";
$title = 'Transaksi Return Pembelian';
?>
<?php include 'layouts/breadcrumb.php'; ?>
<!-- end page title -->

<!-- end row-->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Tambah Return Pembelian</h4>
                <form action="" method="get">
                    <input type="text" name="page" id="return-pembelian" hidden value="return-pembelian">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pembelian" class="form-label">Kode Pembelian</label>
                                <select class="form-select" name="kode_pembelian" id="pembelian" required>
                                    <?php
                                    include "config.php";
                                    $sql = "SELECT * FROM inventory";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['kode_pembelian'] . '">' . $row['kode_pembelian'] . " | " . $row['tanggal_masuk'] . " | " . $row['jumlah'] . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <button type="submit" class="btn btn-primary mb-3" id="tambah">Pilih</button>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_GET['kode_pembelian'])) {

                    $sql = "SELECT jumlah, id_produk, nama_produk, kode_produk, harga_jual, harga_beli FROM v_inventory WHERE kode_pembelian = '$_GET[kode_pembelian]' ORDER BY id_produk";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    ?>
                    <form action="proses.php?aksi=tambah-return-pembelian" method="post">
                        <input type="text" name="kode_pembelian" hidden value="<?= $_GET['kode_pembelian'] ?>">
                        <div class="row">
                            <h3 class="header-title"><?php echo $_GET['kode_pembelian'] ?></h3>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Produk Obat</label>
                                    <input type="text" class="form-control" value="<?= $row['nama_produk'] ?>" readonly>
                                    <input type="text" name="id_produk" hidden value="<?= $row['id_produk'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Stok</label>
                                    <input type="text" name="jumlah" class="form-control" value="<?= $row['jumlah'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Harga Beli</label>
                                    <input type="text" name="harga_beli" class="form-control"
                                        value="Rp. <?= number_format($row['harga_beli'], 0, ',', '.') ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Supplier</label>
                                    <?php
                                    $suppSQL = "SELECT * FROM v_pembelian WHERE kode_pembelian = '$_GET[kode_pembelian]'";
                                    $suppResult = $conn->query($suppSQL);
                                    $suppRow = $suppResult->fetch_assoc();
                                    ?>
                                    <input type="text" class="form-control" name="supplier"
                                        value="<?= $suppRow['nama_supplier'] ?>" readonly>
                                    <input type="text" name="id_supplier" hidden value="<?= $suppRow['id_supplier'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Tanggal Return</label>
                                    <input type="date" class="form-control" name="tanggal_return" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Jumlah dikembalikan</label>
                                    <input type="text" class="form-control" name="jumlah" id="jumlah" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Tambah</button>
                    </form>
                    <?php
                }
                ?>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->
<!-- end row-->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Daftar Return Pembelian</h4>
                <div id="load-table">

                </div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->

<script>
    function loadTable() {
        $('#load-table').load('pages/return-pembelian/tabel-return-pembelian.php')
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').on('click', function () {
            $('.modal').modal('show');
            $('.modal-title').html('Tambah Penjualan');
            // load form
            $('.modal-body').load('pages/return-pembelian/tambah-return-pembelian.php');
        });
    });
</script>