<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200124 rusiang  回傳營業費用拆解
  /**********************************************************************************/  
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';

  $sql = "select ".
         "( ".
         "  select v2 ".
         "  from income_3 ".
         "  where i.code = code ".
         "  and i.year = year ".
         "  and i.season = season ".
         "  and col_name = '推銷費用' ".
         ") sale, ".
         "( ".
         "  select v2 ".
         "  from income_3 ".
         "  where i.code = code ".
         "  and i.year = year ".
         "  and i.season = season ".
         "  and col_name = '管理費用' ".
         ") manage, ".
         "( ".
         "  select v2 ".
         "  from income_3 ".
         "  where i.code = code ".
         "  and i.year = year ".
         "  and i.season = season ".
         "  and col_name = '研究發展費用' ".
         ") research, ".
         "( ".
         "  select v2 ".
         "  from income_3 ".
         "  where i.code = code ".
         "  and i.year = year ".
         "  and i.season = season ".
         "  and col_name = '預期信用減損損失（利益）' ".
         ") credit, ".
         "( ".
         "  select v2 ".
         "  from income_3 ".
         "  where i.code = code ".
         "  and i.year = year ".
         "  and i.season = season ".
         "  and col_name = '營業費用合計' ".
         ") total, ".
         "concat(year, season) season ".
         "from (select distinct year, season, code from income_3 where code = '".$_GET['company']."') i ".
         "where 1=1 ".
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
