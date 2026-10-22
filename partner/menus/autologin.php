<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "app_home_service");
    $loginkey = $_GET['LoginKey'];
    $query = mysqli_query($conn, "SELECT * FROM tbl_partners WHERE LoginKey = '$loginkey'");
    $data = mysqli_fetch_assoc($query);

    if($data)
    {

        if($data['LoginStatus'] != "The Login Status Is Very True. Maybe.")
        {
            echo "<script>window.location.href='login.php#login';</script>";
        }
        else if($data['LoginStatus'] == "The Login Status Is Very True. Maybe.")
        {
            $_SESSION['LogedPartner'] = true;
            $_SESSION['UsernamePartner'] = $data['Username'];
            $_SESSION['EmailPartner'] = $data['Email'];
            $_SESSION['PhoneNumberPartner'] = $data['PhoneNumber'];
            $_SESSION['ProvincePartner'] = $data['Province'];
            $_SESSION['DistrictPartner'] = $data['District'];
            $_SESSION['SubdistrictPartner'] = $data['Subdistrict'];
            $_SESSION['AddressPartner'] = $data['Address'];
            $_SESSION['IdentificationNumberPartner'] = $data['IdentificationNumber'];
            $_SESSION['ImageCardPartner'] = $data['ImageCard'];
            $_SESSION['BankNamePartner'] = $data['BankName'];
            $_SESSION['AccountNumberPartner'] = $data['AccountNumber'];
            $_SESSION['ImagePartner'] = $data['Image'];
            $_SESSION['SkillStatusPartner'] = $data['SkillStatus'];
            $_SESSION['StatusPartner']      = $data['Status'];

            $target = isset($_GET['target']) ? "profile" : "home";
            echo "<script>window.location.href='$target/php/$target.php';</script>";
        }
    }
    else 
    {
        echo "<script>window.location.href='login.php#login';</script>";
    }
?>