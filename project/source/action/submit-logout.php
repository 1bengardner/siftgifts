<?php
session_start();

unset($_SESSION["greeted"]);
unset($_SESSION["id"]);

header('Location: ../page/landing');
?>