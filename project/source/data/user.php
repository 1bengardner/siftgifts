<?php
require_once '../util/utilities.php';

class User
{
  public $id;
  public $email;
  public $username;
  public $visible;
  public $subscribed;

  public function __construct($assoc)
  {
    $this->id = $assoc['id'];
    $this->email = $assoc['email'];
    $this->username = $assoc['username'];
    $this->visible = $assoc['visible'];
    $this->subscribed = $assoc['subscribed'];
  }
  
  public static function get_from_id($id)
  {
    $stmt = "SELECT * FROM user WHERE id = ?";
    $user = Database::run_statement(Database::get_connection(), $stmt, [$id]);
    return new User($user->fetch_assoc());
  }
  
  public static function get_from_email($email)
  {
    $stmt = "SELECT * FROM user WHERE email = ?";
    $user = Database::run_statement(Database::get_connection(), $stmt, [$email]);
    return new User($user->fetch_assoc());
  }
  
  public static function get_from_name($username)
  {
    $stmt = "SELECT * FROM user WHERE username = ?";
    $user = Database::run_statement(Database::get_connection(), $stmt, [$username])->fetch_assoc();
    if (!is_null($user)) {
      return new User($user);
    }
    return null;
  }
}
?>