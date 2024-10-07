<table id="table-data" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Supplier</th>
            <th>Kontak</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../../config.php';
        $no = 1;
        $sql = "SELECT * FROM supplier";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_supplier'] ?></td>
                <td><?= $row['kontak_supplier'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td>
                    <button id="edit" data-nama="<?= $row['nama_supplier'] ?>" data-id="<?= $row['id_supplier'] ?>"
                        class="btn btn-primary btn-sm">Edit</button>
                    <button id="delete" data-nama="<?= $row['nama_supplier'] ?>" data-id="<?= $row['id_supplier'] ?>"
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
                url: 'pages/supplier/edit-supplier.php',
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
                    url: 'proses.php?aksi=hapus-supplier',
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
    });
</script>