<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191124 rusiang  計算毛利率成長，分母使用絕對值
  /* 20191214 rusiang  新增同業比較 
  /* 20200112 rusiang  修正四率成長幅度算法 
  /* 20200118 rusiang  新增同業本業比率 
  /**********************************************************************************/  
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";
  /*********************************************************************************/
  /*『SQL』指標成長                                                               
  /*********************************************************************************/
  echo "【指標成長】（本業比率太低者追月營收無意義）<br>";
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
           "<th>本業比率</th>".
         "</tr>".
       "</thead><tbody>";
  
  $sql = "select concat(this.year, this.season)season, ".
         "       round((this.operatingIncome-past.operatingIncome)/abs(past.operatingIncome)*100,2)nIncome, ".
         "       round((this.grossRate-past.grossRate),2)nGross, ".
         "       round((this.operatingRate-past.operatingRate),2)nOperating, ".
         "       round((this.beforeTaxRate-past.beforeTaxRate),2)nBeforeTax, ".
         "       round((this.afterTaxRate-past.afterTaxRate),2)nAfterTax, ".
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
  echo "</div>";

  /*********************************************************************************/
  /*『SQL』同業比較                                                               
  /*********************************************************************************/
  echo "【同業比較】<br>";
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th>公司</th>".
           "<th>收盤價</th>".
           "<th>本益比</th>".
           "<th>現金殖利率</th>".
           "<th>毛利率</th>".
           "<th>營業利益率</th>".
           "<th>稅前利益率</th>".
           "<th>稅後利益率</th>".
           "<th>本業比率</th>".
         "</tr>".
       "</thead><tbody>";

  // get today
  $sql = "SELECT date ".
         "FROM prices ".
         "order by date desc ".
         "limit 0,1 ";
  $result = $conn->query($sql);
  $row    = mysqli_fetch_assoc($result); //將陣列以欄位名索引
  $today  = $row['date']; 

  // get this year, season
  $sql = "SELECT year, season ".
         "FROM income ".
         "order by year desc, season desc ".
         "limit 0,1 ";
  $result  = $conn->query($sql);
  $row     = mysqli_fetch_assoc($result); //將陣列以欄位名索引
  $tYear   = $row['year']; 
  $pYear   = (string)((int)$tYear-1); 
  $tSeason = $row['season'];
 
  $sql = "select p.code, p.price, p.pe, c.company, i.grossRate, i.operatingRate, i.beforeTaxRate, ".        
         "       i.afterTaxRate, round((d.cash/p.price)*100,2) dividend, ".
         "       round(i.operatingRate/i.beforeTaxRate*100,2) mainJob ".
         "from prices p, company_map c, dividend d, income i ".
         "where 1=1 ".
         ///同類股
         "and p.code in ( ". 
         "    select code ".
         "    from company_map c ".
         "    where 1=1 ".
         "    and grp in ( ".
         "        select grp ".
         "        from company_map ".
         "        where code = '".$_GET['company']."' ".
         "    ) ".
         ") ".
         ////當天
         "and p.date = '".$today."' ".
         "and p.code = c.code ".
         "and i.code = p.code ".
         "and i.year = '".$tYear."' ".
         "and i.season = '".$tSeason."' ".
         "and d.code = p.code ".
         "and d.year = (select year from dividend order by year desc limit 0,1) ".
//       "and d.year = '".$pYear."' ".
         "order by code asc ";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>";
      echo "<td><a href=finance.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td>";
      echo "<td>".$row['price']."</td>";
      echo "<td>".$row['pe']."</td>";
      echo "<td>".$row['dividend']."%</td>";
      echo "<td>".$row['grossRate']."%</td>";
      echo "<td>".$row['operatingRate']."%</td>";
      echo "<td>".$row['beforeTaxRate']."%</td>";
      echo "<td>".$row['afterTaxRate']."%</td>";
      echo "<td>".$row['mainJob']."%</td>";
      echo "</tr>";
  }
  echo "</tbody></table>";
  echo "</div>";
  echo "\"";
?>
