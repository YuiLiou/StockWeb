<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191222 rusiang  新增成長性分析 
  /* 20200105 rusiang  新增月均價 
  /* 20200111 rusiang  新增本益比 
  /* 20200112 rusiang  修改營收排行寫法 
  /* 20200119 rusiang  新增12月最高價/本益比，最低價/本益比 
  /**********************************************************************************/ 
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";

  /*********************************************************************************/
  /*『SQL』1/3/12營收年增率                                                                      
  /*********************************************************************************/
  echo "【成長性分析】<br>";
  $months = array(1,3,12);
  foreach ($months as $m) 
  {
      $sql = "select round(((this_3.val-past_3.val)/past_3.val*100),2) growth ".
             "from ".
             /******************************『今年營收總和』************************************/
             "    (select code, sum(current) val ".
             "    from ( ".
             "        select code, current, @rank := @rank + 1 AS rank ".
             "        from monthly, (select @rank := 0)a ".
             "        where code = '".$_GET['company']."' ".
             "        order by month desc ".
             "    ) ranked ".
             "    where rank <= ".$m." ".
             "    group by code) this_3, ".         
             /******************************『去年營收總和』************************************/
             "    (select code, sum(current) val ".
             "    from ( ".
             "        select code, current, @rank2 := @rank2 + 1 AS rank ".
             "        from monthly, (select @rank2 := 0)a ".
             "        where code = '".$_GET['company']."' ".
             "        order by month desc ".
             "    ) ranked ".
             "    where rank > 12 and rank <= ".($m+12)." ".
             "    group by code) past_3 ";
      $result = $conn->query($sql);
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引    
      if ($m == 1)
          echo "當月營收年增率:".$row['growth']."%<br>";
      else if($m == 3)
          echo "短期營收年增率:".$row['growth']."%<br>";
      else if($m == 12)
          echo "長期營收年增率:".$row['growth']."%<br>"; 
  }

  /*********************************************************************************/
  /*『SQL』最新月份                                                                      
  /*********************************************************************************/
  $sql = "select new_month ".
         "from ( ".
         "    select concat('%', substr(month,5,2)) as new_month ".
         "    from monthly m ".
         "    where code = '".$_GET['company']."' ".
         "    order by month desc ".
         "    limit 0,1 ".
         ") n ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引     
  $_GET['new_month'] = $row['new_month']; // 最新月份

  /*********************************************************************************/
  /*『SQL』每月營收                                              
  /*********************************************************************************/
  $sql = "select m.*, cons.grows, record.rank, ".
         /***************************************月均價**************************************/
         "      ( ".
         "        select round(avg(price),2) ".
         "        from prices ".
         "        where code = '".$_GET['company']."' ".
         "        and date like concat(m.month,'%') ".
         "      ) monthPrice, ".
         /***************************************本益比**************************************/
         "      ( ".
         "        select round(avg(pe),2) ".
         "        from prices ".
         "        where code = '".$_GET['company']."' ".
         "        and date like concat(m.month,'%') ".
         "      ) monthPE ".
         "from monthly m, ".
         /***************************************yoy成長月數************************************/
         "    (select m.month, ".
         "            @con := (case ".
         "                         when (m.YoY > 0 and @con > 0) then (@con + 1) ".
         "                         when (m.YoY > 0)              then 1 ".
         "                         when (m.YoY < 0 and @con < 0) then (@con - 1) ".
         "                         when (m.YoY < 0)              then -1 ".
         "                         else 0 ".
         "                     end) grows ".
         "    from monthly m, (select @con := 0) a ".
         "    where code = '".$_GET['company']."' ".
         "    order by month asc) cons, ".
         /***************************************營收排行**************************************/
         "    (select m.month, @rank := @rank +1 rank ".
         "    from monthly m, (select @rank := 0) a ".
         "    where code = '".$_GET['company']."' ".
         "    order by current desc) record ".
         "where m.code  = '".$_GET['company']."' ".
         "and   m.month = cons.month ".
         "and   m.month = record.month ".
         "order by m.month desc ";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  
  /*********************************************************************************/
  /*『HTML』每月營收                                              
  /*********************************************************************************/ 
  echo "【每月營收】<br>";
  $monthlyStr  = "";
  $monthlyStr .= "<div class='table100 ver1' id='monthlyTbl' style='height:700px;'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th>年度/月份</th>".
           "<th>營收</th>".
           "<th>月增率</th>".
           "<th>年增率</th>".
           "<th>累計營收</th>". 
           "<th>累計年增率</th>".
           "<th>成長月數</th>".
           "<th>月均價</th>".
           "<th>月均本益比</th>".
         "</tr>".
       "</thead><tbody>";
  $price_ary = array();
  $pe_ary = array();
  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result);                       //將陣列以欄位名索引
      $monthlyStr .= "<tr class='row100'>".
             "<td>".$row['month']."</td>". 
             "<td>".$row['current']." (".$row['rank'].")</td>";
      $monthlyStr .= getRateTd($row['MoM']);                    // 月增率
      $monthlyStr .= getRateTd($row['YoY']);                    // 年增率
      $monthlyStr .= "<td>".$row['Yearly']."</td>";             // 年營收
      $monthlyStr .= getRateTd($row['Yearly_YoY']);             // 累計年增率
      $monthlyStr .= getMarkedTd($row['grows']);                // yoy成長月
      $monthlyStr .= "<td>".$row['monthPrice']."</td>";
      $monthlyStr .= "<td>".$row['monthPE']."</td>";
      $monthlyStr .= "</tr>";
      if ($i < 12) //過去12月的平均價/平均本益比
      {
          $price_ary[$row['month']] = $row['monthPrice'];
          $pe_ary[$row['month']] = $row['monthPE'];
      }
  }
  $monthlyStr .= "</tbody></table></div>";  
  asort($price_ary);
  asort($pe_ary);
  // 12過去月最高價/最低價 ///////////////////////////////////////////////////////////////////
  foreach ( $price_ary as $key => $value )
  {   
      if ($key === array_key_first($price_ary))
          echo "過去12月最低價:".$value."，發生於".$key."<br>";
      else if ($key === array_key_last($price_ary))
          echo "過去12月最高價:".$value."，發生於".$key."<br>";
  }
  // 12過去月最高本益比/最低本益比 /////////////////////////////////////////////////////////////
  foreach ( $pe_ary as $key => $value )
  {   
      if ($key === array_key_first($pe_ary))
          echo "過去12月最低本益比:".$value."，發生於".$key."<br>";
      else if ($key === array_key_last($pe_ary))
          echo "過去12月最高本益比:".$value."，發生於".$key."<br>";
  }
  echo $monthlyStr;

  /*********************************************************************************/
  /*『SQL』歷年累計營收                                              
  /*********************************************************************************/
  $sql = "select m.*, cons.grows, record.rank, record2.yearlyRank ".
         "from monthly m, ".
         /***************************************成長年數************************************/
         "    (select m.month, m.code, ".
         "            @con := (case ".
         "                         when (m.YoY > 0 and @con > 0) then (@con + 1) ".
         "                         when (m.YoY > 0)              then 1 ".
         "                         when (m.YoY < 0 and @con < 0) then (@con - 1) ".
         "                         when (m.YoY < 0)              then -1 ".
         "                         else 0 ".
         "                     end) grows ".
         "    from monthly m, (select @con := 0) a ".
         "    where 1=1 ".
         "    and code = '".$_GET['company']."' ".
         "    and month like '".$_GET['new_month']."' ".
         "    order by month asc) cons, ".
         /***************************************營收排行**************************************/
         "    (select m.month, @rank := @rank +1 rank ".
         "    from monthly m, (select @rank := 0) a ".
         "    where 1=1 ".
         "    and code = '".$_GET['company']."' ".
         "    and month like '".$_GET['new_month']."' ".
         "    order by current desc) record, ".
         /***************************************累計營收排行**************************************/
         "    (select m.month, @rank2 := @rank2 +1 yearlyRank ".
         "    from monthly m, (select @rank2 := 0) a ".
         "    where 1=1 ".
         "    and code = '".$_GET['company']."' ".
         "    and month like '".$_GET['new_month']."' ".
         "    order by Yearly desc) record2 ". 
         "where 1=1 ".
         "and m.code = cons.code ".
         "and m.month = cons.month ".
         "and m.month = record.month ".
         "and m.month = record2.month ".
         "order by month desc ";

  /*********************************************************************************/
  /*『HTML』歷年累計營收                                              
  /*********************************************************************************/
  echo "【歷年累計營收】";
  echo "<div class='table100 ver1' id='monthlyTbl'>".
         "<table data-vertable='ver1'>".
         "<thead>".
           "<tr class='row100 head'>".
             "<th>年度/月份</th>".
             "<th>營收</th>".
             "<th>月增率</th>".
             "<th>年增率</th>".
             "<th>累計營收</th>". 
             "<th>累計年增率</th>".
             "<th>成長年數</th>".
           "</tr>".
         "</thead><tbody>";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);                             // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result);                                //將陣列以欄位名索引
      echo "<tr class='row100'>".
             "<td>".$row['month']."</td>".                               // 月份
             "<td>".$row['current']." (".$row['rank'].")</td>";          // 月營收
      echo   getRateTd($row['MoM']);                                     // 月增率
      echo   getRateTd($row['YoY']);                                     // 年增率
      echo   "<td>".$row['Yearly']." (".$row['yearlyRank'].")</td>";     // 年營收
      echo   getRateTd($row['Yearly_YoY']);                              // 累計年增率
      echo   getMarkedTd($row['grows']);                                 // yoy成長月
      echo "</tr>";
  }
  echo "</tbody></table></div>";
  echo "\"";
  $result->close();
?>
