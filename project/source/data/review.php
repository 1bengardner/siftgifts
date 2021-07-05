<?php
require_once '../util/utilities.php';

class Review
{
    public $reviewer;
    public $rating;
    public $timestamp;
    public $content;

    public function __construct($assoc)
    {
        $this->reviewer = $assoc['reviewer'];
        $this->rating = $assoc['rating'];
        $this->timestamp = $assoc['timestamp'];
        $this->content = $assoc['content'];
    }
}
?>