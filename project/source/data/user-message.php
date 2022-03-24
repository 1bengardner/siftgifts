<?php
require_once '../util/utilities.php';

class UserMessage
{
  public $id;
  public $to;
  public $from;
  public $body;
  public $sent_time;

  public function __construct($assoc)
  {
    $this->id = $assoc['id'];
    $this->to = $assoc['to'];
    $this->from = $assoc['from'];
    $this->body = $assoc['body'];
    $this->sent_time = $assoc['sent_time'];
  }
  
  public static function get_from_id($id)
  {
    $stmt = "SELECT * FROM message WHERE id = ?";
    $msg = Database::run_statement(Database::get_connection(), $stmt, [$id]);
    return new UserMessage($msg->fetch_assoc());
  }
}
?>