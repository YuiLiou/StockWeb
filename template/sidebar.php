<?php
  // connect to db
  require_once('db.php');
  $sql = "select code, company ".
         "from company_map  ".
         "where code in ('".$codes."') ".
         "order by code asc";
  $result = $conn->query($sql);
  $data = array();
  echo "<section id='sidebar'>";
  echo "<nav>";
  echo "<ul>";
  foreach ($result as $row)
  {
      echo "<li><a href='finance.php?company=".$row['code']."'>".$row['company']." (".$row['code'].")</a></li>";
  }
  echo "</ul>";
  echo "</nav>";
  echo "</section>";
  // close db
  $result->close();
?>

