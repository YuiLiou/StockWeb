<?php

// connect to db
require_once('db.php');
$sql = "select date, price ".
       "from prices ".
       "where code = '".$_GET['company']."' ".
       "order by date desc limit 30";
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
