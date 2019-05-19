<?php
  require_once('db.php');

  ///////////////////////////////////// 月份選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from eps ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);
  echo "\"";
  /*********************************************************************************/
  /* 日期下拉式選單跳轉的部份
  /*********************************************************************************/
  echo "  <input type='hidden' name='type' value='season'>";
  echo "</form>";
  /*********************************************************************************/
  echo "<form action='index.php' method='POST'>";  
  echo "    <select id='selSeason' name='season' onchange='this.form.submit()'>";  
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
  echo "  <input type='hidden' name='type' value='season'>";
  echo "</form>";

  ///////////////////////////////////// 公司列表 /////////////////////////////////////
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>".
         "<table data-vertable='ver1'>".
         "<thead>".
           "<tr class='row100 head'>".
             "<th>公司</th>".
             "<th>股價</th>".
             "<th>eps</th>".
             "<th>去年同期eps</th>".
           "</tr>".
         "</thead><tbody>";

  $sql = "select p.code, p.price, tSeason.eps tEps, pSeason.eps pEps ".
         "from (select eps, e.code ".  /**************當季eps*******************/
         "      from eps e, (select code from own where user = 'rusiang') o ".
         "      where year='".substr($_POST['season'],0,4)."' ".
         "      and e.code = o.code ".
         "      and season = '".substr($_POST['season'],4,6)."' ) tSeason, ".
         "     (select eps, e.code ".  /**************前季eps*******************/
         "      from eps e, (select code from own where user = 'rusiang') o ".
         "      where year='".(string)((int)substr($_POST['season'],0,4)-1)."' ".
         "      and e.code = o.code ".
         "      and season = '".substr($_POST['season'],4,6)."' ) pSeason, ".
         "     (select code from own where user = 'rusiang') o, ".
         "      prices p ".
         "where 1=1 ".
         "and tSeason.code = pSeason.code ".
         "and p.date = '".$_POST['date']."' ".
         "and p.code = o.code ".
         "and p.code=tSeason.code ".
         "order by code ";
  
  $result = $conn->query($sql);
  foreach ($result as $row)
  {  
      echo  "<tr class='row100'>";
      echo    "<td>".$row['code']."</td>";
      echo    "<td>".$row['price']."</td>";
      echo    "<td>".$row['tEps']."</td>";
      echo    "<td>".$row['pEps']."</td>"; 
      echo  "</tr>";
  }

  echo "\""; 
  $result->close();
?>
