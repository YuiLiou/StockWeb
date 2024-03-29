<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191124 rusiang  計算毛利率成長，分母使用絕對值
  /* 20191214 rusiang  新增同業比較 
  /* 20200112 rusiang  修正四率成長幅度算法 
  /* 20200118 rusiang  新增同業本業比率 
  /* 20200213 rusiang  指標成長增加今年數值 
  /**********************************************************************************/  
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";

  /*********************************************************************************/
  /*【營益指標】                                                                     
  /*********************************************************************************/
  echo "【營益指標】<br>";
  echo "<canvas id='myChart'></canvas>";

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
         "       this.grossRate, ".
         "       this.operatingRate, ".
         "       this.beforeTaxRate, ".
         "       this.afterTaxRate, ".
         "       round((this.operatingIncome-past.operatingIncome)/abs(past.operatingIncome)*100,2)nIncome, ".
         "       round((this.grossRate-past.grossRate),2)nGross, ".
         "       round((this.operatingRate-past.operatingRate),2)nOperating, ".
         "       round((this.beforeTaxRate-past.beforeTaxRate),2)nBeforeTax, ".
         "       round((this.afterTaxRate-past.afterTaxRate),2)nAfterTax, ".
         "       round(this.operatingRate/this.beforeTaxRate*100,2) mainJob ".
         "from (select i.year, ".
         "             i.season, ".
         "             case when i.season in ('Q4','Q3','Q2') then (i.operatingIncome-x.operatingIncome) ".
         "                  else i.operatingIncome end operatingIncome, ".
         "             i.grossRate, ".
         "             i.operatingRate, ".
         "             i.beforeTaxRate, ".
         "             i.afterTaxRate, ".
         "             i.rnk ".
         "      from ( ".
         "        select i.*, (@rank := @rank + 1) rnk ".
         "        from income i, (select @rank := 0)a ".
         "        where 1=1 ".
         "        and i.code = '".$_GET['company']."' ".
         "        order by i.year desc, i.season desc ".
         "        limit 0,1000) i, income x ".
         "      where 1=1 ".
         "      and i.code = x.code ".
         "      and i.year = x.year ".
         "      and case when i.season='Q4' then x.season='Q3' ".
         "               when i.season='Q3' then x.season='Q2' ".
         "               when i.season='Q2' then x.season='Q1' ".
         "               when i.season='Q1' then x.season='Q1' end) this, ".
         // 去年同期
         "     (select i.year, ".
         "             i.season, ".
         "             case when i.season in ('Q4','Q3','Q2') then (i.operatingIncome-x.operatingIncome) ".
         "                  else i.operatingIncome end operatingIncome, ".
         "             i.grossRate, ".
         "             i.operatingRate, ".
         "             i.beforeTaxRate, ".
         "             i.afterTaxRate, ".
         "             i.rnk ".
         "      from ( ".
         "        select i.*, (@rank2 := @rank2 + 1) rnk ".
         "        from income i, (select @rank2 := 0)a ".
         "        where 1=1 ".
         "        and i.code = '".$_GET['company']."' ".
         "        order by i.year desc, i.season desc ".
         "        limit 4,1000) i, income x ".
         "      where 1=1 ".
         "      and i.code = x.code ".
         "      and i.year = x.year ".
         "      and case when i.season='Q4' then x.season='Q3' ".
         "               when i.season='Q3' then x.season='Q2' ".
         "               when i.season='Q2' then x.season='Q1' ".
         "               when i.season='Q1' then x.season='Q1' end) past ".
         "where this.rnk = past.rnk order by this.rnk asc ";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>";
      // 季節 ------------------------------------------------------------------------------ 
      echo "<td>".$row['season']."</td>";
      // 營收成長率 -------------------------------------------------------------------------
      echo getRateTd($row['nIncome']);
      // 毛利率成長率 ------------------------------------------------------------------------
      if ($row['nGross'] >= 0)
          echo "<td class='up'>".$row['grossRate']."%(".$row['nGross'].")</td>";
      else
          echo "<td class='down'>".$row['grossRate']."%(".$row['nGross'].")</td>";
      // 營業利益率成長 ----------------------------------------------------------------------
      if ($row['nOperating'] >= 0)
          echo "<td class='up'>".$row['operatingRate']."%(".$row['nOperating'].")</td>";
      else
          echo "<td class='down'>".$row['operatingRate']."%(".$row['nOperating'].")</td>";
      // 稅前淨利率成長 ----------------------------------------------------------------------
      if ($row['nBeforeTax'] >= 0)
          echo "<td class='up'>".$row['beforeTaxRate']."%(".$row['nBeforeTax'].")</td>";
      else
          echo "<td class='down'>".$row['beforeTaxRate']."%(".$row['nBeforeTax'].")</td>";
      // 稅後淨利率成長 ----------------------------------------------------------------------
      if ($row['nAfterTax'] >= 0)
          echo "<td class='up'>".$row['afterTaxRate']."%(".$row['nAfterTax'].")</td>";
      else
          echo "<td class='down'>".$row['afterTaxRate']."%(".$row['nAfterTax'].")</td>";
      // 本業利益率 -------------------------------------------------------------------------
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
 
  $sql = "select p.code, p.price, p.pe, c.company, i.grossRate, i.operatingRate, i.beforeTaxRate, ".        
         "       i.afterTaxRate, round((d.cash/p.price)*100,2) dividend, ".
         "       round(i.operatingRate/i.beforeTaxRate*100,2) mainJob ".
         "from prices p, company_map c, dividend d, income i ".
         "where 1=1 ".
         // 同類股 ----------------------------------------------------------------------
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
         // 當天 ----------------------------------------------------------------------
         "and p.date = (select max(date) from prices where code = p.code)".
         "and p.code = c.code ".
         "and i.code = p.code ".
         // 當季 ----------------------------------------------------------------------
         "and i.year = substr((select max(concat(year, season)) from income ),1,4) ".
         "and i.season = substr((select max(concat(year, season)) from income ),5,2) ".
         "and d.code = p.code ".
         "and d.year = (select year from dividend order by year desc limit 0,1) ".
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
