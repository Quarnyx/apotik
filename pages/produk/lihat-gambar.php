<?php
include "../../config.php";
$sql = "SELECT * FROM produk WHERE id_produk = '$_POST[id]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<div class="card">
    <div class="card-body">
        <div class="text-center">
            <img src="<?php echo $row['foto'] ?>" alt="" class="img-fluid" width="300px" height="300px">
        </div>
        <div class="row">
            <form id="form-foto" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id_produk'] ?>">
                <div class="col-md-12">
                    <label for="ganti-foto" class="form-label">Ganti Foto</label>
                    <input type="file" class="form-control" name="foto" id="ganti-foto">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#form-foto").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'proses.php?aksi=edit-foto-produk',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Edit Foto Berhasil');

                } else {
                    alertify.error('Edit Foto Gagal');

                }
            },
            error: function (data) {
                alertify.error(data);
            }
        });
    });
</script>