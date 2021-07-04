<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registration</title>        
    </head>
    <body>
        <form action="../action/registration-action.php" method="post">
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
                <input class="submit-button" type="submit" value="Sign up" /></p>
            </div>
        </form>
    </body>
</html>