<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Custom styles for this template -->
    <link href="../../assets/css/app.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />


</head>

<body>
    <?php
    include '../../config.php';
    function bulan($inputbulan)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        return $bulan[(int) $inputbulan[1]];
    }
    if (isset($_GET['bulan'])) {
        $titlebulan = bulan($_GET['bulan']);
    } else {
        $titlebulan = bulan(date('m'));

    }
    function tanggal($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo & title -->

                        <div class="row">
                            <div class="col-md-8 text-center">
                                <h4 class="text-center mt-3 mb-3"><b>APOTIK GRAHA MEDIKA</b><br><b>JURNAL</b></h4>

                                <p><strong>Tanggal Cetak : </strong> <span class="">
                                        <?= date('d F Y'); ?></span></p>
                                <p><strong>Bulan : </strong> <span class=""><?= $titlebulan ?></span></strong>
                                    <span class="">
                            </div><!-- end col -->
                        </div>
                        <hr>
                        <!-- end row -->
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-centered">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Deskripsi</th>
                                                <th>Akun</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../../config.php";
                                            $debit = 0;
                                            $kredit = 0;
                                            if (isset($_GET['bulan'])) {
                                                $query = mysqli_query($conn, "SELECT * FROM jurnal WHERE MONTH(tanggal_transaksi) = '$_GET[bulan]' ORDER BY `tanggal_transaksi` ASC");

                                            } else {
                                                $query = mysqli_query($conn, "SELECT * FROM jurnal ORDER BY `tanggal_transaksi` ASC");

                                            }
                                            while ($data = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <td><?= tanggal($data['tanggal_transaksi']) ?></td>
                                                    <td><?= $data['deskripsi'] ?></td>
                                                    <td><?= $data['nama_akun'] ?></td>
                                                    <td>Rp. <?= number_format($data['debit'], 0, ',', '.') ?></td>
                                                    <td>Rp. <?= number_format($data['kredit'], 0, ',', '.') ?></td>

                                                </tr>
                                                <?php

                                                $debit += $data['debit'];
                                                $kredit += $data['kredit'];
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="3"><b>Total</b></td>
                                                <td>Rp. <?= number_format($debit, 0, ',', '.') ?></td>
                                                <td>Rp. <?= number_format($kredit, 0, ',', '.') ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>

    </div>




</body>
<script>

    window.print();
    window.onafterprint = window.close;
</script>

</html>