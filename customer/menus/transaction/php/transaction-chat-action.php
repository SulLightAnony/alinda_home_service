<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include '../../connection.php';

    $message = isset($_POST['Message']) ? $_POST['Message'] : '';
    $chatRoom = isset($_SESSION['Chatroom']) ? $_SESSION['Chatroom'] : '';
    $sender = 'Customer';
    $timestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO tbl_chatroom (ChatRoom, Sender, Message, Timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $chatRoom, $sender, $message, $timestamp);

    if ($stmt->execute()) {
        header('Location: transaction-chat.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>