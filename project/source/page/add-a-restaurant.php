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
                <input class="submit-button" type="submit" value="Add restaurant" />
            </div>
        </form>
    </body>
</html>