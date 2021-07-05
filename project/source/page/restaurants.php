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
        <title>Restaurants</title>
    </head>
    <body>
        <form>
            <a href="add-a-restaurant"><button>Add a restaurant</button></a>
            <input type="search" name="q" placeholder="Search for a restaurant..." />
            <button>🔍</button>
        </form>
        <?php include '../action/show-restaurants.php'; ?>
    </body>
</html>