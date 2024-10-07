<?php
include "../../config.php";
$sql = "SELECT * FROM supplier WHERE id_supplier = '$_POST[id]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<form id="form-edit" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id_supplier'] ?>">
    <div class="row">
        <div class="col-md-6">
            <label for="nama" class="form-label">Name Supplier</label>
            <input type="text" class="form-control" name="nama_supplier" id="nama" placeholder="Nama"
                value="<?= $row['nama_supplier'] ?>">
        </div>
        <div class="col-md-6">
            <label for="kontak" class="form-label">Kontak</label>
            <input type="text" class="form-control" name="kontak" id="kontak" placeholder="Kontak"
                value="<?= $row['kontak_supplier'] ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md 12">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="" cols="10" rows="5"><?= $row['alamat'] ?></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">SImpan</button>
</form>
<script>
    $("#form-edit").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'proses.php?aksi=edit-supplier',
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