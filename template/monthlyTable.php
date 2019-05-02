<?php
require_once('db.php');
if (empty($_GET))
    $sql = "select * ".
           "from monthly ".
           "order by month desc";
else
    $sql = "select * ".
           "from monthly ".
           "where code = '".$_GET['company']."' ".
           "order by month desc";
$result = $conn->query($sql);
$total_records = mysqli_num_rows($result);  // 取得記錄數

/////////////////////////// 標題 /////////////////////////// 
echo "\"<div class='table100 ver1 m-b-110' id='monthlyTbl'>".
     "<table data-vertable='ver1'>".
     "<thead>".
       "<tr class='row100 head'>".
         "<th style='width:15%;' class='column100 column1' data-column='column1'>年度/月份</th>".
         "<th class='column100 column2' data-column='column2'>月營收</th>".
         "<th class='column100 column3' data-column='column3'>年增率</th>".
         "<th class='column100 column4' data-column='column4'>累計營收</th>". 
         "<th class='column100 column5' data-column='column5'>累計營收年增率</th>".
       "</tr>".
     "</thead><tbody>";

/////////////////////////// 欄位 /////////////////////////// 
for ($i=0;$i<$total_records;$i++){ 
    $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
    echo  "<tr class='row100'>".
            "<td class='column100 column1' data-column='column1'>".$row['month']."</td>". 
            "<td class='column100 column2' data-column='column2'>".$row['current']."</td>".
            "<td class='column100 column3' data-column='column3'>".$row['YoY']."</td>".
            "<td class='column100 column4' data-column='column4'>".$row['Yearly']."</td>".
            "<td class='column100 column5' data-column='column5'>".$row['Yearly_YoY']."</td>".
          "</tr>";
}
echo "</tbody></table></div>\"";
$result->close();
?>
