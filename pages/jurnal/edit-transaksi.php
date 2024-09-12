<?php
require_once '../../config.php';
$sql = "SELECT * FROM transaksi WHERE id_transaksi = '$_POST[id]'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<form id="edit-transaksi" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Tanggal Transaski</label>
                <input type="date" class="form-control" name="tanggal_transaksi"
                    value="<?= $row['tanggal_transaksi'] ?>">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Jumlah Transaksi</label>
                <input type="number" name="total" class="form-control" placeholder="Jumlah Transaksi"
                    value="<?= $row['total'] ?>">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Akun Debit</label>
                <select class="form-select" name="id_akun_debit">
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun";
                    $result = $conn->query($sql);
                    while ($rowa = $result->fetch_assoc()) {
                        echo '<option value="' . $rowa['id_akun'] . '"' . ($rowa['id_akun'] == $row['id_akun_debit'] ? 'selected' : '') . '>' . $rowa['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Akun Kredit</label>
                <select class="form-select" name="id_akun_kredit">
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun";
                    $result = $conn->query($sql);
                    while ($rowb = $result->fetch_assoc()) {
                        echo '<option value="' . $rowb['id_akun'] . '"' . ($rowb['id_akun'] == $row['id_akun_kredit'] ? 'selected' : '') . '>' . $rowb['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="mb-3">
                <label for="" class="form-label">Catatan</label>
                <textarea class="form-control" name="deskripsi" id="" cols="10"
                    rows="5"><?php echo $row['deskripsi'] ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

<script>
    $("#edit-transaksi").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'proses.php?aksi=edit-transaksi',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $(".modal").modal('hide');
                loadTable();

                // alertify pesan sukses
                alertify.success('Pelanggan Berhasil Diedit');

            },
            error: function (data) {
                alertify.error(data);
            }
        });
    });
</script>