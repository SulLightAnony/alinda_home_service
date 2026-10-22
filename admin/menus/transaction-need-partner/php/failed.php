<?php
    include '../../connection/Validate.php';

    $IndexPage = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
    $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $statusRejectedReason = htmlspecialchars($_POST['StatusRejectedReason']);
        $status = "Transaksi gagal";

        $query = "UPDATE tbl_transaction SET StatusRejectedReason = ?, Status = ? WHERE ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $statusRejectedReason, $status, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: index.php" . $IndexPage . $IndexSearch);
    exit;
?>