<?php
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";
  /*********************************************************************************/
  /*【股利政策】                                                                     
  /*********************************************************************************/
  echo "【股利政策】<br>";
  
  $sql = "select d.*, ".
         "       (case ".
         "           when (d.cash = 0) then 0 ".
         "           when (e.eps = 0) then 0 ".
         "           else round(d.cash*100/e.eps,2) ".
         "       end) dispatch ". 
         "from dividend d, ".
         "    (select year, eps ".
         "    from eps ".
         "    where code = '".$_GET['company']."' ".
         "    and season = 'Q4')e ".
         "where code = '".$_GET['company']."' ".
         "and d.year = e.year ".
         "order by year desc ";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數

  /////////////////////////// 標題 /////////////////////////// 
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th>年度</th>".
           "<th>現金股利</th>".
           "<th>股票股利</th>".
           "<th>總和</th>".
           "<th>現金發放率</th>". 
         "</tr>".
       "</thead><tbody>";

  /////////////////////////// 欄位 /////////////////////////// 
  for ($i=0;$i<$total_records;$i++){ 
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>";
      echo "  <td>".$row['year']."</td>"; 
      echo "  <td>".$row['cash']."</td>";
      echo "  <td>".$row['allotment']."</td>";
      echo "  <td>".$row['total']."</td>";
      echo "  <td>".$row['dispatch']."%</td>";
      echo "</tr>";
  }
  echo "</tbody></table></div>\"";
  $result->close();
?>
