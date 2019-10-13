<?php
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";

  /*********************************************************************************/
  /*『SQL』月/季/年增率                                                                      
  /*********************************************************************************/
  $sql = "select round(((this_3.val-past_3.val)/past_3.val*100),2) qoy, new_month, YoY, Yearly_YoY ".
         "from ".
         /******************************『季增率』最近三月************************************/
         "    (select code, sum(current) val ".
         "    from ( ".
         "        select code, current, @rank := @rank + 1 AS rank ".
         "        from monthly, (select @rank := 0)a ".
         "        where code = '".$_GET['company']."' ".
         "        order by month desc ".
         "    ) ranked ".
         "    where rank <= 3 ".
         "    group by code) this_3, ".         
         /******************************『季增率』去年三月************************************/
         "    (select code, sum(current) val ".
         "    from ( ".
         "        select code, current, @rank2 := @rank2 + 1 AS rank ".
         "        from monthly, (select @rank2 := 0)a ".
         "        where code = '".$_GET['company']."' ".
         "        order by month desc ".
         "    ) ranked ".
         "    where rank > 12 and rank <= 15 ".
         "    group by code) past_3, ".
         "    (select concat('%', substr(month,5,2)) as new_month, YoY, Yearly_YoY ".
         "    from monthly m ".
         "    where code = '".$_GET['company']."' ".
         "    order by month desc ".
         "    limit 0,1) n "; 
 
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
  echo "『月成長』".$row['YoY']."%<br>";       
  echo "『季成長』".$row['qoy']."%<br>";       
  echo "『年成長』".$row['Yearly_YoY']."%<br>";       
  $_GET['new_month'] = $row['new_month']; // 最新月份

  /*********************************************************************************/
  /*『SQL』每月營收                                              
  /*********************************************************************************/
  $sql = "select m.*, cons.grows, record.rank ".
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
           "<th>成長月數</th>".
           "<th>排行</th>".
         "</tr>".
       "</thead><tbody>";

  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>".
             "<td>".$row['month']."</td>". 
             "<td>".$row['current']."</td>";
      echo   getRateTd($row['MoM']); // 月增率
      echo   getRateTd($row['YoY']); // 年增率
      echo   "<td>".$row['Yearly']."</td>"; // 年營收
      echo   getRateTd($row['Yearly_YoY']); // 累計年增率
      echo   getMarkedTd($row['grows']); // yoy成長月
      echo   "<td>".$row['rank']."</td>";
      echo "</tr>";
  }
  echo "</tbody></table></div>";

  /*********************************************************************************/
  /*『SQL』歷年累計營收                                              
  /*********************************************************************************/
  $sql = "select m.*, cons.grows, record.rank ".
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
         "    order by current desc) record ".
         "where 1=1 ".
         "and m.code = cons.code ".
         "and m.month = cons.month ".
         "and m.month = record.month ".
         "order by month desc ";

  /*********************************************************************************/
  /*『HTML』歷年累計營收                                              
  /*********************************************************************************/
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
             "<th>成長月數</th>".
             "<th>排行</th>".
           "</tr>".
         "</thead><tbody>";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);    // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result);       //將陣列以欄位名索引
      echo "<tr class='row100'>".
             "<td>".$row['month']."</td>". 
             "<td>".$row['current']."</td>";
      echo   getRateTd($row['MoM']);            // 月增率
      echo   getRateTd($row['YoY']);            // 年增率
      echo   "<td>".$row['Yearly']."</td>";     // 年營收
      echo   getRateTd($row['Yearly_YoY']);     // 累計年增率
      echo   getMarkedTd($row['grows']);        // yoy成長月
      echo   "<td>".$row['rank']."</td>";
      echo "</tr>";
  }
  echo "</tbody></table></div>";
  echo "\"";
  $result->close();
?>
