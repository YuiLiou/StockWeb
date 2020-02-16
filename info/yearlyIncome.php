<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200129 rusiang  回傳年營收
  /* 20200201 rusiang  回傳年EPS
  /**********************************************************************************/
  // connect to db
  require_once('db.php');
  if (empty($_GET))
      $_GET['company'] = '2330';

  $sql = "select month, yearly income, ".
         "       ( ".
         "         select eps ".
         "         from eps ".
         "         where code = m.code ".
         "         and season = 'Q4' ".
         "         and year = substr(m.month, 1, 4) ".
         "       ) eps ".
         "from monthly m ". 
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "and month like '____12' ".
         "order by m.month desc ";

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
