<?php
  if (empty($_GET))
      $_GET['company'] = '2330';

  echo "\"";

  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from property ".
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

  /******************************************* 全部欄位 *******************************************/
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
      echo "<tr class='row100'>";
      echo "  <td>".$row['col_name']."</td>";  
      echo "  <td>".$row['this_value']."</td>";      
      echo "  <td>".$row['past_value']."</td>";
      echo getRateTd($row['grow']);
      echo "</tr>";      
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>";

  /*********************************************************************************/
  /*『SQL』現金流量表                                                                      
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
