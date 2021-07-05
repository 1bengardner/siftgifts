<?php
require_once '../util/utilities.php';

class Restaurant
{
    public $id;
    public $name;
    public $rating;
    public $cuisine;
    public $location;
    public $reviews;

    public function __construct($assoc)
    {
        $this->id = $assoc['id'];
        $this->name = $assoc['name'];
        $this->cuisine = $assoc['cuisine'];
        $this->location = $assoc['location'];
        $this->url = $assoc['url'];
        $this->rating = $this->get_average_rating();
        $this->reviews = $this->get_review_count();
    }

    private function get_average_rating()
    {
        // Get corresponding reviews
        $stmt = "SELECT AVG(rating) FROM review WHERE restaurant = ?";
        $res = Database::run_statement($stmt, [$this->id]);
        return $res->fetch_row()[0];
    }

    private function get_review_count()
    {
        // Get corresponding reviews
        $stmt = "SELECT COUNT(*) FROM review WHERE restaurant = ?";
        $res = Database::run_statement($stmt, [$this->id]);
        return $res->fetch_row()[0];
    }
}
?>