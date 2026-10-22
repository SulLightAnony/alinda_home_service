<?php
require '../../validate.php';

// Ambil semua input
$email       = htmlspecialchars($_POST['Email'] ?? '');
$province    = htmlspecialchars($_POST['Province'] ?? '');
$district    = htmlspecialchars($_POST['District'] ?? '');
$subdistrict = htmlspecialchars($_POST['Subdistrict'] ?? '');
$address     = htmlspecialchars($_POST['Address'] ?? '');
$googleMap   = htmlspecialchars($_POST['GoogleMap'] ?? '');
$image       = $_FILES['Image'] ?? null;

// Cek apakah ada yang kosong (selain gambar)
if (
    empty($email) ||
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

// Siapkan query update dasar
$sql = "UPDATE tbl_customers SET 
    Province = ?, 
    District = ?, 
    Subdistrict = ?, 
    Address = ?, 
    GoogleMap = ?";

// Cek jika ada file gambar yang diupload
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

// Bind parameter sesuai kondisi
if ($imagePath !== '') {
    $stmt->bind_param("sssssss", $province, $districtName, $subdistrict, $address, $googleMap, $imagePath, $email);
} else {
    $stmt->bind_param("ssssss", $province, $districtName, $subdistrict, $address, $googleMap, $email);
}

// Eksekusi dan redirect
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: ../../login.php");
exit;
?>