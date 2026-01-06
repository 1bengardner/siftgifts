<?php
require_once '../util/utilities.php';
require_once '../action/start-session.php';
require_once '../data/xmas-participant.php';

if (!isset($_GET["xmas"])) {
  http_response_code(404);
  include "../page/404.php";
  exit;  
}

$user = XmasParticipant::get_from_code($_GET["xmas"]);
if (is_null($user)) {
  http_response_code(404);
  include "../page/404.php";
  exit;
}
if (isset($_SESSION["xmas"]) && $user->name != XmasParticipant::get_from_code($_SESSION["xmas"])->name) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NaughtyList, NotificationLevel::Error)];
  http_response_code(403);
} else {
  $_SESSION["xmas"] = $_GET["xmas"];
}
include "../page/xmas-template.php";
?>