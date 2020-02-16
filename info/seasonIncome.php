<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200201 rusiang  回傳月營收
  /**********************************************************************************/
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';

  $sql = "select concat(a.year, a.season) season, eps, ". 
         //      單季營收
         "       ( ".
         "         select sum(current) ".
         "         from monthly ".
         "         where 1=1 ".
         "         and code = a.code ".
         "         and month like concat(a.year,'%') ".
         "         and ((a.season = 'Q4' and ".
         "              (month like '____12' or month like '____11' or month like '____10')) or ".
         "              (a.season = 'Q3' and ".
         "              (month like '____09' or month like '____08' or month like '____07')) or ".
         "              (a.season = 'Q2' and ".
         "              (month like '____06' or month like '____05' or month like '____04')) or ".
         "              (a.season = 'Q1' and ".
         "              (month like '____03' or month like '____02' or month like '____01'))) ".
         "       ) income ".
         "from _eps a ".
         "where 1=1 ".
         "and code ='".$_GET['company']."' ".
         "order by year desc, season desc ";

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
