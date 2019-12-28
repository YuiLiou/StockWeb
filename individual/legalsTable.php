<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20191130 rusiang  新增法人買賣佔大盤比率 
  /* 20191221 rusiang  計算1/5/20/60日大盤 
  /* 20191228 rusiang  成交量佔股本比率
  /**********************************************************************************/  
  require_once('commonFunc.php');
  if (empty($_GET)) {$_GET['company'] = '2330';}
  echo "\"";
  echo "【平均買賣超】<br>";
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
           "<th>法人佔成交量比率</th>".
           "<th>成交量佔股本比率</th>".
         "</tr>".
       "</thead>";
  echo "<tbody>";
  $days = array(1,5,20,60);
  foreach ($days as $d) 
  {
    $sql = "select round(p30.p,2) p30, ".                             // 平均收盤價
           "       round((p001.price-p30.p)/p30.p*100,2) moving30, ". // 漲幅
           "       round(l30.f/p30.v*100,2) f30, l30.f, ".            // 外資
           "       round(l30.d/p30.v*100,2) d30, l30.d, ".            // 自營商
           "       round(l30.i/p30.v*100,2) i30, l30.i, ".            // 投信
           "       round(l30.t/p30.v*100,2) t30, l30.t, ".            // 總計
           "       round(p30.v/share.num*100,2) s30     ".            // 成交量佔股本比
           "from ".
           "( ". /***近日法人總買賣量***/
           "  select sum(l30.foreigner) f, sum(l30.dealer) d, sum(l30.investment) i, sum(l30.total) t ".
           "  from ".
           "  ( ".
           "    select foreigner, dealer, investment, total ".
           "    from legals ".        
           "    where 1=1 ".
           "    and code = '".$_GET['company']."' ".
           "    order by date desc ".
           "    limit 0,".$d." ".
           "  ) l30 ".
           ") l30, ".
           "( ". /***近日平均價格/總買賣量***/
           "  select avg(p30.price) p, sum(p30.volume) v ".
           "  from ".
           "  ( ".
           "    select price, volume ".
           "    from prices ".
           "    where 1=1 ".
           "    and code = '".$_GET['company']."' ".
           "    order by date desc ".
           "    limit 0,".$d." ".
           "  ) p30 ".
           ")p30, ".
           "( ". /***前日收盤價***/
           "  select price ".
           "  from prices ".
           "  where 1=1 ".
           "  and code = '".$_GET['company']."' ".
           "  order by date desc ". 
           "  limit 0,1 ".
           ") p001, ".
           "( ". /***發行股數***/
           "  select value/10 num ".
           "  from property p ".
           "  where p.code = '".$_GET['company']."' ".
           "  and p.col_name = '股本' ".
           "  order by year desc, season desc ".
           "  limit 0,1 ".
           ") share ";

    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    echo "<tr class='row100'>";
    echo " <td>".$d."</td>";
    echo " <td>".$row['p30']."</td>";
    echo getRateTd($row['moving30']);
    echo getMarkedTd($row['f']);
    echo getRateTd($row['f30']);
    echo getMarkedTd($row['d']);
    echo getRateTd($row['d30']);
    echo getMarkedTd($row['i']);
    echo getRateTd($row['i30']); 
    echo getMarkedTd($row['t']);
    echo getRateTd($row['t30']);
    echo getRateTd($row['s30']);
    echo "</tr>";  
  }
  echo "</tbody></table>";
  echo "【每日買賣超】<br>";
  
  /*********************************************************************************/
  /*『SQL』30日法人買賣狀況                                                                      
  /*********************************************************************************/
  $sql = "select p.price, p.moving, l.date, l.foreigner, l.dealer, l.investment, l.total, ".
         "round(l.foreigner/p.volume*100,2) fr, round(l.dealer/p.volume*100,2) dr, ".
         "round(l.investment/p.volume*100,2) ir, round(l.total/p.volume*100,2) tr, ".
         "round(p.volume/share.num*100,2) s ".
         "from legals l, prices p, ".
         "( ". /***發行股數***/
         "  select code, value/10 num ".
         "  from property p ".
         "  where p.code = '".$_GET['company']."' ".
         "  and p.col_name = '股本' ".
         "  order by year desc, season desc ".
         "  limit 0,1 ".
         ") share ".   
         "where 1=1 ".
         "and l.code = '".$_GET['company']."' ".
         "and l.code = p.code ".
         "and l.code = share.code ".
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
           "<th>法人佔成交量比率</th>".
           "<th>成交量佔股本比率</th>".
         "</tr>".
       "</thead><tbody>";

  for ($i=0;$i<$total_records;$i++)
  { 
      $row = mysqli_fetch_assoc($result); 
      echo  "<tr class='row100'>";
      echo    "<td>".$row['date']."</td>";
      echo    "<td>".$row['price']."</td>";   // 股價     
      echo    getRateTd($row['moving']);      // 漲幅
      echo    getMarkedTd($row['foreigner']); // 外資     
      echo    getRateTd($row['fr']);          // 外資比率
      echo    getMarkedTd($row['dealer']);    // 自營商   
      echo    getRateTd($row['dr']);          // 自營商比率   
      echo    getMarkedTd($row['investment']);// 投信
      echo    getRateTd($row['ir']);          // 投信比率    
      echo    getMarkedTd($row['total']);     // 總計   
      echo    getRateTd($row['tr']);          // 法人佔成交量比率  
      echo    getRateTd($row['s']);           // 成交量佔股本比率    
      echo "</tr>";
  }
  echo "</tbody></table></div>\"";
  $result->close();
?>
