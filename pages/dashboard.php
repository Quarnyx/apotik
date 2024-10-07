<div class="container-fluid">

    <!-- start page title -->
    <?php
    $maintitle = "Symox";
    $title = 'Welcome !';
    include 'config.php';
    ?>
    <?php include 'layouts/breadcrumb.php'; ?>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="text-center py-3">
                        <ul class="bg-bubbles ps-0">
                            <li><i class="bx bx-grid-alt font-size-24"></i></li>
                            <li><i class="bx bx-tachometer font-size-24"></i></li>
                            <li><i class="bx bx-store font-size-24"></i></li>
                            <li><i class="bx bx-cube font-size-24"></i></li>
                            <li><i class="bx bx-cylinder font-size-24"></i></li>
                            <li><i class="bx bx-command font-size-24"></i></li>
                            <li><i class="bx bx-hourglass font-size-24"></i></li>
                            <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                            <li><i class="bx bx-coffee font-size-24"></i></li>
                            <li><i class="bx bx-polygon font-size-24"></i></li>
                        </ul>
                        <div class="main-wid position-relative">
                            <h3 class="text-white">APOTIK GRAHA MEDIKA</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-primary-subtle rounded">
                                    <i class="mdi mdi-shopping-outline text-primary font-size-24"></i>
                                </span>
                            </div>
                            <?php
                            $sql = "SELECT sum(harga_jual) as total FROM v_penjualan WHERE MONTH(tanggal_penjualan) = MONTH(CURRENT_DATE()) AND YEAR(tanggal_penjualan) = YEAR(CURRENT_DATE())";

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            }

                            ?>
                            <p class="text-muted mt-4 mb-0">Pendapatan Bulan ini</p>
                            <h4 class="mt-1 mb-0">Rp. <?= number_format($total) ?></h4>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-success-subtle rounded">
                                    <i class="mdi mdi-eye-outline text-success font-size-24"></i>
                                </span>
                            </div>
                            <?php
                            $sql = "SELECT count(id_penjualan) as total FROM penjualan WHERE MONTH(tanggal_penjualan) = MONTH(CURRENT_DATE()) AND YEAR(tanggal_penjualan) = YEAR(CURRENT_DATE())";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            }

                            ?>
                            <p class="text-muted mt-4 mb-0">Penjualan Produk Bulan ini</p>
                            <h4 class="mt-1 mb-0"><?= $total ?></h4>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-primary-subtle rounded">
                                    <i class="mdi mdi-rocket-outline text-primary font-size-24"></i>
                                </span>
                            </div>
                            <?php
                            $sql = "SELECT count(id_produk) as total FROM produk";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            } ?>
                            <p class="text-muted mt-4 mb-0">Total Produk</p>
                            <h4 class="mt-1 mb-0"><?= $total ?></h4>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-success-subtle rounded">
                                    <i class="mdi mdi-account-multiple-outline text-success font-size-24"></i>
                                </span>
                            </div>
                            <?php
                            $sql = "SELECT count(id_pengguna) as total FROM pengguna";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            } ?>
                            <p class="text-muted mt-4 mb-0">Total Pengguna</p>
                            <h4 class="mt-1 mb-0"><?= $total ?></h4>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <h5 class="card-title mb-0">Grafik Penjualan</h5>

                    </div>

                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div>
                                <div id="sales-statistics"
                                    data-colors='["#33a186","#eff1f3","#33a186","#eff1f3","#33a186","#3980c0","#33a186","#33a186","#33a186", "#33a186"]'
                                    class="apex-chart"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center">
                        <h5 class="card-title mb-0">Stok Produk</h5>

                    </div>
                </div>
                <div class="card-body pt-xl-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT SUM(jumlah) AS stok, kode_produk, nama_produk FROM v_inventory GROUP BY kode_produk ORDER BY stok DESC LIMIT 5";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        ?>
                                        <tr>
                                            <td><?= $row['kode_produk'] ?></td>
                                            <td><a href="javascript: void(0);" class="text-body"><?= $row['nama_produk'] ?></a>
                                            </td>
                                            <td>
                                                <i class="mdi mdi-circle font-size-10 me-1 align-middle text-secondary"></i>
                                                <?= $row['stok'] ?>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div> <!-- container-fluid -->
<?php
$sqljual = "SELECT
                YEAR(tanggal_penjualan) AS year,
                MONTH(tanggal_penjualan) AS month,
                COUNT(*) AS sales_count
            FROM
	            v_penjualan
                WHERE YEAR(tanggal_penjualan) = YEAR(CURDATE())
            GROUP BY year, month";
$sales_result = $conn->query($sqljual);
$sales_data = [];

if ($sales_result->num_rows > 0) {
    while ($row = $sales_result->fetch_assoc()) {
        $sales_data[] = $row;
    }
}
// Preparing data for ApexCharts
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$sales_counts = array_fill(0, 12, 0);  // Initialize an array with 12 zeros
foreach ($sales_data as $data) {
    $sales_counts[$data['month'] - 1] = $data['sales_count'];
}
?>
<script>
    function getChartColorsArray(chartId) {
        if (document.getElementById(chartId) !== null) {
            var colors = document.getElementById(chartId).getAttribute("data-colors");
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf("--") != -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(
                        newValue
                    );
                    if (color) return color;
                } else {
                    return newValue;
                }
            });
        }
    }
    //  Sales Statistics
    const salesCounts = <?php echo json_encode($sales_counts); ?>;
    const months = <?php echo json_encode($months); ?>;

    var barchartColors = getChartColorsArray("sales-statistics");
    var options = {
        series: [{
            data: salesCounts
        }],
        chart: {
            toolbar: {
                show: false,
            },
            height: 350,
            type: 'bar',
            events: {
                click: function (chart, w, e) {
                }
            }
        },
        plotOptions: {
            bar: {
                columnWidth: '70%',
                distributed: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        colors: barchartColors,
        xaxis: {
            categories: months,
            labels: {
                style: {
                    colors: barchartColors,
                    fontSize: '12px'
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#sales-statistics"), options);
    chart.render();
</script>