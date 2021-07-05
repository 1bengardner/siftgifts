<?php
    require_once '../util/utilities.php';
    require_once '../data/review.php';
    // Get reviews from db
    $stmt = "SELECT * FROM review WHERE restaurant = ?";
    $res = Database::run_statement($stmt, [$_GET['restaurant']]);
    $reviews = $res->fetch_all(MYSQLI_ASSOC);

    foreach ($reviews as $review_data) {
        $review = new Review($review_data);

        // Display each review
?>

<div class="review-widget focused">
    <h3><?php echo $review->reviewer; ?></h3></input>
    <h2><?php echo $review->rating; ?></h2>
    <h3><?php echo $review->timestamp; ?></h3>
    <p><?php echo $review->content; ?></p>
    <p></p>
</div>

<?php
    }
?>