<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Partner Rejected List</title>

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
            <?php include "../../template/header.php"; ?>

            <!-- Content-->
            <div class="main-content">
                <div class = "developer-original-pagination-container">
                    <?php $id = $_GET['ID']; echo "<script>let id = '&ID=$id';</script>"; ?>
                    <abbr title="Refresh Page"><a href = "rejected.php?page=1&ID=<?= $id ?>"><button class = "refresh">&#8635;</button></a></abbr>
                    
                    <?php 
                        $id = $_GET['ID'];
                        echo "<script>let id = '&ID=$id';</script>";

                        $IndexPage = isset($_GET['page']) ? "&page=" . $_GET['page'] : null;
                        $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
                        $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
                        $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
                        $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

                        $data = mysqli_query($conn, "SELECT PartnerRejectedEmail, PartnerRejectedUsername, PartnerRejectedReason, PartnerRejectedTimestamp FROM tbl_transaction WHERE ID = '$id'");
                        $data = mysqli_fetch_assoc($data);

                        function split_or_single($string) {
                            return strpos($string, '|') !== false ? explode('|', $string) : [$string];
                        }

                        $arrID = split_or_single($data['PartnerRejectedEmail']);
                        $arrUsername = split_or_single($data['PartnerRejectedUsername']);
                        $arrReason = split_or_single($data['PartnerRejectedReason']);
                        $arrTimestamp = split_or_single($data['PartnerRejectedTimestamp']);

                        $maxLength = max(count($arrID), count($arrUsername), count($arrReason), count($arrTimestamp));
                    ?>

                    <div class="developer-original-pagination-container">
                        <div class="content">
                            <div class="buttons">
                                <a href="form.php?edit<?= $IndexPage . "&id=" . $id . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch ?>"><input type="button" value="Return"></a>
                            </div>

                            <div class="table">
                                <div>
                                    <table style="border-radius:8px;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Partner ID</th>
                                                <th>Partner Username</th>
                                                <th>Rejected Reason</th>
                                                <th>Rejected Timestamp</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php for($i = 0; $i < $maxLength; $i++): ?>
                                            <tr <?= ($i+1) % 2 == 0 ? "style='background:rgb(245, 245, 245);'" : "" ?>>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= $arrID[$i] ?? '-' ?></td>
                                                <td><?= $arrUsername[$i] ?? '-' ?></td>
                                                <td><?= $arrReason[$i] ?? '-' ?></td>
                                                <td><?= $arrTimestamp[$i] ?? '-' ?></td>
                                            </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="developer-original-blackbarrier hidden"></div>

                <div class="developer-original-modal-delete hidden">
                    <p>Yakin ingin menghapus data ini?</p>
                    <div>
                        <button>Tidak</button>
                        <button>Iya</button>
                    </div>
                </div>

                <div class="developer-original-modal-image hidden">
                    <img>
                </div>

                <div class="developer-original-modal-no-image hidden">
                    <p>Data tidak memiliki gambar</p>
                    <button>Oke😢</button>
                </div>

                <div class="developer-original-modal-systems hidden">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <?php include "../../template/javascipts.php"; ?>
    <script src = "../javascript/pagination.js"></script>
</body>

</html>