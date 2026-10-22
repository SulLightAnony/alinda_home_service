<?php
session_start();

if (isset($_GET['chatroom'])) {
    $_SESSION['ID-Transaction-Partner'] = $_GET['id'];
    $_SESSION['Chatroom-Partner'] = $_GET['chatroom'];
    header('Location: transaction-chat.php');
    exit();
}
?>