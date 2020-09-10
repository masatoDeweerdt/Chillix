<?php
//cree une variable pour le message d'erreur
class Constants {
public static $firstNameCharacters ="<div class='error'>* Your first name must be between 2 and 25 characters</div>";
public static $lastNameCharacters ="<div class='error'>* Your last name must be between 2 and 25 characters</div>";
public static $userNameCharacters ="<div class='error'>* Your username must be between 2 and 25 characters</div>";
public static $usernameTaken ="<div class='error'>* Username already taken </div>";
public static $emailsDontMatch ="<div class='error'>* Emails dont match</div>";
public static $emailInvalid ="<div class='error'>* Invalid email</div>";
public static $emailTaken ="<div class='error'>* Email already in use</div>";
public static $passwordsDontMatch ="<div class='error'>* Passwords dont match</div>";
public static $passwordLength ="<div class='error'>* Your password must be between 5 and 25 characters</div>";
public static $notCorrect = "<div class='error'>* Username or Password is not correct</div>";
public static $sql_thriller = "SELECT * FROM movie WHERE category = 'thriller'";
public static $sql_action = "SELECT * FROM movie WHERE category = 'action'";
public static $sql_sciencefiction = "SELECT * FROM movie WHERE category = 'science-fiction'";
public static $sql_comedy = "SELECT * FROM movie WHERE category = 'comedy'";
public static $sql_drama = "SELECT * FROM movie WHERE category = 'drama'";
}
?>