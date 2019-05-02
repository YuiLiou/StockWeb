<?php

// connect to db
require_once('db.php');
$sql = "select o.code code,  m.company company ".
       "from own o, company_map m ".
       "where o.user = 'rusiang' and o.code = m.code ".
       "order by o.code asc";
$result = $conn->query($sql);
$data = array();
echo "<section id='sidebar'>";
echo "<nav>";
echo "<ul>";
foreach ($result as $row)
{
    echo "<li><a href='finance.php?company=".$row['code']."'>".$row['company']." (".$row['code'].")</a></li>";
}
echo "</ul>";
echo "</nav>";
echo "</section>";
// close db
$result->close();
?>

