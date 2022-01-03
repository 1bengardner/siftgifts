<?php
class Gift
{
  public $id;
  public $name;
  public $url;
  public $notes;
  public $reserved;
  public $creation_time;

  public function __construct($assoc)
  {
    $this->id = $assoc['id'];
    $this->name = $assoc['name'];
    $this->url = $assoc['url'];
    $this->notes = $assoc['notes'];
    $this->reserved = $assoc['reserved'];
    $this->creation_time = $assoc['creation_time'];
  }
}
?>