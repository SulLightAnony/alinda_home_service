<?php
if (isset($_GET['excel'])) {
    include '../../connection/Validate.php';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Table-' . $_POST['TableName'] . '-Export.xls"');

    $output = fopen("php://output", "w");
    $columns = array_map('trim', explode(',', $_POST['TableColumns']));
    $result = mysqli_query($conn, $_POST['Database']);
    
    fwrite($output, implode("\t", $columns) . "\n");

    while ($row = mysqli_fetch_assoc($result)) {
        $data = [];
        foreach ($columns as $col) {
            if (array_key_exists($col, $row)) {
                $data[] = $row[$col] !== "" ? $row[$col] : "NULL";
            } else {
                $data[] = "INVALID_COL";
            }
        }
        fwrite($output, implode("\t", $data) . "\n");
    }

    fclose($output);
    exit;
}
?>