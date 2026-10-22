<?php
    require '../../validate.php';

    $email = $_SESSION['EmailPartner'] ?? '';
    $oldPassword = htmlspecialchars($_POST['PasswordOld'] ?? '');
    $newPassword = htmlspecialchars($_POST['PasswordNew'] ?? '');

    if (!$email || !$oldPassword || !$newPassword) {
        header("Location: form-password.php");
        exit;
    }

    $query = $conn->prepare("SELECT Password FROM tbl_partners WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    $query->close();

    if (!$user || !password_verify($oldPassword, $user['Password'])) {
        header("Location: form-password.php?false");
        exit;
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $update = $conn->prepare("UPDATE tbl_partners SET Password = ? WHERE Email = ?");
    $update->bind_param("ss", $hashedPassword, $email);
    $update->execute();
    $update->close();
    $conn->close();

    header("Location: profile.php");
    exit;
?>