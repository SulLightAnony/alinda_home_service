<?php
    include '../../connection/Validate.php';

    $IndexPage = isset($_GET['page']) ? "&page=" . $_GET['page'] : null;
    $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
    $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
    $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
    $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['ID'])) {
        $id = $_GET['ID'];
        $statusRejectedReason = htmlspecialchars($_POST['StatusRejectedReason']);
        $status = "Transaksi ditolak";

        $query = "UPDATE tbl_transaction SET StatusRejectedReason = ?, Status = ? WHERE ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $statusRejectedReason, $status, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: form.php?edit" . $IndexPage . "&id=" . $id . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch);
    exit;
?>