<?php
    require_once '../util/utilities.php';
    session_start();

    if (!isset($_SESSION["id"]) || !$_SESSION["id"]) {
        $_SESSION["messages"] = [Message::NotLoggedIn];
        header("Location: login.php");
    }
?>