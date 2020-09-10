<?php
ob_start();//Turns on output buffering = attends que tout le php est chargé (loaded) avant de le retourner
session_start();//si la ssesion est set avec start c'est que l'utilisateur est login
//mettre la timezone
date_default_timezone_set("Europe/London");
// try (to connect to database) pour se connecter, catch (if it failled)si sa ne fonctione pas.
 //PDO =php data object sert a conecter la database
    //  host=database sous docker, sinon host=localhost et j'ai root en user et en mots de passe dans docker

$server = "sql305.epizy.com";
$dbname = "epiz_26592840_Chillix";
$user = "epiz_26592840";
$pass = "0tHrJZtbfSe96";


try  {
   
    $con = new PDO("mysql:dbname=$dbname;host=$server;charset=utf8", $user, $pass);
    // mets la propriete de l'atribut ATTR_ERRMODE, a la valeur de ERRMODE_WARNING en fonction statique
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
// (PDOException $e)= listining(ecouter) la variable PDOException qui s'apelle $e et on y fait apelle : $e
catch (PDOException $e) {
  exit("Connection failed:" . $e->getMessage());
}
?>