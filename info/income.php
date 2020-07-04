<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200208 rusiang  增加季營收
  /**********************************************************************************/ 
  // error message
  ini_set('display_errors','1');
  error_reporting(E_ALL);

  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';
  $sql = "select a.grossRate, a.operatingRate, a.beforeTaxRate, a.afterTaxRate, ".
         "       concat(a.year, a.season) season, ".
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
         "from income a ".
         "where code = '".$_GET['company']."' ".
         "order by year asc, season asc"; 
  $result = $conn->query($sql);
  $data = array();
  foreach ($result as $row)
  {
      $data[] = $row;
  }
  // close db
  $result->close();
  echo json_encode($data);
?>
