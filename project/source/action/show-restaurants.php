<?php
require_once '../util/utilities.php';
require_once '../data/restaurant.php';

// Get available restaurants from db
$stmt = "SELECT * FROM restaurant ORDER BY id DESC";
$res = Database::run_statement_no_params(Database::get_connection(), $stmt);
$restaurants = $res->fetch_all(MYSQLI_ASSOC);

foreach ($restaurants as $restaurant_data) {
    $restaurant = new Restaurant($restaurant_data);
    // Get restaurant image
    $stmt = "SELECT data FROM restaurant_image WHERE restaurant = ?";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$restaurant->id]);
    $image = $res->fetch_row()[0];

    // Display each restaurant - this is HTML
?>
<div class="widget restaurant-widget focused">
    <form method="get" action="reviews.php">
        <input type="hidden" name="restaurant" value="<?php echo $restaurant->id; ?>" />
        <div class="grid">
            <div style="grid-item-center">
                <?php
                if ($image != NULL) {
                ?>
                <input type="image" class="restaurant-image" src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" />
                <?php
                }
                ?>
            </div>
            <div>
                <h2 class="restaurant-name"><?php echo $restaurant->name; ?></h2>
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
                <div class="right">
                    <input type="submit" value="See reviews" />
                </div>
            </div>
        </div>
    </form>
</div>
<?php
}
if (count($restaurants) === 0) {
?>
<div class="widget focused center">
    <h2>No restaurants yet. Click <a href="add-a-restaurant"><span class="lighter">Add a restaurant</span></a> to get started.</h2>
</div>
<?php
}
?>