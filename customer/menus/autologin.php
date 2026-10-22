<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "app_home_service");
    $loginkey = $_GET['LoginKey'];
    $query = mysqli_query($conn, "SELECT * FROM tbl_customers WHERE LoginKey = '$loginkey'");
    $data = mysqli_fetch_assoc($query);
    

    if($data)
    {

        if($data['LoginStatus'] != "The Login Status Is Very True. Maybe.")
        {
            echo "<script>window.location.href='login.php#login';</script>";
        }
        else if($data['LoginStatus'] == "The Login Status Is Very True. Maybe.")
        {
            $_SESSION['Loged'] = true;
            $_SESSION['Username'] = $data['Username'];
            $_SESSION['Email'] = $data['Email'];
            $_SESSION['PhoneNumber'] = $data['PhoneNumber'];
            $_SESSION['Province'] = $data['Province'];
            $_SESSION['District'] = $data['District'];
            $_SESSION['Subdistrict'] = $data['Subdistrict'];
            $_SESSION['Address'] = $data['Address'];
            $_SESSION['GoogleMap'] = $data['GoogleMap'];
            $_SESSION['Image'] = $data['Image'];
            $_SESSION['ProductStatus'] = $data['ProductStatus'];

            if(isset($_GET['orderpage']))
            {
                echo "<script>window.location.href='product/php/product-order.php?orderpage&ID=" . $_GET["ID"] . "&search=" . $_GET["search"] . "';</script>";
            }
            else
            {
                $target = isset($_GET['target']) ? $_GET['target'] : 'home';
                echo "<script>window.location.href='$target/php/$target.php';</script>";
            }
        }
    }
    else 
    {
        echo "<script>window.location.href='login.php#login';</script>";
    }
?>