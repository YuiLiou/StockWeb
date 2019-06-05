<?php

  // connect to db
  require_once('db.php');
  if (empty($_GET))
      $_GET['company'] = '2330';

  $sql = "select p.*, round(ma5.value,2) ma5, round(ma20.value,2) ma20, round(ma60.value,2) ma60 ".
         "from (select price, date ".
         "      from prices ".
         "      where code = '".$_GET['company']."') p left join ". 
         "     ((select date, value ".
         "       from ma ".
         "       where code = '".$_GET['company']."' ".
         "       and span = 5) ma5, ".
         "      (select date, value ".
         "       from ma ".
         "       where code = '".$_GET['company']."' ".
         "       and span = 20) ma20, ".
         "      (select date, value ".
         "       from ma ".
         "       where code = '".$_GET['company']."' ".
         "       and span = 60) ma60) ".
         "      on (p.date=ma5.date and p.date=ma20.date and p.date=ma60.date) ".
         "order by p.date desc limit 30";

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
