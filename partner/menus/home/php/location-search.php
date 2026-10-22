<?php
    include "../../validate.php";

    header('Content-Type: application/json');

    $data = [];

    if (isset($_GET['DistrictID']) && ctype_digit($_GET['DistrictID'])) {
        $districtID = $_GET['DistrictID'];

        $stmt = $conn->prepare("SELECT Name FROM tbl_subdistrict WHERE DistrictID = ?");
        $stmt->bind_param("i", $districtID);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row['Name'];
        }

        $stmt->close();
    }

    echo json_encode($data);

    $conn->close();
?>