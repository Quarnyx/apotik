<table id="tabel-data" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Kode Pembelian</th>
            <th>Nama Barang</th>
            <th>Tgl. Return</th>
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
        $query = mysqli_query($conn, query: "SELECT * FROM v_return_penjualan order by id_return_penjualan desc");
        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $data['kode_penjualan'] ?></td>
                <td><?= $data['nama_produk'] ?></td>
                <td><?= $data['tanggal_return'] ?></td>
                <td>Rp. <?= number_format($data['harga_jual'], 0, ',', '.') ?></td>
                <td><?= $data['jumlah'] ?></td>
                <td><?= $data['satuan'] ?></td>
                <td>Rp. <?= number_format($data['harga_jual'] * $data['jumlah'], 0, ',', '.') ?></td>
                <td>
                    <button data-id="<?= $data['id_return_penjualan'] ?>"
                        data-kodepenjualan="<?= $data['kode_penjualan'] ?>" data-jumlah="<?= $data['jumlah'] ?>" id="delete"
                        type="button" class="btn btn-danger">Delete</button>
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
            const id_return_penjualan = $(this).data('id');
            const kode_penjualan = $(this).data('kodepenjualan');
            const jumlah = $(this).data('jumlah');
            console.log(kode_penjualan);
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus transaksi ini? ', function () {
                $.ajax({
                    type: 'POST',
                    url: 'proses.php?aksi=hapus-return-penjualan',
                    data: {
                        id_return_penjualan: id_return_penjualan,
                        kode_penjualan: kode_penjualan,
                        jumlah: jumlah
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