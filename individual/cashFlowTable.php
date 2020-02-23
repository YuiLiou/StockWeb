<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200101 rusiang  新增營業現金流 
  /* 20200105 rusiang  新增投資/融資/淨現金流 
  /**********************************************************************************/ 
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";
  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from cash_flow ".
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);

  echo "<form action='cashFlow.php?company=".$_GET['company']."' method='POST'>";    
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
  echo "  <input type='hidden' name='type' value='cashFlow'>";
  echo "</form>";

  $tYear = substr($_POST['season'],0,4);
//$pYear = (string)((int)substr($_POST['season'],0,4)-1);
  $tSeason = substr($_POST['season'],4,6);

  /*********************************************************************************/
  /*『SQL』營業現金流                                                                      
  /*********************************************************************************/
  echo "【營業現金流】<br>";
  $sql = "select c.year, c.season, c.v1 cash, i.value profit, round(c.v1/i.value*100,2) cash_rate, ".
         "       c2.v1 investCash, c3.v1 financing, (c.v1+c2.v1+c3.v1) sum ".
         "from ".
//       營業現金流
         "( ".
         "  select * ".
         "  from cash_flow c ".
         "  where 1=1 ".
         "  and c.code = '".$_GET['company']."' ".
         "  and c.season = '".$tSeason."' ".
         "  and c.col_name = '營業活動之淨現金流入（流出）'".
         ") c, ".
//       投資現金流
         "( ".
         "  select * ".
         "  from cash_flow c ".
         "  where 1=1 ".
         "  and c.code = '".$_GET['company']."' ".
         "  and c.season = '".$tSeason."' ".
         "  and c.col_name = '投資活動之淨現金流入（流出）'".
         ") c2, ".
//       融資現金流
         "( ".
         "  select * ".
         "  from cash_flow c ".
         "  where 1=1 ".
         "  and c.code = '".$_GET['company']."' ".
         "  and c.season = '".$tSeason."' ".
         "  and c.col_name = '籌資活動之淨現金流入（流出）'".
         ") c3, ".
         "( ".
         "  select i.value, i.year ".
         "  from income_2 i ".
         "  where 1=1 ".
         "  and i.code = '".$_GET['company']."' ".
         "  and i.season = '".$tSeason."' ".
         "  and i.col_name = '本期淨利（淨損）' ".
         ") i ".
         "where c.year = i.year ".
         "and c2.year = i.year ".
         "and c3.year = i.year ";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  echo "<div class='table100 ver1' id='monthlyTbl' style='height:350px;'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>年度</th>";
  echo "        <th>投資現金流入</th>";
  echo "        <th>融資現金流入</th>";
  echo "        <th>營業現金流入</th>";
  echo "        <th>本期淨利</th>";
  echo "        <th>營業現金佔淨利比率</th>";
  echo "        <th>淨現金流</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  
  for ($i=0;$i<$total_records;$i++)
  {  
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr>";
      echo "  <td>".$row['year'].$row['season']."</td>";
      echo "  <td>".$row['investCash']."</td>";
      echo "  <td>".$row['financing']."</td>";
      echo "  <td>".$row['cash']."</td>";
      echo "  <td>".$row['profit']."</td>";
      echo "  <td>".$row['cash_rate']."</td>";
      echo "  <td>".$row['sum']."</td>";
      echo "</tr>";
  }
  echo "    </tbody>"; 
  echo "  </table>"; 
  echo "</div>";

  /*********************************************************************************/
  /*『SQL』現金流量表                                                                      
  /*********************************************************************************/
  echo "【現金流量表】<br>";
  $sql = "select col_name, v1, v2 ".
         "from cash_flow i ".
         "where 1=1 ".
         "and i.code = '".$_GET['company']."' ".
         "and i.year = '".$tYear."' ".
         "and i.season = '".$tSeason."' ".
         "order by col_index";         

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
          echo "</tr>";  
      }          
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>\"";
?>
