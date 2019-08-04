<?php
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";
  /////////////////////////// 標題 /////////////////////////// 
  echo "<div class='table100 ver1' id='monthlyTbl' style='height:450px;'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th style='width:15%;'>年度/月份</th>".
           "<th>營業收入</th>".
           "<th>毛利率</th>".
           "<th>營業利益率</th>".
           "<th>稅前淨利率</th>". 
           "<th>稅後淨利率</th>".
         "</tr>".
       "</thead><tbody>";
  
  $sql = "select concat(this.year, this.season)season, ".
         "       round((this.operatingIncome-past.operatingIncome)/past.operatingIncome*100,2)nIncome, ".
         "       round((this.grossRate-past.grossRate)/past.grossRate*100,2)nGross, ".
         "       round((this.operatingRate-past.operatingRate)/past.operatingRate*100,2)nOperating, ".
         "       round((this.beforeTaxRate-past.beforeTaxRate)/past.beforeTaxRate*100,2)nBeforeTax, ".
         "       round((this.afterTaxRate-past.afterTaxRate)/past.afterTaxRate*100,2)nAfterTax ".
         "from (select * ".
         "      from income ".
         "      where code = '".$_GET['company']."' ".
         "      order by year desc, season desc ".
         "      limit 0,4) this, ".
         "     (select * ".
         "      from income ".
         "      where code = '".$_GET['company']."' ".
         "      order by year desc, season desc ".
         "      limit 4,4) past ".
         "where this.season = past.season ";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>";
      echo "<td>".$row['season']."</td>";
      echo getRateTd($row['nIncome']);
      echo getRateTd($row['nGross']);
      echo getRateTd($row['nOperating']);
      echo getRateTd($row['nBeforeTax']);
      echo getRateTd($row['nAfterTax']);
      echo "</tr>";
  }
  echo "</tbody></table>";
  echo "</div>\"";
?>
