<?php
require_once __DIR__ . '/../util/utilities.php';

class XmasParticipant
{
  public $id;
  public $name;

  public function __construct($assoc)
  {
    $this->id = $assoc['code'];
    $this->name = $assoc['name'];
  }
  
  public static function get_from_code($code)
  {
    $stmt = "SELECT * FROM xmas_participant WHERE code = ?";
    $user = Database::run_statement(Database::get_connection(), $stmt, [$code])->fetch_assoc();
    if (!is_null($user)) {
      return new XmasParticipant($user);
    }
    return null;
  }
}
?>