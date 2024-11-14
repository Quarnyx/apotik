<table id="tabel-data" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Kode Pembelian</th>
            <th>Supplier</th>
            <th>Nama Barang</th>
            <th>Tgl. Return</th>
            <th>Harga Beli</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../config.php";
        $query = mysqli_query($conn, query: "SELECT * FROM v_return_pembelian");
        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $data['kode_pembelian'] ?></td>
                <td><?= $data['nama_supplier'] ?></td>
                <td><?= $data['nama_produk'] ?></td>
                <td><?= $data['tanggal_return'] ?></td>
                <td>Rp. <?= number_format($data['harga_beli'], 0, ',', '.') ?></td>
                <td><?= $data['jumlah'] ?></td>
                <td><?= $data['satuan'] ?></td>
                <td>Rp. <?= number_format($data['harga_beli'] * $data['jumlah'], 0, ',', '.') ?></td>
                <td>
                    <button data-id="<?= $data['id_return_pembelian'] ?>"
                        data-kodepembelian="<?= $data['kode_pembelian'] ?>" data-jumlah="<?= $data['jumlah'] ?>" id="delete"
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
            const id_return_pembelian = $(this).data('id');
            const kode_pembelian = $(this).data('kodepembelian');
            const jumlah = $(this).data('jumlah');
            console.log(kode_pembelian);
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus transaksi ini? ', function () {
                $.ajax({
                    type: 'POST',
                    url: 'proses.php?aksi=hapus-return-pembelian',
                    data: {
                        id_return_pembelian: id_return_pembelian,
                        kode_pembelian: kode_pembelian,
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