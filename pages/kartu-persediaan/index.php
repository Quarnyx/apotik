<div class="container-fluid">
    <div class="row d-print-none">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pilih Produk</h5>
                </div><!-- end card header -->
                <?php
                include 'config.php';

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
                $daritanggal = "";
                $sampaitanggal = "";

                if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
                    $daritanggal = $_GET['dari_tanggal'];
                    $sampaitanggal = $_GET['sampai_tanggal'];
                }

                ?>
                <div class="card-body">
                    <form action="" method="get" class="row g-3">
                        <input type="hidden" name="page" value="kartu-persediaan">
                        <div class="col-md-6">
                            <label for="validationDefault01" class="form-label">Produk</label>
                            <select class="form-control" name="id">
                                <?php
                                $sqla = "SELECT * FROM produk";
                                $resulta = $conn->query($sqla);
                                if ($resulta->num_rows > 0) {
                                    while ($rowa = $resulta->fetch_assoc()) {
                                        echo "<option value='" . $rowa['id_produk'] . "'>" . $rowa['nama_produk'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Pilih</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div>
    </div>
    <!-- end row-->

    <!-- start page title -->
    <?php
    if (isset($_GET['id'])) {
        $sql = "SELECT
    pb.tanggal_masuk AS date,
    pb.kode_pembelian AS kode,
    pb.jumlah AS jumlah_beli,
    pb.harga_beli,
	pj.jumlah AS jumlah_jual,
    pj.harga_jual,
    pj.id_penjualan
    FROM pembelian pb
    LEFT JOIN penjualan pj ON pj.tanggal_penjualan = pb.tanggal_masuk AND pj.id_produk=pb.id_produk
    WHERE pb.id_produk = '$_GET[id]'
    UNION
    SELECT
    pj.tanggal_penjualan AS date,
    pj.kode_penjualan AS kode,
	pb.jumlah AS jumlah_beli,
    pb.harga_beli,
    pj.jumlah AS jumlah_jual,
    pj.harga_jual,
    pj.id_penjualan
    FROM penjualan pj
    LEFT JOIN pembelian pb ON pb.tanggal_masuk = pj.tanggal_penjualan AND pb.id_produk=pj.id_produk
    WHERE pj.id_produk = '$_GET[id]'
    ORDER BY date ASC";
        $result = $conn->query($sql);
        function countSameDates($result)
        {
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $dateCounts = [];
            foreach ($rows as $row) {
                $dateCounts[$row['date']] = isset($dateCounts[$row['date']]) ? $dateCounts[$row['date']] + 1 : 1;
            }

            return ['rows' => $rows, 'counts' => $dateCounts];
        }
        // Get the rows and counts
        $data = countSameDates($result);
        $rows = $data['rows'];
        $dateCounts = $data['counts'];

        // Reset pointer to use result set again
        $result->data_seek(0);
        // get product name from id
        $sqlProduct = "SELECT * FROM produk WHERE id_produk = '$_GET[id]'";
        $resultProduct = $conn->query($sqlProduct);
        $rowProduct = $resultProduct->fetch_assoc();
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="row align-self-center">
                        <div class="text-center d-flex align-items-center">
                            <div>
                                <img src="assets/images/logo-sm.png" width="100px" alt="brand" />
                            </div>
                            <div class="ms-3">
                                <h1>APOTEK</h1>
                                <h1><b>GRAHA MEDIKA</b></h1>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 text-center">
                            <h6>Jl. Lkr. Barat Ps. Kendal pasar No.5 Blok H, Pekauman, Pakauman, Kec. Kendal, Kabupaten
                                Kendal, Jawa Tengah 51314
                            </h6>
                        </div>
                    </div>
                    <hr style="border-width: 2px; border-color: black; border-style: solid;">
                    <h4 class="text-center mt-3 mb-3"><b>KARTU PERSEDIAAN</b>
                        <br>Produk : <?php echo $rowProduct['nama_produk']; ?>
                    </h4>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center align-content-center">Tanggal</th>
                                        <th rowspan="2" class="text-center align-content-center">Kode</th>
                                        <th colspan="3" class="text-center align-content-center">Masuk</th>
                                        <th colspan="5" class="text-center align-content-center">Keluar</th>
                                        <th colspan="2" class="text-center align-content-center">Persediaan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Dari Batch</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Total Keuntungan</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Total Harga</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $printedDates = [];
                                    $qtyBefore = 0;
                                    $totalBefore = 0;
                                    $qtyPurchase = 0;
                                    $totalPurchase = 0;
                                    $qtySales = 0;
                                    $totalSales = 0;
                                    foreach ($rows as $row) {
                                        ?>
                                        <tr>
                                            <?php
                                            if (!in_array($row['date'], $printedDates)) {
                                                // Print the date with rowspan
                                                echo "<td class='text-center align-content-center' rowspan='{$dateCounts[$row['date']]}'>{$row['date']}</td>";
                                                $printedDates[] = $row['date'];  // Mark this date as printed
                                            }
                                            ?>
                                            <td class="text-center"><?= $row['kode'] ?></td>
                                            <!-- get kode_pembelian from penjualan by kode_penjualan -->
                                            <?php

                                            $sqlKodePembelian = "SELECT kode_pembelian FROM penjualan WHERE id_penjualan = '{$row['id_penjualan']}'";
                                            $resultKodePembelian = $conn->query($sqlKodePembelian);
                                            $rowKodePembelian = $resultKodePembelian->fetch_assoc();
                                            if ($rowKodePembelian) {
                                                $sqlpembelian = "SELECT * FROM pembelian WHERE kode_pembelian = '{$rowKodePembelian['kode_pembelian']}'";
                                                $resultpembelian = $conn->query($sqlpembelian);
                                                $rowpembelian = $resultpembelian->fetch_assoc();
                                            }

                                            ?>
                                            <td class="text-center"><?= $row['jumlah_beli'] ?></td>
                                            <td class="text-center">
                                                <?php echo !empty($row['harga_beli']) ? "Rp. " . number_format($row['harga_beli'], 0, ',', '.') : 0; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo !empty($row['harga_beli']) ? "Rp. " . number_format($row['harga_beli'] * $row['jumlah_beli'], 0, ',', '.') : 0; ?>
                                            </td>
                                            <td class="text-center">
                                                <?= !empty($rowpembelian['tanggal_masuk']) ? $rowpembelian['tanggal_masuk'] : '-' ?>
                                            </td>
                                            <td class="text-center"><?= $row['jumlah_jual'] ?></td>
                                            <td class="text-center">
                                                <?php echo !empty($row['harga_jual']) ? "Rp. " . number_format($row['harga_jual'], 0, ',', '.') : 0; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo !empty($row['harga_jual']) ? "Rp. " . number_format($row['harga_jual'] * $row['jumlah_jual'], 0, ',', '.') : 0; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $harga_beli = isset($rowpembelian['harga_beli']) ? $rowpembelian['harga_beli'] : 0;
                                                $harga_jual = $row['harga_jual'];
                                                $totalProfit = ($harga_jual - $harga_beli) * $row['jumlah_jual'];
                                                echo "Rp. " . number_format($totalProfit, 0, ',', '.');
                                                ?>

                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $currentQty = $qtyBefore + $row['jumlah_beli'] - $row['jumlah_jual'];
                                                $qtyBefore = $currentQty;
                                                echo $currentQty;
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $currentTotal = $totalBefore + ($row['harga_beli'] * $row['jumlah_beli']) - ($row['harga_jual'] * $row['jumlah_jual']);
                                                $totalBefore = $currentTotal;
                                                echo "Rp. " . number_format($currentTotal, 0, ',', '.');
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $qtyPurchase += $row['jumlah_beli'];
                                        $qtySales += $row['jumlah_jual'];
                                        $totalPurchase += ($row['harga_beli'] * $row['jumlah_beli']);
                                        $totalSales += ($row['harga_jual'] * $row['jumlah_jual']);
                                    }
                                    ?>
                                    <tr style="font-weight: bold;">
                                        <td class="text-center align-content-center" colspan="2">Total</td>
                                        <td class="text-center"><?php echo $qtyPurchase; ?></td>
                                        <td></td>
                                        <td class="text-center">
                                            <?php echo "Rp. " . number_format($totalPurchase, 0, ',', '.'); ?>
                                        </td>
                                        <td></td>
                                        <td class="text-center"><?php echo $qtySales; ?></td>
                                        <td></td>
                                        <td class="text-center">
                                            <?php echo "Rp. " . number_format($totalSales, 0, ',', '.'); ?>
                                        </td>
                                        <td class="text-center"><?php echo $qtyBefore; ?></td>
                                        <td class="text-center">
                                            <?php echo "Rp. " . number_format($totalBefore, 0, ',', '.'); ?>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 mb-1">
                            <div class="text-end d-print-none">
                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-printer me-1"></i> Print</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
    ?>