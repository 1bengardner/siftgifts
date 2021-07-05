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

<div class="widget review-widget focused">
    <h3><?php echo $review->reviewer; ?></h3></input>
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