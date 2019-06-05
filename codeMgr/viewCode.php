<?php
  require('db.php');
  $count=1;
  $sel_query="Select user, o.code, c.company ".
             "from own o, company_map c ".
             "where o.code = c.code ".
             "ORDER BY user desc, code asc ";
  $result = mysqli_query($conn,$sel_query);
  while($row = mysqli_fetch_assoc($result)) { 
      echo "<tr>";
      echo "<td>".$count."</td>";
      echo "<td>".$row["user"]."</td>";
      echo "<td>".$row['company']."(".$row["code"].")</td>";
      echo "<td><a href='codeMgr/deleteCode.php?user=".$row['user']."&code=".$row["code"]."'>Delete</a></td>";
      echo "</tr>";
      $count++; 
  } 
?>
