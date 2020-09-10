<?php

ob_start(); //execute the following script after everything else loaded.
session_start();

$server = "localhost";
$user = "root";
$pass = "root";
$dbname = "Chillix";


try {
    $con = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $error) {
    echo "Connection Failed: " . $error->getMessage(); 
}

// $sql = "SELECT * FROM users";

// $stmt = $connect->query($sql);

// // $stmt->execute();

// while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     print_r($row) . "<br>";
// };
