<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191130 rusiang  新增法人買賣佔大盤比率  
  /**********************************************************************************/  
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
  $sql = "select l.date, l.foreigner, l.dealer, l.investment, l.total, ".
         "round(l.foreigner/p.volume*100,2) fr, round(l.dealer/p.volume*100,2) dr, ".
         "round(l.investment/p.volume*100,2) ir, round(l.total/volume*100,2) tr ".
         "from legals l, prices p ".         
         "where 1=1 ".
         "and l.code = '".$_GET['company']."' ".
         "and l.code = p.code ".
         "and l.date = p.date ".
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
           "<th>外資比率</th>".
           "<th>自營商</th>".
           "<th>自營商比率</th>".
           "<th>投信</th>". 
           "<th>投信比率</th>". 
           "<th>總計</th>".
           "<th>比率</th>".
         "</tr>".
       "</thead><tbody>";

  for ($i=0;$i<$total_records;$i++){ 
      $row = mysqli_fetch_assoc($result); 
      echo  "<tr class='row100'>";
      echo    "<td>".$row['date']."</td>";
      echo    getMarkedTd($row['foreigner']); // 外資     
      echo    getRateTd($row['fr']); // 自營商    
      echo    getMarkedTd($row['dealer']); // 自營商   
      echo    getRateTd($row['dr']); // 自營商   
      echo    getMarkedTd($row['investment']); // 投信
      echo    getRateTd($row['ir']); // 自營商    
      echo    getMarkedTd($row['total']); // 三大法人   
      echo    getRateTd($row['tr']); // 自營商   
      echo "</tr>";
  }
  echo "</tbody></table></div>\"";
  $result->close();
?>
