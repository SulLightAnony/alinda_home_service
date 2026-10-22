<?php
    require '../../validate.php';

    $id = $_POST['ID'] ?? '';
    $reason = trim($_POST['StatusCanceledReason'] ?? '');

    if (strlen($reason) < 20) {
        header("Location: transaction-cancel.php");
        exit();
    }

    $sessionEmail = $_SESSION['Email'] ?? '';
    $sessionPhone = $_SESSION['PhoneNumber'] ?? '';

    $result = mysqli_query($conn, "SELECT CustomerEmail, CustomerPhoneNumber FROM tbl_transaction WHERE ID = '$id'");
    if (!$result || mysqli_num_rows($result) === 0) {
        header("Location: transaction.php?NOPE");
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $dbEmail = $row['CustomerEmail'];
    $dbPhone = $row['CustomerPhoneNumber'];

    if ($sessionEmail !== $dbEmail || $sessionPhone !== $dbPhone) {
        header("Location: transaction.php?NOPE");
        exit();
    }

    date_default_timezone_set("Asia/Jakarta");
    $timestamp = date("Y-m-d H:i");

    $query = mysqli_query($conn, "
        UPDATE tbl_transaction SET 
            Status = 'Transaksi dibatalkan oleh customer',
            StatusCanceledFrom = 'Customer',
            StatusCanceledTimestamp = '$timestamp',
            StatusCanceledReason = '$reason'
        WHERE ID = '$id'
    ");

    if ($query) {
        header("Location: transaction.php");
        exit();
    } else {
        header("Location: transaction.php?db=false");
        exit();
    }
?>