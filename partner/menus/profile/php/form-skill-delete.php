<?php
    require '../../validate.php';
    $from = isset($_GET['from']) ? "../../home/php/" . $_GET['from'] . ".php" : "profile.php";

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
    $from = $from == "../../home/php/home.php" ? "?from=home" : "";
    header("Location: form-skill.php$from");
    exit;
?>
