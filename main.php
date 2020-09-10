<?php

ob_start();
session_start();

require_once("assets/includes/config-local.php");
require_once("assets/classes/Funk.php");
require_once("assets/classes/FormSanitizer.php");
require_once("assets/classes/Constants.php");

// GLOBAL VARIABLES=========


$title = $_GET['movie'];
$clean_title = str_replace('-', ' ', $title);


$randNum = rand(1, 50);
$funk = new Funk($con);

//JUMBOTRON MOVIE================

if (!isset($title)) {
  $stmt = $con->query("SELECT * FROM movie WHERE movie_id = $randNum");
  $firstResult = $stmt->fetch(PDO::FETCH_ASSOC);
  header("Location: main.php?movie=" . $firstResult['title']);
} else {
  $stmt = $con->query("SELECT * FROM movie WHERE title LIKE '$clean_title'");
  $firstResult = $stmt->fetch(PDO::FETCH_ASSOC);
}


// SEARCH ENGINE=============================

if (isset($_POST["search_submit"])) {

  $searchQuery = $_POST["search"];
  $searchQuery = FormSanitizer::sanitizeFormString($searchQuery);
  $searchQuery = "%" . $searchQuery . "%";

  if ($searchQuery == "") {
    return;
  } else {
    $stmt = $con->prepare("SELECT * FROM movie WHERE title LIKE :searchQuery");
    $stmt->bindParam(":searchQuery", $searchQuery);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
      $stmt = $con->query("SELECT * FROM movie WHERE movie_id = $randNum");
      $firstResult = $stmt->fetch(PDO::FETCH_ASSOC);
      // header("Location: main.php?movie=" . $firstResult["title"]);
    } else if ($stmt->rowCount() == 1) {
      $firstResult = $stmt->fetch(PDO::FETCH_ASSOC);
      // header("Location: main.php?movie=" . $firstResult["title"]);
    } else if ($stmt->rowCount() > 1) {
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $firstResult = $results[0];
      // header("Location: main.php?movie=" . $firstResult["title"]);
    }
  }
}

// COMMENTS====================

$id = $firstResult['movie_id'];
$comments = $con->query("SELECT * FROM comments  WHERE id_movie =" . $id . " ORDER BY date_time DESC");

if (isset($_SESSION["loggedin"])) {
  $comment_username = $_SESSION["username"];
  $un_request = "SELECT * FROM users WHERE username = '$comment_username'";
  $un_stmt = $con->query($un_request);
  $un_result = $un_stmt->fetch(PDO::FETCH_ASSOC);

  if (isset($_POST['comment_submit'])) {
    if (!empty($_POST['comment_content'])) {
      $comment_content = htmlspecialchars($_POST['comment_content']);
      $id_movie = $_POST['movie_id'];
      $insert = $con->prepare('INSERT INTO comments (username, content, id_movie, id_user, date_time) VALUES (?, ?, ?, ?, NOW())');
      $insert->execute(array($comment_username, $comment_content, $id_movie, $un_result["id"]));
      header('Location: ' . $_SERVER['REQUEST_URI']);
    }
  }
}
// =====================================

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/styleR.css">
  <script src="https://use.fontawesome.com/d8793cf2cc.js"></script>

  <!--================ ADD SOME META TAGS ==============-->
  <title>Chillix</title>
</head>

<body>
  <header>
    <div id="nothing" class="nothing"></div>
    <nav id="navigation" class="col-lg-12 navi_bar">
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <div class="col-lg-3 logo-wrapper">
              <a href="main.php"><img id="logo" src="assets/images/chillix.png" alt="Chillix motherfucking logo" /></a>
            </div>
            <div class="col-lg-9 navi">
              <ul class="row d-flex align-items-center">
                <li class="col-lg-3"><a href="main.php">Home</a></li>
                <li class="col-lg-3"><a href="#">must-see</a></li>
                <li class="col-lg-3">
                  <form>
                    <select name="movies" id="select-form" onchange="filterMovie(this.value)">
                      <option class="opt" value="">Genres</option>
                      <option class="opt" value="action">Action</option>
                      <option class="opt" value="crime">Crime</option>
                      <option class="opt" value="drama">Drama</option>
                      <option class="opt" value="mind-fuck">Mindfuck</option>
                    </select>
                  </form>
                </li>
                <li class="col-lg-3"><a href="#">Series</a></li>
              </ul>
              <div id="open-comment">leave a comment</div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 offset-lg-1">
          <ul class="row d-flex align-items-center justify-content-end mr-lg-4">
            <li id="search-bar" class="mr-lg-3">
              <!----------SEARCH ------------>
              <form id="hint" class="d-flex align-items-center" method="POST" autocomplete="off">
                <i class="fa fa-search p-lg-1"></i>
                <input type="text" name="search" placeholder="Search your best shit..." autofocus onkeyup="getMovie(this.value)">
                <div id="movie-hint"></div>
                <button class="d-none" name="search_submit"></button>
              </form>
            </li>
            <?php
            if ($_SESSION["loggedin"]) {
              echo "<li id='user' class='col-lg-auto p-3'>" . $_SESSION["username"] . "</li>";
              echo "<li class='col-lg-auto p-3'><a href='logout.php'>out</a></li>";
            } else {
              echo "<li class='up col-lg-auto p-3'><a href='register.php'>up</a></li>";
              echo "<li class='col-lg-auto p-3'><a href='login.php'>in</a></li>";
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="jumbotron">
      <div class="iframe">
        <?php // DISPLAYING RECOMMENDED MOVIE 
        echo "<iframe src=" . $firstResult["link"] . "?autoplay=1 frameborder='0' allow='autoplay'></iframe>"; ?>
      </div>
      <div id='title' class="container pt-lg-5 ml-lg-3 d-flex flex-column justify-content-start">
        <div class="row">
          <?php echo "<div class='col-lg-auto mt-lg-4 font-weight-bold title'>" . $firstResult["title"] . "</div>"; ?>
        </div>
        <div class="row">
          <?php echo "<div class='col-lg-6 pt-lg-2 pb-lg-3 font-italic tagline'>" . $firstResult["overview"] . "</div>"; ?>
        </div>
        <div class="row">
          <?php
          if (fmod($firstResult["runtime"], 60) < 10) {
            $min = "0" . fmod($firstResult["runtime"], 60);
          } else {
            $min = fmod($firstResult["runtime"], 60);
          }
          echo "<div class='col-lg-auto runtime'>" . ROUND($firstResult["runtime"] / 60) . ":" . $min . " mins</div>"; ?>
        </div>

        <div class="row mt-lg-3">
          <button class="button col-lg-auto ml-lg-3">Play this</button>
          <button class="button col-lg-auto ml-lg-3">Know more?</button>
        </div>
      </div>
    </div>
  </header>
  <main class="main">
    <!----------- COMMENT SECTION------------->
    <div id="comment" class="container comment d-none">
      <div class="row">
        <div class="col-lg-12">
          <form class="comment-form" method="POST" action="">
            <input class="d-none" type="text" name="movie_id" <?php echo "value=" . $firstResult['movie_id'] . ">"; ?> </br> <input id="contenu" class="comment_content" name="comment_content" placeholder="Tell people how fucking amazing this movie is, will ya?">
            <button id="btn-send" name="comment_submit" />Send </button>
          </form>
          <div id="get-comment" class="comment-container col-lg-12 mt-lg-4">
            <div class="row comment-item mb-lg-4">
              <?php
              if ($comments->rowCount() == 0) {
                echo "<div class='col-lg-6 offset-lg-3'> No comments on this movie yet, please write one! </div>";
              } else {
                while ($comment = $comments->fetch()) {
                  echo "<div class='row comment-item mb-lg-4'>";
                  echo "<div class='user col-lg-1 offset-1 border-right'>" . $comment['username'] . "</div>";
                  echo "<div class='content col-lg-6'>" . $comment['content'] . "</div>";
                  echo "<div class='date-time col-lg-2'>" .  $comment['date_time'] .  "</div>";
                  echo "</div>";
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!------------- MAIN ------------->
    <div class="container">
      <!---- SEARCH RESULTS ---->
      <?php
      if (isset($_POST["search_submit"])) {
        $funk->printSearchResult($results);
      }
      // RECOMMENDATIONS RESULTS
      $funk->printRecommedation(Constants::$sql_thriller);
      $funk->printRecommedation(Constants::$sql_drama);
      $funk->printRecommedation(Constants::$sql_action);
      $funk->printRecommedation(Constants::$sql_sciencefiction);
      $funk->printRecommedation(Constants::$sql_comedy);
      ?>
      <!---------FILTER ------>
  </main>
  <footer class="footer">
    <p><i class="fa fa-2x fa-github-square github_icon"></i></p>
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
        <li><a href="http://eepurl.com/hcMJ6L">Subscribe to Newsletter!</a></li>
      </ul>
      <ul>
        <li><a href="#">Account</a></li>
      </ul>
      <ul>
        <li>Becode</li>
      </ul>
    </div>

  </footer>
  <div class="media-query">
    OOPS! THIS WEBSITE IS NOT MEANT FOR SMALL SCREENS.
  </div>
  <script src="assets/js/script.js"></script>
</body>

</html>