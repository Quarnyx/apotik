<table id="table-data" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Satuan</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../../config.php';
        $no = 1;
        $sql = "SELECT * FROM produk";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['kode_produk'] ?></td>
                <td><?= $row['nama_produk'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= 'Rp. ' . number_format($row['harga_beli'], 0, ',', '.') ?></td>
                <td><?= 'Rp. ' . number_format($row['harga_jual'], 0, ',', '.') ?></td>
                <td>
                    <button id="lihat-gambar" data-nama="<?= $row['nama_produk'] ?>" data-id="<?= $row['id_produk'] ?>"
                        class="btn btn-primary btn-sm">Lihat Gambar</button>
                    <button id="edit" data-nama="<?= $row['nama_produk'] ?>" data-id="<?= $row['id_produk'] ?>"
                        class="btn btn-primary btn-sm">Edit</button>
                    <button id="delete" data-nama="<?= $row['nama_produk'] ?>" data-id="<?= $row['id_produk'] ?>"
                        class="btn btn-danger btn-sm">Hapus</button>

                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<script>

    $(document).ready(function () {
        $('#table-data').DataTable();
        $('#table-data').on('click', '#edit', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $.ajax({
                type: 'POST',
                url: 'pages/produk/edit-produk.php',
                data: 'id=' + id + '&nama=' + nama,
                success: function (data) {
                    $('.modal').modal('show');
                    $('.modal-title').html('Edit Data ' + nama);
                    $('.modal .modal-body').html(data);
                }
            })
        });
        $('#table-data').on('click', '#delete', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus data ' + nama + '?', function () {
                $.ajax({
                    type: 'POST',
                    url: 'proses.php?aksi=hapus-produk',
                    data: 'id=' + id,
                    success: function (data) {
                        if (data == "ok") {
                            loadTable();
                            $('.modal').modal('hide');
                            alertify.success('Supplier Berhasil Dihapus');

                        } else {
                            alertify.error('Supplier Gagal Dihapus');

                        }
                    },
                    error: function (data) {
                        alertify.error(data);
                    }
                })
            }, function () {
                alertify.error('Hapus dibatalkan');
            })
        });
        $('#table-data').on('click', '#lihat-gambar', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $.ajax({
                type: 'POST',
                url: 'pages/produk/lihat-gambar.php',
                data: 'id=' + id + '&nama=' + nama,
                success: function (data) {
                    $('.modal').modal('show');
                    $('.modal-title').html('Lihat Gambar ' + nama);
                    $('.modal .modal-body').html(data);
                }
            })
        });
    });
</script>