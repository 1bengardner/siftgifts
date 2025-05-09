<?php
require_once 'authenticate.php';
require_once '../data/user.php';

return in_array(User::get_from_id($_SESSION['id'])->id, [2]);
?>