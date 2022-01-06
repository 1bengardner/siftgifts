<?php
require_once '../util/utilities.php';

class User
{
  public $id;
  public $email;
  public $username;

  public function __construct($assoc)
  {
    $this->id = $assoc['id'];
    $this->email = $assoc['email'];
    $this->username = $assoc['username'];
  }
  
  public static function get_from_id($id)
  {
    $stmt = "SELECT * FROM user WHERE id = ?";
    $user = Database::run_statement(Database::get_connection(), $stmt, [$id]);
    return new User($user->fetch_assoc());
  }
}
?>