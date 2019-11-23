<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191116 rusiang  新增長期投資項目＆固定資產＆綜合損益  
  /* 20191123 rusiang  新增股本＆每股淨值＆股東權益＆ROE＆合約負債  
  /**********************************************************************************/  
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";

  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from property_2 ".
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);
  echo "<form action='finance.php?company=".$_GET['company']."' method='POST'>";    
  echo "    <select id='slct' name='season' onchange='this.form.submit()'>";  
  foreach ($result as $row)
  {
      $selSeason = $row['year'].$row['season'];
      if (empty($_POST['season']))
      {
          $_POST['season'] = $selSeason; // 預設
      }      
      if ($_POST['season'] == $selSeason) // 顯示被選擇的季節
          echo "<option selected='selected' value='".$selSeason."'>".$selSeason."</option>";
      else
          echo "<option value='".$selSeason."'>".$selSeason."</option>";
  }
  echo "  </select>";
  echo "  <input type='hidden' name='type' value='property'>";
  echo "</form>";

  $tYear = substr($_POST['season'],0,4);
  $tSeason = substr($_POST['season'],4,6);

  /*********************************************************************************/
  /*『SQL』長期投資項目...tbd盈再率 (Table1)                                                                    
  /*********************************************************************************/
  $sql = "select a.year, a.season, profit, investment, house, shareholder, ".
         "       round(profit/shareholder*100,2) ROE, share, contract, stockvalue ".
         "from ( ".
//      「資產負債表」股本 ----------------------------------------------------------------
         "    select year, season, value share ".
         "    from property ".
         "    where 1=1 ".
         "    and col_name in ('股本') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = 'Q4') a ".
//      「資產負債表」長期投資 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, sum(v1) investment ".
         "    from property_2 ".
         "    where 1=1 ".
         "    and col_name in ('透過其他綜合損益按公允價值衡量之金融資產－非流動', ".
         "    '備供出售金融資產－非流動淨額', ".
         "    '以成本衡量之金融資產－非流動淨額', ".
         "    '採用權益法之投資淨額', ".
         "    '採用權益法之投資', ".
         "    '按攤銷後成本衡量之金融資產－非流動') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = 'Q4' ".
         "    group by year, season ) b ".
         "on a.year = b.year and a.season = b.season ".
//      「資產負債表」固定資產 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, sum(v1) house ".
         "    from property_2 ".
         "    where 1=1 ".
         "    and col_name in ('不動產、廠房及設備', '投資性不動產淨額') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = 'Q4' ".
         "    group by year, season ) c ".
         "on a.year = c.year and a.season = c.season ".
//      「資產負債表」股東權益 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, value shareholder ".
         "    from property ".
         "    where 1=1 ".
         "    and col_name in ('歸屬於母公司業主之權益合計') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = 'Q4') d ".
         "on a.year = d.year and a.season = d.season ".
//      「資產負債表」合約負債 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, v1 contract ".
         "    from property_2 ".
         "    where 1=1 ".
         "    and col_name in ('合約負債－流動') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = 'Q4') e ".
         "on a.year = e.year and a.season = e.season ".
//       「綜合損益表」獲利 ----------------------------------------------------------------   
         "left join ( ".
         "    select i.year, i.season, i.value profit ".
         "    from income_2 i ".
         "    where 1=1 ".
         "    and i.code = '".$_GET['company']."' ".
         "    and i.season = 'Q4' ".
         "    and i.col_name = '綜合損益總額歸屬於母公司業主') f ".
         "on a.year = f.year and a.season = f.season ".
//      「資產負債表」每股淨值 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, value stockvalue ".
         "    from property ".
         "    where 1=1 ".
         "    and col_name in ('每股參考淨值') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = 'Q4') g ".
         "on a.year = g.year and a.season = g.season ";
         
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  echo "<div class='table100 ver1' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>年份</th>";
  echo "        <th>股本</th>";
  echo "        <th>每股淨值</th>";
  echo "        <th>長期投資項目</th>";
  echo "        <th>固定資產</th>";
  echo "        <th>綜合損益總額歸屬於母公司業主</th>";
  echo "        <th>股東權益</th>";
  echo "        <th>ROE</th>";
  echo "        <th>合約負債</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";
  for ($i=0;$i<$total_records;$i++)
  {  
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "  <tr>";
      echo "    <td>".$row['year'].$row['season']."</td>";
      echo "    <td>".$row['share']."</td>";
      echo "    <td>".$row['stockvalue']."</td>";
      echo "    <td>".$row['investment']."</td>";
      echo "    <td>".$row['house']."</td>";
      echo "    <td>".$row['profit']."</td>";
      echo "    <td>".$row['shareholder']."</td>";
      echo "    <td>".$row['ROE']."</td>";
      echo "    <td>".$row['contract']."</td>";
      echo "  </tr>";
  }
  echo "    </tbody>";
  echo "  </table>";
  //echo "</div>";
  /* back up */
  // 『SQL』資產負債簡表 (Table2) ////////////////////////////////////////////
  $pYear = (string)((int)substr($_POST['season'],0,4)-1);
  
  //echo "<div class='table100 ver1' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th></th>";
  echo "        <th>".$tYear.$tSeason."</th>";
  echo "        <th>".$pYear.$tSeason."</th>";
  echo "        <th>成長</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  //******************************************* 全部欄位 *******************************************
  $sql = "select this_y.col_name, this_y.value this_value, past_y.value past_value, ".
         "       round((this_y.value-past_y.value)/abs(past_y.value)*100,2) grow ".
         "from (select i.col_name, i.value ".
         "      from property i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$tYear."' ".
         "      and i.season = '".$tSeason."') this_y, ".
         "     (select i.col_name, i.value ".
         "      from property i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$pYear."' ".
         "      and i.season = '".$tSeason."') past_y ".
         "where 1=1 ".
         "and this_y.col_name = past_y.col_name ".
         "order by this_y.col_name asc ";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "  <tr class='row100'>";
      echo "    <td>".$row['col_name']."</td>";  
      echo "    <td>".$row['this_value']."</td>";      
      echo "    <td>".$row['past_value']."</td>";
      echo      getRateTd($row['grow']);
      echo "  </tr>";      
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>";

  /*********************************************************************************/
  /*『SQL』資產負債表 (Table3)                                                                     
  /*********************************************************************************/
  $sql = "select col_name, v1, v2, v3, v4, v5, v6 ".
         "from property_2 i ".
         "where 1=1 ".
         "and i.code = '".$_GET['company']."' ".
         "and i.year = '".$tYear."' ".
         "and i.season = '".$tSeason."' ".
         "order by col_index ";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {  
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      if ($i == 0)
      {
          echo "<div class='table100 ver1' id='monthlyTbl'>";
          echo "  <table data-vertable='ver1'>";
          echo "    <thead>";
          echo "      <tr class='row100 head'>";
          echo "        <th>".$row['col_name']."</th>";
          echo "        <th>".$row['v1']."</th>";
          echo "        <th>".$row['v2']."</th>";
          echo "        <th>".$row['v3']."</th>";
          echo "        <th>".$row['v4']."</th>";
          echo "        <th>".$row['v5']."</th>";
          echo "        <th>".$row['v6']."</th>";
          echo "      </tr>";
          echo "    </thead>";
          echo "    <tbody>";
      }
      else 
      {
          echo "<tr>";
          echo "<td>".$row['col_name']."</td>";    
          echo "<td>".$row['v1']."</td>";    
          echo "<td>".$row['v2']."</td>";  
          echo "<td>".$row['v3']."</td>";  
          echo "<td>".$row['v4']."</td>";  
          echo "<td>".$row['v5']."</td>";  
          echo "<td>".$row['v6']."</td>";  
          echo "</tr>";  
      }
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>\""
?>
