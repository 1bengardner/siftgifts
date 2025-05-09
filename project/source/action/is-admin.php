<?php
require_once 'authenticate.php';
require_once '../data/user.php';

$user = User::get_from_id($_SESSION['id']);
return in_array($user->id, [2]);
?>