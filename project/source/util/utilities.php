<?php
class Database
{
  public static function get_connection()
  {
    $url = "127.0.0.1";
    $user = "root";
    $db = "gift_data";
    $mysqli = new mysqli($url, $user, "", $db);
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

abstract class Message
{
  const EmailInvalid = "Please enter a valid e-mail address.";
  const EmailTooLong = "Your e-mail must be under 320 characters.";
  const EmailDoesNotExist = "Please enter a registered e-mail address.";
  const PasswordTooLong = "Your password must be under 255 characters.";
  const NameTooLong = "Your username is too long.";
  const NotLoggedIn = "Please log in to access this page.";
  const InvalidUser = "Incorrect e-mail or password.";
  const FieldsCannotBeEmpty = "Please fill out all fields.";
  const EmailExists = "This e-mail address is already registered with Siftgifts.";
  const PasswordsDiffer = "The two entered passwords must match.";
  const UsernameExists = "There is already someone registered with that username.";
  const UsernameIsBad = "Please use just letters and numbers in your username.";
  const ChangePasswordSuccess = "You have successfully updated your password.";
  const LogOutSuccess = "You have successfully logged out.";
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
      return Message::UsernameExists;
    }
    if (!ctype_alnum($name)) {
      return Message::UsernameIsBad;
    }
    if (strlen($name) > 30) {
      return Message::NameTooLong;
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
}
?>