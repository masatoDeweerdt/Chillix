<?php
session_start();
ob_start();

require_once("assets/includes/config-local.php");
require_once("assets/classes/Account.php");
require_once("assets/classes/Constants.php");
// require_once("register.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {

    $username = $_POST["username"];
    $pwd = $_POST["password"];

    $success = $account->login($pwd, $username);

    if ($success) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        header("Location: main.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styleR.css">
    <title>Chillix</title>
</head>

<body>
    <header class="showcase">
        <!-- <div class="showcase-top">
            <img src="assets/images/chillix.png" alt="Chillix logo">
        </div> -->

        <div class="signInContainer">

            <div class="column">

                <div class="header">
                    <img src="assets/images/chillix.png" title="logo" alt="logo Chillix">
                    <h3>Sign in to continue</h3>

                </div>

                <form method="POST" class="form">
                    <?php echo $account->getError(Constants::$notCorrect); ?>
                    <input class="username" type="text" name="username" placeholder="Username" required>

                    <input class="password" type="password" name="password" placeholder="Password" required>

                    <!-- <input type="submit" name="submitButton" value="Submit"> -->

                    <button type="submit" name="submitButton" value="Submit"><i class="fas fa-sign-in-alt sign"></i>Login</button>

                </form>
                <a href="register.php" class="signInMessage">Need an account? Sign up here!</a>
                <div id="space"></div>
                <a href="requestReset.php">Forgot password?</a>

            </div>

        </div>
    </header>

    <footer class="footer">
        <p><i class="fab fa-github-square github_icon"></i></p>
        <div class="footer-cols">
            <ul>
                <li>Team :</li>
                <li><a href="#">Lap Hoang</a></li>
                <li><a href="#">Melissa Fruit</a></li>
                <li><a href="#">Frédéric Bembassat</a></li>
                <li><a href="#">Masato Deweerdt</a></li>
            </ul>
            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">Terms Of Use</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            <ul>
                <li><a href="#">Account</a></li>
            </ul>
            <ul>
                <li>Becode</li>
            </ul>
        </div>

    </footer>

</body>

</html>