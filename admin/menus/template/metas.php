<?php
    include '../../connection/Validate.php';

    $notificationPartnerApproval = false;
    $notificationPartnerApprovalValue = 0;

    $notificationTransactionValue = 0;
    $notificationTransactionApproval = false;
    $notificationTransactionApprovalValue = 0;
    $notificationTransactionNeedPartner = false;
    $notificationTransactionNeedPartnerValue = 0;
    $notificationTransactionPartnerPayment = false;
    $notificationTransactionPartnerPaymentValue = 0;

    $data = mysqli_query($conn, "SELECT COUNT(StatusApproval) AS Result FROM tbl_partners WHERE StatusApproval = 'Belum dikonfirmasi'");
    $notificationPartnerApprovalValue = mysqli_fetch_assoc($data)['Result'];
    $notificationPartnerApproval = $notificationPartnerApprovalValue > 0 ? true : false;

    $data = mysqli_query($conn, "SELECT COUNT(Status) AS Result FROM tbl_transaction WHERE Status = 'Menunggu konfirmasi pembayaran'");
    $notificationTransactionApprovalValue = mysqli_fetch_assoc($data)['Result'];
    $notificationTransactionApproval = $notificationTransactionApprovalValue > 0 ? true : false;
    
    $data = mysqli_query($conn, "SELECT COUNT(Status) AS Result FROM tbl_transaction WHERE Status = 'Menunggu konfirmasi mitra.' OR Status = 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru.'");
    $notificationTransactionNeedPartnerValue = mysqli_fetch_assoc($data)['Result'];
    $notificationTransactionNeedPartner = $notificationTransactionNeedPartnerValue > 0 ? true : false;

    $data = mysqli_query($conn, "SELECT COUNT(Status) AS Result FROM tbl_transaction WHERE StatusPayment = 'Belum dibayar' AND (Status = 'Berjalan' OR Status = 'Selesai')");
    $notificationTransactionPartnerPaymentValue = mysqli_fetch_assoc($data)['Result'];
    $notificationTransactionPartnerPayment = $notificationTransactionPartnerPaymentValue > 0 ? true : false;

    $notificationTransactionValue = $notificationTransactionApprovalValue + $notificationTransactionNeedPartnerValue + $notificationTransactionPartnerPaymentValue;
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="au theme template">
<meta name="author" content="Hau Nguyen">
<meta name="keywords" content="au theme template">