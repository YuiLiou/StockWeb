<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191124 rusiang  計算毛利率成長，分母使用絕對值 
  /**********************************************************************************/  
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";
  /////////////////////////// 標題 /////////////////////////// 
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th style='width:15%;'>年度/月份</th>".
           "<th>營業收入</th>".
           "<th>毛利率</th>".
           "<th>營業利益率</th>".
           "<th>稅前淨利率</th>". 
           "<th>稅後淨利率</th>".
           "<th>本業收入</th>".
         "</tr>".
       "</thead><tbody>";
  
  $sql = "select concat(this.year, this.season)season, ".
         "       round((this.operatingIncome-past.operatingIncome)/abs(past.operatingIncome)*100,2)nIncome, ".
         "       round((this.grossRate-past.grossRate)/abs(past.grossRate)*100,2)nGross, ".
         "       round((this.operatingRate-past.operatingRate)/abs(past.operatingRate)*100,2)nOperating, ".
         "       round((this.beforeTaxRate-past.beforeTaxRate)/abs(past.beforeTaxRate)*100,2)nBeforeTax, ".
         "       round((this.afterTaxRate-past.afterTaxRate)/abs(past.afterTaxRate)*100,2)nAfterTax, ".
         "       round(this.operatingRate/this.beforeTaxRate*100,2) mainJob ".
         "from (select i.*, @rank := @rank + 1 rnk ".
         "      from income i, ".
         "      (select @rank := 0)a ".
         "      where code = '".$_GET['company']."' ".
         "      order by year desc, season desc ".
         "      limit 0,1000) this, ".
         "     (select i.*, @rank2 := @rank2 + 1 rnk ".
         "      from income i, ".
         "      (select @rank2 := 0)a ".
         "      where code = '".$_GET['company']."' ".
         "      order by year desc, season desc ".
         "      limit 4,1000) past ".
         "where this.rnk = past.rnk ";

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
      echo "<td>".$row['mainJob']."%</td>";
      echo "</tr>";
  }
  echo "</tbody></table>";
  echo "</div>\"";
?>
