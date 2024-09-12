<form id="tambah-supplier" enctype="multipart/form-data">
    <div class="d-grid gap-3">
        <div>
            <label for="nama" class="form-label">Name Supplier</label>
            <input type="text" class="form-control" name="nama_supplier" id="nama" placeholder="Nama">
        </div>
        <div>
            <label for="kontak" class="form-label">Kontak</label>
            <input type="text" class="form-control" name="kontak" id="kontak" placeholder="Kontak">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">SImpan</button>
</form>
<script>
    $("#tambah-supplier").submit(function (e) {
        var formData = new FormData(this);

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "proses.php?aksi=tambah-supplier",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Supplier Berhasil Ditambah');

                } else {
                    alertify.error('Supplier Gagal Ditambah');

                }
            }
        });
    });
</script>