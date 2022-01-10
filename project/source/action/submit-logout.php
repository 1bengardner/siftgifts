<?php
require_once '../util/utilities.php';
session_start();

unset($_SESSION["greeted"]);
unset($_SESSION["id"]);

$_SESSION["messages"] = [Message::LogOutSuccess];

header('Location: ../page/landing');
?>