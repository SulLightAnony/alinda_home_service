<?php
require '../../validate.php';
date_default_timezone_set('Asia/Jakarta');

$username = $_SESSION['UsernamePartner'] ?? '';
$email = $_SESSION['EmailPartner'] ?? '';
$text = htmlspecialchars($_POST['text']) ?? '';
$timestamp = date("Y-m-d H:i:s");
$sender = 'Mitra';

if (empty($username) || empty($email) || empty($text)) {
    header("Location: bug-and-suggestion.php");
    exit;
}

$stmt = $conn->prepare("INSERT INTO tbl_bug_and_suggestion (Sender, SenderUsername, SenderEmail, Text, Timestamp) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $sender, $username, $email, $text, $timestamp);
$stmt->execute();
$stmt->close();

header("Location: bug-and-suggestion.php?success&link=" . $_GET['link']);
exit;
?>
