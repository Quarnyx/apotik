<!-- start page title -->
<?php
$maintitle = "Data";
$title = 'Data Pembelian';
?>
<?php include 'layouts/breadcrumb.php'; ?>
<!-- end page title -->
<button class="btn btn-primary mb-3" id="tambah">Tambah Pembelian</button>

<!-- end row-->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Histori Pembelian</h4>
                <div id="load-table">

                </div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->

<script>
    function loadTable() {
        $('#load-table').load('pages/pembelian/tabel-pembelian.php')
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').on('click', function () {
            $('.modal').modal('show');
            $('.modal-title').html('Tambah Pembelian');
            // load form
            $('.modal-body').load('pages/pembelian/tambah-pembelian.php');
        });
    });
</script>