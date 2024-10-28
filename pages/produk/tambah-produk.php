<form id="tambah-produk" enctype="multipart/form-data">
    <?php
    require_once '../../config.php';
    ?>

    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Satuan Produk</label>
                    <select class="form-select" name="satuan">
                        <option selected>Pilih Satuan</option>
                        <option value="PCS">PCS</option>
                        <option value="Botolan">Botolan</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Strip">Strip</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="golongan_obat" class="form-label">Golongan Obat</label>
                <select class="form-select" name="golongan_obat">
                    <option selected>Pilih Golongan Obat</option>
                    <option value="Obat Luar">Obat Luar</option>
                    <option value="Obat Dalam">Obat Dalam</option>
                </select>
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
                <label for="foto" class="form-label">foto</label>
                <input type="file" class="form-control" name="foto" id="fototak">
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="kontak" class="form-label">Harga Beli</label>
                            <input type="text" class="form-control" name="harga_beli" id="harga_beli" placeholder="">
                        </div>
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Harga Jual</label>
                            <input type="text" class="form-control" name="harga_jual" id="harga_jual" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>

    $("#harga_beli").on("keyup", function () {
        var value = $(this).val().replace(/[^\d]/g, "");
        $(this).val("Rp. " + value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
        // up the price by 10%
        var newPrice = (parseFloat(value) * 1.1).toFixed(0);
        $("#harga_jual").val("Rp. " + newPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
    })

    $("#tambah-produk").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);

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