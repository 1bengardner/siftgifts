<?php
require_once 'start-session.php';

unset($_SESSION["greeted"]);
unset($_SESSION["id"]);

$_SESSION["notifications"] = [new Notification(NotificationText::LogOutSuccess, NotificationLevel::Success)];

header('Location: /landing');
?>