<?php

session_start();
require_once("assets/includes/config.php");

// Méthode pour se connecter à la base de donnée désirée


if($_SESSION['logadmin']){
    if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
        $supprime = (int) $_GET['supprime'];
        $req = $con->prepare('DELETE FROM users WHERE id = ?');
        $req->execute(array($supprime));
    }
}

$users = $con->query("SELECT * FROM users ORDER BY id DESC");
$users->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Chillix</title>
</head>

<body>

    <h2>Administration System</h2>

    <ul>
    <?php while ($u = $users->fetch()) { ?>
            <li><?= $u['id'] ?> : <?= $u['username'] ?> - <a href="administration.php?supprime=<?= $u['id'] ?>">Supprimer</a></li>
        <?php } ?>
    </ul>

</body>

</html>