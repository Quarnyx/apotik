<table id="tabel-data" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Kategori</th>
            <th>Nama Barang</th>
            <th>Tgl. Transaksi</th>
            <th>Harga Jual</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../config.php";
        $query = mysqli_query($conn, query: "SELECT sum(jumlah) AS jumlah, id_penjualan, kode_penjualan, kategori_obat, nama_produk, tanggal_penjualan, harga_jual, satuan FROM v_penjualan GROUP BY kode_penjualan ORDER BY `id_penjualan` DESC");
        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $data['kode_penjualan'] ?></td>
                <td><?= $data['kategori_obat'] ?></td>
                <td><?= $data['nama_produk'] ?></td>
                <td><?= $data['tanggal_penjualan'] ?></td>
                <td>Rp. <?= number_format($data['harga_jual'], 0, ',', '.') ?></td>
                <td><?= $data['jumlah'] ?></td>
                <td><?= $data['satuan'] ?></td>
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
        $('#tabel-data').DataTable(
            {
                responsive: true,
                order: [[0, 'desc']],
            }
        );
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