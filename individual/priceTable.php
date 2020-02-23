<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200112 rusiang  Created
  /* 20200118 rusiang  統計增加高低差/殖利率/淨值比
  /**********************************************************************************/  
  if (empty($_GET)) $_GET['company'] = '2330';
  echo "\"";  
  
  /*********************************************************************************/
  /*【股價走勢】                                                                     
  /*********************************************************************************/
  echo "【股價走勢】<br>";
  echo "<canvas id='myChart'></canvas>";

  /*********************************************************************************/
  /*【統計資料】                                                                     
  /*********************************************************************************/  
  echo "<div class='table100 ver1' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th></th>".
           "<th>股價</th>".
           "<th>本益比</th>".
           "<th>最高價</th>".
           "<th>最低價</th>".
           "<th>高低差</th>".
           "<th>每股淨值比</th>".
           "<th>現金殖利率</th>".
         "</tr>".
       "</thead><tbody>";
  
  echo "【統計資料】<br>";
  $sql = "select p.*, round(p.price/d.value,2) net_worth, ".
         "       round(cash/price*100,2) cash_rate ".             
         "from ".
         "( ".  
         "  select pe, price, code ".
         "  from prices ".
         "  where 1=1 ".
         "  and code = '".$_GET['company']."' ".
         "  order by date desc ".
         "  limit 0,1 ".
         ") p left join ". 
         "( ".
         "  select c.value, c.code ".
         "  from ".
         "  ( ".
         "    select code, value ".
         "    from property ". 
         "    where 1=1 ". 
         "    and col_name in ('每股參考淨值') ". 
         "    and code = '".$_GET['company']."' ".
         "    order by year desc , season desc ".
         "  ) c ".
         "  limit 0,1 ".
         ") d on p.code = d.code ".
         "left join ".
         "( ".
         "  select c.cash, c.code ".
         "  from ".
         "  ( ".
         "    select code, cash ".
         "    from dividend ". 
         "    where 1=1 ". 
         "    and code = '".$_GET['company']."' ".
         "    order by year desc ".
         "  ) c ".
         "  limit 0,1 ".
         ") e on p.code = e.code ";     
   
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引 
  echo "<tr>";   
  echo "  <td>當日</td>"; 
  echo "  <td>".$row['price']."</td>"; 
  echo "  <td>".$row['pe']."</td>"; 
  echo "  <td>-</td>"; 
  echo "  <td>-</td>"; 
  echo "  <td>-</td>"; 
  echo "  <td>".$row['net_worth']."</td>"; 
  echo "  <td>".$row['cash_rate']."％</td>"; 
  echo "</tr>";

  /*********************************************************************************/
  /*5/20/60日股價                                                                    
  /*********************************************************************************/
  $days = array(5,20,60);
  foreach ($days as $d) 
  {
      $sql = "select b.*, round(((max_price/min_price))-1,2)*100 move, ".
             "       round(price/d.value,2) net_worth, ".
             "       round(cash/price*100,2) cash_rate ".             
             "from ".
             "( ". 
             "  select round(avg(pe),2) pe, round(avg(price),2) price, ".
             "         max(price) max_price, min(price) min_price, code ".            
             "  from ".
             "  ( ".
             "    select price, pe, code ".
             "    from prices ".
             "    where 1=1 ".
             "    and code = '".$_GET['company']."' ".
             "    order by date desc ".
             "    limit 0,".$d." ".
             "  ) a ". 
             "  group by code ".            
             ") b left join ".
             "( ".
             "  select c.value, c.code ".
             "  from ".
             "  ( ".
             "    select code, value ".
             "    from property ". 
             "    where 1=1 ". 
             "    and col_name in ('每股參考淨值') ". 
             "    and code = '".$_GET['company']."' ".
             "    order by year desc, season desc ".
             "  ) c ".
             "  limit 0,1 ".
             ") d on b.code = d.code ". 
             "left join ".
             "( ".
             "  select c.cash, c.code ".
             "  from ".
             "  ( ".
             "    select code, cash ".
             "    from dividend ". 
             "    where 1=1 ". 
             "    and code = '".$_GET['company']."' ".
             "    order by year desc ".
             "  ) c ".
             "  limit 0,1 ".
             ") e on b.code = e.code "; 
      $result = $conn->query($sql);
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引     
      echo "<tr>";   
      echo "  <td>".$d."日</td>"; 
      echo "  <td>".$row['price']."</td>"; 
      echo "  <td>".$row['pe']."</td>"; 
      echo "  <td>".$row['max_price']."</td>"; 
      echo "  <td>".$row['min_price']."</td>"; 
      echo getRateTd($row['move']); 
      echo "  <td>".$row['net_worth']."</td>"; 
      echo "  <td>".$row['cash_rate']."％</td>"; 
      echo "</tr>";           
  }
  echo "\"";
?>
