<?php
require_once '../data/user.php';
require_once '../util/utilities.php';

$email = $_POST['email'];

$name = User::get_from_email($email)->username;

$subject = 'Sift.gifts - Someone has just registered!';

$message = '
<html>
<body style="font-family: sans-serif;">
  <h1>Sift.gifts new user alert</h1>
  <div>
    <p>User <strong>'.htmlentities($name).' &lt;'.$email.'&gt;</strong> has just registered.</p>
  </div>
</body>
</html>
';

Email::send_email(null, EmailAlias::AlertsRecipient, EmailAlias::Alerts, $subject, $message);
?>