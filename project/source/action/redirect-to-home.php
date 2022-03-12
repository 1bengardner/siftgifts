<?php
require_once 'start-session.php';

if (isset($_SESSION["id"])) {
    header("Location: /home");
    exit;
}
?>