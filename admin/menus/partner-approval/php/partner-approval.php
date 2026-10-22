<?php
    include "../../connection/Validate.php";

    $id = $_GET['id'];
    $statusApproval = 'Sudah dikonfirmasi';
    $dateApproval = date("Y-m-d");
    $query = "UPDATE tbl_partners SET StatusApproval = ?, ApprovalDate = ? WHERE ID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $statusApproval, $dateApproval, $id);
    
    $RedirectURL = "index.php";

    $IndexPage = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
    $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
    $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
    $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
    $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

    if ($stmt->execute()) {
        echo "<script>window.location.href = '" . $RedirectURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch . "';</script>";
        exit();
    } else {
        echo "Gagal mengedit user: " . $stmt->error;
    } 

    $stmt->close();
    $conn->close();
?>