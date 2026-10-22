<?php
session_start();

if (isset($_GET['chatroom'])) {
    $_SESSION['ID-Transaction'] = $_GET['id'];
    $_SESSION['Chatroom'] = $_GET['chatroom'];
    header('Location: transaction-chat.php');
    exit();
}
?>