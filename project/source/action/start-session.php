<?php
// Session may contain Notifications defined in utilities.php
require_once '../util/utilities.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>