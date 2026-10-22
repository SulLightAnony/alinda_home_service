<?php
    require '../../validate.php';

    if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
        header("Location: form-product.php?error=invalid_id");
        exit;
    }

    $id = intval($_GET['ID']);
    $delete = $conn->prepare("DELETE FROM tbl_customers_product WHERE ID = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
    $delete->close();

    $conn->close();
    header("Location: form-product.php?deleted=true");
    exit;
?>
