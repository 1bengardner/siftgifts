<?php
require_once '../util/utilities.php';
require_once 'start-session.php';

// Validate required field presence
$required_fields = ['email', 'password'];
$validation_errors = [];
$validations = [
    function() use ($required_fields) { return Validation::keys_missing($required_fields); },
    function() { return Validation::email_login_error($_POST['email']); }
];

foreach ($validations as $validation) {
    if ($msg = $validation()) {
        array_push($validation_errors, new Notification($msg, MessageLevel::Error));
    }
}
if (count($validation_errors) === 0 && $msg = Validation::login_error($_POST['email'], $_POST['password'])) {
    array_push($validation_errors, new Notification($msg, MessageLevel::Error));
}

if (count($validation_errors) > 0) {
    $_SESSION["notifications"] = $validation_errors;
    header('Location: /login');
    exit;
}

$stmt = "SELECT id FROM user WHERE email = ?";
$user_id = Database::run_statement(Database::get_connection(), $stmt, [$_POST['email']]);
$id = $user_id->fetch_assoc()['id'];

$_SESSION["id"] = $id;

header('Location: /home');
?>