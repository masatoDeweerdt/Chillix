<?php


class Funk
{
  private $con;

  public function __construct($con)
  {
    $this->con = $con;
  }

  public function printSearchResult($rs)
  {
    echo "<div class='col-lg-12 search-category-wrapper'>";
    echo "<h4 class='category col-lg-12 p-lg-2'>More search results</h4>";
    echo " <div class='col-lg-12'>";
    echo "<div class='row'>";
    if ($rs) {
      for ($int = 1; $int < count($rs); $int++) {
        echo "<div class='col-lg-2 item'><a href=main.php?movie=" . str_replace(' ', '-', $rs[$int]['title']). "> <img src=" . $rs[$int]["thumbnail"] . "> </a> </div>";
        if ($int == 6) {
          break;
        }
      }
    } else {
      echo "<div class='col-lg-12 text-danger'>No more results found!</div>";
    }

    echo "</div>
    </div>
  </div>";
  }

  public function printRecommedation($sql)
  {
    $stmt = $this->con->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='col-lg-12 recommedation-category-wrapper'>";
    echo "<h4 class='category col-lg-auto p-lg-2'>" . ucfirst($result[0]['category']) . "</h4>";
    echo "<div class='col-lg-12'>";
    echo "<div class='row'>";

    for ($int = 0; $int < count($result); $int++) {

      $result[$int]['title'] = str_replace(' ', '-', $result[$int]['title']);

      echo "<div class='col-lg-2 item'> <a href=main.php?movie=" . $result[$int]['title'] . "><img src=" . $result[$int]["thumbnail"] . "> </a> </div>";
      if ($int == 5) {
        break;
      }
    };

    echo " </div>";
    echo " </div>";
    echo " </div>";
  }

}
