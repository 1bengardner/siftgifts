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
        <title>Leave a review</title>
    </head>
    <body>
        <?php
            require_once '../util/utilities.php';
            require_once '../data/restaurant.php';

            // Get restaurant from db
            $stmt = "SELECT * FROM restaurant WHERE id = ?";
            $res = Database::run_statement($stmt, [$_POST['restaurant']]);
            $restaurant_data = $res->fetch_assoc();
            $restaurant = new Restaurant($restaurant_data);
        ?>
        <form action="../action/submit-review.php" method="post">
            <h1><?php echo $restaurant->name; ?></h1>
            <input type="hidden" name="restaurant" value="<?php echo $restaurant->id; ?>" />
            <div>
                <input type="radio" name="rating" value="1" required />
                <input type="radio" name="rating" value="2" />
                <input type="radio" name="rating" value="3" />
                <input type="radio" name="rating" value="4" />
                <input type="radio" name="rating" value="5" />
            </div>
            <div>
                <span>1</span>
                <span>2</span>
                <span>3</span>
                <span>4</span>
                <span>5</span>
            </div>
            <div>
                <input type="text" name="name" placeholder="Your name" maxlength="50" required />
            </div>
            <div>
                <textarea name="review-text" placeholder="Write your review..." maxlength="2000" required></textarea>
            </div>
            <div>
                <input class="submit-button" type="submit" value="Submit" />
            </div>
        </form>
    </body>
</html>