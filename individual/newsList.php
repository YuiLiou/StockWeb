<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200215 rusiang  新增集保統計 
  /* 20200216 rusiang  新增大股東比例 
  /* 20200222 rusiang  大股東持有比例上色 
  /* 20200725 rusiang  統計大股東最近四周買進張數 
  /**********************************************************************************/    
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";    

  /*********************************************************************************/
  /*【大股東比例】                                              
  /*********************************************************************************/
  echo "【大股東比例】<br>";
  echo "<canvas id='shareRatioChart'></canvas>";  
  
  /*********************************************************************************/
  /*【四百張股東四周變化】                                              
  /*********************************************************************************/  
  echo "【四百張股東最近四周】";
  $sql = "SELECT t.grow ".
         "FROM ".
         "( ".
         "  select date, super, ".
         "         @rnk:=@rnk+1 rnk, ".
         "         ( ".
         "           CASE ".
         "             WHEN @rnk = 1 THEN @cur_super:=super ".
         "             ELSE @cur_super - super ".
         "           END ".
         "         ) grow ".
         "  FROM ".
         "  ( ".
         "    SELECT t.date, SUM(t.number) super ".
         "    FROM share_ratio t ".
         "    WHERE rank IN ('400001-600000' , '600001-800000', '800001-1000000', '1000001以上') ".
         "    and code = '".$_GET['company']."' ".
         "    GROUP BY date DESC ".
         "  ) t, (SELECT @rnk:=0, @cur_super:=0) p ".
         ") t ".
         "WHERE rnk = 4 "; 
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); 
  if ($row['grow'] > 0)
    echo "<font color='red'>買進".$row['grow']."張</font><br>";
  else 
    echo "<font color='red'>賣出".$row['grow']."張</font><br><br><br>";
   
  /*********************************************************************************/
  /*【集保統計】
  /*********************************************************************************/
  echo "【集保統計】<br>";
  $sql = "select a.*, ".
         "       (p_all-p_400) p_400_minus, ". // 散戶人數
         "       (100-r_400_up) r_400_minus ". // 散戶比例
         "from ".
         "( ".
         "  select distinct s.date, ".
         //   >400張股東持有張數
         "    ( ". 
         "      select sum(number) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000','600001-800000','800001-1000000','1000001以上') ".
         "    ) n_400, ".
         //   >400張股東人數
         "    ( ". 
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000','600001-800000','800001-1000000','1000001以上') ".
         "    ) p_400, ".
         //   >400張股東持有比例
         "    ( ". 
         "      select round(sum(rate),2) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000','600001-800000','800001-1000000','1000001以上') ".
         "    ) r_400_up, ".
         //   400-600張持有比例
         "    ( ".   
         "      select round(sum(rate),2) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000') ".
         "    ) r_400, ". 
         //   600-800張持有比例
         "    ( ". 
         "      select round(sum(rate),2) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('600001-800000') ".
         "    ) r_600, ". 
         //   800-1000張持有比例
         "    ( ". 
         "      select round(sum(rate),2) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('800001-1000000') ".
         "    ) r_800, ". 
         //   >1000張持有比例
         "    ( ". 
         "      select round(sum(rate),2) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('1000001以上') ".
         "    ) r_1000, ". 
         //   股東總人數
         "    ( ". 
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank not in ('合　計') ".
         "    ) p_all, ".
         //   總張數
         "    ( ". 
         "      select sum(number) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank not in ('合　計') ".
         "    ) n_all, ".
         //   股價
         "    ( ".
         "      select price ".
         "      from prices ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date <= s.date ".
         "      order by date desc ".
         "      limit 0,1 ".
         "    ) price ".
         "  from share_ratio s ".
         "  where code = '".$_GET['company']."' ".
         "  order by date desc ".
         ") a ";

  echo "<div class='table100 ver1 m-b-110' style='height:800px;'>";
  echo "<table data-vertable='ver1'>";
  echo "<thead>".
         "<tr class='row100 head'>".
           "<th>日期</th>".
           "<th>股價</th>".
           "<th>股東總人數</th>".
           "<th>散戶人數</th>".
           "<th>散戶比例</th>".
           "<th>400張股東持有張數</th>".
           "<th>400張以上持有比例</th>".
           "<th>400-600張持有比例</th>".
           "<th>600-800張持有比例</th>".
           "<th>800-1000張持有比例</th>".
           "<th>1000張持有比例</th>". 
         "</tr>".
       "</thead>";
  echo "<tbody>";
  // 現在集保 ------------------------------------------------------
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  // 上週集保 ------------------------------------------------------
  $result_past = $conn->query($sql);
  mysqli_fetch_assoc($result_past); 
  // --------------------------------------------------------------
  for ($i=0;$i<$total_records-1;$i++)
  { 
      $row      = mysqli_fetch_assoc($result);
      $row_past = mysqli_fetch_assoc($result_past); 
      
      echo "<tr class='row100'>";
      echo "<td>".$row['date']."</td>";
      echo getShareRatio($row['price']   , $row_past['price']);     
      echo "<td>".$row['p_all']."</td>";                             // 股東總人數
      echo "<td>".$row['p_400_minus']."</td>";                       // 散戶人數
      echo "<td>".$row['r_400_minus']."</td>";                       // 散戶比例
      echo getShareRatio($row['n_400']   , $row_past['n_400']);      // 大戶張數
      echo getShareRatio($row['r_400_up'], $row_past['r_400_up']);   // 大戶比例
      echo getShareRatio($row['r_400']   , $row_past['r_400']);      // 400張比例
      echo getShareRatio($row['r_600']   , $row_past['r_600']);      // 600張比例
      echo getShareRatio($row['r_800']   , $row_past['r_800']);      // 800張比例
      echo getShareRatio($row['r_1000']  , $row_past['r_1000']);     // 1000張比例
      echo "</tr>";
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>";
  /*********************************************************************************/
  /*『SQL』新聞列表                                                                      
  /*********************************************************************************/
  echo "【新聞列表】<br>";
  $sql = "select title, date, url ".
         "from news ".
         "where code = '".$_GET['company']."' ".
         "and logTime >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) ".
         "order by date desc ".
         "limit 0,30 ";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數

  ////////////////////////////// 新聞列表 ///////////////////////////////
  echo "<div id='newsList' style='height:400px;'><nav><ul>";
  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo  "<li><a href='".$row['url']."' target='_blank'>".$row['date']." ".$row['title']."</a></li>";
  }
  echo "</ul></nav></div>";
  echo "\"";
?>
