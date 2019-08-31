<?php

  // connect to db
  require_once('db.php');
  if (empty($_GET))
      $_GET['company'] = '2330';

  $sql = "select round(8*a.x, 2) pe8, round(12*a.x, 2) pe12, round(16*a.x ,2) pe16, ".
         "       price, date ".
         "from (select price/pe x, price, date ".
         "      from prices ".
         "      where code = '".$_GET['company']."' ) a ".
         "order by a.date desc ";

  $result = $conn->query($sql);
  $data = array();
  foreach ($result as $row)
  {
      $data[] = $row;
  }

  // close db
  $result->close();
  $conn->close();
  echo json_encode($data);
?>
