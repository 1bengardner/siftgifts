<?php
require_once 'start-session.php';

if (isset($_SESSION["id"])) {
    require_once '../data/user.php';
    $user = User::get_from_id($_SESSION['id']);
    header("Location: /home");
    exit;
}
?>