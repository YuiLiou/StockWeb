<?php
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
  echo "        <th>EPS</th>";
  echo "        <th>毛利率</th>";
  echo "        <th>營利率</th>";
  echo "        <th>連續配息</th>";
  echo "        <th>去年獲利</th>";
  echo "        <th>今年配息</th>";
  echo "        <th>近年配息</th>";
  echo "        <th>今年發放率</th>";
  echo "        <th>近年發放率</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  $sql = "select m.company, a.code, a.year, a.season, a.epsPolar, d.cash, ".
         "    round(d.cash*100/g.pre_eps,2) dispatch, e.avgCash, ".
         "    b.grossPolar, c.operatingPolar, d.polar cashYears, ".
         "    f.avgDispatch, g.pre_eps ".
         "from ".
         "    (SELECT e.code, e.year, e.season, ". /************* eps *************/
         "        @con_day := ".
         "            (case ".
         "                when (e.code != @cur_code) then 0 ".
	 "                when (e.eps > @pre and @con_day > 0) then (@con_day + 1) ".
         "                when (e.eps > @pre) then 1 ".
         "                when (e.eps < @pre and @con_day < 0) then (@con_day - 1) ".
         "                when (e.eps < @pre) then -1 ".
         "                else 0 ".
         "            end) epsPolar, ".
         "        @pre := e.eps, ".
         "        @cur_code := e.code ".
         "    from _eps e, ".
         "    (SELECT @cur_code := '', @con_day:=0, @pre:=0) p ".
         "    where e.code in ('".$codes."') ".
         "    order by code asc , year asc , season asc) a, ".
         "    (SELECT i.code, i.year, i.season, ".  /************* 毛利 *************/
         "        @con_day := ". 
         "            (case ".
         "                 when (i.code != @cur_code) then 0 ".
         "                 when (i.grossRate > @pre AND @con_day > 0) then (@con_day + 1) ".
         "                 when (i.grossRate > @pre) then 1 ".
         "                 when (i.grossRate < @pre AND @con_day < 0) then (@con_day - 1) ".
         "                 when (i.grossRate < @pre) then -1 ".
         "                 else 0 ".
         "            end) grossPolar, ".
         "        @pre:=i.grossRate, ".
         "        @cur_code:=i.code ".
         "    from income i, ".
         "    (SELECT @cur_code := '', @con_day:=0, @pre:=0) p ".
         "    where i.code in ('".$codes."') ".
         "    order by code asc, year asc, season asc) b,".
         "    (SELECT i.code, i.year, i.season, ".  /************* 營利 *************/
         "        @con_day := ". 
         "            (case ".
         "                 when (i.code != @cur_code) then 0 ".
         "                 when (i.operatingRate > @pre AND @con_day > 0) then (@con_day + 1) ".
         "                 when (i.operatingRate > @pre) then 1 ".
         "                 when (i.operatingRate < @pre AND @con_day < 0) then (@con_day - 1) ".
         "                 when (i.operatingRate < @pre) then -1 ".
         "                 else 0 ".
         "            end) operatingPolar, ".
         "        @pre:=i.operatingRate, ".
         "        @cur_code:=i.code ".
         "    from income i, ".
         "    (SELECT @cur_code := '', @con_day:=0, @pre:=0) p ".
         "    where i.code in ('".$codes."') ".
         "    order by code asc, year asc, season asc) c,".
         "    (select d.code, d.year, d.cash, @con_year := ". /***************連續配息年度**************/
         "         (case ".
         "             when (d.code != @cur_code) then 0 ".
         "             when (d.cash > 0 and @con_year > 0) then (@con_year + 1) ".
         "             when (d.cash > 0) then 1 ".
         "             else 0 ".
         "         end) polar, ".
         "         @cur_code := d.code ".
         "     from dividend d, ".
         "     (select @cur_code := '', @con_year:=0)p ".
         "     where d.code in ('".$codes."') ".
         "     order by code asc, year asc)d, ".
         "    (select code, avg(cash) avgCash ". /*********************近5年平均股息********************/
         "    from dividend ".
         "    where year >= '".((int)$tYear-4)."' ".
         "    and code in ('".$codes."') ".
         "    group by code) e, ".
         "    (select code, AVG(dispatch) avgDispatch ".    /*******************發放率********************/
         "    from (select (d.cash/e.eps)*100 dispatch, e.code ".
         "         from (select code,year,sum(eps) eps from _eps group by code, year) e ".
         "              ,dividend d ".
         "         where e.code = d.code ".
         "         and e.year = d.year ".
         "         and e.year > '".((int)$tYear-4)."')a ".
         "    where code in ('".$codes."') ".
         "    group by code)f, ".
         "    (select code, sum(eps) pre_eps ". /*******************去年營收********************/
         "    from _eps ".
         "    where year = '".((int)$tYear-1)."' ".
         "    and code in ('".$codes."') ".
         "    group by code, year)g, ".
         "company_map m ".
         "where m.code = a.code ".
         "and a.code = b.code ".
         "and a.code = c.code ".
         "and a.code = e.code ".
         "and a.code = d.code ".
         "and a.code = f.code ".
         "and a.code = g.code ".
         "and a.year = '".$tYear."' ".
         "and a.season = '".$tSeason."' ".
         "and b.year = '".$tYear."' ".
         "and b.season = '".$tSeason."' ".
         "and c.year = '".$tYear."' ".
         "and c.season = '".$tSeason."' ".
         "and d.year = ".((int)$tYear-1)." ".
         "order by epsPolar desc ";
  $result = $conn->query($sql);

  foreach ($result as $row){
    echo  "<tr class='row100'>";
    echo  "  <td><a href=finance.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td>";
    echo     getContinuousTd($row['epsPolar']);
    echo     getContinuousTd($row['grossPolar']);
    echo     getContinuousTd($row['operatingPolar']);
    if ($row['cashYears'] == 0)
      echo "<td class='down'>無配息</td>";
    else if ($row['cashYears'] > 1)    
      echo "<td class='up'>連續".$row['cashYears']."年配息</td>";    
    echo "<td>".round($row['pre_eps'],2)."</td>";    
    echo "<td>".round($row['cash'],2)."</td>";    
    echo "<td>".round($row['avgCash'],2)."</td>";   
    echo getDispatchTd($row['dispatch']);
    echo getDispatchTd($row['avgDispatch']);
    echo  "<tr>";
  }
  echo "</tbody></table></div>";
  

  echo "\""; 
  $result->close();
?>
