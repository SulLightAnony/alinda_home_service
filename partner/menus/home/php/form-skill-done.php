<?php
    require '../../validate.php';

    if (!isset($_GET['Email']) || !filter_var($_GET['Email'], FILTER_VALIDATE_EMAIL)) {
        header("Location: form-skill.php?error=invalid_email");
        exit;
    }

    $email = $_GET['Email'];
    $update = $conn->prepare("UPDATE tbl_partners SET SkillStatus = 'Existed' WHERE Email = ?");
    $update->bind_param("s", $email);
    $update->execute();
    $update->close();
    $conn->close();

    header("Location: ../../login.php");
    exit;
?>