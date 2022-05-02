<?php
// TODO: Extract the separate responsibilities of this class
class Database
{
  public static function get_connection()
  {
    include 'db_config.php';
    $mysqli = new mysqli($url, $user, $password, $db);
    return $mysqli;
  }

  public static function run_statement($connection, $stmt, $args)
  {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $prepared_stmt = $connection->prepare($stmt);
    $prepared_stmt->bind_param(str_repeat("s", count($args)), ...$args);
    $prepared_stmt->execute();
    $res = $prepared_stmt->get_result();
    $prepared_stmt->close();
    return $res;
  }

  public static function run_statement_no_params($connection, $stmt)
  {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $prepared_stmt = $connection->prepare($stmt);
    $prepared_stmt->execute();
    $res = $prepared_stmt->get_result();
    $prepared_stmt->close();
    return $res;
  }
}

require 'email_config.php';
define("PASSWORD_RESET", $password_reset);
define("ACCOUNT_VERIFICATION", $account_verification);
define("ALERTS", $alerts);
define("ALERTS_RECIPIENT", $alerts_recipient);

abstract class EmailAlias
{
  const PasswordReset = PASSWORD_RESET;
  const AccountVerification = ACCOUNT_VERIFICATION;
  const Alerts = ALERTS;
  const AlertsRecipient = ALERTS_RECIPIENT;
}
class Email
{
  public static function send_email($name, $email, $from, $subject, $body)
  {
    $to = $name ? $name.' <'.$email.'>' : $email;
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'From: '.$from;

    mail($to, $subject, $body, implode("\r\n", $headers));
  }
}

abstract class NotificationLevel
{
  const Success = 1;
  const Error = 2;
  const Info = 4;
}
abstract class NotificationText
{
  const EmailInvalid = "Please enter a valid e-mail address.";
  const EmailTooLong = "Your e-mail must be under 320 characters.";
  const EmailDoesNotExist = "This e-mail address is not registered with Sift.gifts.";
  const PasswordTooLong = "Your password is too long (over 255 characters).";
  const PasswordTooShort = "Your password is too short (under 6 characters).";
  const NameIsTooLong = "Your display name is too long (over 30 characters).";
  const NotLoggedIn = "Please log in to access this page.";
  const InvalidUser = "Incorrect e-mail or password.";
  const FieldsCannotBeEmpty = "Please fill out all the required fields.";
  const EmailExists = "This e-mail address is already registered with Sift.gifts.";
  const PasswordsDiffer = "The two entered passwords must match.";
  const NameExists = "There is already someone registered with that display name.";
  const NameIsBad = "Please do not use symbols or spaces in your display name.";
  const ChangePasswordSuccess = "You have successfully updated your password.";
  const PasswordResetSent = "A password reset link has been sent to your e-mail.";
  const LogOutSuccess = "Logged out. Thanks for coming by!";
  const InvalidResetCode = "This password reset link is invalid.";
  const ExpiredResetCode = "This password reset link has expired (they last 15 minutes).";
  const NoPermission = "You do not have permission to do that.";
  const InvalidVerificationCode = "This verification link is invalid.";
  const VerifyAccountSuccess = "Your account is now verified.";
  const RegistrationSuccess = "You are now signed up with Sift.gifts.";
  const ChangeProfileSuccess = "You have successfully updated your profile.";
  const MessageSent = "Message sent.";
  const WishlistNotFound = "There is no wishlist under that name.";
  const ToDoesNotExist = "There is nobody with this name.";
  const AddSuccess = "Added!";
}
class Notification
{
  protected $text;
  protected $level;

  public function __construct($text, $level) {
      $this->text = $text;
      $this->level = $level;
  }

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }
}
class Validation
{
  // Returns list of keys missing from POST
  public static function get_missing_keys($keys)
  {
    $missing_keys = [];
    foreach ($keys as $key) {
      if (empty($_POST[$key])) {
        $missing_keys[] = $key;
      }
    }
    return $missing_keys;
  }

  public static function keys_missing($keys)
  {
    if (count(Validation::get_missing_keys($keys)) > 0) {
      return NotificationText::FieldsCannotBeEmpty;
    }
    return false;
  }

  // Returns the email error if there is one, otherwise false
  public static function email_login_error($email)
  {
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return NotificationText::EmailInvalid;
    }
    // Validate email length - this is included within the FILTER_VALIDATE_EMAIL filter, but also here as secondary defense for the database
    if (strlen($email) > 320) {
      return NotificationText::EmailTooLong;
    }
    return false;
  }

  public static function password_error($password)
  {
    if (strlen($password) > 255) {
      return NotificationText::PasswordTooLong;
    }
    if (strlen($password) < 6) {
      return NotificationText::PasswordTooShort;
    }
    return false;
  }

  private static function name_exists($name)
  {
    $stmt = "SELECT username FROM user WHERE username = ?";
    $duplicate_username = Database::run_statement(Database::get_connection(), $stmt, [$name]);
    return $duplicate_username->num_rows > 0;
  }

  public static function name_error($name)
  {
    if (Validation::name_exists($name)) {
      return NotificationText::NameExists;
    }
    if (!ctype_alnum(str_replace(array("-", "_"), "", $name))) {
      return NotificationText::NameIsBad;
    }
    if (strlen($name) > 30) {
      return NotificationText::NameIsTooLong;
    }
    return false;
  }
  
  public static function to_error($to)
  {
    if (!Validation::name_exists($to)) {
      return NotificationText::ToDoesNotExist;
    }
    return false;
  }

  public static function email_exists($email)
  {
    $stmt = "SELECT email FROM user WHERE email = ?";
    $duplicate_email = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    return $duplicate_email->num_rows > 0;
  }

  public static function email_registration_error($email)
  {
    if (Validation::email_exists($email)) {
      return NotificationText::EmailExists;
    }
    if ($res = Validation::email_login_error($email)) {
      return $res;
    }
    return false;
  }

  public static function login_error($email, $password)
  {
    $stmt = "SELECT 1 FROM user WHERE email = ?";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    if (empty($res->fetch_row()[0])) {
      return NotificationText::EmailDoesNotExist;
    }
    $stmt = "SELECT encrypted_password FROM user WHERE email = ?";
    $user_password = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    if (!$user_password) {
      return false;
    }
    $encrypted_password = $user_password->fetch_row()[0];
    return password_verify($password, $encrypted_password) ? false : NotificationText::InvalidUser;
  }

  public static function passwords_differ($p1, $p2)
  {
    if ($p1 != $p2) {
      return NotificationText::PasswordsDiffer;
    }
    return false;
  }

  public static function forgot_password_error($email)
  {
    $stmt = "SELECT 1 FROM user WHERE email = ?";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    if (empty($res->fetch_row()[0])) {
      return NotificationText::EmailDoesNotExist;
    }
    return false;
  }
  
  public static function invalid_reset_code($email, $code)
  {
    $stmt = "SELECT is_valid_reset_code(?, ?)";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$email, $code])->fetch_row()[0];
    if ($res === NULL) {
      return NotificationText::InvalidResetCode;
    } else if (!$res) {
      return NotificationText::ExpiredResetCode;
    }
    return false;
  }
  
  public static function invalid_verification_code($email, $code)
  {
    $stmt = "SELECT is_valid_verification_code(?, ?)";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$email, $code])->fetch_row()[0];
    if (!$res) {
      return NotificationText::InvalidVerificationCode;
    }
    $stmt = "SELECT 1 FROM user WHERE email = ?";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    if (empty($res->fetch_row()[0])) {
      return NotificationText::EmailDoesNotExist;
    }
    return false;
  }
}
?>