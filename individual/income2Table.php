<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList                                                   
  /* --------------------------------------------------------------------------------  
  /* 20191117 rusiang  標記投資亮點/風險，如所得稅費用減少為亮點                          
  /* 20191128 rusiang  新增歷年營運指標盤點  
  /* 20191214 rusiang  更新公開觀測連結 
  /* 20200119 rusiang  新增業外收支佔稅前淨利比 
  /* 20200124 rusiang  新增營業費用拆解表  
  /* 20200127 rusiang  新增業外收入拆解表  
  /* 20200215 rusiang  簡明表依四率分類  
  /**********************************************************************************/  
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";
  /*********************************************************************************/
  /*【季節選單】                                              
  /*********************************************************************************/
  $sql = "select year, season ".
         "from income_2 ".
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);
  echo "<form action='income2.php?company=".$_GET['company']."' method='POST'>";    
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
  /*********************************************************************************/
  /*【公開觀測站】                                              
  /*********************************************************************************/
  echo "【公開觀測站】";
  echo "<a href='https://doc.twse.com.tw/server-java/t57sb01?step=1&colorchg=1&co_id=".$_GET['company']."&year=".$ROCYear."&seamon=&mtype=A&'>財報</a>；";
  echo "<a href='https://doc.twse.com.tw/server-java/t57sb01?step=1&colorchg=1&co_id=".$_GET['company']."&year=".$ROCYear."&mtype=F&'>股東會</a>；";
  echo "<a href='https://mops.twse.com.tw/mops/web/t100sb07_1'>法說會</a>；";
  echo "<a href='https://mops.twse.com.tw/mops/web/t164sb04'>綜合損益表</a><br>";

  /*********************************************************************************/
  /*【歷年營運盤點】                                              
  /*********************************************************************************/
  $sql = "select a.*, round(v6/t11*100,2) v11, round(v5*v10/v8,2) v12 ".
         "from (".
         "  select t1.year, t1.season, ".
         "         t1.value v1, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '營業收入') v2, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '營業毛利（毛損）') v3, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '營業費用') v4, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '營業利益（損失）') v5, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '營業外收入及支出') v6, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '所得稅費用（利益）') v7, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '本期淨利（淨損）') v8, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '綜合損益總額歸屬於母公司業主') v9, ".
         "         (select round(i.eps,2) ".
         "          from _eps i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year) v10, ".
         "         (select value ".
         "          from income_2 i ".
         "          where 1=1 ".
         "          and i.code = t1.code ".
         "          and i.season = t1.season ".
         "          and i.year = t1.year ".
         "          and i.col_name = '稅前淨利（淨損）') t11 ".
         "  from (select i.value, i.year, i.season, i.code ".
         "        from income_2 i ".
         "        where 1=1 ".
         "        and i.code = '".$_GET['company']."' ".
         "        and i.season = '".$tSeason."' ".
         "        and i.col_name = '營業成本') t1 ".
         "  where 1=1 ".         
         "  order by year asc ".
         ") a ";
  echo "【歷年營運指標】<br>";
  echo "<div class='table100 ver1' id='monthlyTbl' style='height:500px;'>";
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
  echo "        <th>業外收支佔稅前淨利比</th>";
  echo "        <th>本業EPS</th>";
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
      echo "  <td>".$row['v10']."</td>";
      echo "  <td>".$row['v11']."%</td>";
      echo "  <td>".$row['v12']."</td>";
      echo "</tr>";
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>";
  /*********************************************************************************/
  /*【簡明表】                                              
  /*********************************************************************************/
  $row_1 = "";
  $row_2 = "";
  $row_3 = "";
  $row_4 = "";
  $row_5 = "";
  $row_6 = "";

/*  // 合併淨利 
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
  if (isset($row['this_value']))
  {
      $this_benefit = $row['this_value'];
      $past_benefit = $row['past_value'];

      // 綜合損益 
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
      $past_sum_up = $row['past_value'];*/
  //簡明表細項 --------------------------------------------------------------------------
  $sql = "select this_y.col_name, this_y.value this_value, past_y.value past_value, ".
         "       round((this_y.value-past_y.value)/abs(past_y.value)*100,2) grow ".
         "from ( ".
         "  select i.col_name, i.value ".
         "  from income_2 i ".
         "  where 1=1 ".
         "  and i.code = '".$_GET['company']."' ".
         "  and i.year = '".$tYear."' ".
         "  and i.season = '".$tSeason."' ".
         ") this_y, ".
         "( ".
         "  select i.col_name, i.value ".
         "  from income_2 i ".
         "  where 1=1 ".
         "  and i.code = '".$_GET['company']."' ".
         "  and i.year = '".$pYear."' ".
         "  and i.season = '".$tSeason."' ".
         ") past_y ".
         "where 1=1 ".
         "and this_y.col_name = past_y.col_name ".
         "order by this_y.col_name asc ";
    
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      if ($row['col_name'] == '營業收入' or 
          $row['col_name'] == '營業毛利（毛損）' or
          $row['col_name'] == '營業毛利（毛損）淨額')
      { 
          $row_1 .= getUpGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']);
      }
      else if ($row['col_name'] == '營業成本')
      {
          $row_1 .= getDownGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']); 
      }  
      else if ($row['col_name'] == '營業利益（損失）')
      {
          $row_2 .= getUpGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']);
      }
      else if ($row['col_name'] == '營業費用')
      {
          $row_2 .= getDownGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']); 
      }
      else if ($row['col_name'] == '稅前淨利（淨損）' or 
               $row['col_name'] == '營業外收入及支出')
      {
          $row_3 .= getUpGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']);    
      }
      else if ($row['col_name'] == '本期淨利（淨損）')
      {
          $row_4 .= getUpGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']);    
      }  
      else if ($row['col_name'] == '所得稅費用（利益）')
      {
          $row_4 .= getDownGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']);  
      }
      else if ($row['col_name'] == '其他綜合損益（淨額）' or
               $row['col_name'] == '基本每股盈餘（元）' or
               $row['col_name'] == '本期綜合損益總額' or
               $row['col_name'] == '淨利（淨損）歸屬於母公司業主' or
               $row['col_name'] == '綜合損益總額歸屬於母公司業主' or
               $row['col_name'] == '繼續營業單位本期淨利（淨損）')
      {
          $row_5 .= getUpGroup($row['col_name'], $row['this_value'], $row['past_value'], $row['grow']);     
      } 
      else 
      {
          $row_6 .= "<tr>";
          $row_6 .= "<td>".$row['col_name']."</td>";
          $row_6 .= "<td>".$row['this_value']."</td>";
          $row_6 .= "<td>".$row['past_value']."</td>";
          $row_6 .= "<td>".$row['grow']."</td>";
          $row_6 .= "</tr>";
      }
  }
  //毛利/營業利益/稅前利益/稅後利益 -------------------------------------------------------------------
  $sql = "select this_y.grossRate     thisGross, ".
         "       this_y.operatingRate thisOperating, ".
         "       this_y.beforeTaxRate thisBeforeTax, ".
         "       this_y.afterTaxRate  thisAfterTax, ".
         "       past_y.grossRate     pastGross, ".
         "       past_y.operatingRate pastOperating, ".
         "       past_y.beforeTaxRate pastBeforeTax, ".
         "       past_y.afterTaxRate  pastAfterTax ".
         "from ".
         "( ".
         "  select i.* ".
         "  from income i ".
         "  where 1=1 ".
         "  and i.code = '".$_GET['company']."' ".
         "  and i.year = '".$tYear."' ".
         "  and i.season = '".$tSeason."' ".
         ") this_y, ".
         "( ".
         "  select i.* ".
         "  from income i ".
         "  where 1=1 ".
         "  and i.code = '".$_GET['company']."' ".
         "  and i.year = '".$pYear."' ".
         "  and i.season = '".$tSeason."' ".
         ") past_y ".
         "where 1=1 ".
         "and this_y.code = past_y.code ";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      $row_1 .= "<tr>";
      $row_1 .= "<td>毛利率</td>";
      $row_1 .= "<td>".$row['thisGross']."</td>";
      $row_1 .= "<td>".$row['pastGross']."</td>";
      $row_1 .= "<td>".($row['thisGross'] - $row['pastGross'])."</td>";
      $row_1 .= "</tr>";
      $row_2 .= "<tr>";
      $row_2 .= "<td>營業利益率</td>";
      $row_2 .= "<td>".$row['thisOperating']."</td>";
      $row_2 .= "<td>".$row['pastOperating']."</td>";
      $row_2 .= "<td>".($row['thisOperating'] - $row['pastOperating'])."</td>";
      $row_2 .= "</tr>";
      $row_3 .= "<tr>";
      $row_3 .= "<td>稅前利益率</td>";
      $row_3 .= "<td>".$row['thisBeforeTax']."</td>";
      $row_3 .= "<td>".$row['pastBeforeTax']."</td>";
      $row_3 .= "<td>".($row['thisBeforeTax'] - $row['pastBeforeTax'])."</td>";
      $row_3 .= "</tr>";
      $row_4 .= "<tr>";
      $row_4 .= "<td>稅後利益率</td>";
      $row_4 .= "<td>".$row['thisAfterTax']."</td>";
      $row_4 .= "<td>".$row['pastAfterTax']."</td>";
      $row_4 .= "<td>".($row['thisAfterTax'] - $row['pastAfterTax'])."</td>";
      $row_4 .= "</tr>"; 
  }
  
      /*echo "<tr>";
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
          echo "</tr>";*/
  echo "【簡明表】<br>";
  echo "<div class='table100 ver1' id='monthlyTbl'>";
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
  echo "<tr><td>【營業毛利】</td><td></td><td></td><td></td></tr>";
  echo $row_1;
  echo "<tr><td>【營業利益】</td><td></td><td></td><td></td></tr>";
  echo $row_2;
  echo "<tr><td>【稅前利益】</td><td></td><td></td><td></td></tr>";
  echo $row_3;
  echo "<tr><td>【稅後利益】</td><td></td><td></td><td></td></tr>";
  echo $row_4;
  echo "<tr><td>【綜合損益】</td><td></td><td></td><td></td></tr>";
  echo $row_5;
  echo $row_6;
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>";
 // }
  /*********************************************************************************/
  /*【營業費用拆解】                                              
  /*********************************************************************************/
  echo "【營業費用拆解】<br>";
  echo "<canvas id='myChart'></canvas>";
  /*********************************************************************************/
  /*【業外收入拆解】                                              
  /*********************************************************************************/
  echo "【業外收入拆解】<br>";
  echo "<canvas id='outOfBusinessChart'></canvas>";
  /*********************************************************************************/
  /*【指標說明】                                              
  /*********************************************************************************/
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
