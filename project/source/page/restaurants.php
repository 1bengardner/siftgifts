<?php require '../action/login-check.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Restaurants</title>
    </head>
    <body>
        <a href="add-a-restaurant"><button>Add a restaurant</button></a>
        <form>
            <input type="search" name="q" placeholder="Search for a restaurant..." />
            <button>Search</button>
        </form>
        <?php include '../action/restaurants-action'; ?>
    </body>
</html>