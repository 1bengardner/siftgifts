<?php
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

abstract class MessageLevel
{
  const Success = 1;
  const Error = 2;
}
abstract class Message
{
  const EmailInvalid = "Please enter a valid e-mail address.";
  const EmailTooLong = "Your e-mail must be under 320 characters.";
  const EmailDoesNotExist = "This e-mail address is not registered with Sift.gifts.";
  const PasswordTooLong = "Your password is too long (over 255 characters).";
  const PasswordTooShort = "Your password is too short (under 6 characters).";
  const NameIsTooLong = "Your display name is too long (over 30 characters).";
  const NotLoggedIn = "Please log in to access this page.";
  const InvalidUser = "Incorrect e-mail or password.";
  const FieldsCannotBeEmpty = "Please fill out all fields.";
  const EmailExists = "This e-mail address is already registered with Sift.gifts.";
  const PasswordsDiffer = "The two entered passwords must match.";
  const NameExists = "There is already someone registered with that display name.";
  const NameIsBad = "Please do not use symbols in your display name.";
  const ChangePasswordSuccess = "You have successfully updated your password.";
  const PasswordResetSent = "A password reset link has been sent to your e-mail.";
  const LogOutSuccess = "You are logged out. Thanks for coming by!";
  const InvalidResetCode = "This password reset link is invalid.";
  const ExpiredResetCode = "This password reset link has expired (they last 15 minutes).";
  const NoPermission = "You do not have permission to do that.";
}
class Notification
{
  protected $message_text;
  protected $message_level;

  public function __construct($message_text, $message_level) {
      $this->message_text = $message_text;
      $this->message_level = $message_level;
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
      return Message::FieldsCannotBeEmpty;
    }
    return false;
  }

  // Returns the email error if there is one, otherwise false
  public static function email_login_error($email)
  {
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return Message::EmailInvalid;
    }
    // Validate email length - this is included within the FILTER_VALIDATE_EMAIL filter, but also here as secondary defense for the database
    if (strlen($email) > 320) {
      return Message::EmailTooLong;
    }
    return false;
  }

  public static function password_error($password)
  {
    if (strlen($password) > 255) {
      return Message::PasswordTooLong;
    }
    if (strlen($password) < 6) {
      return Message::PasswordTooShort;
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
      return Message::NameExists;
    }
    if (!ctype_alnum(str_replace(array("-", "_", " "), "", $name))) {
      return Message::NameIsBad;
    }
    if (strlen($name) > 30) {
      return Message::NameIsTooLong;
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
      return Message::EmailExists;
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
      return Message::EmailDoesNotExist;
    }
    $stmt = "SELECT encrypted_password FROM user WHERE email = ?";
    $user_password = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    if (!$user_password) {
      return false;
    }
    $encrypted_password = $user_password->fetch_row()[0];
    return password_verify($password, $encrypted_password) ? false : Message::InvalidUser;
  }

  public static function passwords_differ($p1, $p2)
  {
    if ($p1 != $p2) {
      return Message::PasswordsDiffer;
    }
    return false;
  }

  public static function forgot_password_error($email)
  {
    $stmt = "SELECT 1 FROM user WHERE email = ?";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    if (empty($res->fetch_row()[0])) {
      return Message::EmailDoesNotExist;
    }
    return false;
  }
  
  public static function invalid_reset_code($email, $code)
  {
    $stmt = "SELECT is_valid_reset_code(?, ?)";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$email, $code]);
    if ($res->fetch_row()[0] === NULL) {
      return Message::InvalidResetCode;
    } else if (!$res->fetch_row()[0]) {
      return Message::ExpiredResetCode;
    }
    return false;
  }
}
?>