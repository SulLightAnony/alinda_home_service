<?php
    session_start();
    require '../../validate.php';
    date_default_timezone_set('Asia/Jakarta');

    // Ambil data
    $id = $_POST['ID'] ?? null;
    $timestamp = date("Y-m-d H:i:s");
    $emailPartner = $_SESSION['EmailPartner'];

    // Validasi ID
    if (!$id) {
        header("Location: transaction.php");
        exit;
    }

    // Inisialisasi path gambar
    $imagePath = "-";

    // Proses gambar jika ada
    if (isset($_FILES['PartnerFinishedImageProve']) && $_FILES['PartnerFinishedImageProve']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['PartnerFinishedImageProve'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = mime_content_type($image['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('finish_proof_', true) . '.' . $ext;
            $uploadPath = "../../../../database/partner/image/finished-image-prove/" . $newFileName;

            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                $imagePath = $uploadPath;
            }
        }
    }

    // Update ke tbl_transaction
    $update = $conn->prepare("UPDATE tbl_transaction SET PartnerFinishedImageProve = ?, PartnerFinishedTimestamp = ?, Status = ? WHERE ID = ?");
    $status = "Selesai";
    $update->bind_param("sssi", $imagePath, $timestamp, $status, $id);
    $update->execute();
    $update->close();

    // Update status partner
    $partnerUpdate = $conn->prepare("UPDATE tbl_partners SET Status = ? WHERE Email = ?");
    $partnerStatus = "Sedang dapat melayani";
    $partnerUpdate->bind_param("ss", $partnerStatus, $emailPartner);
    $partnerUpdate->execute();
    $partnerUpdate->close();

    $_SESSION['StatusPartner'] = "Sedang dapat melayani";

    // Hapus semua baris dari tbl_chatroom berdasarkan ChatRoom
    $chatroom = $_SESSION['Chatroom-Partner'];
    $deleteChatroom = $conn->prepare("DELETE FROM tbl_chatroom WHERE ChatRoom = ?");
    $deleteChatroom->bind_param("s", $chatroom);
    $deleteChatroom->execute();
    $deleteChatroom->close();

    // Kembali ke halaman transaksi
    header("Location: transaction.php");
    exit;
?>