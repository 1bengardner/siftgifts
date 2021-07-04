<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add a new restaurant</title>
    </head>
    <body>
        <form action="../action/submit-restaurant.php" method="post">
            <div>
                <input type="name" name="name" placeholder="Restaurant name" maxlength="255" required />
            </div>
            <div>
                <input type="cuisine" name="cuisine" placeholder="Type of cuisine" maxlength="50" />
            </div>
            <div>
                <input type="location" name="location" placeholder="Location" maxlength="50" />
            </div>
            <div>
                <input type="url" name="url" placeholder="URL" maxlength="50" />
            </div>
            <div>
                <input class="submit-button" type="submit" value="Submit and add a review" />
            </div>
        </form>
    </body>
</html>