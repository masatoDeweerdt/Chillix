<?php
session_start();

require_once("assets/includes/config.php");

if (isset($_POST["submitButton"])) {

    $username = $_POST["username"];
    $pwd = $_POST["password"];
    // $pwd = hash("sha512", $pwd); 

    $stmt = $con->prepare("SELECT * FROM logadmin WHERE username = :username AND pwd = :pwd");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $pwd);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['logadmin'] = true;
        header("Location: administration.php");
    } else {
        echo "Username or Password is not correct!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/logadmin.css" rel="stylesheet">
    <title>Login Administration Chillix</title>
</head>

<body>

    <div id="container">

        <form method="POST">

            <h2>Login for the administration system</h2>

            <input type="text" name="username" placeholder="Username" required>

            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" name="submitButton" value="SUBMIT">

        </form>

    </div>

</body>

</html>