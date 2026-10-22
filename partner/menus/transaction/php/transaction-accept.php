<?php
require '../../validate.php';
date_default_timezone_set('Asia/Jakarta');

$id = $_GET['ID'] ?? null;

$emailPartner        = $_SESSION['EmailPartner']        ?? '';
$usernamePartner     = $_SESSION['UsernamePartner']     ?? '';
$phonePartner        = $_SESSION['PhoneNumberPartner']  ?? '';
$provincePartner     = $_SESSION['ProvincePartner']     ?? '';
$districtPartner     = $_SESSION['DistrictPartner']     ?? '';
$subdistrictPartner  = $_SESSION['SubdistrictPartner']  ?? '';
$addressPartner      = $_SESSION['AddressPartner']      ?? '';
$imagePartner        = $_SESSION['ImagePartner']        ?? '';
$accountNumber       = $_SESSION['AccountNumberPartner'] ?? '';
$agreedTimestamp     = date('Y-m-d H:i:s');

if (!$id || !$emailPartner) {
    header("Location: transaction.php");
    exit;
}

// Ambil IDPartner dari tbl_partners berdasarkan Email
$query = $conn->prepare("SELECT ID FROM tbl_partners WHERE Email = ?");
$query->bind_param("s", $emailPartner);
$query->execute();
$query->bind_result($idPartner);
$query->fetch();
$query->close();

// Ambil ProductName dan ProductStatus
$productQuery = $conn->prepare("SELECT ProductName, ProductStatus FROM tbl_transaction WHERE ID = ?");
$productQuery->bind_param("i", $id);
$productQuery->execute();
$productQuery->bind_result($productName, $productStatus);
$productQuery->fetch();
$productQuery->close();

// Tentukan status berdasarkan jenis transaksi
if (strtolower($productName) === "suruh apa saja" || strtolower($productStatus) === "suruh apa saja") {
    $status = "Menunggu konfirmasi pembayaran";
} else {
    $status = "Berjalan";
}

// Update tbl_transaction
$update = $conn->prepare("
    UPDATE tbl_transaction SET 
        PartnerID = ?, 
        PartnerUsername = ?, 
        PartnerEmail = ?, 
        PartnerPhoneNumber = ?, 
        PartnerProvince = ?, 
        PartnerDistrict = ?, 
        PartnerSubdistrict = ?, 
        PartnerAddress = ?, 
        PartnerImage = ?, 
        PartnerAccountNumber = ?, 
        PartnerAgreedTimestamp = ?, 
        Status = ?
    WHERE ID = ?
");
$update->bind_param(
    "isssssssssssi", 
    $idPartner, 
    $usernamePartner, 
    $emailPartner, 
    $phonePartner, 
    $provincePartner, 
    $districtPartner, 
    $subdistrictPartner, 
    $addressPartner, 
    $imagePartner, 
    $accountNumber, 
    $agreedTimestamp, 
    $status, 
    $id
);
$update->execute();
$update->close();

// Update status partner jadi tidak tersedia
$updateStatus = $conn->prepare("UPDATE tbl_partners SET Status = 'Sedang tidak dapat melayani' WHERE Email = ?");
$updateStatus->bind_param("s", $emailPartner);
$updateStatus->execute();
$updateStatus->close();

// Redirect
header("Location: transaction.php");
exit;
?>