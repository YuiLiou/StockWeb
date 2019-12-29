<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191229 rusiang  計算損益表同期成長季數/殖利率/本益比 
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
  echo "  <input type='hidden' name='type' value='continuous'>";
  echo "</form>";

  $tYear = substr($_POST['season'],0,4);
  $tSeason = substr($_POST['season'],4,6);

  ///////////////////////////////////// 公司列表 /////////////////////////////////////
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>公司</th>";
  echo "        <th>股價</th>";
  echo "        <th>本益比</th>";
  echo "        <th>現金殖利率</th>";
  echo "        <th>毛利率</th>";
  echo "        <th>營業利益率</th>";
  echo "        <th>稅前利益率</th>";
  echo "        <th>稅後利益率</th>";
  echo "        <th>配息力</th>";
  echo "        <th>獲利力</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  $sql = "select m.company, i.code, i.operating_cons, i.gross_cons, i.beforeTax_cons, i.afterTax_cons, ".
         "       p.price, p.PE, round((d.cash/p.price)*100,2) dividend, dividend_cons, eps_cons ".
         "from ".
         "( ".
         "  select this.code, this.year, this.season, ".
         "         @con1 := ".
         "         ( ".
         "           case ". 
         "             when (this.code != @cur_code) then 0 ". 
         "             when (this.grossRate > past.grossRate and @con1 > 0) then (@con1 + 1) ".
         "             when (this.grossRate > past.grossRate) then 1 ".
         "             when (this.grossRate < past.grossRate and @con1 < 0) then (@con1 - 1) ".
         "             when (this.grossRate < past.grossRate) then -1 ".
         "             else 0 ".
         "           end ".
         "         ) gross_cons, ".
         "         @con2 := ".
         "         ( ".
         "           case ". 
         "             when (this.code != @cur_code) then 0 ". 
         "             when (this.operatingRate > past.operatingRate and @con2 > 0) then (@con2 + 1) ".
         "             when (this.operatingRate > past.operatingRate) then 1 ".
         "             when (this.operatingRate < past.operatingRate and @con2 < 0) then (@con2 - 1) ".
         "             when (this.operatingRate < past.operatingRate) then -1 ".
         "             else 0 ".
         "           end ".
         "         ) operating_cons, ".
         "         @con3 := ".
         "         ( ".
         "           case ". 
         "             when (this.code != @cur_code) then 0 ". 
         "             when (this.beforeTaxRate > past.beforeTaxRate and @con3 > 0) then (@con3 + 1) ".
         "             when (this.beforeTaxRate > past.beforeTaxRate) then 1 ".
         "             when (this.beforeTaxRate < past.beforeTaxRate and @con3 < 0) then (@con3 - 1) ".
         "             when (this.beforeTaxRate < past.beforeTaxRate) then -1 ".
         "             else 0 ".
         "           end ".
         "         ) beforeTax_cons, ".
         "         @con4 := ".
         "         ( ".
         "           case ". 
         "             when (this.code != @cur_code) then 0 ". 
         "             when (this.afterTaxRate > past.afterTaxRate and @con4 > 0) then (@con4 + 1) ".
         "             when (this.afterTaxRate > past.afterTaxRate) then 1 ".
         "             when (this.afterTaxRate < past.afterTaxRate and @con4 < 0) then (@con4 - 1) ".
         "             when (this.afterTaxRate < past.afterTaxRate) then -1 ".
         "             else 0 ".
         "           end ".
         "         ) afterTax_cons, ".
         "         @cur_code := this.code ".          
         "  FROM ".
         // 今年損益表
         "  ( ".
         "    SELECT i.*, ".
         "           @rank:= ".
         "           ( ".
         "             case ".
         "               when (i.code != @cur_code) then 1 ".
         "               else @rank + 1 ".
         "             end ".
         "           ) rnk, ".
         "           @cur_code := i.code ".
         "    FROM ".  
         "      (SELECT @rank:=0,@cur_code:='') r, ".     
	 "      ( ".
         "        select i.* ".
         "        FROM income i ".
         "        where 1=1 ".     
         "        ORDER BY i.code asc, i.year desc, i.season desc ".
         "      )i ".
         "  ) this, ".
         // 去年同期損益表
         "  ( ".
         "    SELECT i.*, ".
         "           @rank:= ".
         "           ( ".
         "             case ".
         "               when (i.code != @cur_code) then 1 ".
         "               else @rank + 1 ".
         "             end ".
         "           ) rnk, ".
         "           @cur_code := i.code ".
         "    FROM ".
         "    ( ".
         "      SELECT @rank:=0,@cur_code:='') r, ".
         "      ( ".
         "        select i.* ".
         "        FROM income i, ".
         "             (select distinct year,season from income order by year desc, season desc limit 4,1) s ".
         "        where 1=1 ".
         "        and (i.year < s.year or ".
         "            (i.year = s.year and i.season <= s.season)) ".
         "        ORDER BY i.code asc, i.year desc, i.season desc ".
         "      )i ".
         "    ) past, ".
         "  (SELECT @con1:=0,@con2:=0,@con3:=0,@con4:=0,@this_code:='') p".
         "  WHERE 1 = 1".
         // Join 去年同期損益表
         "  AND this.code = past.code ".
         "  AND this.rnk  = past.rnk".
         "  order by this.code, this.year asc, this.season asc".
         ") i, ".
         // 公司名稱
         "company_map m, prices p, ".
         // 股息
         "( ".
         "  select code, cash ".                                 
         "  from dividend ".
         "  where 1=1 ".
         "  and year = '".((int)$tYear-1)."' ".
         ") d, ".
         // 連續配息年度
         "( ".
         "  select d.code, d.year, @cons := ".
         "  ( ".
         "    case ".
         "      when (d.code != @cur_code and d.cash > 0) then 1 ".
         "      when (d.cash >  0) then @cons + 1 ".
         "      when (d.cash <= 0) then 0 ".
         "      else 0 ".
         "    end ".
         "  )dividend_cons, ".
         "  @cur_code := d.code ".
         "  from (SELECT @cons:=0,@cur_code:='') p, ". 
         "    ( ".
         "      select * ".
         "      from dividend d ".
         "      where 1=1 ".
         "      order by code asc, year asc ".
         "    ) d ".
         ") d2, ".
         // 連續eps>0
         "( ".
         "  select e.code, e.year, @cons := ".
         "  ( ".
         "    case ".
         "      when (e.code != @cur_code and e.eps > 0) then 1 ".
         "      when (e.eps > 0 and @cons > 0) then @cons+1 ".
         "      when (e.eps > 0) then 1 ".
         "      when (e.code != @cur_code and e.eps < 0) then -1 ".
         "      when (e.eps < 0 and @cons < 0) then @cons-1 ".
         "      when (e.eps < 0) then -1 ".
         "      else 0 ".
         "    end ".
         "  )eps_cons, ".
         "  @cur_code := e.code ".
         "  from (SELECT @cons:=0,@cur_code:='') p, ". 
         "    ( ".
         "      select * ".
         "      from eps e ".
         "      where 1=1 ".
         "      and season = '".$tSeason."' ".
         "      order by code asc, year asc ".
         "    ) e ".
         ") e ".
         "where 1=1 ".
         "and i.code = m.code ".
         "and i.year = '".$tYear."' ".
         "and i.season = '".$tSeason."' ".
         "and d.code = i.code ".
         "and p.code = i.code ".
         "and p.date = '".$_POST['date']."' ".
         "and d2.code = i.code ".
         "and d2.year = '".((int)$tYear-1)."' ".
         "and e.code = i.code ".
         "and e.year = i.year ".
         "order by i.gross_cons desc ";

  $result = $conn->query($sql);
  foreach ($result as $row)
  {
    echo  "<tr class='row100'>";
    echo  "  <td><a href=finance.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td>";
    echo    "<td>".$row['price']."</td>";
    echo    "<td>".$row['PE']."</td>";
    echo    "<td>".$row['dividend']."%</td>";
    echo  getContinuousTd($row['gross_cons']);   
    echo  getContinuousTd($row['operating_cons']);
    echo  getContinuousTd($row['beforeTax_cons']);   
    echo  getContinuousTd($row['afterTax_cons']);   
    if ($row['dividend'] == 0)
        echo "<td>不配息</td>";
    else
        echo "<td>連續".$row['dividend_cons']."年配息</td>";
    if ($row['eps_cons'] > 0)
        echo "<td class='up'>連續".$row['eps_cons']."年賺錢</td>";  
    else
        echo "<td class='down'>連續".(-1*$row['eps_cons'])."年賠錢</td>";  
    echo  "<tr>";
  }
  echo "</tbody></table></div>";
  

  echo "\""; 
  $result->close();
?>
