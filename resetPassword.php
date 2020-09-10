<?php
// pour connecter a la base de données
require_once("assets/includes/config-local.php");
// pour connecter a requestReset.php
//require_once("requestReset.php");

if(!isset($_GET["code"])) {
 exit("Can't find the page");
} else {
    $code = $_GET["code"];
}


$getEmailQuery = $con->query("SELECT * FROM pwd_Reset WHERE code='$code'");
$result = $getEmailQuery->fetch(PDO::FETCH_ASSOC);



if(isset($_POST["password"])) {
    $pw = $_POST["password"];
    $pw = hash("sha512", $pw);

    $email = $result["email"];   

    echo $email . "<br>";
    $query = $con->query("UPDATE users SET password='$pw' WHERE email='$email'"); 

    
          if($query) {
            $query = $con->query("DELETE FROM pwd_Reset WHERE code='$code'");
            exit("Password updated");
          }  
          else{
            exit("Error");
          }                     

    //if($result->rowCount() != 0) {
      //  exit("Can't find the page");
    //}
   }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/styleR.css">
        <title>Document</title>
    </head>
    <body>
    <form method="POST">

<input type="password" name="password" placeholder="New password">
<br />
<input type="submit" name="submit" value="Update password">


</form>
</body>
</html>