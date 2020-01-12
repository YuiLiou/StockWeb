<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200112 rusiang  Created
  /**********************************************************************************/  
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";  
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th></th>".
           "<th>股價</th>".
           "<th>本益比</th>".
           "<th>最高價</th>".
           "<th>最低價</th>".
         "</tr>".
       "</thead><tbody>";

  /*********************************************************************************/
  /*當日股價                                                                    
  /*********************************************************************************/
  echo "【統計】<br>";
  $sql = "select pe, price ".
         "from prices ".
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "order by date desc ".
         "limit 0,1 ";         
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引 
  echo "<tr>";   
  echo "  <td>當日</td>"; 
  echo "  <td>".$row['price']."</td>"; 
  echo "  <td>".$row['pe']."</td>"; 
  echo "  <td>-</td>"; 
  echo "  <td>-</td>"; 
  echo "</tr>";

  /*********************************************************************************/
  /*20日股價                                                                    
  /*********************************************************************************/
  $sql = "select round(avg(pe),2) pe, round(avg(price),2) price, max(price) max_price, min(price) min_price ".
         "from ".
         "( ".
         "  select price, pe ".
         "  from prices ".
         "  where 1=1 ".
         "  and code = '".$_GET['company']."' ".
         "  order by date desc ".
         "  limit 0,20 ".
         ") a ";           
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引     
  echo "<tr>";   
  echo "  <td>20日</td>"; 
  echo "  <td>".$row['price']."</td>"; 
  echo "  <td>".$row['pe']."</td>"; 
  echo "  <td>".$row['max_price']."</td>"; 
  echo "  <td>".$row['min_price']."</td>"; 
  echo "</tr>";

  /*********************************************************************************/
  /*60日股價                                                                    
  /*********************************************************************************/
  $sql = "select round(avg(pe),2) pe, round(avg(price),2) price, max(price) max_price, min(price) min_price ".
         "from ".
         "( ".
         "  select price, pe ".
         "  from prices ".
         "  where 1=1 ".
         "  and code = '".$_GET['company']."' ".
         "  order by date desc ".
         "  limit 0,60 ".
         ") a ";         
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引     
  echo "<tr>";   
  echo "  <td>60日</td>"; 
  echo "  <td>".$row['price']."</td>"; 
  echo "  <td>".$row['pe']."</td>";
  echo "  <td>".$row['max_price']."</td>"; 
  echo "  <td>".$row['min_price']."</td>";  
  echo "</tr>";

  echo "\"";
?>
