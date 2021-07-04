<?php
    require_once '../util/utilities.php';
    require_once '../data/restaurant.php';

    // Get available restaurants from db
    $stmt = "SELECT * FROM restaurant WHERE user = ?";
    $res = Database::run_statement($stmt, [$_SESSION["id"]]);
    $restaurants = $res->fetch_all(MYSQLI_ASSOC);

    foreach ($restaurants as $restaurant) {
        $r = new Restaurant($restaurant);

        // Display each restaurant - this is HTML
?>

<div class="restaurant-widget">
    <h2><?php echo $r->name; ?></h2>
    <h3><?php echo ($r->rating === null ? "No rating" : $r->rating); ?></h3>
    <p><?php echo $r->cuisine; ?></p>
    <p></p>
</div>

<?php
    }
?>