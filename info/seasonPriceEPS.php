<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200129 rusiang  回傳四季EPS/季均價/季均本益比
  /**********************************************************************************/  
  // connect to db
  require_once('db.php');
  if (empty($_GET)) $_GET['company'] = '2330';
  $sql = "select concat(a.year, a.season) season, (a.eps+b.eps+c.eps+d.eps) eps, ".
         "       ( ".
         "         select round(avg(price),2) price ".
         "         from prices p ".
         "         where code = a.code ".
         "         and ((a.season = 'Q4' and (p.date like concat(a.year, '12%') or p.date like concat(a.year, '11%') or p.date like concat(a.year, '10%'))) or ".
         "              (a.season = 'Q3' and (p.date like concat(a.year, '09%') or p.date like concat(a.year, '08%') or p.date like concat(a.year, '07%'))) or ".
         "              (a.season = 'Q2' and (p.date like concat(a.year, '06%') or p.date like concat(a.year, '05%') or p.date like concat(a.year, '04%'))) or ".
         "              (a.season = 'Q1' and (p.date like concat(a.year, '03%') or p.date like concat(a.year, '02%') or p.date like concat(a.year, '01%')))) ".
         "       ) price, ".
         "       ( ".
         "         select round(avg(pe),2) pe ".
         "         from prices p ".
         "         where code = a.code ".
         "         and ((a.season = 'Q4' and (p.date like concat(a.year, '12%') or p.date like concat(a.year, '11%') or p.date like concat(a.year, '10%'))) or ".
         "              (a.season = 'Q3' and (p.date like concat(a.year, '09%') or p.date like concat(a.year, '08%') or p.date like concat(a.year, '07%'))) or ".
         "              (a.season = 'Q2' and (p.date like concat(a.year, '06%') or p.date like concat(a.year, '05%') or p.date like concat(a.year, '04%'))) or ".
         "              (a.season = 'Q1' and (p.date like concat(a.year, '03%') or p.date like concat(a.year, '02%') or p.date like concat(a.year, '01%')))) ".
         "       ) pe ".
         "from ".
         "( ".
         "  select *, (@rnk:=@rnk+1)rnk ".
         "  from _eps e, (select @rnk := 0) a ".
         "  where code= '".$_GET['company']."' ".
         "  order by year desc, season desc ".
         ")a, ".
         "( ".
         "  select *, (@rnk2:=@rnk2+1)rnk ".
         "  from _eps e, (select @rnk2 := 0) a ".
         "  where code= '".$_GET['company']."' ".
         "  order by year desc, season desc ".
         ")b, ".
         "( ".
         "  select *, (@rnk3:=@rnk3+1)rnk ".
         "  from _eps e, (select @rnk3 := 0) a ".
         "  where code= '".$_GET['company']."' ".
         "  order by year desc, season desc ".
         ")c, ".
         "( ".
         "  select *, (@rnk4:=@rnk4+1)rnk ".
         "  from _eps e, (select @rnk4 := 0) a ".
         "  where code= '".$_GET['company']."' ".
         "  order by year desc, season desc ".
         ")d ".
         "where 1=1 ".
         "and a.rnk = b.rnk - 1 ".
         "and a.rnk = c.rnk - 2 ".
         "and a.rnk = d.rnk - 3 ";

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
