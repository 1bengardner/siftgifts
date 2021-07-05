<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
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
        <h1><?php echo $restaurant->name; ?></h1>
        <form action="../action/submit-review.php" method="post">
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