<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "app_home_service");
    if( !isset($_SESSION['Loged']) ){header("location: ../../login.php");}
?>