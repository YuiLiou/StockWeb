<?php
if (empty($_GET))
    $_GET['company'] = '2330';

$sql = "select year, season, eps ".
       "from eps ".
       "where code = '".$_GET['company']."' ".
       "order by year desc, season asc ";
$result = $conn->query($sql);
$total_records = mysqli_num_rows($result);  // 取得記錄數
/////////////////////////// 標題 /////////////////////////// 
echo "\"<div class='table100 ver1' id='monthlyTbl'>".
     "<table data-vertable='ver1'>".
     "<thead>".
       "<tr class='row100 head'>".
         "<th style='width:15%;'></th>".
         "<th style='width:15%;'>Q1</th>".
         "<th style='width:15%;'>Q2</th>".
         "<th style='width:15%;'>Q3</th>".
         "<th style='width:15%;'>Q4</th>".          
       "</tr>".
     "</thead><tbody>";

/////////////////////////// 欄位 /////////////////////////// 
$year_list = array();
$td_count = 0;
for ($i=0;$i<$total_records;$i++){ 
    $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
    if (in_array($row['year'], $year_list)){
        echo "<td>".$row['eps']."</td>";
        $td_count += 1;
    }
    else{
        //////////////////// new row ///////////////////////
        if ($td_count != 0) for(;$td_count < 4; $td_count++) echo "<td>-</td>"; // 未滿一年補空值 
        array_push($year_list, $row['year']);
        echo "</tr><tr class='row100'>".
                "<td>".$row['year']."</td>".
                "<td>".$row['eps']."</td>";
        $td_count = 1;
    } 
}
echo "</tr></tbody></table></div>\"";
$result->close();

?>
