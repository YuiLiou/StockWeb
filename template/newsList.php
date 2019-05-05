<?php
require_once('db.php');
if (empty($_GET))
    $sql = "select title, date, url ".
           "from news ".
           "where code = '2330' ".
           "order by date desc";
else
    $sql = "select title, date, url ".
           "from news ".
           "where code = '".$_GET['company']."' ".
           "order by date desc";
$result = $conn->query($sql);
$total_records = mysqli_num_rows($result);  // 取得記錄數

////////////////////////////// 新聞列表 ///////////////////////////////
echo "\"<nav id='newsList'><ul>";
for ($i=0;$i<$total_records;$i++){ 
    $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
    echo  "<li><a href='".$row['url']."' target='_blank'>".$row['date']." ".$row['title']."</a></li>";
}
echo "</ul></nav>\"";

?>
