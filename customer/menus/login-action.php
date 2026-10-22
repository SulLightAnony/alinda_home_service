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
    $stmt = $conn->prepare("SELECT * FROM tbl_customers WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($pass, $row['Password'])){
        // Set session
        $_SESSION['Loged']       = true;
        $_SESSION['Username']    = $row['Username'];
        $_SESSION['Email']       = $row['Email'];
        $_SESSION['PhoneNumber'] = $row['PhoneNumber'];
        $_SESSION['Province']    = $row['Province'];
        $_SESSION['District']    = $row['District'];
        $_SESSION['Subdistrict'] = $row['Subdistrict'];
        $_SESSION['Address']     = $row['Address'];
        $_SESSION['GoogleMap']   = $row['GoogleMap'];
        $_SESSION['Image']       = $row['Image'];
        $_SESSION['ProductStatus'] = $row['ProductStatus'];

        // Buat login key
        $LoginStatus = "The Login Status Is Very True. Maybe.";
        $LoginKey = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 20);

        // Simpan LoginKey hanya untuk user ini
        $update = $conn->prepare("UPDATE tbl_customers SET LoginStatus = ?, LoginKey = ? WHERE Email = ?");
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