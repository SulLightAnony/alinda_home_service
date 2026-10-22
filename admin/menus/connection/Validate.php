<?php
    session_start();
    include "../../connection/connection.php";
    if( !isset($_SESSION['Loged']) ){header("location: ../../Logout.php");}
    // if( !isset($_SESSION['Loged']) || (!isset($_SESSION['Level']) && $_SESSION['Level'] !== 'Administrator')){header("location: ../../../Logout.php");}
?>