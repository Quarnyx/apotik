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
    <div class="d-grid gap-3">
        <div>
            <label for="nama" class="form-label">Name Supplier</label>
            <input type="text" class="form-control" name="nama_supplier" value="<?= $row['nama_supplier'] ?>" id="nama"
                placeholder="Nama">
        </div>
        <div>
            <label for="kontak" class="form-label">Kontak</label>
            <input type="text" class="form-control" name="kontak" id="kontak" value="<?= $row['kontak_supplier'] ?>"
                placeholder="Kontak">
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