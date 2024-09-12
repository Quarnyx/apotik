<table id="tabel-data" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Kategori</th>
            <th>Nama Barang</th>
            <th>Tgl. Transaksi</th>
            <th>Harga Jual</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../config.php";
        $query = mysqli_query(mysql: $conn, query: "SELECT * FROM v_penjualan");
        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $data['kode_penjualan'] ?></td>
                <td><?= $data['kategori_obat'] ?></td>
                <td><?= $data['nama_produk'] ?></td>
                <td><?= $data['tanggal_penjualan'] ?></td>
                <td>Rp. <?= number_format($data['harga_jual'], 0, ',', '.') ?></td>
                <td><?= $data['jumlah'] ?></td>
                <td>Rp. <?= number_format($data['harga_jual'] * $data['jumlah'], 0, ',', '.') ?></td>
                <td>
                    <button data-id="<?= $data['id_penjualan'] ?>" data-kodetransaksi="<?= $data['kode_penjualan'] ?>"
                        id="delete" type="button" class="btn btn-danger">Delete</button>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#tabel-data').DataTable();
        $('#tabel-data').on('click', '#edit', function () {
            const id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'halaman/penjualan/edit-penjualan.php',
                data: 'id=' + id,
                success: function (data) {
                    $('.modal').modal('show');
                    $('.modal-title').html('Edit Data ' + name);
                    $('.modal .modal-body').html(data);
                }
            })
        });

        $('#tabel-data').on('click', '#delete', function () {
            const id_penjualan = $(this).data('id');
            const kodetransaksi = $(this).data('kodetransaksi');
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus transaksi ini? ', function () {
                $.ajax({
                    type: 'POST',
                    url: 'proses.php?aksi=hapus-penjualan',
                    data: {
                        id_penjualan: id_penjualan,
                        kodetransaksi: kodetransaksi
                    },
                    success: function (data) {
                        var response = JSON.parse(data);
                        if (response.status == 'success') {
                            alertify.success(response.message);
                            loadTable();
                        } if (response.status == 'error') {
                            alertify.error(response.message);
                        }
                    },
                    error: function (data) {
                        alertify.error('Gagal');
                    }
                })
            }, function () {
                alertify.error('Hapus dibatalkan');
            })
        });
    });
</script>