<div class="container-fluid">

    <!-- start page title -->
    <?php
    $maintitle = "Data";
    $title = 'Data Supplier';
    ?>
    <?php include 'layouts/breadcrumb.php'; ?>
    <!-- end page title -->
    <button class="btn btn-primary mb-3" id="tambah">Tambah Supplier</button>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Data Supplier</h4>
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
        $('#tabel').load('pages/supplier/tabel-supplier.php');
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').click(function () {
            $('.modal').modal('show');
            $('.modal-title').text('Tambah Supplier');
            $('.modal-body').load('pages/supplier/tambah-supplier.php');
        });
    });
</script>