<?php
    require_once '../util/utilities.php';
    require_once '../data/restaurant.php';

    // Get available restaurants from db
    $stmt = "SELECT * FROM restaurant WHERE user = ? ORDER BY id DESC";
    $res = Database::run_statement($stmt, [$_SESSION["id"]]);
    $restaurants = $res->fetch_all(MYSQLI_ASSOC);

    foreach ($restaurants as $restaurant_data) {
        $restaurant = new Restaurant($restaurant_data);

        // Display each restaurant - this is HTML
?>

<div class="widget restaurant-widget focused">
    <form method="get" action="reviews.php">
        <input type="hidden" name="restaurant" value="<?php echo $restaurant->id; ?>" />
        <h2><?php echo $restaurant->name; ?></h2></input>
        <h3 class="subheading">
            <?php
            if ($restaurant->rating === null) {
                echo "<button>No reviews!</button>";
            } else {
                echo "<span class='lighter'>" . round($restaurant->rating, 1) . "🌟</span> - " . $restaurant->reviews . ($restaurant->reviews > 1 ? " reviews" : " review");
            }
            ?>
        </h3>
        <p class="subheading"><?php echo $restaurant->cuisine; ?></p>
        <p class="subheading"><?php echo $restaurant->location; ?></p>
        <input type="submit" value="See reviews" />
    </form>
</div>
<?php
    }
    if (count($restaurants) === 0) {
?>
<div class="widget restaurant-widget focused">
    <h2>No restaurants yet. Click <a href="add-a-restaurant"><span class="lighter">Add a restaurant</span></a> to get started.</h2>
</div>
<?php
    }
?>