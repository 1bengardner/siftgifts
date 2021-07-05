<?php
require_once '../util/utilities.php';

class Restaurant
{
    public $id;
    public $name;
    public $rating;
    public $cuisine;

    public function __construct($assoc)
    {
        $this->id = $assoc['id'];
        $this->name = $assoc['name'];
        $this->cuisine = $assoc['cuisine'];
        $this->rating = $this->get_average_rating();
    }

    private function get_average_rating()
    {
        // Get corresponding reviews
        $stmt = "SELECT AVG(rating) FROM review WHERE restaurant = ?";
        $res = Database::run_statement($stmt, [$this->id]);
        return $res->fetch_row()[0];
    }
}
?>