<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200215 rusiang  新增集保統計 
  /**********************************************************************************/    
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";    
  /*********************************************************************************/
  /*『SQL』集保統計                                                                      
  /*********************************************************************************/
  echo "【集保統計】<br>";
  $sql = "select a.*, ".
         "       (p_all-p_400) p_400_minus, ".
         "       (100-r_400) r_400_minus ".
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
         //   >400張股東持有比例
         "    ( ". 
         "      select round(sum(rate),2) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000','600001-800000','800001-1000000','1000001以上') ".
         "    ) r_400, ".
         //   >400張股東人數
         "    ( ".   
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('400001-600000','600001-800000','800001-1000000','1000001以上') ".
         "    ) p_400, ". 
         //   600-800張股東人數
         "    ( ". 
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('600001-800000') ".
         "    ) p_600, ". 
         //   800-1000張股東人數
         "    ( ". 
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('800001-1000000') ".
         "    ) p_800, ". 
         //   >1000張股東人數
         "    ( ". 
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "      and rank in ('1000001以上') ".
         "    ) p_1000, ". 
         //   股東總人數
         "    ( ". 
         "      select sum(person) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "    ) p_all, ".
         //   總張數
         "    ( ". 
         "      select sum(number) ".
         "      from share_ratio ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
         "    ) n_all, ".
         //   股價
         "    ( ".
         "      select price ".
         "      from prices ".
         "      where 1=1 ".
         "      and code = s.code ".
         "      and date = s.date ".
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
           "<th>400張股東持有比例</th>".
           "<th>400張股東人數</th>".
           "<th>600-800張股東人數</th>".
           "<th>800-1000張股東人數</th>".
           "<th>1000張股東人數</th>". 
         "</tr>".
       "</thead>";
  echo "<tbody>";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result); 
      echo "<tr class='row100'>";
      echo "<td>".$row['date']."</td>";
      echo "<td>".$row['price']."</td>";
      echo "<td>".$row['p_all']."</td>";
      echo "<td>".$row['p_400_minus']."</td>";
      echo "<td>".$row['r_400_minus']."</td>";
      echo "<td>".$row['n_400']."</td>";
      echo "<td>".$row['r_400']."</td>";
      echo "<td>".$row['p_400']."</td>";
      echo "<td>".$row['p_600']."</td>";
      echo "<td>".$row['p_800']."</td>";
      echo "<td>".$row['p_1000']."</td>";
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
