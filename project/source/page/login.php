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
        <title>Login</title>
    </head>
    <body>
        <form action="../action/login-action.php" method="post">
            <h1 class="logo-text">Dine<span class="lighter">line</span></h1>
            <?php
                require_once '../util/utilities.php';
                session_start();
                if (isset($_SESSION["messages"]) && array_pop($_SESSION["messages"]) == Message::NotLoggedIn) {
            ?>
            <p>
                Please log in to access this page.
            </p>
            <?php
                    unset($_SESSION["messages"]);
                }
            ?>
            <div>
                <input type="email" name="email" placeholder="E-mail" maxlength="320" required />
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" maxlength="255" required />
            </div>
            <div>
                <input class="submit-button" type="submit" value="Log in" />
            </div>
            <p>
                Not registered? <a href="registration">Sign Up</a>
            </p>
        </form>
    </body>
</html>