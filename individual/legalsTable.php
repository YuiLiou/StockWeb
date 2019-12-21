<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191130 rusiang  新增法人買賣佔大盤比率 
  /* 20191221 rusiang  計算30日大盤 
  /**********************************************************************************/  
  require_once('commonFunc.php');
  if (empty($_GET)) {$_GET['company'] = '2330';}
  echo "\"";

  /*********************************************************************************/
  /*『SQL』30日價差                                                          
  /*********************************************************************************/
  $sql = "select round((p1.price-p30.price)/p30.price*100,2) pavg ".
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
  echo "*** 30日以來 ***";
  $avgMoving30 = $row['pavg'];
  /*********************************************************************************/
  /*『SQL』30日累計買賣超                                                                      
  /*********************************************************************************/
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>";
  echo "<table data-vertable='ver1'>";
  echo "<thead>".
         "<tr class='row100 head'>".
           "<th>天數</th>".
           "<th>收盤</th>".
           "<th>漲跌</th>".
           "<th>外資</th>".
           "<th>外資比率</th>".
           "<th>自營商</th>".
           "<th>自營商比率</th>".
           "<th>投信</th>". 
           "<th>投信比率</th>". 
           "<th>總計</th>".
           "<th>比率</th>".
         "</tr>".
       "</thead>";
  echo "<tbody>";
  $sql = "select round(p30.p,2) p30, l30.f, l30.d, l30.i, l30.t, ".
         "       round(l30.f/p30.v*100,2) f30, round(l30.d/p30.v*100,2) d30, ".
         "       round(l30.i/p30.v*100,2) i30, round(l30.t/p30.v*100,2) t30 ".
         "from ".
         "( ".
         "  select sum(l30.foreigner) f, sum(l30.dealer) d, sum(l30.investment) i, sum(l30.total) t ".
         "  from ".
         "  ( ".
         "    select foreigner, dealer, investment, total ".
         "    from legals ".        
         "    where 1=1 ".
         "    and code = '".$_GET['company']."' ".
         "    order by date desc ".
         "    limit 0,30 ".
         "  ) l30 ".
         ") l30, ".
         "( ".
         "  select avg(p30.price) p, sum(p30.volume) v ".
         "  from ".
         "  ( ".
         "    select price, volume ".
         "    from prices ".
         "    where 1=1 ".
         "    and code = '".$_GET['company']."' ".
         "    order by date desc ".
         "    limit 0,30 ".
         "  ) p30 ".
         ")p30 ";
  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result);
      echo "<tr class='row100'>";
      echo " <td>30</td>";
      echo " <td>".$row['p30']."</td>";
      echo " <td>".$avgMoving30."</td>";
      echo getMarkedTd($row['f']);
      echo getRateTd($row['f30']);
      echo getMarkedTd($row['d']);
      echo getRateTd($row['d30']);
      echo getMarkedTd($row['i']);
      echo getRateTd($row['i30']); 
      echo getMarkedTd($row['t']);
      echo getRateTd($row['t30']);
      echo "</tr>";
  }
  echo "</tbody></table>";
  echo "*********************************************************************<br>";
  
  /*********************************************************************************/
  /*『SQL』30日法人買賣狀況                                                                      
  /*********************************************************************************/
  $sql = "select p.price, p.moving, l.date, l.foreigner, l.dealer, l.investment, l.total, ".
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
  //echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>".
  echo "<table data-vertable='ver1'>".
       "<thead>".
         "<tr class='row100 head'>".
           "<th>日期</th>".
           "<th>收盤</th>".
           "<th>漲跌</th>".
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

  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result); 
      echo  "<tr class='row100'>";
      echo    "<td>".$row['date']."</td>";
      echo    "<td>".$row['price']."</td>"; // 外資     
      echo    getRateTd($row['moving']);
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
