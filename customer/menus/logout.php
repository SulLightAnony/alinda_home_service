<?php
    session_start();
    session_destroy();

    include 'connection.php';

    $Email = $_GET['email'];
    $query = mysqli_query($conn, "UPDATE tbl_customers SET LoginStatus = 'FALSE', LoginKey = ''");
?>

<script>
    localStorage.removeItem("KrabbyPattyIsTheBestBurgerAfterDonsBurgerYeay");
    window.location.href="login.php#login";
</script>