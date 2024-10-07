<form id="tambah-supplier" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <label for="nama" class="form-label">Name Supplier</label>
            <input type="text" class="form-control" name="nama_supplier" id="nama" placeholder="Nama">
        </div>
        <div class="col-md-6">
            <label for="kontak" class="form-label">Kontak</label>
            <input type="text" class="form-control" name="kontak" id="kontak" placeholder="Kontak">
        </div>
    </div>
    <div class="row">
        <div class="col-md 12">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="" cols="10" rows="5"></textarea>
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