<?php
require_once '../action/start-session.php';

unset($_SESSION["greeted"]);
unset($_SESSION["id"]);

$_SESSION["notifications"] = [new Notification(Message::LogOutSuccess, MessageLevel::Success)];

header('Location: ../page/landing');
?>