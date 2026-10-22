<?php
session_start();
include "../../connection/connection.php";
$user = ($_GET["username"]);
$pass = ($_GET["password"]);

$database = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE Username = '$user'");

while ($row = mysqli_fetch_array($database))
{
    if($row["Password"]==$pass)
    {
        $_SESSION['Username'] = $row["Username"];
        $_SESSION['Email'] = $row["Email"];
        $_SESSION['Loged'] = true;
        echo "I AM ATOMIC";
    }
    else
    {
        echo "I AM NOT ATOMIC";
    }
}
?>