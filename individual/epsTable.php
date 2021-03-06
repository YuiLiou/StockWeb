<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200101 rusiang  新增本期表現  
  /* 20200111 rusiang  新增四季累計  
  /* 20200202 rusiang  四季累計改用圖表
  /**********************************************************************************/  
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";

  /*********************************************************************************/
  /*『SQL』本期EPS                                                                     
  /*********************************************************************************/
  echo "【本期表現】<br>";
  $sql = "select round(((this.eps/past.eps)-1)*100,2) growth, this.eps this_eps, past.eps past_eps ".
         "from ".
         "( ".
         "  select * ".
         "  from eps ".
         "  where 1=1 ".
         "  and code ='".$_GET['company']."' ".
         "  order by year desc, season desc ".
         "  limit 0,1 ".
         ") this, ".
         "( ".
         "  select * ".
         "  from eps ".
         "  where 1=1 ".
         "  and code ='".$_GET['company']."' ".
         "  order by year desc, season desc ".
         "  limit 4,1 ".
         ") past ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引  
  if (isset($row['this_eps']))
  { 
      echo "今年累計EPS：".$row['this_eps']."元<br>"; 
      echo "去年累計EPS：".$row['past_eps']."元<br>"; 
      echo "成長幅度：".$row['growth']."%<br>";
  }

  /*********************************************************************************/
  /*『SQL』本期月營收                                                                     
  /*********************************************************************************/
  $sql = "select m.Yearly_YoY,current.month ".
         "from monthly m, ".
         "( ".
         "  select case ".
         "    when this.season = 'Q4' then concat(this.year, '12') ".
         "    when this.season = 'Q3' then concat(this.year, '09') ".
         "    when this.season = 'Q2' then concat(this.year, '06') ".
         "    when this.season = 'Q1' then concat(this.year, '03') ".
         "    else '01' ".
         "  end month ".
         "  from ".
         "  ( ".
         "    select year, season ".
         "    from eps ".
         "    where 1=1 ".
         "    and code ='".$_GET['company']."' ".
         "    order by year desc, season desc ".
         "    limit 0,1 ".
         "  ) this ".
         ") current ".
         "where 1=1 ".
         "and current.month = m.month ".
         "and code ='".$_GET['company']."'";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引   
  if (isset($row['Yearly_YoY']))
      echo $row['month']."營收累計年增率：".$row['Yearly_YoY']."%<br>"; 

  /*********************************************************************************/
  /*『SQL』最新月營收                                                                     
  /*********************************************************************************/
  $sql = "select Yearly_YoY,month ".
         "from monthly m ".
         "where code = '".$_GET['company']."' ".
         "order by month desc ".
         "limit 0,1";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引   
  if (isset($row['Yearly_YoY']))
      echo $row['month']."營收累計年增率：".$row['Yearly_YoY']."%<br>";

  /*********************************************************************************/
  /*『SQL』四季累計                                                                     
  /*********************************************************************************/
  echo "【四季累計】<br>";
  echo "<canvas id='seasonPriceEPSChart'></canvas>";
/* 
  // 20200202拿掉，改用圖表
  echo "<div class='table100 ver1' id='monthlyTbl' style='height:250px;'>".
       "<table data-vertable='ver1'>".
       "<thead>".
       "  <tr class='row100 head'>".
           "<th></th>";
  $sql = "select year ".
         "from ".
         "( ".
         "  select concat(year, season) year ".
         "  from _eps ".
         "  where code = '".$_GET['company']."' ".
         "  order by year desc, season desc ".
         "  limit 0, 4 ".
         ") a ".
         "order by year asc "; 
  $result = $conn->query($sql);
  foreach ($result as $row)
  {
      echo "<th>".$row['year']."</th>";    
  }
  echo "  </tr>";
  echo "</thead>";
  echo "<tbody>";
  // 累計eps ////////////////////////////////////////////////////////////// 
  echo "  <tr>"; 
  echo "    <td>EPS</td>"; 
  for ($i=3; $i>=0; $i--)  
  {
      $sql = "select round(sum(eps), 2) eps_sum ".
             "from ".
             "( ".
             "  select eps ".
             "  from _eps ".
             "  where code = '".$_GET['company']."' ".
             "  order by year desc, season desc ".
             "  limit ".$i.", 4 ".
             ") a " ; 
      $result = $conn->query($sql);
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引   
      echo "<td>".$row['eps_sum']."</td>";
  } 
  echo "  </tr>";
  // 平均股價 ////////////////////////////////////////////////////////////// 
  echo "  <tr>"; 
  echo "    <td>平均股價</td>"; 
  $peList = "<td>平均本益比</td>";
  for ($i=3; $i>=0; $i--)  
  {
      $sql = "select round(avg(price),2) price, round(avg(pe),2) pe ".
             "from prices p, ".
             "( ".
             "  select year, season ".
             "  from _eps ".
             "  where code = '".$_GET['company']."' ".
             "  order by year desc, season desc ".
             "  limit ".$i.",1 ".
             ") b ".
             "where 1=1 ".
             "and p.code = '".$_GET['company']."' ".
             "and ".
             "( ".
             "  ( ".
             "    b.season = 'Q4' and ( ".
             "                          p.date like concat(b.year, '12%') or ".
             "                          p.date like concat(b.year, '11%') or ".
             "                          p.date like concat(b.year, '10%') ".
             "                        )".
             "  ) or ".
             "  ( ".
             "    b.season = 'Q3' and ( ".
             "                          p.date like concat(b.year, '09%') or ".
             "                          p.date like concat(b.year, '08%') or ".
             "                          p.date like concat(b.year, '07%') ".
             "                        )".
             "  ) or ".
             "  ( ".
             "    b.season = 'Q2' and ( ".
             "                          p.date like concat(b.year, '06%') or ".
             "                          p.date like concat(b.year, '05%') or ".
             "                          p.date like concat(b.year, '04%') ".
             "                        )".
             "  ) or ".
             "  ( ".
             "    b.season = 'Q1' and ( ".
             "                          p.date like concat(b.year, '03%') or ".
             "                          p.date like concat(b.year, '02%') or ".
             "                          p.date like concat(b.year, '01%') ".
             "                        )".
             "  ) ".
             ") ";
      $result = $conn->query($sql);
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引   
      echo "<td>".$row['price']."</td>";
      $peList .=  "<td>".$row['pe']."</td>";
  }  
  echo "  </tr>";
  echo "  <tr>".$peList."</tr>";
  echo "</tbody>";
  echo "</table>";
  echo "</div>";
*/
  /*********************************************************************************/
  /*『SQL』歷年表現                                                                     
  /*********************************************************************************/
  $sql = "select a.year, ".
         "       ifnull(a.eps,'-') Q1, ".
         "       ifnull(b.eps,'-') Q2, ".
         "       ifnull(c.eps,'-') Q3, ".
         "       ifnull(d.eps,'-') Q4, ".
         "       a.eps+ifnull(b.eps,0)+ifnull(c.eps,0)+ifnull(d.eps,0) total ".
         "from ".
         "    (select year, eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q1' ) a ".
         "    left join (select year, eps ".
         "               from _eps ".
         "               where code = '".$_GET['company']."' ".
         "               and season = 'Q2' ) b ".
         "    on a.year = b.year ".
         "    left join (select year, eps ".
         "               from _eps ".
         "                where code = '".$_GET['company']."' ".
         "                and season = 'Q3' ) c ".
         "    on a.year = c.year ".
         "    left join (select year, eps ".
         "               from _eps ".
         "               where code = '".$_GET['company']."' ".
         "               and season = 'Q4' ) d ".
         "    on a.year = d.year ".
         "order by year desc ";
  echo "【歷年表現】<br>";
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th></th>".
           "<th>Q1</th>".
           "<th>Q2</th>".
           "<th>Q3</th>".
           "<th>Q4</th>".          
           "<th>總計</th>".          
         "</tr>".
       "</thead><tbody>";  

  $result = $conn->query($sql);
  foreach ($result as $row)
  {
      echo "<tr class='row100'>";
      echo "  <td>".$row['year']."</td>";
      echo "  <td>".round($row['Q1'],2)."</td>";
      echo "  <td>".round($row['Q2'],2)."</td>";
      echo "  <td>".round($row['Q3'],2)."</td>";
      echo "  <td>".round($row['Q4'],2)."</td>";
      echo "  <td>".round($row['total'],2)."</td>";
      echo "</tr>";
  }

  $sql = "select round(avg(a.eps),2) Q1, ".
         "       round(avg(b.eps),2) Q2, ".
         "       round(avg(c.eps),2) Q3, ".
         "       round(avg(d.eps),2) Q4,  ".
         "       round(avg(a.eps)+avg(b.eps)+avg(c.eps)+avg(d.eps),2) total ".
         "from ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q1' ) a, ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q2' ) b, ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q3' ) c, ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q4' ) d ";

  $result = $conn->query($sql);
  foreach ($result as $row)
  {
      echo "<tr class='row100'>";
      echo "  <td>平均</td>";
      echo "  <td>".$row['Q1']."</td>";
      echo "  <td>".$row['Q2']."</td>";
      echo "  <td>".$row['Q3']."</td>";
      echo "  <td>".$row['Q4']."</td>";
      echo "  <td>".$row['total']."</td>";
      echo "</tr>";
  }  

  echo "</tr></tbody></table></div>";
  echo "\"";
?>
