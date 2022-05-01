<?php
require_once '../action/authenticate.php';
require_once '../util/utilities.php';
require_once '../data/user.php';

$stmt = "INSERT INTO message(`to`, `from`, body) VALUES (?, ?, ?)";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [$_POST['to'], $_SESSION['id'], $_POST['message']]);

$_SESSION['message_alert'] = [
  'email' => User::get_from_id($_POST['to'])->email,
  'conversations' => [
    [
      [
        'from' => $_SESSION['id'],
        'sent_time' => date('g:i A'),
        'body' => $_POST['message'],
      ],
    ],
  ]
];
?>