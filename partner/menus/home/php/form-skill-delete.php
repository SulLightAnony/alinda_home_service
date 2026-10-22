<?php
    require '../../validate.php';

    if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
        header("Location: form-skill.php?error=invalid_id");
        exit;
    }

    $id = intval($_GET['ID']);
    $delete = $conn->prepare("DELETE FROM tbl_partners_skill WHERE ID = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
    $delete->close();

    $conn->close();
    header("Location: form-skill.php?deleted=true");
    exit;
?>
