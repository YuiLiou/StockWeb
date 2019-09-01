<?php
  if (empty($_GET))
      $_GET['company'] = '2330';

  echo "\"";

  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from income_2 ".
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

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>";
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
      echo "</tr>";      
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>\"";
?>
