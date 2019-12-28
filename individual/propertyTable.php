<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191116 rusiang  新增長期投資項目＆固定資產＆綜合損益  
  /* 20191123 rusiang  新增股本＆每股淨值＆股東權益＆ROE＆合約負債  
  /* 20191130 rusiang  新增策略分析說明
  /* 20191228 rusiang  新增股本成長率
  /* 20191228 rusiang  新增杜邦分析
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
  echo "【外部連結】";
  echo "<a href='http://pchome.megatime.com.tw/stock/sto3/ock4/sid".$_GET['company'].".html'>轉投資項目</a><br>";
  echo "【歷年資產指標】<br>";
  /*********************************************************************************/
  /*『SQL』長期投資項目...tbd盈再率 (Table1)                                                                    
  /*********************************************************************************/
  $sql = "select a.year, a.season, profit, investment, house, shareholder, ".
         "       round(profit/shareholder*100,2) ROE, share, contract, stockvalue, ".
         "       round(profit/h.value*100,2) profitRate, ".           // 淨利率
         "       round(h.value/i.value*100,2) assetTurnOver, ".       // 資產週轉率
         "       round(i.value/shareholder*100,2) equityMultiplier ". // 權益乘數 
         "from ( ".
//      「資產負債表」股本 ----------------------------------------------------------------
         "    select year, season, value share ".
         "    from property ".
         "    where 1=1 ".
         "    and col_name in ('股本') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."') a ".
//      「資產負債表」長期投資 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, sum(v1) investment ".
         "    from property_2 ".
         "    where 1=1 ".
         "    and col_name in ('採用權益法之投資淨額', '採用權益法之投資') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."' ".
         "    group by year, season ) b ".
         "on a.year = b.year and a.season = b.season ".
//      「資產負債表」固定資產 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, sum(v1) house ".
         "    from property_2 ".
         "    where 1=1 ".
         "    and col_name in ('不動產、廠房及設備', '投資性不動產淨額') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."' ".
         "    group by year, season ) c ".
         "on a.year = c.year and a.season = c.season ".
//      「資產負債表」股東權益 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, value shareholder ".
         "    from property ".
         "    where 1=1 ".
         "    and col_name in ('歸屬於母公司業主之權益合計') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."' ) d ".
         "on a.year = d.year and a.season = d.season ".
//      「資產負債表」合約負債 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, v1 contract ".
         "    from property_2 ".
         "    where 1=1 ".
         "    and col_name in ('合約負債－流動') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."') e ".
         "on a.year = e.year and a.season = e.season ".
//       「綜合損益表」獲利 ----------------------------------------------------------------   
         "left join ( ".
         "    select i.year, i.season, i.value profit ".
         "    from income_2 i ".
         "    where 1=1 ".
         "    and i.code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."' ".
         "    and i.col_name = '本期淨利（淨損）') f ".
         "on a.year = f.year and a.season = f.season ".
//      「資產負債表」每股淨值 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, value stockvalue ".
         "    from property ".
         "    where 1=1 ".
         "    and col_name in ('每股參考淨值') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."') g ".
         "on a.year = g.year and a.season = g.season ".
//      「綜合損益表」營業收入 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, value ".
         "    from income_2 ".
         "    where 1=1 ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."' ".
         "    and col_name = '營業收入') h ".
         "on a.year = h.year and a.season = h.season ".
//      「資產負債表」資產總計 --------------------------------------------------------------
         "left join ( ".
         "    select year, season, value ".
         "    from property ".
         "    where 1=1 ".
         "    and col_name in ('資產總計') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."') i ".
         "on a.year = i.year and a.season = i.season ";
         
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  echo "<div class='table100 ver1' id='monthlyTbl' style='height:600px;'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>年份</th>";
  echo "        <th>股本</th>";
  echo "        <th>每股淨值</th>";
  echo "        <th>長期投資</th>";
  echo "        <th>固定資產</th>";
  echo "        <th>淨利</th>";
  echo "        <th>淨利率</th>";
  echo "        <th>資產週轉率</th>";
  echo "        <th>股東權益</th>";
  echo "        <th>權益乘數</th>";
  echo "        <th>ROE</th>";
  echo "        <th>合約負債</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";
  $share_s = 0;
  $share_e = 0;
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
      echo "    <td>".$row['profitRate']."%</td>";
      echo "    <td>".$row['assetTurnOver']."%</td>";
      echo "    <td>".$row['shareholder']."</td>";
      echo "    <td>".$row['equityMultiplier']."</td>";
      echo "    <td>".$row['ROE']."</td>";
      echo "    <td>".$row['contract']."</td>";
      echo "  </tr>";
      if ($i == 0)
          $share_s = $row['share'];
      else 
          $share_e = $row['share'];
  } 
  echo "    </tbody>";
  echo "  </table>";
  if ($share_s != $share_e)
      echo "股本成長率 = ".round((($share_e/$share_s)-1)*100,2)."%<br>";
  echo "ROE = 利潤率 × 資產周轉率 × 權益乘數 = (淨收入 / 營業收入) × (營業收入 / 資產) × (資產/ 股東權益)<br>";
  echo "1.淨利率代表獲利能力，分析損益表，比較營收、獲利金額、獲利率的變化。<br>";
  echo "2.總資產週轉率代表管理階層運用總資產創造營收的能力，強化分析資產比例和營運天數。<br>";  
  echo "3.權益乘數代表財務槓桿的運用程度，強化分析負債內容，看是好債還是壞債。<br>";  
  echo "</div>";
  /* back up */
  // 『SQL』資產負債簡表 (Table2) ////////////////////////////////////////////
  $pYear = (string)((int)substr($_POST['season'],0,4)-1);
  
  echo "<div class='table100 ver1' id='monthlyTbl'>";
  echo "【簡明表】<br>";
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
          echo "【詳細報告】<br>";
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
  echo "</div>";
  echo "【策略分析】<br>";
  echo "<img src='/stock/css/img/strategy.jpg'>";
  echo "<br>1.透過損益按公允價值衡量之金融資產(Trading Securities)，指的是企業持有這項資產會在短期之內出售。因此賣出這項資產所產生的利益或損失，不會一直長期存在，因此在損益表中的表達，會被列在其他利益及損失當中的透過損益按公允價值衡量之金融資產淨利益(損失)。除了賣出會產生損益影響損益表之外，為了能使投資的價格更符合現況，因此每一期的期末都會使用市價重新計算股票的價值，如果成本高於或低於市價，就會產生評價損失或利得，也是列在其他利益及損失當中。";
  echo "<br>";
  echo "<br>2.持有至到期日之金融資產(Held to Maturity Securities)，指的是像債券那一種形式的證券，有到期日、持有主要是為了賺取利息收入。公報規定如果要分類到這個科目來，公司必須要有能力，能夠持有到到期日，而且公司本身持有至到期日的意圖也要夠積極。在這個分類當中的證券，每期都會有利息收入，列在其他利益及損失當中，而在期末資產負債表上的所表達的金額，是攤銷後的成本，並不是市價，因此它不會產生未實現損益。";
  echo "<br>";
  echo "<br>3.備供出售之金融資產(Available for Sale Securities)，指的則是不是短期持有、也不是短期獲利的操作模式，也不屬於其他分類，像是成本衡量、持有至到期日、權益法的，就歸在這一類當中。這一類的證券，跟交易目的之金融資產最大的不同是它的評價損失或者是利得，不是放在損益表當中，而是放在權益變動表當中的金融資產未實現損益項下，因此不管股票是漲是跌，都不會影響到本期淨利。只有在把股票賣出時，才會影響本期淨利，或者是收到股利收入時，會在損益表的其他收入當中，認列股利收入。";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "\"";
?>
