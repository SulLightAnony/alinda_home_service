<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "app_home_service");
    if( !isset($_SESSION['LogedPartner']) ){header("location: ../../login.php");}
?>