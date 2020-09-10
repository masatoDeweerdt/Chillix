
<?php

require_once("config-local.php");

$request = $_GET['request'];

if ($request != "") {
  $request = "%" . $request . "%";
  $sql = "SELECT * FROM movie WHERE title LIKE '$request' ORDER BY title";

  $stmt = $con->query($sql);

  if ($stmt->rowCount() > 0) {
    echo "<div id='suggestion'>Suggesting...</div>";
    while($result = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      echo "<div> <a href=" . "main.php?movie=" . str_replace(' ', '-', $result['title']) . ">" . $result['title'] . "</a></div>";
    }
  } else {
    echo "<div id='suggestion'> No Suggestions...</div>";
  }
}

?>

