<?php
require '../../validate.php';

$email        = htmlspecialchars($_POST['Email'] ?? '');
$username     = htmlspecialchars($_POST['Username'] ?? '');
$phoneNumber  = htmlspecialchars($_POST['PhoneNumber'] ?? '');
$province     = htmlspecialchars($_POST['Province'] ?? '');
$district     = htmlspecialchars($_POST['District'] ?? '');
$subdistrict  = htmlspecialchars($_POST['Subdistrict'] ?? '');
$address      = htmlspecialchars($_POST['Address'] ?? '');
$identification = htmlspecialchars($_POST['IdentificationNumber'] ?? '');
$bankName     = htmlspecialchars($_POST['BankName'] ?? '');
$accountNumber = htmlspecialchars($_POST['AccountNumber'] ?? '');

$image        = $_FILES['Image'] ?? null;
$imageCard    = $_FILES['ImageCard'] ?? null;

if (
    empty($email) || empty($username) || empty($phoneNumber) || empty($province) ||
    empty($district) || empty($subdistrict) || empty($address) ||
    empty($identification) || empty($bankName) || empty($accountNumber)
) {
    header("Location: form.php");
    exit;
}

$districtParts = explode('|', $district);
$districtName = $districtParts[1] ?? '';

$sql = "UPDATE tbl_partners SET 
    Username = ?, 
    PhoneNumber = ?, 
    Province = ?, 
    District = ?, 
    Subdistrict = ?, 
    Address = ?, 
    IdentificationNumber = ?, 
    BankName = ?, 
    AccountNumber = ?";

$params = [$username, $phoneNumber, $province, $districtName, $subdistrict, $address, $identification, $bankName, $accountNumber];
$types  = "sssssssss";

// Handle Profile Image
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $fileType = mime_content_type($image['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('profile_', true) . '.' . $ext;
        $uploadPath = "../../../../database/customer/image/profile/" . $newFileName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $sql .= ", Image = ?";
            $params[] = $uploadPath;
            $types .= "s";
        }
    }
}

// Handle ImageCard (KTP)
if ($imageCard && $imageCard['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $fileType = mime_content_type($imageCard['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        $ext = pathinfo($imageCard['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('card_', true) . '.' . $ext;
        $uploadPath = "../../../../database/customer/image/card/" . $newFileName;

        if (move_uploaded_file($imageCard['tmp_name'], $uploadPath)) {
            $sql .= ", ImageCard = ?";
            $params[] = $uploadPath;
            $types .= "s";
        }
    }
}

$sql .= " WHERE Email = ?";
$params[] = $email;
$types .= "s";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->close();
$conn->close();

$url = '../../login.php?target=profile';
header("Location: " . $url);
exit;
?>
