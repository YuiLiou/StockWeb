<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200129 rusiang  回傳股價/均線
  /* 20200223 rusiang  新增股價區間
  /**********************************************************************************/  
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';
  if (!isset($_GET['days'])) $_GET['days'] = '60';
  $sql = "select p.price, p.date, ".
         "( ".
         "  select round(value,2) ".
         "  from ma ".
         "  where 1=1 ".
         "  and code = p.code ".
         "  and span = 5 ".
         "  and date = p.date ".
         ") ma5, ".
         "( ".
         "  select round(value,2) ".
         "  from ma ".
         "  where 1=1 ".
         "  and code = p.code ".
         "  and span = 20 ".
         "  and date = p.date ".
         ") ma20, ".
         "( ".
         "  select round(value,2) ".
         "  from ma ".
         "  where 1=1 ".
         "  and code = p.code ".
         "  and span = 60 ".
         "  and date = p.date ".
         ") ma60 ". 
         "from prices p ".
         "where code = '".$_GET['company']."' ".
         "order by p.date desc limit ".$_GET['days']." ";

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
