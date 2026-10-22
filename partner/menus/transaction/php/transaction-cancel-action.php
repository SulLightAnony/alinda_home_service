<?php
session_start();
require '../../validate.php';
date_default_timezone_set('Asia/Jakarta');

// Ambil data
$id = $_POST['ID'] ?? null;
$reason = $_POST['StatusCanceledReason'] == '' ? '-' : $_POST['StatusCanceledReason'];
$emailPartner = $_SESSION['EmailPartner'] ?? '';
$usernamePartner = $_SESSION['UsernamePartner'] ?? '';
$timestamp = date("Y-m-d H:i:s");

// Handle gambar bukti
$imagePath = '';
if (isset($_FILES['StatusCanceledImageProve']) && $_FILES['StatusCanceledImageProve']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['StatusCanceledImageProve'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $fileType = mime_content_type($image['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('cancel_proof_', true) . '.' . $ext;
        $uploadPath = "../../../../database/partner/image/canceled-image-prove/" . $newFileName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $imagePath = $uploadPath;
        }
    }
}

if (!$id || !$reason || !$emailPartner || !$usernamePartner) {
    header("Location: transaction.php");
    exit;
}

// Ambil data lama
$query = $conn->prepare("SELECT PartnerCanceledEmail, PartnerCanceledUsername, PartnerCanceledReason, PartnerCanceledTimestamp, PartnerCanceledImageProve FROM tbl_transaction WHERE ID = ?");
$query->bind_param("i", $id);
$query->execute();
$query->bind_result($emails, $usernames, $reasons, $timestamps, $images);
$query->fetch();
$query->close();

$isEmpty = empty($emails) || $emails === "-";

if ($isEmpty) {
    $newEmails = $emailPartner;
    $newUsernames = $usernamePartner;
    $newReasons = $reason;
    $newTimestamps = $timestamp;
    $newImages = $imagePath;
} else {
    $newEmails = $emails . "|" . $emailPartner;
    $newUsernames = $usernames . "|" . $usernamePartner;
    $newReasons = $reasons . "|" . $reason;
    $newTimestamps = $timestamps . "|" . $timestamp;
    $newImages = $images . ($imagePath ? "|$imagePath" : "");
}

$update = $conn->prepare("UPDATE tbl_transaction SET PartnerCanceledEmail=?, PartnerCanceledUsername=?, PartnerCanceledReason=?, PartnerCanceledTimestamp=?, PartnerCanceledImageProve=? WHERE ID=?");
$update->bind_param("sssssi", $newEmails, $newUsernames, $newReasons, $newTimestamps, $newImages, $id);
$update->execute();
$update->close();

// Ambil data produk dan lokasi
$result = $conn->query("SELECT CustomerSubdistrict, ProductStatus, ProductName FROM tbl_transaction WHERE ID = '$id'");
$row = $result->fetch_assoc();
$subdistrict = $row['CustomerSubdistrict'];
$productStatus = $row['ProductStatus'];
$productName = $row['ProductName'];

// Ambil partner yang belum pernah cancel
$emails = [];
$sql = "SELECT Email FROM tbl_partners WHERE Subdistrict = ? AND Status = 'Sedang dapat melayani' AND StatusApproval = 'Sudah dikonfirmasi'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $subdistrict);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    if (!in_array($r['Email'], explode('|', $newEmails))) {
        $emails[] = $r['Email'];
    }
}
$stmt->close();

shuffle($emails);
$found = false;

// ✅ Skip validasi skill jika Suruh Apa Saja
if (strtolower($productName) === "suruh apa saja" || strtolower($productStatus) === "suruh apa saja") {
    if (!empty($emails)) {
        $partnerEmail = $emails[0];
        $newStatus = "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru";
        $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = ?, Status = ? WHERE ID = ?");
        $update->bind_param("ssi", $partnerEmail, $newStatus, $id);
        $update->execute();
        $update->close();
        $found = true;
    }
} else {
    // 🔍 Normal: cek skill
    foreach ($emails as $email) {
        $skills = $conn->prepare("SELECT SkillStatus, SkillName FROM tbl_partners_skill WHERE PartnerEmail = ? AND Status = 'Sudah dikonfirmasi'");
        $skills->bind_param("s", $email);
        $skills->execute();
        $result = $skills->get_result();

        while ($skill = $result->fetch_assoc()) {
            if (
                strtolower(trim($skill['SkillName'])) == strtolower(trim($productName))
            ) {
                $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = ?, Status = ? WHERE ID = ?");
                $newStatus = "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru";
                $update->bind_param("ssi", $email, $newStatus, $id);
                $update->execute();
                $update->close();
                $found = true;

                $partnerUpdate = $conn->prepare("UPDATE tbl_partners SET Status = ? WHERE Email = ?");
                $partnerStatus = "Sedang tidak dapat melayani";
                $partnerUpdate->bind_param("ss", $partnerStatus, $email);
                $partnerUpdate->execute();
                $partnerUpdate->close();
                
                $_SESSION['StatusPartner'] = "Sedang tidak dapat melayani";
                break 2;
            }
        }
        $skills->close();
    }
}

if (!$found) {
    $updateStatus = $conn->prepare("UPDATE tbl_transaction SET Status = ?, PartnerEmail = '' WHERE ID = ?");
    $status = "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru.";
    $updateStatus->bind_param("si", $status, $id);
    $updateStatus->execute();
    $updateStatus->close();
}

// Update status partner agar bisa ambil order lagi
$partnerUpdate = $conn->prepare("UPDATE tbl_partners SET Status = ? WHERE Email = ?");
$partnerStatus = "Sedang dapat melayani";
$partnerUpdate->bind_param("ss", $partnerStatus, $emailPartner);
$partnerUpdate->execute();
$partnerUpdate->close();

$_SESSION['StatusPartner'] = "Sedang dapat melayani";

// Hapus semua baris chatroom sesuai ChatRoom
$chatroom = $_SESSION['Chatroom-Partner'];
$deleteChatroom = $conn->prepare("DELETE FROM tbl_chatroom WHERE ChatRoom = ?");
$deleteChatroom->bind_param("s", $chatroom);
$deleteChatroom->execute();
$deleteChatroom->close();

header("Location: transaction.php");
exit;