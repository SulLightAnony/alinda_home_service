<?php
    require '../../validate.php';
    $from = isset($_GET['from']) ? "../../home/php/" . $_GET['from'] . ".php" : "profile.php";

    $skill       = htmlspecialchars($_POST['SkillName'] ?? '');
    $skillStatus = htmlspecialchars($_POST['SkillStatus'] ?? '');
    $date        = date("d-m-Y");
    $username      = htmlspecialchars($_SESSION['UsernamePartner'] ?? '');
    $email       = htmlspecialchars($_POST['Email'] ?? '');

    if (empty($skill) || empty($skillStatus) || empty($email)) {
        header("Location: form-skill.php?error=empty");
        exit;
    }

    $parts = explode('|', $skill);
    $skillID = $parts[0] ?? '';
    $skillName = $parts[1] ?? '';

    if (empty($skillID) || empty($skillName)) {
        header("Location: form-skill.php?error=invalid_product");
        exit;
    }

    $insert = $conn->prepare("INSERT INTO tbl_partners_skill (SkillID, SkillName, SkillStatus, PartnerUsername, PartnerEmail, Date) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("isssss", $skillID, $skillName, $skillStatus, $username, $email, $date);
    $insert->execute();

    $insert->close();
    $conn->close();

    $from = $from == "../../home/php/home.php" ? "?from=home" : "";
    header("Location: form-skill.php$from");
    exit;
?>