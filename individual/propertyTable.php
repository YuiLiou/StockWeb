<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191116 rusiang  新增長期投資項目＆固定資產＆綜合損益  
  /* 20191123 rusiang  新增股本＆每股淨值＆股東權益＆ROE＆合約負債  
  /* 20191130 rusiang  新增策略分析說明
  /* 20191228 rusiang  新增股本成長率
  /* 20191228 rusiang  新增杜邦分析
  /* 20191228 rusiang  長短期金融借款負債比
  /* 20200125 rusiang  產出杜邦分析結果
  /* 20200126 rusiang  Fix table1 SQL
  /* 20200126 rusiang  新增負債比率
  /* 20200127 rusiang  新增存貨週轉率
  /* 20200208 rusiang  新增盈再率
  /**********************************************************************************/  
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";
  
  /*********************************************************************************/
  /*【季節選單】
  /*********************************************************************************/
  $sql = "select year, season ".
         "from property_2 ".
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);
  echo "<form action='property.php?company=".$_GET['company']."' method='POST'>";    
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
  /*【外部連結】
  /*********************************************************************************/
  echo "【外部連結】";
  echo "<a href='https://www.cmoney.tw/finance/f00031.aspx?s=".$_GET['company']."'>轉投資項目</a><br>";
  /*********************************************************************************/
  /*【歷年資產指標】
  /*********************************************************************************/
  echo "【歷年資產指標】<br>";
  $sql = "select a.year, a.season, ".
         "       profit, ".                                              // 稅後淨利                         
         "       investment, ".                                          // 長期投資
         "       house, ".                                               // 固定資產
         "       shareholder, ".                                         // 股東權益
         "       round(profit/shareholder*100,2) ROE, ".                 // ROE
         "       share, ".                                               // 股本
         "       contract, ".                                            // 合約負債
         "       stockvalue, ".                                          // 每股淨值
         "       round(profit/ope_income*100,2) profitRate, ".           // 淨利率
         "       round(ope_income/asset*100,2) assetTurnOver, ".         // 資產週轉率
         "       round(asset/shareholder*100,2) equityMultiplier ".      // 權益乘數 
         "from ".
         "( ".
//      「資產負債表」股本 ----------------------------------------------------------------
         "    select year, season, value share, @year:=year, ".
//      「資產負債表」長期投資 --------------------------------------------------------------
         "    ( ".
         "      select sum(v1) ".
         "      from property_2 ".
         "      where 1=1 ".
         "      and col_name in ('採用權益法之投資淨額', '採用權益法之投資') ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "    ) investment, ".
//      「資產負債表」固定資產 --------------------------------------------------------------
         "    ( ".
         "      select sum(v1) ".
         "      from property_2 ".
         "      where 1=1 ".
         "      and col_name in ('不動產、廠房及設備', '投資性不動產淨額') ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "    ) house, ".      
//      「資產負債表」股東權益 --------------------------------------------------------------
         "    ( ".
         "      select value ".
         "      from property ".
         "      where 1=1 ".
         "      and col_name in ('權益總計','權益總額') ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "    ) shareholder, ".
//      「資產負債表」合約負債 --------------------------------------------------------------
         "    ( ".
         "      select v1 ".
         "      from property_2 ".
         "      where 1=1 ".
         "      and col_name in ('合約負債－流動') ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "    ) contract, ".
//       「綜合損益表」獲利 ----------------------------------------------------------------   
         "    ( ".
         "      select value ".
         "      from income_2 ".
         "      where 1=1 ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "      and col_name = '本期淨利（淨損）' ".
         "    ) profit, ".
//      「資產負債表」每股淨值 --------------------------------------------------------------
         "    ( ".
         "      select value ".
         "      from property ".
         "      where 1=1 ".
         "      and col_name in ('每股參考淨值') ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "    ) stockvalue, ".
//      「綜合損益表」營業收入 --------------------------------------------------------------
         "    ( ".
         "      select value ".
         "      from income_2 ".
         "      where 1=1 ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "      and col_name = '營業收入' ".
         "    ) ope_income, ".
//      「資產負債表」資產總計 --------------------------------------------------------------
         "    ( ".
         "      select value ".
         "      from property ".
         "      where 1=1 ".
         "      and col_name in ('資產總計','資產總額') ".
         "      and code = p.code ".
         "      and year = p.year ".
         "      and season = p.season ".
         "    ) asset ".         
         "    from property p, ".
         "    (select @year := 0)a ".
         "    where 1=1 ".
         "    and col_name in ('股本') ".
         "    and code = '".$_GET['company']."' ".
         "    and season = '".$tSeason."' ".
         ") a ";
         
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  $share_s = 0;            //初期股本
  $roe_s = 0;              //初期roe
  $profitRate_s = 0;       //初期淨利率
  $assetTurnOver_s = 0;    //初期資產週轉率
  $equityMultiplier_s = 0; //初期權益乘數
  $assetList = array();    //歷年資產
  $assetIncrease = 0;      //資產增加
  $profitList = array();   //歷年盈餘
  $profitSum = 0;          //四年累積盈餘
  for ($i=0;$i<$total_records;$i++)
  {  
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      array_push($assetList, $row['investment']+$row['house']);
      array_push($profitList, $row['profit']);
      // 四年間增加的資產 -------------------------------------
      if ($i >= 4)
      {
          $assetIncrease = $assetList[$i] - $assetList[$i-4];
      }
      // 四年累積盈餘 ----------------------------------------
      if ($i > 0)
      {
          $profitSum += $profitList[$i];
          if ($i > 4)
          {
              $profitSum -= $profitList[$i-4];
          }
      }    
      // 第一列 ---------------------------------------------
      if ($i == 0)
      {
          $share_s = $row['share'];
          echo "<div class='table100 ver1' id='monthlyTbl' style='height:700px;'>";
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
          echo "        <th>盈再率</th>";
          echo "      </tr>";
          echo "    </thead>";
          echo "    <tbody>";
      }
      echo "  <tr>";
      echo "    <td>".$row['year'].$row['season']."</td>";   //年份
      echo "    <td>".$row['share']."</td>";                 //股本
      echo "    <td>".$row['stockvalue']."</td>";            //每股淨值
      echo "    <td>".$row['investment']."</td>";            //長期投資
      echo "    <td>".$row['house']."</td>";                 //固定資產
      echo "    <td>".$row['profit']."</td>";                //淨利
      echo "    <td>".$row['profitRate']."%</td>";           //淨利率
      echo "    <td>".$row['assetTurnOver']."%</td>";        //資產週轉率
      echo "    <td>".$row['shareholder']."</td>";           //股東權益
      echo "    <td>".$row['equityMultiplier']."</td>";      //權益乘數
      echo "    <td>".$row['ROE']."</td>";                   //ROE
      echo "    <td>".$row['contract']."</td>";              //合約負債
      // 盈再率 ---------------------------------------------------------        
      if ($i>=4)
          echo "<td>".round(($assetIncrease/$profitSum)*100,2)."%</td>";
      else 
          echo "<td></td>";
      // 盈再率 ---------------------------------------------------------        
      echo "  </tr>";       

      // 倒數第二列 -----------------------------------------------------        
      if ($i == $total_records -2)
      {
          $roe_s              = $row['ROE']; 
          $profitRate_s       = $row['profitRate'];
          $assetTurnOver_s    = $row['assetTurnOver'];
          $equityMultiplier_s = $row['equityMultiplier'];
      }
      // 最後一列 -------------------------------------------------------
      else if ($i == $total_records -1) 
      {
          echo "  </tbody>";
          echo "</table>";
          if ($share_s != $row['share'])
              echo "股本成長率 = ".round((($row['share']/$share_s)-1)*100,2)."%<br>";
          else 
              echo "股本不變<br>";
          echo "ROE = 利潤率 × 資產周轉率 × 權益乘數 = (淨收入 / 營業收入) × (營業收入 / 資產) × (資產/ 股東權益)<br>";
          // ROE自動分析 ------------------------------------------------------- 
          if ($roe_s <= $row['ROE']) 
              echo "<font color='red'>ROE上升".round(($row['ROE']-$roe_s),2)."%</font><br>";
          else
              echo "<font color='green'>ROE下降".round(($roe_s-$row['ROE']),2)."%</font><br>";
          if ($profitRate_s <= $row['profitRate'])
          { 
              echo "<font color='red'>淨利率上升";
              echo round(($row['profitRate']-$profitRate_s),2)."%，獲利能力進步</font><br>";
          }
          else
          {
              echo "<font color='green'>淨利率下降";
              echo round(($profitRate_s-$row['profitRate']),2)."%，獲利能力退步</font><br>";
          }
          if ($assetTurnOver_s <= $row['assetTurnOver'])
          { 
              echo "<font color='red'>資產週轉率上升";
              echo round(($row['assetTurnOver']-$assetTurnOver_s),2)."%，總資產創造營收能力進步</font><br>";
          }
          else
          {
              echo "<font color='green'>資產週轉率下降";
              echo round(($assetTurnOver_s-$row['assetTurnOver']),2)."%，總資產創造營收能力退步</font><br>";
          }
          if ($equityMultiplier_s <= $row['equityMultiplier']) 
          {
              echo "<font color='green'>權益乘數上升";
              echo round(($row['equityMultiplier']-$equityMultiplier_s),2)."，財務槓桿運用程度提昇</font><br>";
          }
          else
          {
              echo "<font color='red'>權益乘數下降";
              echo round(($equityMultiplier_s-$row['equityMultiplier']),2)."，財務槓桿運用程度降低</font><br>"; 
          }
          // ROE自動分析 ------------------------------------------------------- 
          echo "</div>";
      } 
  }
  /*********************************************************************************/
  /*【存貨週轉率】
  /*********************************************************************************/  
  $sql = "select concat(year,season) season, ".
         "       v2 inventory, ".
         "       ( ".
         "         select round(v1/p.v1*100,2) ".
         "         from income_3 ".
         "         where 1=1 ".
         "         and code = p.code ".
         "         and year = p.year ".
         "         and season = p.season ".
         "         and col_name = '銷貨成本' ".
         "       ) inventoryRate ".
         "from property_2 p ".
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "and col_name = '存貨' ".
         "order by year desc, season desc ".
         "limit 0,12 ";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  $strTH  = "";
  $strTD  = "";
  $strTD2 = "";
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      $strTH  .= "<th>".$row['season']."</th>";
      $strTD  .= "<td>".$row['inventory']."%</td>";
      $strTD2 .= "<td>".$row['inventoryRate']."%</td>";
  }
  if ($strTH != "")
  {    
      echo "【存貨週轉率】<br>";
      echo "<div class='table100 ver1' id='monthlyTbl' style='height:300px;'>";
      echo "  <table data-vertable='ver1'>";
      echo "    <thead>";
      echo "      <tr class='row100 head'><th></th>".$strTH."</tr>";
      echo "    </thead>";
      echo "    <tbody>";
      echo "      <tr class='row100'><td>存貨比率</td>".$strTD."</tr>";
      echo "      <tr class='row100'><td>存貨週轉率</td>".$strTD2."</tr>";
      echo "    </tbody>";
      echo "  </table>";
      echo "</div>";
  } 

  /*********************************************************************************/
  /*【負債比率 & 長短期金融借款負債比】                                                                    
  /*********************************************************************************/  
  $sql = "select concat(a.year,a.season) season, ".
         "       round((a.value/b.value)*100,2) debtRate, ".
         "       ( ".
         "         select round(sum(v2),2) ".
         "         from property_2 ".
         "         where 1=1 ".
         "         and code = a.code ".
         "         and year = a.year ".
         "         and season = a.season ".
         "         and col_name in ('短期借款','應付短期票券','應付公司債','長期借款') ".
         "       ) debt ".
         "from ".
         // 負債總計 ----------------------------------------------------
         "( ". 
         "  select code, year, season, value ".
         "  from property ".
         "  where code = '".$_GET['company']."' ".
         "  and col_name in ('負債總額','負債總計') ".
         ") a, ".
         // 資產總計 ----------------------------------------------------
         "( ".
         "  select year, season, value ".
         "  from property ".
         "  where code = '".$_GET['company']."' ".
         "  and col_name in ('資產總額','資產總計') ".
         ") b ".
         "where 1=1 ".
         "and a.year = b.year ".
         "and a.season = b.season ".
         "order by a.year desc, a.season desc ".
         "limit 0,12 ";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  $strTH  = "";
  $strTD  = "";
  $strTD2 = "";
  $debtRate_s = 0;
  $debt_s = 0;
  $debtRate_e = 0;
  $debt_e = 0;
  
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      $strTH  .= "<th>".$row['season']."</th>";
      $strTD  .= "<td>".$row['debtRate']."%</td>";
      $strTD2 .= "<td>".$row['debt']."%</td>";
      if ($i == 0)
      {
          $debtRate_s = $row['debtRate'];
          $debt_s     = $row['debt'];
      }
      else if ($i == $total_records-1)
      {
          $debtRate_e = $row['debtRate'];
          $debt_e     = $row['debt'];
      }
  }
  if ($strTH != "")
  {    
      echo "【負債比率】（長短期金融借款負債比不宜超過40%）<br>";
      echo "<div class='table100 ver1' id='monthlyTbl' style='height:400px;'>";
      echo "  <table data-vertable='ver1'>";
      echo "    <thead>";
      echo "      <tr class='row100 head'><th></th>".$strTH."</tr>";
      echo "    </thead>";
      echo "    <tbody>";
      echo "      <tr class='row100'><td>負債比率</td>".$strTD."</tr>";
      echo "      <tr class='row100'><td>長短期負債比</td>".$strTD2."</tr>";
      echo "    </tbody>";
      echo "  </table>";
      echo "負債比率增加：".($debtRate_s-$debtRate_e)."%<br>";
      echo "長短期金融借款增加：".($debt_s-$debt_e)."%<br>";
      echo "</div>";
  }

  /*********************************************************************************/
  /*【應收帳款週轉率】                                              
  /*********************************************************************************/
  echo "【應收帳款週轉率】<br>";
  echo "<canvas id='receivableChart'></canvas>";  
 
  /*********************************************************************************/
  /*【簡明表】
  /*********************************************************************************/  
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
      echo "  <tr>";
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
  /*【詳細報告】                                                                     
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
