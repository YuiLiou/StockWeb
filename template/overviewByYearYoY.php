<?php
  require_once('db.php');
  echo "\"";
  /*********************************************************************************/
  /* 日期下拉式選單跳轉的部份
  /*********************************************************************************/
  echo "  <input type='hidden' name='type' value='yoy'>";
  echo "</form>";

  /*********************************************************************************/
  ///////////////////////////////////// 月份選單 /////////////////////////////////////
  $sql = "select distinct month ".
         "from monthly ".
         "order by month desc ";
  $result = $conn->query($sql);

  echo "<form action='index.php' method='POST'>";  
  echo "    <select id='slcMonth' name=month onchange='this.form.submit()'>";  
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
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>公司</th>";
  echo "        <th>月營收</th>";
  echo "        <th>月增率</th>";
  echo "        <th>年增率</th>";
  echo "        <th>累計營收</th>"; 
  echo "        <th>累計營收年增率</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  $sql = "select m.*, map.company ".
         "from company_map map, monthly m ".
         "where 1=1 ".
         "and map.code in ('".$codes."') ".
         "and map.code = m.code ".
         "and m.month = '".$_POST['month']."' ".
         "order by Yearly_YoY desc ";

  $result = $conn->query($sql);
  foreach ($result as $row){
    echo  "<tr class='row100'>";
    echo  "  <td>".$row['company']."(".$row['code'].")</td>";
    echo  "  <td>".$row['current']."</td>";
    // ----------------------------- MoM -----------------------------
    if ($row['MoM'] > 0) 
        echo "<td class='up'>".$row['MoM']."%</td>";
    else if ($row['MoM'] < 0) 
        echo "<td class='down'>".$row['MoM']."%</td>";
    else 
        echo "<td class='same'>".$row['MoM']."%</td>";
    // ----------------------------- YoY -----------------------------
    if ($row['YoY'] > 0) 
        echo "<td class='up'>".$row['YoY']."%</td>";
    else if ($row['YoY'] < 0) 
        echo "<td class='down'>".$row['YoY']."%</td>";
    else 
        echo "<td class='same'>".$row['YoY']."%</td>";
    // ----------------------------- Yearly -----------------------------
    echo "<td>".$row['Yearly']."</td>";
    // ----------------------------- Yearly_YoY -----------------------------
    if ($row['Yearly_YoY'] > 0) 
        echo "<td class='up'>".$row['Yearly_YoY']."%</td>";
    else if ($row['Yearly_YoY'] < 0) 
        echo "<td class='down'>".$row['Yearly_YoY']."%</td>";
    else 
        echo "<td class='same'>".$row['Yearly_YoY']."%</td>";
    echo "</tr>";
  }
  echo "</tbody></table></div>";
  echo "\""; 
  $result->close();
?>
