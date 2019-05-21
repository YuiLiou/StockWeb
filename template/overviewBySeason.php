<?php
  require_once('db.php');
  echo "\"";
  /*********************************************************************************/
  /* 日期下拉式選單跳轉的部份
  /*********************************************************************************/
  echo "  <input type='hidden' name='type' value='season'>";
  echo "</form>";
  /*********************************************************************************/
  ///////////////////////////////////// 月份選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from eps ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);
  
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
  $tYear = substr($_POST['season'],0,4);
  $pYear = (string)((int)substr($_POST['season'],0,4)-1);
  $tSeason = substr($_POST['season'],4,6);
  $sql = "select map.company, p.code, p.price, ".
         "tSeason.grossRate tGross, pSeason.grossRate pGross, ".
         "tSeason.operatingRate tOperating, pSeason.operatingRate pOperating, ".
         "tSeason.eps tEps, pSeason.eps pEps, ".
         "(tSeason.eps-pSeason.eps)/pSeason.eps*100 epsRate ".
         "from (select e.eps, e.code, i.grossRate, i.operatingRate ".  /**************當季*******************/
         "      from eps e, income i ".
         "      where e.code in ('".$codes."') ".
         "      and e.code = i.code ".
         "      and e.year = '".$tYear."' ".
         "      and e.year = i.year ".
         "      and e.season = i.season ".
         "      and e.season = '".$tSeason."' ) tSeason, ".
         "     (select e.eps, e.code, i.grossRate, i.operatingRate ".  /**************前季*******************/
         "      from eps e, income i ".
         "      where e.code in ('".$codes."') ".
         "      and e.code = i.code ".
         "      and e.year = '".$pYear."' ".
         "      and e.year = i.year ".
         "      and e.season = i.season ".
         "      and e.season = '".$tSeason."' ) pSeason, ".
         "      prices p, company_map map ".
         "where 1=1 ".
         "and p.date = '".$_POST['date']."' ".
         "and tSeason.code = p.code ".
         "and tSeason.code = pSeason.code ".
         "and tSeason.code = map.code ".
         "order by code ";

  $result = $conn->query($sql);
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>公司</th>";
  echo "        <th>股價</th>";
  echo "        <th>eps</th>";
  echo "        <th>去年同期eps</th>";
  echo "        <th>增減比例</th>";
  echo "        <th>毛利率</th>";
  echo "        <th>營利率</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  foreach ($result as $row)
  {  
      echo  "<tr class='row100'>";
      echo    "<td>".$row['company'].'('.$row['code'].")</td>";
      echo    "<td>".$row['price']."</td>";
      echo    "<td>".$row['tEps']."</td>";
      echo    "<td>".$row['pEps']."</td>";
      /*************************** EPS增減 ***************************/
      if ($row['epsRate'] > 0) 
          echo "<td class='up'>".round($row['epsRate'],2)."%</td>";
      else if ($row['epsRate'] < 0) 
          echo "<td class='down'>".round($row['epsRate'],2)."%</td>";
      else 
          echo "<td class='same'>".round($row['epsRate'],2)."%</td>";
      /*************************** 毛利率增減 ***************************/
      if ($row['tGross'] > $row['pGross'])
          echo "<td class='up'>".($row['tGross'] - $row['pGross'])."%</td>";
      else if($row['tGross'] < $row['pGross'])
          echo "<td class='down'>".($row['tGross'] - $row['pGross'])."%</td>";
      else
          echo "<td class='same'>".($row['tGross'] - $row['pGross'])."%</td>";
      /*************************** 營利率增減 ***************************/
      if ($row['tOperating'] > $row['pOperating'])
          echo "<td class='up'>".($row['tOperating'] - $row['pOperating'])."%</td>";
      else if($row['tOperating'] < $row['pOperating'])
          echo "<td class='down'>".($row['tOperating'] - $row['pOperating'])."%</td>";
      else
          echo "<td class='same'>".($row['tOperating'] - $row['pOperating'])."%</td>";

      echo  "</tr>";
  }

  echo "\""; 
  $result->close();
?>
