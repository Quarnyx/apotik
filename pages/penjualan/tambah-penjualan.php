<form id="tambah-penjualan" enctype="multipart/form-data">
    <?php
    session_start();
    ?>
    <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id_pengguna']; ?>">
    <div class="row">
        <?php
        require_once '../../config.php';
        $query = mysqli_query($conn, "SELECT MAX(kode_penjualan) AS kode_penjualan FROM penjualan");
        $data = mysqli_fetch_array($query);
        $max = $data['kode_penjualan'] ? substr($data['kode_penjualan'], 4, 3) : "000";
        $no = $max + 1;
        $char = "INV-";
        $kode = $char . sprintf("%03s", $no);
        ?>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Kode Penjualan</label>
                <input type="text" name="kode_penjualan" class="form-control" placeholder="Kode Penjualan"
                    value="<?= $kode; ?>" readonly required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Tanggal Penjualan</label>
                <input type="date" class="form-control" name="tanggal_penjualan" value="<?= date('Y-m-d'); ?>" required>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="simpleinput" class="form-label">Produk Obat</label>
                        <select id="produk" class="form-select" name="id_produk" required>
                            <?php
                            $sql = "SELECT SUM(jumlah) AS stok, id_produk, nama_produk, kode_produk, harga_jual, harga_beli FROM v_inventory GROUP BY id_produk ORDER BY id_produk";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<option data-stok="' . $row['stok'] . '" data-harga="' . $row['harga_jual'] . '" data-hargabeli="' . $row['harga_beli'] . '" value="' . $row['id_produk'] . '">' . $row['kode_produk'] . ' - ' . $row['nama_produk'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="simpleinput" class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stok" id="stok" readonly required>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Jumlah Beli</label>
                <input type="number" class="form-control" name="jumlah" id="jumlah_beli" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Harga</label>
                <input type="text" class="form-control" name="harga_jual" id="harga" required readonly>
                <input type="hidden" name="harga_beli" id="harga_beli">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="simpleinput" class="form-label">Kategori Obat</label>
                <select class="form-select" name="kategori_obat" required>
                    <option value="Resep Dokter">Resep Dokter</option>
                    <option value="Bukan Resep">Bukan Resep</option>
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
            const harga = $(this).find(':selected').data('harga');
            const hargabeli = $(this).find(':selected').data('hargabeli');
            $('#stok').val($(this).find(':selected').data('stok'));
            $('#harga_beli').val(hargabeli);
            $('#harga').val("Rp. " + harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
        });

        $('#jumlah_beli').on('change', function () {
            const stok = $('#stok').val();
            const jumlah = $('#jumlah_beli').val();
            if (parseInt(jumlah) > parseInt(stok)) {
                alertify.error('Stok Tidak Mencukupi');
                $('#jumlah_beli').val('');
            }
        });

    })
    $("#tambah-penjualan").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'proses.php?aksi=tambah-penjualan',
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