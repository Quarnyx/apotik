<?php
include "../../config.php";
$sql = "SELECT * FROM produk WHERE id_produk = '$_POST[id]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<form id="form-edit" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id_produk'] ?>">

    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Kode Produk</label>
                    <input type="text" name="kode_produk" class="form-control" placeholder="Jumlah Transaksi"
                        value="<?= $row['kode_produk']; ?>" readonly>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Satuan Produk</label>
                    <select class="form-select" name="satuan">
                        <option selected>Pilih Satuan</option>
                        <option value="PCS" <?= ($row['satuan'] == 'PCS' ? 'selected' : '') ?>>PCS</option>
                        <option value="Botolan" <?= ($row['satuan'] == 'Botolan' ? 'selected' : '') ?>>Botolan</option>
                        <option value="Kapsul" <?= ($row['satuan'] == 'Kapsul' ? 'selected' : '') ?>>Kapsul</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <label for="nama" class="form-label">Name Produk</label>
                    <input type="text" class="form-control" name="nama_produk" id="nama" placeholder=""
                        value="<?= $row['nama_produk'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" name="deskripsi" id="kondeskripsitak" placeholder=""
                        value="<?= $row['deskripsi'] ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <label for="nama" class="form-label">Harga Jual</label>
                    <input type="text" class="form-control" name="harga_jual" id="harga_jual" placeholder=""
                        value="<?= $row['harga_jual'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="kontak" class="form-label">Harga Beli</label>
                    <input type="text" class="form-control" name="harga_beli" id="harga_beli" placeholder=""
                        value="<?= $row['harga_beli'] ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="golongan_obat" class="form-label">Golongan Obat</label>
                <select class="form-select" name="golongan_obat">
                    <option selected>Pilih Golongan Obat</option>
                    <option value="Obat Luar" <?php if ($row['golongan_obat'] == 'Obat Luar')
                        echo 'selected'; ?>>Obat
                        Luar</option>
                    <option value="Obat Dalam" <?php if ($row['golongan_obat'] == 'Obat Dalam')
                        echo 'selected'; ?>>Obat
                        Dalam</option>
                </select>
            </div>
        </div>

    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
    $("#harga_beli").on("keyup", function () {
        var value = $(this).val();
        $("#harga_jual").val(value);
        // add 10% up 
        $("#harga_jual").val(parseInt($("#harga_jual").val()) + (parseInt($("#harga_jual").val()) * 0.1))
    })
    $("#form-edit").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'proses.php?aksi=edit-produk',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Edit Berhasil');

                } else {
                    alertify.error('Edit Gagal');

                }
            },
            error: function (data) {
                alertify.error(data);
            }
        });
    });
</script>