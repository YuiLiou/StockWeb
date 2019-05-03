<?php

// connect to db
require_once('db.php');
$sql = "select date, foreigner, dealer, investment, total ".
       "from legals l ".         
       "where 1=1 ".
       "and code = '".$_GET['company']."' ".
       "order by date desc ";
echo $sql;
$result = $conn->query($sql);
$data = array();
foreach ($result as $row)
{
    $data[] = $row;
}

// close db
$result->close();
$conn->close();
echo json_encode($data);
?>
