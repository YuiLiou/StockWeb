<?php
  function getContinuousTd($value)
  {
      if ($value == 1)
          return "<td class='up'>轉虧為盈</td>";
      else if ($value > 1)    
          return "<td class='up'>連續".$value."季成長</td>";
      else if ($value == -1)
          return "<td class='down'>轉盈為虧</td>";
      else if ($value < -1)    
          return "<td class='down'>連續".-1*$value."季虧損</td>";
  }
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
  echo "        <th>季節</th>";
  echo "        <th>EPS</th>";
  echo "        <th>毛利率</th>";
  echo "        <th>營利率</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  $sql = "select m.company, a.code, a.year, a.season, a.eps, a.polar epsPolar, ".
         "b.polar grossPolar, c.polar operatingPolar ".
         "from ".
         "    (SELECT e.code, e.year, e.season, e.eps , ". /************* eps *************/
         "        @con_day := ".
         "            (case ".
         "                when (e.code != @cur_code) then 0 ".
	 "                when (e.eps > @pre and @con_day > 0) then (@con_day + 1) ".
         "                when (e.eps > @pre) then 1 ".
         "                when (e.eps < @pre and @con_day < 0) then (@con_day - 1) ".
         "                when (e.eps < @pre) then -1 ".
         "                else 0 ".
         "            end) polar, ".
         "        @pre := e.eps, ".
         "        @cur_code := e.code ".
         "    from _eps e, ".
         "    (SELECT @cur_code = '', @con_day:=0, @pre:=0) p ".
         "    where e.code in ('".$codes."') ".
         "    order by code asc , year asc , season asc) a, ".
         "    (SELECT i.code, i.year, i.season, i.grossRate , ".  /************* 毛利 *************/
         "        @con_day := ". 
         "            (case ".
         "                 when (i.code != @cur_code) then 0 ".
         "                 when (i.grossRate > @pre AND @con_day > 0) then (@con_day + 1) ".
         "                 when (i.grossRate > @pre) then 1 ".
         "                 when (i.grossRate < @pre AND @con_day < 0) then (@con_day - 1) ".
         "                 when (i.grossRate < @pre) then -1 ".
         "                 else 0 ".
         "            end) polar, ".
         "        @pre:=i.grossRate, ".
         "        @cur_code:=i.code ".
         "    from income i, ".
         "    (SELECT @cur_code = '', @con_day:=0, @pre:=0) p ".
         "    where i.code in ('".$codes."') ".
         "    order by code asc, year asc, season asc) b,".
         "    (SELECT i.code, i.year, i.season, i.operatingRate , ".  /************* 營利 *************/
         "        @con_day := ". 
         "            (case ".
         "                 when (i.code != @cur_code) then 0 ".
         "                 when (i.operatingRate > @pre AND @con_day > 0) then (@con_day + 1) ".
         "                 when (i.operatingRate > @pre) then 1 ".
         "                 when (i.operatingRate < @pre AND @con_day < 0) then (@con_day - 1) ".
         "                 when (i.operatingRate < @pre) then -1 ".
         "                 else 0 ".
         "            end) polar, ".
         "        @pre:=i.operatingRate, ".
         "        @cur_code:=i.code ".
         "    from income i, ".
         "    (SELECT @cur_code = '', @con_day:=0, @pre:=0) p ".
         "    where i.code in ('".$codes."') ".
         "    order by code asc, year asc, season asc) c,".
         "company_map m ".
         "where m.code = a.code ".
         "and a.code = b.code ".
         "and a.code = c.code ".
         "and a.year = '".$tYear."' ".
         "and a.season = '".$tSeason."' ".
         "and b.year = '".$tYear."' ".
         "and b.season = '".$tSeason."' ".
         "and c.year = '".$tYear."' ".
         "and c.season = '".$tSeason."' ".
         "order by epsPolar desc ";

  $result = $conn->query($sql);

  foreach ($result as $row){
    echo  "<tr class='row100'>";
    echo  "  <td><a href=finance.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td>";
    echo  "  <td>".$row['year'].$row['season']."</td>";
    echo getContinuousTd($row['epsPolar']);
    echo getContinuousTd($row['grossPolar']);
    echo getContinuousTd($row['operatingPolar']);
    echo  "<tr>";
  }
  echo "</tbody></table></div>";

  echo "\""; 
  $result->close();
?>
