<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200201 rusiang  回傳應收帳款週轉率
  /**********************************************************************************/
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';

  $sql = "select concat(year, season) season, ".
         //      應收帳款週轉率
         "       round(income/receive,2) receivable, ".
         "       income, ".
         "       receive ".
         "from ( ".
         "  select a.year, a.season, ".
         //        當季/前季應收帳款取平均
         "         (a.v1+a.v2+b.v1+b.v2)/2 receive, ". 
         //        單季營收
         "         ( ".
         "           select sum(current) ".
         "           from monthly ".
         "           where 1=1 ".
         "           and code = a.code ".
         "           and month like concat(a.year,'%') ".
         "           and ((a.season = 'Q4' and ".
         "                (month like '____12' or month like '____11' or month like '____10')) or ".
         "                (a.season = 'Q3' and ".
         "                (month like '____09' or month like '____08' or month like '____07')) or ".
         "                (a.season = 'Q2' and ".
         "                (month like '____06' or month like '____05' or month like '____04')) or ".
         "                (a.season = 'Q1' and ".
         "                (month like '____03' or month like '____02' or month like '____01'))) ".
         "         ) income ".
         "  from ".
         // 當季應收帳款
         "  ( ".
         "    select v1, code, year, season, (@rnk := @rnk+1) rnk, ".
         "           ( ".
         "             select v1 ".
         "             from property_2 ".
         "             where code = p.code ".
         "             and year = p.year ".
         "             and season = p.season ".
         "             and col_name = '應收票據淨額' ".
         "           ) v2 ".
         "    from property_2 p, ".
         "    (SELECT @rnk:=0) a ".
         "    where code ='".$_GET['company']."' ".
         "    and col_name = '應收帳款淨額' ".
         "    order by year desc, season desc ".
         "  )a, ".
         // 前季應收帳款
         "  ( ".
         "    select v1, (@rnk2 := @rnk2+1) rnk, ".
         "           ( ".
         "             select v1 ".
         "             from property_2 ".
         "             where code = p.code ".
         "             and year = p.year ".
         "             and season = p.season ".
         "             and col_name = '應收票據淨額' ".
         "           ) v2 ".
         "    from property_2 p, ".
         "    (SELECT @rnk2:=0) a ".
         "    where code ='".$_GET['company']."' ".
         "    and col_name = '應收帳款淨額' ".
         "    order by year desc, season desc ".
         "  )b ".
         "  where 1=1 ".
         "  and a.rnk = b.rnk-1 ".
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
