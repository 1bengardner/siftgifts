<?php
require_once '../action/start-session.php';

if (isset($_SESSION["id"])) {
    header("Location: ../page/home");
    exit;
}
?>