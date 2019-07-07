<?php
  if (empty($_GET))
      $_GET['company'] = '2330';
  echo "\"";
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th></th>".
           "<th>Q1</th>".
           "<th>Q2</th>".
           "<th>Q3</th>".
           "<th>Q4</th>".          
           "<th>總計</th>".          
         "</tr>".
       "</thead><tbody>";

  $sql = "select a.year, ".
         "       ifnull(a.eps,'-') Q1, ".
         "       ifnull(b.eps,'-') Q2, ".
         "       ifnull(c.eps,'-') Q3, ".
         "       ifnull(d.eps,'-') Q4, ".
         "       a.eps+ifnull(b.eps,0)+ifnull(c.eps,0)+ifnull(d.eps,0) total ".
         "from ".
         "    (select year, eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q1' ) a ".
         "    left join (select year, eps ".
         "               from _eps ".
         "               where code = '".$_GET['company']."' ".
         "               and season = 'Q2' ) b ".
         "    on a.year = b.year ".
         "    left join (select year, eps ".
         "               from _eps ".
         "                where code = '".$_GET['company']."' ".
         "                and season = 'Q3' ) c ".
         "    on a.year = c.year ".
         "    left join (select year, eps ".
         "               from _eps ".
         "               where code = '".$_GET['company']."' ".
         "               and season = 'Q4' ) d ".
         "    on a.year = d.year ".
         "order by year desc ";

  $result = $conn->query($sql);
  foreach ($result as $row){
      echo "<tr class='row100'>";
      echo "  <td>".$row['year']."</td>";
      echo "  <td>".round($row['Q1'],2)."</td>";
      echo "  <td>".round($row['Q2'],2)."</td>";
      echo "  <td>".round($row['Q3'],2)."</td>";
      echo "  <td>".round($row['Q4'],2)."</td>";
      echo "  <td>".round($row['total'],2)."</td>";
      echo "</tr>";
  }

  $sql = "select round(avg(a.eps),2) Q1, ".
         "       round(avg(b.eps),2) Q2, ".
         "       round(avg(c.eps),2) Q3, ".
         "       round(avg(d.eps),2) Q4,  ".
         "       round(avg(a.eps)+avg(b.eps)+avg(c.eps)+avg(d.eps),2) total ".
         "from ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q1' ) a, ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q2' ) b, ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q3' ) c, ".
         "    (select eps ".
         "     from _eps ".
         "     where code = '".$_GET['company']."' ".
         "     and season = 'Q4' ) d ";

  $result = $conn->query($sql);
  foreach ($result as $row){
      echo "<tr class='row100'>";
      echo "  <td>平均</td>";
      echo "  <td>".$row['Q1']."</td>";
      echo "  <td>".$row['Q2']."</td>";
      echo "  <td>".$row['Q3']."</td>";
      echo "  <td>".$row['Q4']."</td>";
      echo "  <td>".$row['total']."</td>";
      echo "</tr>";
  }

  echo "</tr></tbody></table></div>";
  echo "\"";
?>