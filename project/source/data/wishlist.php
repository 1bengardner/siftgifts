<?php
class Wishlist
{
  public $id;
  public $name;
  public $short_name;
  public $owner;

  public function __construct($assoc)
  {
    $this->id = $assoc['id'];
    $this->name = $assoc['name'];
    $this->short_name = $assoc['short_name'];
    $this->owner = $assoc['owner'];
  }
  
  public static function get_from_short_name($short_name)
  {
    $stmt = "SELECT * FROM wishlist WHERE short_name = ?";
    $wishlist = Database::run_statement(Database::get_connection(), $stmt, [$short_name]);
    return new Wishlist($wishlist->fetch_assoc());
  }
}
?>