<?php
require_once '../data/user.php';
require_once '../util/utilities.php';

$email = $_POST['email'];

$name = User::get_from_id($email)->username;

$subject = 'Sift.gifts - Someone has just registered!';

$message = '
<html>
<body style="font-family: sans-serif;">
  <h1>Sift.gifts New User Alert</h1>
  <div>
    <p>User "'.$name.'" <'.$email.'> has just registered.</p>
  </div>
</body>
</html>
';

Email::send_email(null, EmailAlias::AlertsRecipient, EmailAlias::Alerts, $subject, $message);
?>