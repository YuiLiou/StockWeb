<?php
  require_once('commonFunc.php');
  if (empty($_GET)) {$_GET['company'] = '2330';}
  echo "\"";

  /*********************************************************************************/
  /*『SQL』30日價差                                                          
  /*********************************************************************************/
  $sql = "select p1.price p1, p30.price p30, round((p1.price-p30.price)/p30.price*100,2) pavg ".
         "from (select price ".
         "      from prices ".
         "      where 1=1 ".
         "      and code = '".$_GET['company']."' ".
         "      order by date desc ". 
         "      limit 0,1) p1, ".
         "     (select price ".
         "      from prices ".
         "      where 1=1 ".
         "      and code = '".$_GET['company']."' ".
         "      order by date desc ".
         "      limit 29,1) p30 ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  echo "*********************************************************************<br>";
  echo "*** 30日以來 ***<br>";
  echo "【".$row['pavg']."%】".$row['p30']."元→".$row['p1']."元<br>";

  /*********************************************************************************/
  /*『SQL』30日累計買賣超                                                                      
  /*********************************************************************************/
  $sql = "select sum(sub.foreigner) f, sum(sub.dealer) d, sum(sub.investment) i, sum(sub.total) t ".
         "from (select foreigner, dealer, investment, total ".
         "      from legals ".         
         "      where 1=1 ".
         "      and code = '".$_GET['company']."' ".
         "      order by date desc ".
         "      limit 0,30) sub ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); 
  echo "『外資買賣超』".$row['f']."張<br>";
  echo "『自營商買賣超』".$row['d']."張<br>";
  echo "『投信買賣超』".$row['i']."張<br>";
  echo "『總計買賣超』".$row['t']."張<br>";
  echo "*********************************************************************<br>";
  
  /*********************************************************************************/
  /*『SQL』30日法人買賣狀況                                                                      
  /*********************************************************************************/
  $sql = "select date, foreigner, dealer, investment, total ".
         "from legals ".         
         "where 1=1 ".
         "and code = '".$_GET['company']."' ".
         "order by date desc ".
         "limit 0,30"; 
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數

  /*********************************************************************************/
  /*『HTML』30日法人買賣狀況                                                                      
  /*********************************************************************************/
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>".
       "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th style='width:15%;'>日期</th>".
           "<th>外資</th>".
           "<th>自營商</th>".
           "<th>投信</th>". 
           "<th>總計</th>".
         "</tr>".
       "</thead><tbody>";

  for ($i=0;$i<$total_records;$i++){ 
      $row = mysqli_fetch_assoc($result); 
      echo  "<tr class='row100'>";
      echo    "<td>".$row['date']."</td>";
      echo    getMarkedTd($row['foreigner']); // 外資      
      echo    getMarkedTd($row['dealer']); // 自營商   
      echo    getMarkedTd($row['investment']); // 投信 
      echo    getMarkedTd($row['total']); // 三大法人   
      echo "</tr>";
  }
  echo "</tbody></table></div>\"";
  $result->close();
?>
