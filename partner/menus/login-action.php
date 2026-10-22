<?php
    session_start();
    include "connection.php";

    // Ambil input secara aman
    $Email = $_POST["Email"] ?? '';
    $pass  = $_POST["Password"] ?? '';

    // Validasi input kosong
    if (empty($Email) || empty($pass)) {
        header("Location: login.php#failed");
        exit;
    }

    // Siapkan statement SQL yang aman dari SQL Injection
    $stmt = $conn->prepare("SELECT * FROM tbl_partners WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($pass, $row['Password'])){
        // Set session
        $_SESSION['LogedPartner']       = true;
        $_SESSION['UsernamePartner']    = $row['Username'];
        $_SESSION['EmailPartner']       = $row['Email'];
        $_SESSION['PhoneNumberPartner'] = $row['PhoneNumber'];
        $_SESSION['ProvincePartner']    = $row['Province'];
        $_SESSION['DistrictPartner']    = $row['District'];
        $_SESSION['SubdistrictPartner'] = $row['Subdistrict'];
        $_SESSION['AddressPartner']     = $row['Address'];
        $_SESSION['IdentificationNumberPartner']    = $row['IdentificationNumber'];
        $_SESSION['ImageCardPartner']               = $row['ImageCard'];
        $_SESSION['BankNamePartner']                = $row['BankName'];
        $_SESSION['AccountNumberPartner']           = $row['AccountNumber'];
        $_SESSION['ImagePartner']       = $row['Image'];
        $_SESSION['SkillStatusPartner'] = $row['SkillStatus'];
        $_SESSION['StatusPartner']      = $row['Status'];

        // Buat login key
        $LoginStatus = "The Login Status Is Very True. Maybe.";
        $LoginKey = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 20);

        // Simpan LoginKey hanya untuk user ini
        $update = $conn->prepare("UPDATE tbl_partners SET LoginStatus = ?, LoginKey = ? WHERE Email = ?");
        $update->bind_param("sss", $LoginStatus, $LoginKey, $Email);
        $update->execute();
        $update->close();

        header("Location: login-autologin.php#$LoginKey");
    } else {
        header("Location: login.php#failed");
    }

    $stmt->close();
    $conn->close();
?>