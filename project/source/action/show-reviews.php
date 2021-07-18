<?php
require_once '../util/utilities.php';
require_once '../data/review.php';
// Get reviews from db
$stmt = "SELECT * FROM review WHERE restaurant = ? ORDER BY timestamp DESC";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET['restaurant']]);
$reviews = $res->fetch_all(MYSQLI_ASSOC);

foreach ($reviews as $review_data) {
    $review = new Review($review_data);
    // Get review user from db
    $stmt = "SELECT name FROM user WHERE id = ?";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$review->user]);
    $user = $res->fetch_row()[0];

    // Display each review
?>

<div class="widget review-widget focused">
    <h3><?php echo $user; ?></h3></input>
    <p class="subheading">
    <?php
    for ($i = 0; $i < $review->rating; $i++) {
        echo "⭐";
    }
    ?>
    </p>
    <p><?php echo explode(' ', $review->timestamp)[0]; ?></p>
    <p><?php echo $review->content; ?></p>
    <p></p>
</div>

<?php
}
?>