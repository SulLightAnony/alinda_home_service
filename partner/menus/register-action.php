<?php
    session_start();
    include "connection.php";

    // Ambil data input
    $Username     = $_POST['Username'] ?? '';
    $Email        = $_POST['Email'] ?? '';
    $PhoneNumber  = $_POST['PhoneNumber'] ?? '';
    $Password     = $_POST['Password'] ?? '';
    $RegisterDate = date("d-m-Y");

    // Cek input kosong
    if (empty($Username) || empty($Email) || empty($PhoneNumber) || empty($Password)) {
        header("Location: register.php");
        exit;
    }

    // Format nomor telepon ke format internasional
    $Number = preg_replace('/[^0-9]/', '', $PhoneNumber);
    $PhoneNumber = (substr($Number, 0, 1) === '0') ? '62' . substr($Number, 1) : $Number;

    // Cek apakah email sudah terdaftar
    $stmt = $conn->prepare("SELECT Email FROM tbl_partners WHERE LOWER(Email) = LOWER(?)");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        header("Location: register.php?error=email_taken");
        exit;
    }
    $stmt->close();

    // Hash password dengan algoritma default (saat ini bcrypt)
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Siapkan Login Status dan Key
    $LoginStatus = "The Login Status Is Very True. Maybe.";
    $LoginKey = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 20);

    // Simpan ke database
    $insert = $conn->prepare("INSERT INTO tbl_partners (Username, Email, PhoneNumber, Password, LoginStatus, LoginKey, RegisterDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssssss", $Username, $Email, $PhoneNumber, $hashedPassword, $LoginStatus, $LoginKey, $RegisterDate);
    $insert->execute();
    $insert->close();

    // Set session
    $_SESSION['LogedPartner']       = true;
    $_SESSION['UsernamePartner']    = $Username;
    $_SESSION['EmailPartner']       = $Email;
    $_SESSION['PhoneNumberPartner'] = $PhoneNumber;
?>

<script>
    localStorage.setItem("KenapaHarusAdaPerangDuniaKeTigaDisaatAkuMenjadiDewasa", <?= json_encode($LoginKey) ?>);
    window.location.href = "home/php/home.php";
</script>