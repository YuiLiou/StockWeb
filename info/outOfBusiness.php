<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200127 rusiang  回傳業外收入拆解
  /**********************************************************************************/  
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';

  $sql = "select ".
         "( ".
         "  select v2 ".
         "  from income_3 i2 ".
         "  where code = '".$_GET['company']."' ".
         "  and i.year = i2.year ".
         "  and i.season = i2.season ".
         "  and col_name = '其他收入' ".
         ") a, ".
         "( ".
         "  select v2 ".
         "  from income_3 i2 ".
         "  where code = '".$_GET['company']."' ".
         "  and i.year = i2.year ".
         "  and i.season = i2.season ".
         "  and col_name = '其他利益及損失淨額' ".
         ") b, ".
         "( ".
         "  select v2 ".
         "  from income_3 i2 ".
         "  where code = '".$_GET['company']."' ".
         "  and i.year = i2.year ".
         "  and i.season = i2.season ".
         "  and col_name = '財務成本淨額' ".
         ") c, ".
         "( ".
         "  select v2 ".
         "  from income_3 i2 ".
         "  where code = '".$_GET['company']."' ".
         "  and i.year = i2.year ".
         "  and i.season = i2.season ".
         "  and col_name = '採用權益法認列之關聯企業及合資損益之份額淨額' ".
         ") d, ".
         "( ".
         "  select v2 ".
         "  from income_3 i2 ".
         "  where code = '".$_GET['company']."' ".
         "  and i.year = i2.year ".
         "  and i.season = i2.season ".
         "  and col_name = '營業外收入及支出合計' ".
         ") e, ".
         "concat(year, season) season ".
         "from (select distinct year, season from income_3 where code = '".$_GET['company']."') i ".
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
