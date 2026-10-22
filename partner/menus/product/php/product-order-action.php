<?php
    require_once '../../validate.php';

    $target_dir = "../../../../database/customer/image/transfer/";
    
    if (empty($_FILES['Image']['name'])) {
        header("Location: product-order.php?NOPE");
        exit();
    }

    $imageFileType = strtolower(pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'];
    if (!in_array($imageFileType, $allowedTypes)) {
        header("Location: product-order.php?type=false");
        exit();
    }

    $dateToday = date("Ymd");
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomStr = substr(str_shuffle($characters), 0, 20 - strlen($dateToday) - 1);
    $code = $dateToday . '-' . $randomStr;

    $username = $_SESSION['Username'] ?? '';
    $email = $_SESSION['Email'] ?? '';
    $phone = $_SESSION['PhoneNumber'] ?? '';
    $province = $_SESSION['Province'] ?? '';
    $district = $_SESSION['District'] ?? '';
    $subdistrict = $_SESSION['Subdistrict'] ?? '';
    $address = $_SESSION['Address'] ?? '';
    $customerImage = $_SESSION['Image'] ?? '';
    $productDetail = htmlspecialchars($_POST['ProductDetail'] ?? '-');
    $productStatus = htmlspecialchars($_GET['status'] == 'repairing' ? 'Repairing' : 'Cleaning');

    date_default_timezone_set("Asia/Jakarta");
    $timestamp = date("Y-m-d H:i");
    $date = date("Y-m-d");
    $dateExpired = date("Y-m-d", strtotime("+1 day"));

    $productID = $_GET['ID'] ?? '';
    $status = strtolower($_GET['status'] ?? '');

    $product = mysqli_query($conn, "SELECT * FROM tbl_admin_product WHERE ID = '$productID'");
    if (!$product || mysqli_num_rows($product) === 0) {
        header("Location: product-order.php?product=notfound");
        exit();
    }
    $row = mysqli_fetch_assoc($product);
    $productName = $row['Name'];
    $productImage = $row['Image'];

    if ($status === 'repairing') {
        $productPrice = $row['PriceRepair'];
        $partnerPrice = $row['PriceRepairPartner'];
        $adminPrice = $row['PriceRepairAdmin'];
    } else if ($status === 'cleaning') {
        $productPrice = $row['PriceClean'];
        $partnerPrice = $row['PriceCleanPartner'];
        $adminPrice = $row['PriceCleanAdmin'];
    } else {
        header("Location: product-order.php?status=invalid");
        exit();
    }

    $newFileName = '../../../../database/customer/image/transfer/' . uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $newFileName;

    if (!move_uploaded_file($_FILES['Image']['tmp_name'], $target_file)) {
        header("Location: product-order.php?upload=failed");
        exit();
    }

    $insert = mysqli_query($conn, "INSERT INTO tbl_transaction (
        Code, CustomerUsername, CustomerEmail, CustomerPhoneNumber,
        CustomerProvince, CustomerDistrict, CustomerSubdistrict, CustomerAddress,
        CustomerImage, CustomerImageProve, CustomerOrderTimestamp,
        ProductName, ProductStatus, ProductPrice, ProductImage, ProductDetail, PartnerPrice, AdminPrice,
        Date, DateExpired
    ) VALUES (
        '$code', '$username', '$email', '$phone',
        '$province', '$district', '$subdistrict', '$address',
        '$customerImage', '$newFileName', '$timestamp',
        '$productName', '$productStatus', '$productPrice', '$productImage', '$productDetail', '$partnerPrice', '$adminPrice',
        '$date', '$dateExpired')");

    if ($insert) {
        header("Location: ../../transaction/php/transaction.php");
        exit();
    } else {
        header("Location: product-order.php?db=false");
        exit();
    }
?>