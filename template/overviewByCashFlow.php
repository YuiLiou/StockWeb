<?php
  require_once('commonFunc.php');  
  require_once('db.php');
  echo "\"";
  
  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from cash_flow ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);
  
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
  echo "  <input type='hidden' name='type' value='cashFlow'>"; // 記憶當下頁面
  echo "</form>";

  /*********************************************************************************/
  /*『SQL』標題：日期                                                                      
  /*********************************************************************************/
  $tYear = substr($_POST['season'],0,4);
  $tSeason = substr($_POST['season'],4,6);
  $sql = "select col_name, v1, v2 ".
         "from cash_flow c ".
         "where 1=1 ".
         "and c.code in ('".$codes."') ".
         "and c.year = '".$tYear."'".
         "and c.season = '".$tSeason."' ".
         "and c.col_name = '會計項目' ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>公司</th>";
  echo "        <th>".$row['col_name']."</th>";
  echo "        <th>".$row['v1']."</th>";
  echo "        <th>".$row['v2']."</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  /*********************************************************************************/
  /*『SQL』內文：重要訊息                                                                      
  /*********************************************************************************/
  $sql = "select c.code, c.col_name, c.v1, c.v2, map.company ".
         "from cash_flow c, company_map map ".
         "where 1=1 ".
         "and c.code = map.code ".
         "and c.code in ('".$codes."') ".
         "and c.year = '".$tYear."'".
         "and c.season = '".$tSeason."' ".
         "and c.col_name like '%合約負債%' ";
  $result = $conn->query($sql);
  foreach ($result as $row)
  {  
      echo  "<tr class='row100'>";
      echo  "  <td><a href=price.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td>";
      echo    "<td>".$row['col_name']."</td>";
      echo    "<td>".$row['v1']."</td>";
      echo    "<td>".$row['v2']."</td>";
      echo  "</tr>";
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>";
  echo "\""; 
  $result->close();
?>
