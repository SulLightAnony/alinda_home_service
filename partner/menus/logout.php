<?php
    session_start();
    session_destroy();

    include 'connection.php';

    $Email = $_GET['email'];
    $query = mysqli_query($conn, "UPDATE tbl_partners SET LoginStatus = 'FALSE', LoginKey = ''");
?>

<script>
    localStorage.removeItem("KenapaHarusAdaPerangDuniaKeTigaDisaatAkuMenjadiDewasa");
    window.location.href="login.php#login";
</script>