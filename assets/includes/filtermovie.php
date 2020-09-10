<?php
require_once("config-local.php");

$request = $_GET['request'];

$stmt = $con->query("SELECT * FROM movie WHERE category = '$request'");


while($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $res['title'] . "<br>";
}