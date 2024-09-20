<form id="tambah-produk" enctype="multipart/form-data">
    <?php
    require_once '../../config.php';
    $query = mysqli_query($conn, "SELECT MAX(kode_produk) AS kode_produk FROM produk");
    $data = mysqli_fetch_array($query);
    $max = $data['kode_produk'] ? substr($data['kode_produk'], 4, 3) : "000";
    $no = $max + 1;
    $char = "PRD-";
    $kode = $char . sprintf("%03s", $no);
    ?>

    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Kode Produk</label>
                    <input type="text" name="kode_produk" class="form-control" placeholder="Jumlah Transaksi"
                        value="<?= $kode; ?>" readonly>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Satuan Produk</label>
                    <input type="text" name="satuan" class="form-control" placeholder="Satuan">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <label for="nama" class="form-label">Name Produk</label>
                    <input type="text" class="form-control" name="nama_produk" id="nama" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" name="deskripsi" id="kondeskripsitak" placeholder="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <label for="nama" class="form-label">Harga Jual</label>
                    <input type="text" class="form-control" name="harga_jual" id="nama" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="kontak" class="form-label">Harga Beli</label>
                    <input type="text" class="form-control" name="harga_beli" id="kontak" placeholder="">
                </div>
            </div>
        </div>

    </div>
    <button type="submit" class="btn btn-primary mt-3">SImpan</button>
</form>
<script>
    $("#tambah-produk").submit(function (e) {
        var formData = new FormData(this);

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "proses.php?aksi=tambah-produk",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Produk Berhasil Ditambah');

                } else {
                    alertify.error('Produk Gagal Ditambah');

                }
            }
        });
    });
</script>