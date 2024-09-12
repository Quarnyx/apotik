<div class="container-fluid">

    <!-- start page title -->
    <?php
    $maintitle = "Data";
    $title = 'Data Produk';
    ?>
    <?php include 'layouts/breadcrumb.php'; ?>
    <!-- end page title -->
    <button class="btn btn-primary mb-3" id="tambah">Tambah Produk</button>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Data Produk</h4>
                </div><!-- end card header -->
                <div class="card-body" id="tabel">

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container-fluid -->
<script>
    function loadTable() {
        $('#tabel').load('pages/produk/tabel-produk.php');
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').click(function () {
            $('.modal').modal('show');
            $('.modal-title').text('Tambah Produk');
            $('.modal-body').load('pages/produk/tambah-produk.php');
        });
    });
</script>