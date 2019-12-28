<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191117 rusiang  標記投資亮點/風險，如所得稅費用減少為亮點  
  /* 20191128 rusiang  新增歷年營運指標盤點  
  /* 20191214 rusiang  更新公開觀測連結
  /**********************************************************************************/  
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";
  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from income_2 ".
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
  echo "  <input type='hidden' name='type' value='income2'>";
  echo "</form>";

  $tYear = substr($_POST['season'],0,4);
  $pYear = (string)((int)substr($_POST['season'],0,4)-1);
  $tSeason = substr($_POST['season'],4,6);
  $ROCYear = (string)((int)$tYear-1911);

  echo "【公開觀測站】";
  echo "<a href='https://doc.twse.com.tw/server-java/t57sb01?step=1&colorchg=1&co_id=".$_GET['company']."&year=".$ROCYear."&seamon=&mtype=A&'>財報</a>；";
  echo "<a href='https://doc.twse.com.tw/server-java/t57sb01?step=1&colorchg=1&co_id=".$_GET['company']."&year=".$ROCYear."&mtype=F&'>股東會</a>；";
  echo "<a href='https://mops.twse.com.tw/mops/web/t100sb07_1'>法說會</a>；";
  echo "<a href='https://mops.twse.com.tw/mops/web/t164sb04'>綜合損益表</a><br>";
  
  /************************************ 歷年營運盤點 *******************************************/
  $sql = "select t1.year, t1.season, ".
         "       t1.value v1, t2.value v2, t3.value v3, t4.value v4, ".
         "       t5.value v5, t6.value v6, t7.value v7, t8.value v8, ".
         "       t9.value v9, t10.eps  ".
         "from (select i.value, i.year, i.season ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '營業成本') t1, ".
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '營業收入') t2, ".
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '營業毛利（毛損）') t3, ".
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '營業費用') t4, ".
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '營業利益（損失）') t5, ".
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '營業外收入及支出') t6, ".
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '所得稅費用（利益）') t7, ". 
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '本期淨利（淨損）') t8, ". 
         "     (select i.value, i.year ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '綜合損益總額歸屬於母公司業主') t9, ".
         "     (select i.eps, i.year ".
         "      from _eps i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.season = '".$tSeason."') t10 ".
         "where 1=1 ".
         "and t1.year = t2.year ".
         "and t1.year = t3.year ".
         "and t1.year = t4.year ".
         "and t1.year = t5.year ".
         "and t1.year = t6.year ".
         "and t1.year = t7.year ".
         "and t1.year = t8.year ".
         "and t1.year = t9.year ".
         "and t1.year = t10.year ".
         "order by year asc ";
  echo "【歷年營運指標】<br>";
  echo "<div class='table100 ver1' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>年度</th>";
  echo "        <th>營業成本</th>";
  echo "        <th>營業收入</th>";
  echo "        <th>營業毛利</th>";
  echo "        <th>營業費用</th>";
  echo "        <th>營業利益</th>";
  echo "        <th>業外收入</th>";
  echo "        <th>所得稅費用</th>";
  echo "        <th>本期淨利</th>";
  echo "        <th>母公司損益</th>";
  echo "        <th>EPS</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引  
      echo "<tr>";
      echo "  <td>".$row['year'].$row['season']."</td>";
      echo "  <td>".$row['v1']."</td>";
      echo "  <td>".$row['v2']."</td>";
      echo "  <td>".$row['v3']."</td>";
      echo "  <td>".$row['v4']."</td>";
      echo "  <td>".$row['v5']."</td>";
      echo "  <td>".$row['v6']."</td>";
      echo "  <td>".$row['v7']."</td>";
      echo "  <td>".$row['v8']."</td>";
      echo "  <td>".$row['v9']."</td>";
      echo "  <td>".$row['eps']."</td>";
      echo "</tr>";
  }
  echo "    </tbody>";
  echo "  </table>";

  /******************************************* 合併淨利 *******************************************/
  $sql = "select this_y.col_name, this_y.value this_value, past_y.value past_value ".
         "from (select i.col_name, i.value ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$tYear."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '本期淨利（淨損）') this_y, ".
         "     (select i.col_name, i.value ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$pYear."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '本期淨利（淨損）') past_y ".
         "where 1=1 ".
         "and this_y.col_name = past_y.col_name ";

  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
  $this_benefit = $row['this_value'];
  $past_benefit = $row['past_value'];

  /******************************************* 綜合損益 *******************************************/
  $sql = "select this_y.col_name, this_y.value this_value, past_y.value past_value ".
         "from (select i.col_name, i.value ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$tYear."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '本期綜合損益總額') this_y, ".
         "     (select i.col_name, i.value ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$pYear."' ".
         "      and i.season = '".$tSeason."' ".
         "      and i.col_name = '本期綜合損益總額') past_y ".
         "where 1=1 ".
         "and this_y.col_name = past_y.col_name ";

  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
  $this_sum_up = $row['this_value'];
  $past_sum_up = $row['past_value'];

  /******************************************* 全部欄位 *******************************************/
  $sql = "select this_y.col_name, this_y.value this_value, past_y.value past_value, ".
         "       round((this_y.value-past_y.value)/abs(past_y.value)*100,2) grow ".
         "from (select i.col_name, i.value ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$tYear."' ".
         "      and i.season = '".$tSeason."') this_y, ".
         "     (select i.col_name, i.value ".
         "      from income_2 i ".
         "      where 1=1 ".
         "      and i.code = '".$_GET['company']."' ".
         "      and i.year = '".$pYear."' ".
         "      and i.season = '".$tSeason."') past_y ".
         "where 1=1 ".
         "and this_y.col_name = past_y.col_name ".
         "order by this_y.col_name asc ";

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
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>";
      /************************ 『HighLight』紅色為投資亮點，綠色為投資風險 ************************/
      /************************ 『HighLight』增加為亮點，減少為風險        ************************/
      if ($row['col_name'] == '營業毛利（毛損）' or $row['col_name'] == '營業利益（損失）' 
       or $row['col_name'] == '營業外收入及支出' or $row['col_name'] == '本期綜合損益總額'
       or $row['col_name'] == '本期淨利（淨損）' or $row['col_name'] == '淨利（淨損）歸屬於母公司業主'
       or $row['col_name'] == '綜合損益總額歸屬於母公司業主' or $row['col_name'] == '營業收入'
       or $row['col_name'] == '稅前淨利（淨損）')
      {
          if ($row['grow'] > 0)
              echo "  <td><font color='red'>".$row['col_name']."</td>";
          else
              echo "  <td><font color='green'>".$row['col_name']."</td>";
      }
      /************************ 『HighLight』減少為亮點，增加為風險        ************************/
      else if ($row['col_name'] == '營業費用' or $row['col_name'] == '所得稅費用（利益）'
            or $row['col_name'] == '營業成本')
      {
          if ($row['grow'] < 0)
              echo "  <td><font color='red'>".$row['col_name']."</td>";
          else
              echo "  <td><font color='green'>".$row['col_name']."</td>";
      }
      else 
          echo "  <td>".$row['col_name']."</td>";

      /************************ 『Comment』歸屬比例 ********************************************/
      if ($row['col_name'] == '淨利（淨損）歸屬於母公司業主')
      {
          echo "  <td>".$row['this_value']."(".round($row['this_value']/$this_benefit*100,2)."%)</td>";      
          echo "  <td>".$row['past_value']."(".round($row['past_value']/$past_benefit*100,2)."%)</td>";      
      }
      else if ($row['col_name'] == '淨利（淨損）歸屬於非控制權益')   
      {   
          echo "  <td>".$row['this_value']."(".round($row['this_value']/$this_benefit*100,2)."%)</td>";
          echo "  <td>".$row['past_value']."(".round($row['past_value']/$past_benefit*100,2)."%)</td>";      
      }
      else if ($row['col_name'] == '綜合損益總額歸屬於母公司業主')
      {
          echo "  <td>".$row['this_value']."(".round($row['this_value']/$this_sum_up*100,2)."%)</td>";
          echo "  <td>".$row['past_value']."(".round($row['past_value']/$past_sum_up*100,2)."%)</td>";
      }
      else if ($row['col_name'] == '綜合損益總額歸屬於非控制權益')
      {
          echo "  <td>".$row['this_value']."(".round($row['this_value']/$this_sum_up*100,2)."%)</td>";
          echo "  <td>".$row['past_value']."(".round($row['past_value']/$past_sum_up*100,2)."%)</td>";
      }
      else
      {      
          echo "  <td>".$row['this_value']."</td>";      
          echo "  <td>".$row['past_value']."</td>";
      }
      echo getRateTd($row['grow']);
      echo "</tr>";      
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>";
  /////////////////////////////////////『指標說明』/////////////////////////////////////
  echo "*********************************************************************<br>";
  echo "【指標說明】                                                           <br>";
  echo "本期綜合損益總額 = 綜合損益總額歸屬於母公司業主 + 綜合損益總額歸屬於非控制權益  <br>";
  echo "本期綜合損益總額 = 本期淨利（淨損）           + 其他綜合損益（淨額）         <br>";
  echo "本期淨利（淨損） = 淨利（淨損）歸屬於母公司業主 + 淨利（淨損）歸屬於非控制權益  <br>";
  echo "本期淨利（淨損） = 稅前淨利（淨損）           + 所得稅費用（利益）           <br>";
  echo "營業毛利（毛損） = 營業收入                  + 營業成本                   <br>";
  echo "*********************************************************************<br>";
  echo "\"";
?>
