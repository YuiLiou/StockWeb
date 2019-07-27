<?php
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";

  /*********************************************************************************/
  /* 季增率                                                                      
  /*********************************************************************************/
  $sql = "select round(((this_3.val-past_3.val)/past_3.val*100),2) grow ".
         "from ".
         /*************************************最近三月************************************/
         "    (select code, sum(current) val ".
         "    from ( ".
         "        select code, current, @rank := @rank + 1 AS rank ".
         "        from monthly, (select @rank := 0)a ".
         "        where code = '".$_GET['company']."' ".
         "        order by month desc ".
         "        ) ranked ".
         "    where rank <= 3 ".
         "    group by code) this_3, ".         
         /*************************************去年同期三月************************************/
         "    (select code, sum(current) val ".
         "    from ( ".
         "        select code, current, @rank2 := @rank2 + 1 AS rank ".
         "        from monthly, (select @rank2 := 0)a ".
         "        where code = '".$_GET['company']."' ".
         "        order by month desc ".
         "        ) ranked ".
         "    where rank > 12 and rank <= 15 ".
         "    group by code) past_3 "; 
 
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
  echo "季成長 ".$row['grow']."%";       

  /*********************************************************************************/
  /* 每月營收                                              
  /*********************************************************************************/
  $sql = "select m.*, cons.months ".
         "from monthly m, ".
         "    (select m.month, ".
         "            @rank := (case ".
         "                         when (m.YoY > 0 and @rank > 0) then (@rank + 1) ".
         "                         when (m.YoY > 0) then 1 ".
         "                         when (m.YoY < 0 and @rank < 0) then (@rank - 1) ".
         "                         when (m.YoY < 0) then -1 ".
         "                         else 0 ".
         "                     end) months ".
         "    from monthly m, (select @rank := 0) a ".
         "    where code = '".$_GET['company']."' ".
         "    order by month asc) cons ".
         "where m.code = '".$_GET['company']."' ".
         "and   m.month = cons.month ".
         "order by m.month desc "; 

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  
  /////////////////////////// 標題 /////////////////////////// 
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th style='width:15%;'>年度/月份</th>".
           "<th>營收</th>".
           "<th>月增率</th>".
           "<th>年增率</th>".
           "<th>累計營收</th>". 
           "<th>累計年增率</th>".
           "<th>成長月數</th>".
         "</tr>".
       "</thead><tbody>";

  /////////////////////////// 欄位 /////////////////////////// 
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
      echo   getMarkedTd($row['months']); // yoy成長月
      echo "</tr>";
  }
  echo "</tbody></table></div>\"";
  $result->close();
?>
