<?php
if (empty($_GET)) {$_GET['company'] = '2330';}
$sql = "select sum(sub.foreigner) f, sum(sub.dealer) d, sum(sub.investment) i, sum(sub.total) t ".
       "from (select foreigner, dealer, investment, total ".
             "from legals ".         
             "where 1=1 ".
             "and code = '".$_GET['company']."' ".
             "order by date desc ".
             "limit 0,30) sub";
$result = $conn->query($sql);
/////////////////////////// 買賣超摘要 /////////////////////////// 
echo "\"";
$row = mysqli_fetch_assoc($result); 
echo "外資累計買賣超:".$row['f']."  ";
echo "自營商累計買賣超:".$row['d']."  ";
echo "投信累計買賣超:".$row['i']."  ";
echo "總計買賣超:".$row['t']."<br>";
/////////////////////////// 標題 ///////////////////////////
$sql = "select date, foreigner, dealer, investment, total ".
       "from legals ".         
       "where 1=1 ".
       "and code = '".$_GET['company']."' ".
       "order by date desc ".
       "limit 0,30"; 
$result = $conn->query($sql);
$total_records = mysqli_num_rows($result);  // 取得記錄數
echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>".
     "<table data-vertable='ver1'>".
     "<thead>".
       "<tr class='row100 head'>".
         "<th style='width:15%;'>日期</th>".
         "<th>外資</th>".
         "<th>自營商</th>".
         "<th>投信</th>". 
         "<th>總計</th>".
       "</tr>".
     "</thead><tbody>";

/////////////////////////// 欄位 /////////////////////////// 
for ($i=0;$i<$total_records;$i++){ 
    $row = mysqli_fetch_assoc($result); 
    echo  "<tr class='row100'>";
    echo    "<td>".$row['date']."</td>";
    // ----------------------------- 外資 -----------------------------
    if ($row['foreigner'] > 0) 
        echo "<td class='up'>".$row['foreigner']."</td>";
    else if ($row['foreigner'] < 0) 
        echo "<td class='down'>".$row['foreigner']."</td>";
    else 
        echo "<td class='same'>".$row['foreigner']."</td>";
    // ----------------------------- 自營商 -----------------------------
    if ($row['dealer'] > 0) 
        echo "<td class='up'>".$row['dealer']."</td>";
    else if ($row['dealer'] < 0) 
        echo "<td class='down'>".$row['dealer']."</td>";
    else 
        echo "<td class='same'>".$row['dealer']."</td>";
    // ----------------------------- 投信 -----------------------------
    if ($row['investment'] > 0) 
        echo "<td class='up'>".$row['investment']."</td>";
    else if ($row['investment'] < 0) 
        echo "<td class='down'>".$row['investment']."</td>";
    else 
        echo "<td class='same'>".$row['investment']."</td>";
    // ----------------------------- 三大法人 -----------------------------
    if ($row['total'] > 0) 
        echo "<td class='up'>".$row['total']."</td>";
    else if ($row['total'] < 0) 
        echo "<td class='down'>".$row['total']."</td>";
    else 
        echo "<td class='same'>".$row['total']."</td>";
    echo "</tr>";
}
echo "</tbody></table></div>\"";
$result->close();
?>
