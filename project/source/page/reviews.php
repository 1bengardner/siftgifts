<?php require_once '../action/login-check.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <title>Reviews</title>
    </head>
    <body>
        <?php include 'navigation.php' ?>
        <?php
        require_once '../util/utilities.php';
        require_once '../data/restaurant.php';

        // Get restaurant from db
        $stmt = "SELECT * FROM restaurant WHERE id = ?";
        $res = Database::run_statement(Database::get_connection(), $stmt, [$_GET['restaurant']]);
        $restaurant_data = $res->fetch_assoc();
        $restaurant = new Restaurant($restaurant_data);
        ?>
        <form method="post" action="add-a-review.php">
            <div class="restaurant-display">
                <h1><?php echo $restaurant->name; ?></h1>
                <h2 class="subheading"><?php echo ($restaurant->rating === null ? "No ratings" : round($restaurant->rating, 1) . "🌟"); ?></h2>
                <h3 class="subheading">
                    <?php
                    if ($restaurant->rating != null) {
                        echo $restaurant->cuisine;
                        if ($restaurant->location != null) {
                            echo " in " . $restaurant->location;
                        }
                    }
                    ?>
                </h3>
                <h3 class="link"><?php echo ($restaurant->rating != null ? "<a href=" . $restaurant->url . ">" . $restaurant->url .  "</a>" : "Be the first reviewer:"); ?></h3>
                <p></p>
            </div>
            <input type="hidden" name="restaurant" value="<?php echo $restaurant->id; ?>" />
            <button><a>Leave a review</a></button>
        </form>
        <?php include '../action/show-reviews.php' ?>
    </body>
</html>