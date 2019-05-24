<?php
if (empty($_GET))
    $_GET['company'] = '2330';
$sql = "select * ".
       "from dividend ".
       "where code = '".$_GET['company']."' ".
       "order by year desc ";
$result = $conn->query($sql);
$total_records = mysqli_num_rows($result);  // 取得記錄數

/////////////////////////// 標題 /////////////////////////// 
echo "\"<div class='table100 ver1' id='monthlyTbl'>".
     "<table data-vertable='ver1'>".
     "<thead>".
       "<tr class='row100 head'>".
         "<th>年度</th>".
         "<th>現金股利</th>".
         "<th>股票股利</th>".
         "<th>總和</th>". 
       "</tr>".
     "</thead><tbody>";

/////////////////////////// 欄位 /////////////////////////// 
for ($i=0;$i<$total_records;$i++){ 
    $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
    echo "<tr class='row100'>";
    echo "  <td>".$row['year']."</td>"; 
    echo "  <td>".$row['cash']."</td>";
    echo "  <td>".$row['allotment']."</td>";
    echo "  <td>".$row['total']."</td>";
    echo "</tr>";
}
echo "</tbody></table></div>\"";
$result->close();
?>
