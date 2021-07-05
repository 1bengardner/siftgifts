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
            <h3 class="subheading">Restaurant in <?php echo $restaurant->location; ?></h3>
            <input type="hidden" name="restaurant" value="<?php echo $restaurant->id; ?>" />
            <hr />
            <h4>Rating</h4>
            <div>
                <label>
                    <input type="radio" name="rating" value="1" required />
                    <span class="subheading">1</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="2" />
                    <span class="subheading">2</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="3" />
                    <span class="subheading">3</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="4" />
                    <span class="subheading">4</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="5" />
                    <span class="subheading">5</span>
                </label>
            </div>
            <div>
                <input type="text" name="name" placeholder="Reviewer's name" maxlength="50" required />
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