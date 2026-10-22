<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Admin Dashboard</title>

    <!-- Styles -->
    <?php include "../../template/styles.php"; ?>

    <link rel="stylesheet" href="../css/pagination.css">
</head>

<body class="animsition">
    <div class="page-wrapper" style="overflow-y: hidden;">
        <!-- Sidebar -->
        <?php include "../../template/navbar.php"; ?>

        <div class="page-container">
            <!-- Header -->
            <?php
                include "../../template/header.php";

                $customerTotal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS Total FROM tbl_customers"))['Total'];
                $partnerTotal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS Total FROM tbl_partners"))['Total'];
                
                $date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");

                if ($date === 'AllTime') {
                    $query = $conn->prepare("
                        SELECT SUM(CAST(REPLACE(REPLACE(AdminPrice, 'Rp', ''), '.', '') AS UNSIGNED)) AS Total
                        FROM tbl_transaction
                    ");
                } else {
                    $query = $conn->prepare("
                        SELECT SUM(CAST(REPLACE(REPLACE(AdminPrice, 'Rp', ''), '.', '') AS UNSIGNED)) AS Total
                        FROM tbl_transaction
                        WHERE DATE(CustomerOrderTimestamp) = ?
                    ");
                    $query->bind_param("s", $date);
                }
                $query->execute();
                $result = $query->get_result();
                $row = $result->fetch_assoc();
                $total = $row['Total'] ?? 0;
                $totalEarning = "Rp" . number_format($total, 0, ',', '.');
                $query->close();

                if ($date === 'AllTime') {
                    $query = $conn->prepare("
                        SELECT SUM(CAST(REPLACE(REPLACE(PartnerPrice, 'Rp', ''), '.', '') AS UNSIGNED)) AS Total
                        FROM tbl_transaction
                        WHERE StatusPayment = 'Sudah dibayar'
                    ");
                } else {
                    $query = $conn->prepare("
                        SELECT SUM(CAST(REPLACE(REPLACE(PartnerPrice, 'Rp', ''), '.', '') AS UNSIGNED)) AS Total
                        FROM tbl_transaction
                        WHERE DATE(CustomerOrderTimestamp) = ?
                        AND StatusPayment = 'Sudah dibayar'
                    ");
                    $query->bind_param("s", $date);
                }
                $query->execute();
                $result = $query->get_result();
                $row = $result->fetch_assoc();
                $total = $row['Total'] ?? 0;
                $totalOutcome = "Rp" . number_format($total, 0, ',', '.');
                $query->close();
            ?>

            <!-- Content-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div style="background:white; padding: 10px; border-radius:7px; margin-bottom:20px;">
                            <div class="row m-t-50">
                                <div class="col-sm-6 col-lg-6">
                                    <div class="overview-item overview-item--c1">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-account-o"></i>
                                                </div>
                                                <div class="text">
                                                    <h2>Total Customer</h2>
                                                    <span style="font-size:25px;"><?= $customerTotal ?></span>
                                                </div>
                                            </div>
                                            <div class="overview-chart">
                                                <canvas id="widgetChart1"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-6">
                                    <div class="overview-item overview-item--c2">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-account-o"></i>
                                                </div>
                                                <div class="text">
                                                    <h2>Total Partner</h2>
                                                    <span style="font-size:25px;"><?= $partnerTotal ?></span>
                                                </div>
                                            </div>
                                            <div class="overview-chart">
                                                <canvas id="widgetChart2"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="background:white; padding: 10px; border-radius:7px;">
                            <form method="get">
                                <input type="date" value="<?= isset($_GET['date']) ? $_GET['date'] : date("Y-m-d") ?>" name="date" style="position: relative; left:42%; transform:translateX(-50%); margin-top:20px; border:1px solid gray; border-radius:7px; padding:5px;">
                                <input type="submit" class="btn btn-primary" style="position: relative; left:39%; transform:translateX(-50%);">
                                <input type="button" class="btn btn-primary" style="position: relative; left:39%; transform:translateX(-50%);" value="All Time" id="AllTime">
                            </form>
                            <div class="row m-t-50">
                                <div class="col-sm-6 col-lg-6">
                                    <div class="overview-item overview-item--c3">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-money"></i>
                                                </div>
                                                <div class="text">
                                                    <h2>Total Pendapatan </h2>
                                                    <span><?= $totalEarning ?></span>
                                                </div>
                                            </div>
                                            <div class="overview-chart">
                                                <canvas id="widgetChart3"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-6">
                                    <div class="overview-item overview-item--c4">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-money"></i>
                                                </div>
                                                <div class="text">
                                                    <h2>Total Pengeluaran</h2>
                                                    <span><?= $totalOutcome ?></span>
                                                </div>
                                            </div>
                                            <div class="overview-chart">
                                                <canvas id="widgetChart4"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <?php include "../../template/javascipts.php"; ?>
    <script src = "../javascript/pagination.js"></script>
</body>

</html>