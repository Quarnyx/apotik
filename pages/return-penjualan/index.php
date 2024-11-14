<!-- start page title -->
<?php
$maintitle = "Transaksi";
$title = 'Transaksi Return Penjualan';
?>
<?php include 'layouts/breadcrumb.php'; ?>
<!-- end page title -->

<!-- end row-->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Tambah Return Penjualan</h4>
                <form action="" method="get">
                    <input type="text" name="page" id="return-penjualan" hidden value="return-penjualan">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="penjualan" class="form-label">Kode Pembelian</label>
                                <select class="form-select" name="kode_penjualan" id="penjualan" required>
                                    <?php
                                    include "config.php";
                                    $sql = "SELECT * FROM penjualan";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['kode_penjualan'] . '">' . $row['kode_penjualan'] . " | " . $row['tanggal_penjualan'] . " | " . $row['jumlah'] . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <button type="submit" class="btn btn-primary mb-3" id="tambah">Pilih</button>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_GET['kode_penjualan'])) {

                    $sql = "SELECT jumlah, id_produk, nama_produk, kode_produk, harga_jual, kategori_obat FROM v_penjualan WHERE kode_penjualan = '$_GET[kode_penjualan]' ORDER BY id_produk";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    ?>
                    <form action="proses.php?aksi=tambah-return-penjualan" method="post">
                        <input type="text" name="kode_penjualan" hidden value="<?= $_GET['kode_penjualan'] ?>">
                        <div class="row">
                            <h3 class="header-title"><?php echo $_GET['kode_penjualan'] ?></h3>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Produk Obat</label>
                                    <input type="text" class="form-control" value="<?= $row['nama_produk'] ?>" readonly>
                                    <input type="text" name="id_produk" hidden value="<?= $row['id_produk'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Jumlah Dibeli</label>
                                    <input type="text" name="jumlah" class="form-control" value="<?= $row['jumlah'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Harga Beli</label>
                                    <input type="text" name="harga_jual" class="form-control"
                                        value="Rp. <?= number_format($row['harga_jual'], 0, ',', '.') ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Ketegori Obat</label>
                                    <input value="<?= $row['kategori_obat'] ?>" type="text" class="form-control"
                                        name="kategori_obat" id="kategori_obat" readonly>
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
                <h4 class="header-title">Daftar Return Penjualan</h4>
                <div id="load-table">

                </div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->

<script>
    function loadTable() {
        $('#load-table').load('pages/return-penjualan/tabel-return-penjualan.php')
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').on('click', function () {
            $('.modal').modal('show');
            $('.modal-title').html('Tambah Penjualan');
            // load form
            $('.modal-body').load('pages/return-penjualan/tambah-return-penjualan.php');
        });
    });
</script>