<?php
  require_once('db.php');
  require_once('commonFunc.php');
  echo "\"";
  
  ///////////////////////////////////// 月份選單 /////////////////////////////////////
  $sql = "select distinct month ".
         "from monthly ".
         "order by month desc ";
  $result = $conn->query($sql);

  echo "    <select id='slct' name=month onchange='this.form.submit()'>";  
  foreach ($result as $row)
  {
      if (empty($_POST['month']))
      {
          $_POST['month'] = $row['month']; // 預設為當月
      }      
      if ($_POST['month'] == $row['month']) // 顯示被選擇的月份
          echo "<option selected='selected' value='".$row['month']."'>".$row['month']."</option>";
      else
          echo "<option value='".$row['month']."'>".$row['month']."</option>";
  }
  echo "  </select>";
  echo "  <input type='hidden' name='type' value='yoy'>";
  echo "</form>";

  ///////////////////////////////////// 公司列表 /////////////////////////////////////
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1' id='myTable'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th onclick='sortTable(0)'>公司</th>";
  echo "        <th onclick='sortTable(1)'>月營收</th>";
  echo "        <th onclick='sortTable(2)'>月增率</th>";
  echo "        <th onclick='sortTable(3)'>年增率</th>";
  echo "        <th onclick='sortTable(4)'>累計營收</th>"; 
  echo "        <th onclick='sortTable(5)'>累計年增率</th>";
  echo "        <th onclick='sortTable(6)'>季營收</th>";
  echo "        <th onclick='sortTable(7)'>季成長</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  $sql = "select m.*, map.company, this_3.sCurrent, ".
         "    round((this_3.sCurrent-past_3.sCurrent)*100/past_3.sCurrent,2) grow ".
         "from company_map map, monthly m, ".
         /*************************************最近三月************************************/
         "    (select code, sum(current) sCurrent ".
         "    from ( ".
         "        select code, current, ". 
         "        @rank := if(@current_code != code, 1, @rank + 1) AS rank, ".
         "        @current_code := code ".
         "        from monthly, ".
         "            (select @current_code := '', @rank:=0)a ".
         "        where code in ('".$codes."') ".
         "        order by code asc, month desc ".
         "        ) ranked ".
         "    where rank <= 3 ".
         "    group by code) this_3, ".         
         /*************************************去年同期三月************************************/
         "    (select code, sum(current) sCurrent ".
         "    from ( ".
         "        select code, current, ". 
         "        @rank := if(@current_code != code, 1, @rank + 1) AS rank, ".
         "        @current_code := code ".
         "        from monthly, ".
         "            (select @current_code := '', @rank:=0)a ".
         "        where code in ('".$codes."') ".
         "        order by code asc, month desc ".
         "        ) ranked ".
         "    where rank > 12 and rank <= 15 ".
         "    group by code) past_3 ".         
         "where 1=1 ".
         "and map.code in ('".$codes."') ".
         "and map.code = m.code ".
         "and map.code = this_3.code ".
         "and map.code = past_3.code ".
         "and m.month = '".$_POST['month']."' ".
         "order by Yearly_YoY desc ";

  $result = $conn->query($sql);
  foreach ($result as $row){
    echo  "<tr class='row100'>";
    echo  "  <td><a href=price.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td>";
    echo  "  <td>".$row['current']."</td>";
    echo     getRateTd($row['MoM']); // 月增率
    echo     getRateTd($row['YoY']); // 年增率   
    echo     "<td>".$row['Yearly']."</td>"; // 累計營收
    echo     getRateTd($row['Yearly_YoY']); // 累計年增率   
    echo     "<td>".$row['sCurrent']."</td>";
    echo     getRateTd($row['grow']);
    echo "</tr>";
  }
  echo "</tbody></table></div>";
  echo "\""; 
  $result->close();
?>
