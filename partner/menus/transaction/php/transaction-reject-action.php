<?php
require '../../validate.php';
date_default_timezone_set('Asia/Jakarta');

// Ambil data
$id = $_GET['ID'] ?? null;
$reason = $_GET['StatusRejectedReason'] == '' ? '-' : $_GET['StatusRejectedReason'];
$emailPartner = $_SESSION['EmailPartner'] ?? '';
$usernamePartner = $_SESSION['UsernamePartner'] ?? '';
$timestamp = date("Y-m-d H:i:s"); 

if (!$id || !$reason || !$emailPartner || !$usernamePartner) {
    header("Location: transaction.php");
    exit;
}

// Ambil data saat ini dari transaction
$query = $conn->prepare("SELECT PartnerRejectedEmail, PartnerRejectedUsername, PartnerRejectedReason, PartnerRejectedTimestamp FROM tbl_transaction WHERE ID = ?");
$query->bind_param("i", $id);
$query->execute();
$query->bind_result($rejectedEmails, $rejectedUsernames, $rejectedReasons, $rejectedTimestamps);
$query->fetch();
$query->close();

// ✅ Tambahkan logika: jika masih kosong atau hanya "-", anggap kosong
$isEmpty = empty($rejectedEmails) || $rejectedEmails === "-";

// Update kolom reject
if ($isEmpty) {
    $newEmails = $emailPartner;
    $newUsernames = $usernamePartner;
    $newReasons = $reason;
    $newTimestamps = $timestamp;
} else {
    $newEmails = $rejectedEmails . "|" . $emailPartner;
    $newUsernames = $rejectedUsernames . "|" . $usernamePartner;
    $newReasons = $rejectedReasons . "|" . $reason;
    $newTimestamps = $rejectedTimestamps . "|" . $timestamp;
}

$update = $conn->prepare("UPDATE tbl_transaction SET PartnerRejectedEmail=?, PartnerRejectedUsername=?, PartnerRejectedReason=?, PartnerRejectedTimestamp=? WHERE ID=?");
$update->bind_param("ssssi", $newEmails, $newUsernames, $newReasons, $newTimestamps, $id);
$update->execute();
$update->close();

// Ambil subdistrict customer dan product data
$result = $conn->query("SELECT CustomerSubdistrict, ProductStatus, ProductName FROM tbl_transaction WHERE ID = '$id'");
$row = $result->fetch_assoc();
$subdistrict = $row['CustomerSubdistrict'];
$productStatus = $row['ProductStatus'];
$productName = $row['ProductName'];

// Ambil daftar email partner yang memenuhi syarat
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

shuffle($emails); // Acak urutan email

$found = false;

// ✅ Jika Suruh Apa Saja, langsung assign partner random tanpa validasi skill
if (strtolower($productName) === "suruh apa saja" || strtolower($productStatus) === "suruh apa saja") {
    if (!empty($emails)) {
        $partnerEmail = $emails[0];
        $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = ? WHERE ID = ?");
        $update->bind_param("si", $partnerEmail, $id);
        $update->execute();
        $update->close();
        $found = true;
    }
} else {
    // Normal: validasi skill
    foreach ($emails as $email) {
        $skills = $conn->prepare("SELECT SkillStatus, SkillName FROM tbl_partners_skill WHERE PartnerEmail = ? AND Status = 'Sudah dikonfirmasi'");
        $skills->bind_param("s", $email);
        $skills->execute();
        $result = $skills->get_result();

        while ($skill = $result->fetch_assoc()) {
            if (
                strtolower(trim($skill['SkillName'])) == strtolower(trim($productName))
            ) {
                $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = ? WHERE ID = ?");
                $update->bind_param("si", $email, $id);
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
    $updateStatusQuery = "UPDATE tbl_transaction SET Status = ?, PartnerEmail = '' WHERE ID = ?";
    $updateStatusStmt = $conn->prepare($updateStatusQuery);
    $status = "Menunggu konfirmasi mitra.";
    $updateStatusStmt->bind_param("si", $status, $id);
    $updateStatusStmt->execute();
    $updateStatusStmt->close();
}

$partnerUpdate = $conn->prepare("UPDATE tbl_partners SET Status = ? WHERE Email = ?");
$partnerStatus = "Sedang dapat melayani";
$partnerUpdate->bind_param("ss", $partnerStatus, $emailPartner);
$partnerUpdate->execute();
$partnerUpdate->close();

$_SESSION['StatusPartner'] = "Sedang dapat melayani";

header("Location: transaction.php");
exit;