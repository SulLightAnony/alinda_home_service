<?php
    require '../../validate.php';

    $product       = htmlspecialchars($_POST['Product'] ?? '');
    $productDetail = htmlspecialchars($_POST['ProductDetail'] ?? '');
    $email         = htmlspecialchars($_POST['Email'] ?? '');

    if (empty($product) || empty($productDetail) || empty($email)) {
        header("Location: form-product.php?error=empty");
        exit;
    }

    $parts = explode('|', $product);
    $productID = $parts[0] ?? '';
    $productName = $parts[1] ?? '';

    if (empty($productID) || empty($productName)) {
        header("Location: form-product.php?error=invalid_product");
        exit;
    }

    $insert = $conn->prepare("INSERT INTO tbl_customers_product (ProductID, ProductName, ProductDetail, CustomerEmail) VALUES (?, ?, ?, ?)");
    $insert->bind_param("isss", $productID, $productName, $productDetail, $email);
    $insert->execute();

    $insert->close();
    $conn->close();

    header("Location: form-product.php?success=true");
    exit;
?>