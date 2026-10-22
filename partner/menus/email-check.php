<?php 
    include "connection.php";
    $Email = $_GET['email'];
    $query = mysqli_query($conn, "SELECT * FROM tbl_partners WHERE Email = '$Email'");
    $data = mysqli_fetch_assoc($query);

    if($data){echo json_encode(true);}
    if(!$data){echo json_encode(false);}
?>