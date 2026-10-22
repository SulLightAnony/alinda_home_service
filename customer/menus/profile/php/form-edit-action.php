<?php
require '../../validate.php';

$email        = htmlspecialchars($_POST['Email'] ?? '');
$username     = htmlspecialchars($_POST['Username'] ?? '');
$phoneNumber  = htmlspecialchars($_POST['PhoneNumber'] ?? '');
$province     = htmlspecialchars($_POST['Province'] ?? '');
$district     = htmlspecialchars($_POST['District'] ?? '');
$subdistrict  = htmlspecialchars($_POST['Subdistrict'] ?? '');
$address      = htmlspecialchars($_POST['Address'] ?? '');
$googleMap    = htmlspecialchars($_POST['GoogleMap'] ?? '');
$image        = $_FILES['Image'] ?? null;

if (
    empty($email) ||
    empty($username) ||
    empty($phoneNumber) ||
    empty($province) ||
    empty($district) ||
    empty($subdistrict) ||
    empty($address)
) {
    header("Location: form.php");
    exit;
}

// Ekstrak data district jika menggunakan format "ID|Name"
$districtParts = explode('|', $district);
$districtName = $districtParts[1] ?? '';

// Query dasar dengan tambahan kolom GoogleMap
$sql = "UPDATE tbl_customers SET 
    Username = ?, 
    PhoneNumber = ?, 
    Province = ?, 
    District = ?, 
    Subdistrict = ?, 
    Address = ?, 
    GoogleMap = ?";

$imagePath = '';
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $fileType = mime_content_type($image['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('profile_', true) . '.' . $ext;
        $uploadPath = "../../../../database/customer/image/profile/" . $newFileName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $sql .= ", Image = ?";
            $imagePath = $uploadPath;
        }
    }
}

$sql .= " WHERE Email = ?";
$stmt = $conn->prepare($sql);

if ($imagePath !== '') {
    // Ada gambar baru
    $stmt->bind_param("sssssssss", $username, $phoneNumber, $province, $districtName, $subdistrict, $address, $googleMap, $imagePath, $email);
} else {
    // Tidak ada gambar baru
    $stmt->bind_param("ssssssss", $username, $phoneNumber, $province, $districtName, $subdistrict, $address, $googleMap, $email);
}

$stmt->execute();
$stmt->close();
$conn->close();

// Redirect sesuai kondisi
$url = isset($_GET['orderpage'])
    ? '../../login.php?orderpage&ID=' . $_GET['ID'] . '&search=' . $_GET['search']
    : '../../login.php?target=profile';
header("Location: " . $url);
exit;
?>