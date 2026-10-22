<?php
    require '../../connection/validate.php';

    $id = $_GET['id'] ?? null;
    $partnerEmail = $_GET['PartnerEmail'] ?? '';
    $page = $_GET['page'] ?? 1;

    if (!$id || !$partnerEmail) {
        header("Location: skill.php?PartnerEmail=$partnerEmail&page=$page&error=invalid");
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM tbl_partners_skill WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: skill.php?PartnerEmail=" . urlencode($partnerEmail) . "&page=" . intval($page));
    exit();
?>