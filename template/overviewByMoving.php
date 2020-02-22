<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200222 rusiang  比較週線/月線漲幅 
  /**********************************************************************************/
  require_once('commonFunc.php');
  require_once('db.php');
  echo "\"";
  /*********************************************************************************/
  /* 日期下拉式選單跳轉
  /*********************************************************************************/
  echo "  <input type='hidden' name='type' value='price'>";
  echo "</form>";
  /*********************************************************************************/
  
  ///////////////////////////////////// 公司列表 /////////////////////////////////////
  echo "<div class='table100 ver1 m-b-110' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>公司</th>";
  echo "        <th>收盤</th>";
  echo "        <th>漲跌</th>";
  echo "        <th>本益比</th>";
  echo "        <th>殖利率</th>";
  echo "        <th>週線</th>";
  echo "        <th>月線</th>";
  echo "        <th>法人</th>"; 
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";  

  $pYear = (string)((int)substr($_POST['date'],0,4)-1);
  $tRocYear = (string)((int)substr($_POST['date'],0,4)-1911);

  $sql = "select p.code, ".
         "       p.price, ".
         "       p.date, ".
         "       p.change, ".
         "       p.moving, ".
         "       p.PE, ".
         "       ( ".
         "         select company ".
         "         from company_map ".
         "         where 1=1 ".
         "         and code = p.code ".
         "       )company, ".
         "       ( ".
         "         select value ".
         "         from ma ".
         "         where 1=1 ".
         "         and span = 5 ".
         "         and code = p.code ".
         "         and date = p.date ".
         "       )ma5, ".
         "       ( ".
         "         select value ".
         "         from ma ".
         "         where 1=1 ".
         "         and span = 20 ".
         "         and code = p.code ".
         "         and date = p.date ".
         "       )ma20, ".
         "       ( ".
         "         select round((cash/p.price)*100,2) ".
         "         from dividend ".
         "         where 1=1 ".
         "         and code = p.code ".
         "         order by year desc ".
         "         limit 0,1 ".
         "       )dividend, ". 
         "       ( ".
         "         select foreigner ".
         "         from legals ".
         "         where 1=1 ".
         "         and code = p.code ".
         "         and date = p.date ".
         "       )foreigner ". 
         "from prices p ".
         "where 1=1 ".
         "and p.code in ('".$codes."') ".
         "and p.date = '".$_POST['date']."' ".        
         "order by p.moving desc ";

  $result = $conn->query($sql);    
  foreach ($result as $row)
  {   
    echo  "<tr class='row100'>";
    // 公司
    echo  "  <td><a href=finance.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td> ";
    // 收盤價
    echo  "  <td>".$row['price']."<a href='https://doc.twse.com.tw/server-java/t57sb01?step=1&colorchg=1&co_id=".$row['code']."&year=".$tRocYear."&seamon=&mtype=A&'>（財報）</a></td> ";
    // 漲跌
    echo  getPriceMovingTd($row['change'], $row['moving']);
    // 本益比
    echo  "  <td>".$row['PE']."<a href='https://doc.twse.com.tw/server-java/t57sb01?step=1&colorchg=1&co_id=".$row['code']."&year=".$tRocYear."&mtype=F&'>（股東會）</a></td>";
    // 殖利率
    echo  "  <td><a href='https://tw.stock.yahoo.com/d/s/dividend_".$row['code'].".html'>".$row['dividend']."%</a></td>";
    // 週線
    if ($row['price'] >= $row['ma5'])
        echo "<td><a href='https://norway.twsthr.info/StockHolders.aspx?stock=".$row['code']."'>（集保）</a><font color='red'>↑".round($row['price']-$row['ma5'],2)."元</td>";
    else
        echo "<td><a href='https://norway.twsthr.info/StockHolders.aspx?stock=".$row['code']."'>（集保）</a><font color='green'>↓".round($row['ma5']-$row['price'],2)."元</td>";
    // 月線
    if ($row['price'] >= $row['ma20'])
        echo "<td><font color='red'>↑".round($row['price']-$row['ma20'],2)."元</td>";
    else
        echo "<td><font color='green'>↓".round($row['ma20']-$row['price'],2)."元</td>";
    // 法人
    echo  getLegalsTd($row['foreigner']);
    echo  "</tr>";  
  }
  echo "</tbody></table></div>";
  echo "\""; 
  $result->close();
?>
