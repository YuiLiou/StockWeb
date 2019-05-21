<?php
// error message
ini_set('display_errors','1');
error_reporting(E_ALL);

// connect to db
require_once('db.php');
$sql = "select * ".
       "from income ".
       "where code = '".$_GET['company']."' ".
       "order by year asc, season asc";
$result = $conn->query($sql);
$data = array();
foreach ($result as $row)
{
    $data[] = $row;
}
// close db
$result->close();
echo json_encode($data);
?>
