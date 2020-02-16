<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200129 rusiang  回傳長/短期營收成長率
  /**********************************************************************************/  
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';

  $sql = "select round(((this_3-past_3)/past_3*100),2) growth3, ".     // 短期營收成長率
         "       round(((this_12-past_12)/past_12*100),2) growth12, ". // 長期營收成長率
         "       a.month, a.yoy growth1 ".
         "from ".
         "( ".
         "  select a.*, ".
         // 前3月營收總和 ---------------------------------------------------
         "  ( ".
         "    select sum(current) ".
         "    from ".
         "    ( ".
         "      select b.*, @rank2 := @rank2 + 1 AS rnk2 ".
         "      from monthly b, (select @rank2 := 0)a ". 
         "      where 1=1 ".
         "      and code = '".$_GET['company']."' ".
         "      order by month desc ".
         "    ) b ".
         "    where 1=1 ".
         "    and rnk2 <  rnk + 3 ".
         "    and rnk2 >= rnk     ".
         "  ) this_3, ".
         // 去年同期3月營收總和 ---------------------------------------------------
         "  ( ".
         "    select sum(current) ".
         "    from ".
         "    ( ".
         "      select b.*, @rank3 := @rank3 + 1 AS rnk3 ".
         "      from monthly b, (select @rank3 := 0)a ". 
         "      where 1=1 ".
         "      and code = '".$_GET['company']."' ".
         "      order by month desc ".
         "    ) b ".
         "    where 1=1 ".
         "    and rnk3 <  rnk + 15 ".
         "    and rnk3 >= rnk + 12 ".
         "  ) past_3, ".
         // 前12月營收總和 ---------------------------------------------------
         "  ( ".
         "    select sum(current) ".
         "    from ".
         "    ( ".
         "      select b.*, @rank4 := @rank4 + 1 AS rnk4 ".
         "      from monthly b, (select @rank4 := 0)a ". 
         "      where 1=1 ".
         "      and code = '".$_GET['company']."' ".
         "      order by month desc ".
         "    ) b ".
         "    where 1=1 ".
         "    and rnk4 <  rnk + 12 ".
         "    and rnk4 >= rnk      ".
         "  ) this_12, ".
         // 去年同期12月營收總和 ---------------------------------------------------
         "  ( ".
         "    select sum(current) ".
         "    from ".
         "    ( ".
         "      select b.*, @rank5 := @rank5 + 1 AS rnk5 ".
         "      from monthly b, (select @rank5 := 0)a ". 
         "      where 1=1 ".
         "      and code = '".$_GET['company']."' ".
         "      order by month desc ".
         "    ) b ".
         "    where 1=1 ".
         "    and rnk5 <  rnk + 24 ".
         "    and rnk5 >= rnk + 12 ".
         "  ) past_12 ".
         // 基準 ----------------------------------------------------------------
         "  from ".
         "  ( ".
         "    select m.*, @rank := @rank + 1 AS rnk ".
         "    from monthly m, (select @rank := 0)a ".
         "    where code = '".$_GET['company']."' ".
         "    order by month desc ".
         "    limit 0,36 ".
         "  ) a".
         ")a ";

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
