<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191124 rusiang  計算毛利率成長，分母使用絕對值 
  /* 20200112 rusiang  修正四率成長幅度算法 
  /**********************************************************************************/  
  require_once('commonFunc.php');  
  require_once('db.php');
  echo "\"";
  
  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from eps ".
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
  echo "  <input type='hidden' name='type' value='season'>";
  echo "</form>";

  ///////////////////////////////////// 公司列表 /////////////////////////////////////
  $tYear = substr($_POST['season'],0,4);
  $pYear = (string)((int)substr($_POST['season'],0,4)-1);
  $tSeason = substr($_POST['season'],4,6);
  $sql = "select map.company, p.code, p.price, p.PE, ".
         "(d.cash/p.price)*100 dividend, ".
         "round((tSeason.grossRate-pSeason.grossRate),2) grossRate, ".
         "round((tSeason.operatingRate-pSeason.operatingRate),2) operatingRate, ".
         "round((tSeason.eps-pSeason.eps)/abs(pSeason.eps)*100,2) epsRate, ".
         "round((tSeason.income-pSeason.income)/abs(pSeason.income)*100,2) incomeRate, ".
         "round((tSeason.beforeTaxRate-pSeason.beforeTaxRate),2) beforeTax, ".
         "round((tSeason.afterTaxRate-pSeason.afterTaxRate),2) afterTax, ".
         "round(tSeason.operatingRate/tSeason.beforeTaxRate*100,2) mainJob, ". 
         "round(p.pe/((tSeason.eps-pSeason.eps)/abs(pSeason.eps)*100),2) peGrow ".
         /**************當季*******************/
         "from (select e.code, e.eps, i.grossRate, i.operatingRate, i.operatingIncome income, ".  
         "      i.beforeTaxRate, i.afterTaxRate ".  
         "      from eps e, income i ".
         "      where e.code in ('".$codes."') ".
         "      and e.code = i.code ".
         "      and e.year = '".$tYear."' ".
         "      and e.year = i.year ".
         "      and e.season = i.season ".
         "      and e.season = '".$tSeason."' ) tSeason, ".
         /**************前季*******************/
         "     (select e.code, e.eps, i.grossRate, i.operatingRate, i.operatingIncome income, ".
         "      i.beforeTaxRate, i.afterTaxRate ".  
         "      from eps e, income i ".
         "      where e.code in ('".$codes."') ".
         "      and e.code = i.code ".
         "      and e.year = '".$pYear."' ".
         "      and e.year = i.year ".
         "      and e.season = i.season ".
         "      and e.season = '".$tSeason."' ) pSeason, ".
         /**************現金股息*****************/
         "      (select code, cash ".                                 
         "       from dividend ".
         "       where code in ('".$codes."') ".
         "       and year = (select year from dividend order by year desc limit 0,1) )d, ".
//       "       and year = '".((int)$tYear-1)."' ) d, ".
         "      prices p, company_map map ".
         "where 1=1 ".
         "and p.date = '".$_POST['date']."' ".
         "and tSeason.code = p.code ".
         "and tSeason.code = pSeason.code ".
         "and tSeason.code = map.code ".
         "and tSeason.code = d.code ".
         "order by code ";

  $result = $conn->query($sql);
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1' id='myTable'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th onclick='sortTable(0)'>公司</th>";
  echo "        <th onclick='sortTable(1)'>股價</th>";
  echo "        <th onclick='sortTable(2)'>現金殖利率</th>";
  echo "        <th onclick='sortTable(3)'>本益比</th>";
  echo "        <th onclick='sortTable(4)'>本益成長比</th>";
  echo "        <th onclick='sortTable(5)'>營業收入</th>";
  echo "        <th onclick='sortTable(6)'>毛利率</th>";
  echo "        <th onclick='sortTable(7)'>營業利益率</th>";
  echo "        <th onclick='sortTable(8)'>稅前淨利率</th>";
  echo "        <th onclick='sortTable(9)'>稅後淨利率</th>";
  echo "        <th onclick='sortTable(10)'>EPS</th>";
  echo "        <th onclick='sortTable(11)'>本業收入</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  foreach ($result as $row)
  {  
      echo  "<tr class='row100'>";
      echo  "  <td><a href=price.php?company=".$row['code'].">".$row['company']."</a></td>";
      echo    "<td>".$row['price']."</td>";
      echo    "<td>".round($row['dividend'],2)."%</td>";
      echo    "<td>".$row['PE']."</td>";
      echo    "<td>".$row['peGrow']."</td>";
      echo    getRateTd($row['incomeRate']);
      echo    getRateTd($row['grossRate']);
      echo    getRateTd($row['operatingRate']);
      echo    getRateTd($row['beforeTax']);
      echo    getRateTd($row['afterTax']);
      echo    getRateTd($row['epsRate']);
      echo    "<td>".$row['mainJob']."%</td>";
      echo  "</tr>";
  }

  echo "\""; 
  $result->close();
?>
