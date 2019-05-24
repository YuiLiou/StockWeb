<?php
if (empty($_GET))
    $_GET['company'] = '2330';
$sql = "select * ".
       "from monthly ".
       "where code = '".$_GET['company']."' ".
       "order by month desc ".
       "limit 0,30 ";
$result = $conn->query($sql);
$total_records = mysqli_num_rows($result);  // 取得記錄數

/////////////////////////// 標題 /////////////////////////// 
echo "\"<div class='table100 ver1' id='monthlyTbl'>".
     "<table data-vertable='ver1'>".
     "<thead>".
       "<tr class='row100 head'>".
         "<th style='width:15%;'>年度/月份</th>".
         "<th>月營收</th>".
         "<th>年增率</th>".
         "<th>累計營收</th>". 
         "<th>累計營收年增率</th>".
       "</tr>".
     "</thead><tbody>";

/////////////////////////// 欄位 /////////////////////////// 
for ($i=0;$i<$total_records;$i++){ 
    $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
    echo  "<tr class='row100'>".
            "<td>".$row['month']."</td>". 
            "<td>".$row['current']."</td>";
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
echo "</tbody></table></div>\"";
$result->close();
?>
