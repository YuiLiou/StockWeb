<?php
if (empty($_GET))
    $_GET['company'] = '2330';

$sql = "select title, date, url ".
       "from news ".
       "where code = '".$_GET['company']."' ".
       "and logTime >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) ".
       "order by date desc ".
       "limit 0,30 ";
$result = $conn->query($sql);
$total_records = mysqli_num_rows($result);  // 取得記錄數

////////////////////////////// 新聞列表 ///////////////////////////////
echo "\"<div id='newsList'><nav><ul>";
for ($i=0;$i<$total_records;$i++){ 
    $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
    echo  "<li><a href='".$row['url']."' target='_blank'>".$row['date']." ".$row['title']."</a></li>";
}
echo "</ul></nav></div>\"";
?>
