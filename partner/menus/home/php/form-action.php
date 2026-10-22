<?php
    require '../../validate.php';

    // Ambil semua input
    $email       = htmlspecialchars($_POST['Email'] ?? '');
    $province    = htmlspecialchars($_POST['Province'] ?? '');
    $district    = htmlspecialchars($_POST['District'] ?? '');
    $subdistrict = htmlspecialchars($_POST['Subdistrict'] ?? '');
    $address     = htmlspecialchars($_POST['Address'] ?? '');
    $identificationNumber = htmlspecialchars($_POST['IdentificationNumber'] ?? '');
    $imageCard       = $_FILES['ImageCard'] ?? null;
    $bankName = htmlspecialchars($_POST['BankName'] ?? '');
    $accountNumber = htmlspecialchars($_POST['AccountNumber'] ?? '');
    $image       = $_FILES['Image'] ?? null;

    // Cek apakah ada yang kosong (selain gambar)
    if (
        empty($email) ||
        empty($province) ||
        empty($district) ||
        empty($subdistrict) ||
        empty($address) ||
        empty($identificationNumber) ||
        empty($imageCard) ||
        empty($bankName) ||
        empty($accountNumber)
    ) {
        header("Location: form.php");
        exit;
    }

    // Ekstrak data district jika menggunakan format "ID|Name"
    $districtParts = explode('|', $district);
    $districtName = $districtParts[1] ?? '';

    // Siapkan query update dasar
    $sql = "UPDATE tbl_partners SET 
        Province = ?, 
        District = ?, 
        Subdistrict = ?, 
        Address = ?,
        IdentificationNumber = ?,
        ImageCard = ?,
        BankName = ?,
        AccountNumber = ?";

    // Cek jika ada file gambar yang diupload
    $imagePath = '';
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = mime_content_type($image['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('profile_', true) . '.' . $ext;
            $uploadPath = "../../../../database/partner/image/profile/" . $newFileName;

            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                $sql .= ", Image = ?";
                $imagePath = $uploadPath;
            }
        }
    }

    $imageCardPath = '';
    if ($imageCard && $imageCard['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = mime_content_type($imageCard['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {
            $ext = pathinfo($imageCard['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('profile_', true) . '.' . $ext;
            $uploadPath = "../../../../database/partner/image/profile/" . $newFileName;

            if (move_uploaded_file($imageCard['tmp_name'], $uploadPath)) {
                $imageCardPath = $uploadPath;
            }
        }
    }

    $sql .= " WHERE Email = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameter sesuai kondisi
    if ($imagePath !== '') {
        $stmt->bind_param("ssssssssss", $province, $districtName, $subdistrict, $address, $identificationNumber, $imageCardPath, $bankName, $accountNumber, $imagePath, $email);
    } else {
        $stmt->bind_param("sssssssss", $province, $districtName, $subdistrict, $address, $identificationNumber, $imageCardPath, $bankName, $accountNumber, $email);
    }

    // Eksekusi dan redirect
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: ../../login.php");
    exit;
?>