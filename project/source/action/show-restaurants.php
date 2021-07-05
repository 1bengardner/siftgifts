<?php
    require_once '../util/utilities.php';
    require_once '../data/restaurant.php';

    // Get available restaurants from db
    $stmt = "SELECT * FROM restaurant WHERE user = ?";
    $res = Database::run_statement($stmt, [$_SESSION["id"]]);
    $restaurants = $res->fetch_all(MYSQLI_ASSOC);

    foreach ($restaurants as $restaurant_data) {
        $restaurant = new Restaurant($restaurant_data);

        // Display each restaurant - this is HTML
?>

<div class="restaurant-widget focused">
    <form method="get" action="reviews.php">
        <input type="hidden" name="restaurant" value="<?php echo $restaurant->id; ?>" />
        <h2><?php echo $restaurant->name; ?></h2></input>
        <h3><?php echo ($restaurant->rating === null ? "No rating" : round($restaurant->rating, 1)); ?></h3>
        <p><?php echo $restaurant->cuisine; ?></p>
        <p></p>
        <input type="submit" value="Explore" />
    </form>
</div>

<?php
    }
?>