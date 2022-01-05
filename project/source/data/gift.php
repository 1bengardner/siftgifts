<?php
class Gift
{
  public $id;
  public $name;
  public $url;
  public $notes;
  public $reserved;
  public $creation_time;
  private $user;

  public function __construct($assoc)
  {
    $this->id = $assoc['id'];
    $this->name = $assoc['name'];
    $this->url = $assoc['url'];
    $this->notes = $assoc['notes'];
    $this->reserved = $assoc['reserved'];
    $this->creation_time = $assoc['creation_time'];
    $this->user = $assoc['user'];
  }
  
  public static function get_from_id($id)
  {
    $stmt = "SELECT * FROM gift WHERE id = ?";
    $gift = Database::run_statement(Database::get_connection(), $stmt, [$id]);
    return new Gift($gift->fetch_assoc());
  }
  
  public function belongs_to_user($id)
  {
    return true;
    return $this->user === $id;
  }
}
?>