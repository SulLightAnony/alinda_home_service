<?php
    include "../../connection/Validate.php";

    $id = $_GET['ID'];
    $status = $_GET['Status'] == "Sudah dikonfirmasi" ? "Belum dikonfirmasi" : "Sudah dikonfirmasi" ;
    $dateApproved = $_GET['Status'] == "Sudah dikonfirmasi" ? "" : date("Y-m-d");
    $query = "UPDATE tbl_partners_skill SET Status = ?, DateApproved = ? WHERE ID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $status, $dateApproved, $id);
    
    $RedirectURL = "skill.php";

    $indexPartnerEmail = isset($_GET['PartnerEmail']) ? "?PartnerEmail=" . $_GET['PartnerEmail'] : null;
    $IndexPage = isset($_GET['page']) ? "&page=" . $_GET['page'] : null;
    $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
    $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
    $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
    $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

    if ($stmt->execute()) {
        echo "<script>window.location.href = '" . $RedirectURL . $indexPartnerEmail . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch . "';</script>";
        exit();
    } else {
        echo "Gagal mengedit user: " . $stmt->error;
    } 

    $stmt->close();
    $conn->close();
?>