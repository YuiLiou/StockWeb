<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200216 rusiang  回傳集保及股價關係
  /**********************************************************************************/  
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';
  $sql = "select a.*, ".
         "       (p_all-p_400) p_400_minus, ".
         "       (100-r_400) r_400_minus ".
         "from ".
         "( ".
         "  select distinct s.date, ".
         //   >400張股東持有比例
         "    ( ". 
         "      select round(sum(rate),2) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000','600001-800000','800001-1000000','1000001以上') ".
         "    ) r_400, ".
         //   >400張股東人數
         "    ( ".   
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000','600001-800000','800001-1000000','1000001以上') ".
         "    ) p_400, ". 
         //   股東總人數
         "    ( ". 
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "    ) p_all, ".
         //   股價
         "    ( ".
         "      select price ".
         "      from prices ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "    ) price ".
         "  from share_ratio s ".
         "  where code = '".$_GET['company']."' ".
         "  order by date desc ".
         ") a ";
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
