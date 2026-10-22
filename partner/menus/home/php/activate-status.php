<?php
    require '../../validate.php';

    $email = $_SESSION['EmailPartner'] ?? null;

    if (!$email) {
        header("Location: home.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM tbl_transaction WHERE PartnerEmail = ? AND Status = 'Berjalan'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['total'] > 0) {
        header("Location: home.php?NO-YOU-CANT");
        exit;
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM tbl_partners_skill WHERE PartnerEmail = ? AND Status = 'Sudah dikonfirmasi'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['total'] == 0) {
        header("Location: home.php?NO-YOU-CANT");
        exit;
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT Status FROM tbl_partners WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt->close();
        header("Location: home.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $currentStatus = $row['Status'];
    $stmt->close();

    $newStatus = ($currentStatus === "Sedang tidak dapat melayani") ? "Sedang dapat melayani" : "Sedang tidak dapat melayani";

    $stmt = $conn->prepare("UPDATE tbl_partners SET Status = ? WHERE Email = ?");
    $stmt->bind_param("ss", $newStatus, $email);
    $stmt->execute();
    $stmt->close();

    $_SESSION['StatusPartner'] = $newStatus;

    header("Location: home.php");
    exit;
?>