<form id="tambah-pembelian" enctype="multipart/form-data">
    <?php
    session_start();
    ?>
    <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id_pengguna']; ?>">
    <div class="row">
        <div class="col-lg-3">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Tanggal Pembelian</label>
                <input type="date" class="form-control" name="tanggal_pembelian" required>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Tanggal Kadaluarsa</label>
                <input type="date" class="form-control" name="tanggal_kadaluarsa" required>
            </div>
        </div>
        <?php
        require_once '../../config.php';
        $query = mysqli_query($conn, "SELECT MAX(kode_pembelian) AS kode_pembelian FROM pembelian");
        $data = mysqli_fetch_array($query);
        $max = $data['kode_pembelian'] ? substr($data['kode_pembelian'], 4, 3) : "000";
        $no = $max + 1;
        $char = "PBL-";
        $kode = $char . sprintf("%03s", $no);
        ?>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kode Pembelian</label>
                <input type="text" name="kode_pembelian" class="form-control" placeholder="Jumlah Transaksi"
                    value="<?= $kode; ?>" readonly required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Produk Obat</label>
                <select class="form-select" name="id_produk" id="produk" required>
                    <?php
                    $sql = "SELECT * FROM produk";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option data-hargabeli="' . $row['harga_beli'] . '" value="' . $row['id_produk'] . '">' . $row['kode_produk'] . ' - ' . $row['nama_produk'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Supplier</label>
                <select class="form-select" name="id_supplier" required>
                    <?php
                    $sql = "SELECT * FROM supplier";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_supplier'] . '">' . $row['nama_supplier'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Harga Beli</label>
                <input type="text" class="form-control" name="harga_beli" id="harga_beli" required readonly>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Jumlah Beli</label>
                <input type="number" class="form-control" name="jumlah" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Masuk ke</label>
                <select class="form-select" name="id_akun_debit" required>
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun WHERE jenis_akun = 'Aktiva Lancar' OR jenis_akun = 'Aktiva Tetap'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_akun'] . '">' . $row['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Dibayar dengan</label>
                <select class="form-select" name="id_akun_kredit" required>
                    <?php
                    require_once '../../config.php';

                    $sql = "SELECT * FROM akun WHERE jenis_akun = 'Aktiva Lancar' OR jenis_akun = 'Aktiva Tetap'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_akun'] . '">' . $row['nama_akun'] . '</option>';
                    }

                    ?>
                </select>
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
    $(document).ready(function () {
        $('#produk').on('change', function () {
            const id = $(this).val();
            const hargabeli = $(this).find(':selected').data('hargabeli');
            $('#harga_beli').val("Rp. " + hargabeli.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
        });

    })
    $("#tambah-pembelian").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'proses.php?aksi=tambah-pembelian',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status == 'success') {
                    alertify.success(response.message);
                    $(".modal").modal('hide');
                    loadTable();
                } if (response.status == 'error') {
                    alertify.error(response.message);
                }
            },
            error: function (data) {
                alertify.error('Gagal');
            }
        });
    });
</script>