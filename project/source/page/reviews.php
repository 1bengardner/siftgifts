<?php require_once '../action/login-check.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Reviews</title>
    </head>
    <body>
        <?php
            require_once '../util/utilities.php';
            require_once '../data/restaurant.php';

            // Get restaurant from db
            $stmt = "SELECT * FROM restaurant WHERE id = ?";
            $res = Database::run_statement($stmt, [$_GET['restaurant']]);
            $restaurant_data = $res->fetch_assoc();
            $restaurant = new Restaurant($restaurant_data);
        ?>
        <div class="restaurant-display">
            <h2><?php echo $restaurant->name; ?></h2>
            <h3><?php echo ($restaurant->rating === null ? "No rating" : round($restaurant->rating, 1) . " stars"); ?></h3>
            <p><?php echo $restaurant->cuisine; ?></p>
            <p></p>
        </div>
        <form method="post" action="add-a-review.php">
            <input type="hidden" name="restaurant" value="<?php echo $restaurant->id; ?>" />
            <button>Leave a review</button>
        </form>
        <?php include '../action/show-reviews.php' ?>
    </body>
</html>