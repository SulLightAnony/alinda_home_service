<?php
require_once '../../validate.php';
date_default_timezone_set("Asia/Jakarta");

// ====== STEP 1: Validasi & Insert Transaksi ======
$desc = trim($_POST['Description'] ?? '');
$subDesc = trim($_POST['Sub-Description'] ?? '');
$priceInput = trim($_POST['Price'] ?? '');

// Validasi input wajib
if ($desc === '' || $subDesc === '' || $priceInput === '') {
    header("Location: ask-anything.php?empty");
    exit();
}

// Escape input setelah validasi
$desc = htmlspecialchars($desc);
$subDesc = htmlspecialchars($subDesc);

// Gabungkan description
$productDetail = $desc . " | " . $subDesc;

// Generate kode transaksi otomatis
$dateToday = date("Ymd");
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randomStr = substr(str_shuffle($characters), 0, 20 - strlen($dateToday) - 1);
$code = $dateToday . '-' . $randomStr;

// Ambil data session customer
$username     = $_SESSION['Username'] ?? '';
$email        = $_SESSION['Email'] ?? '';
$phone        = $_SESSION['PhoneNumber'] ?? '';
$province     = $_SESSION['Province'] ?? '';
$district     = $_SESSION['District'] ?? '';
$subdistrict  = $_SESSION['Subdistrict'] ?? '';
$address      = $_SESSION['Address'] ?? '';
$customerImage= $_SESSION['Image'] ?? '';

// Hilangkan titik harga lalu tambahkan 15000
$priceClean = str_replace('.', '', $priceInput);
$priceInt   = intval($priceClean) + 15000;

// Set harga lain
$productPrice = "Rp" . number_format($priceInt, 0, ',', '.');
$adminPrice   = "Rp5.000";
$partnerPrice = "Rp" . number_format($priceInt + 10000, 0, ',', '.');

// Set field tetap
$productName   = "Suruh Apa Saja";
$productStatus = "Suruh Apa Saja";
$productImage  = "../../../../database/admin/image/product/Repair.png";

$timestamp   = date("Y-m-d H:i");
$date        = date("Y-m-d");
$dateExpired = date("Y-m-d", strtotime("+1 day"));
$status      = "Menunggu konfirmasi mitra";

// Insert transaksi baru
$insert = $conn->prepare("INSERT INTO tbl_transaction (
    Code, CustomerUsername, CustomerEmail, CustomerPhoneNumber,
    CustomerProvince, CustomerDistrict, CustomerSubdistrict, CustomerAddress,
    CustomerImage, CustomerOrderTimestamp,
    ProductName, ProductStatus, ProductPrice, ProductImage, ProductDetail, PartnerPrice, AdminPrice,
    Date, DateExpired, Status
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$insert->bind_param("ssssssssssssssssssss", 
    $code, $username, $email, $phone,
    $province, $district, $subdistrict, $address,
    $customerImage, $timestamp,
    $productName, $productStatus, $productPrice, $productImage, $productDetail, $partnerPrice, $adminPrice,
    $date, $dateExpired, $status
);

if (!$insert->execute()) {
    header("Location: product-order.php?db=false");
    exit();
}
$insert->close();

// Ambil ID transaksi terakhir
$transactionId = $conn->insert_id;


// ====== STEP 2: Cari & Assign Partner ======
$emails = [];
$stmt = $conn->prepare("SELECT Email FROM tbl_partners 
    WHERE Subdistrict = ? 
    AND Status = 'Sedang dapat melayani' 
    AND StatusApproval = 'Sudah dikonfirmasi'");
$stmt->bind_param("s", $subdistrict);
$stmt->execute();
$res = $stmt->get_result();

while ($r = $res->fetch_assoc()) {
    $emails[] = $r['Email'];
}
$stmt->close();

shuffle($emails); // Acak urutan email partner

if (!empty($emails)) {
    // Pilih partner random
    $partnerEmail = $emails[0];

    $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = ?, Status = ? WHERE ID = ?");
    $update->bind_param("ssi", $partnerEmail, $status, $transactionId);
    $update->execute();
    $update->close();
} else {
    // Tidak ada partner tersedia
    $status = "Menunggu konfirmasi mitra.";
    $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = '', Status = ? WHERE ID = ?");
    $update->bind_param("si", $status, $transactionId);
    $update->execute();
    $update->close();
}

// ====== Redirect ke transaksi ======
header("Location: ../../transaction/php/transaction.php");
exit;
?>