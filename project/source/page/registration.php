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
        <title>Registration</title>
    </head>
    <body>
        <form action="../action/registration-action.php" method="post">
            <h1 class="logo-text">Dine<span class="lighter">line</span></h1>
            <?php
                require_once '../util/utilities.php';
                session_start();
                if (isset($_SESSION["messages"])) {
            ?>
            <div class="error-box">
            <?php
                    foreach ($_SESSION["messages"] as $message) {
            ?>
                <p>
                        <?php echo $message; ?>
                </p>
            <?php
                    }
                    unset($_SESSION["messages"]);
            ?>
            </div>
            <?php
                }
            ?>
            <div>
                <input type="text" name="name" placeholder="Full name" maxlength="50" required />
            </div>
            <div>
                <input type="email" name="email" placeholder="E-mail" maxlength="320" required />
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" maxlength="255" required />
            </div>
            <div>
                <input type="password" name="confirm-password" placeholder="Confirm password" maxlength="255" required />
            </div>
            <div>
                <input class="submit-button" type="submit" value="Sign up" />
            </div>
            <p>
                or <a href="login">Log In</a>
            </p>
        </form>
    </body>
</html>