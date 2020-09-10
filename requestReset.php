<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require_once("assets/includes/config-local.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
// pour connecter a la base de données

// Instantiation and passing `true` enables exceptions

if(isset($_POST["email"])) {

    $emailTo = $_POST["email"];

    $code = uniqid(true);
    $query = $con->query("INSERT INTO pwd_Reset (code, email)
    VALUES ('$code', '$emailTo')");

          if(!$query) {
              exit("Error");
          }                       
    $mail = new PHPMailer(true);

try {
    //Server settings
    
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'chillix.becode@gmail.com';                     // SMTP username
    $mail->Password   = 'beCodeBxl';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                  // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('chillix.becode@gmail.com', 'Chillix');
    $mail->addAddress("$emailTo");     // Add a recipient
    $mail->addReplyTo('no-reply@gmail.com', 'No reply');
    

    // Content
    $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/resetPassword.php?code=$code";
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = "<div><h1>You requested a password reset</h1><p>Click<a href='$url'> this link </a> to do so</p></div>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'reset passwordlink has been sent to your email';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}   exit();

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/styleR.css">
</head>
<body>

    <header class="showcase">
        <div class="showcase-top">
            <img src="assets/images/chillix.png" alt="Chillix logo">
        </div>

    <div class="signInContainer">

        <div class="column">

            <div class="header">
                <img src="assets/images/chillix.png" title="logo" alt="logo Chillix">
                <h3>Password reset</h3><br>
                <p>Please enter the email address associated with your user account. A verification code will be sent. When you receive it, you will be able to choose a new password</p>
            </div>
    
            <form method="POST" class="form">

            <input type="email" name="email" placeholder="Enter your email"  autocomplete="off">
            <br />
            <button type="submit" name="submitButton" value="Reset email">Submit</button>

            </form>
        
        </div>
    </div>


</body>
</html>