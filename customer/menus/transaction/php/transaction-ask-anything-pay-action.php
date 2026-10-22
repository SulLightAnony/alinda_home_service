<?php
    require_once '../../validate.php';
    $target_dir = "../../../../database/customer/image/transfer/";

    $id = $_GET['id'] ?? null;
    if (!$id) {
        header("Location: transaction-detail.php?invalid_id");
        exit();
    }

    if (empty($_FILES['Image']['name'])) {
        header("Location: transaction-detail.php?NOPE");
        exit();
    }

    $imageFileType = strtolower(pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png'];
    if (!in_array($imageFileType, $allowedTypes)) {
        header("Location: transaction-detail.php?type=false");
        exit();
    }

    $newFileName = uniqid('transfer_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $newFileName;

    if (!move_uploaded_file($_FILES['Image']['tmp_name'], $target_file)) {
        header("Location: transaction-detail.php?upload=failed");
        exit();
    }

    $update = $conn->prepare("UPDATE tbl_transaction SET CustomerImageProve = ? WHERE ID = ?");
    $update->bind_param("si", $target_file, $id);
    $update->execute();
    $update->close();

    header("Location: transaction-detail.php?ID=" . $id);
    exit();
?>