<?php
  require_once('commonFunc.php');
  require_once('db.php');
  echo "\"";
  /*********************************************************************************/
  /* 日期下拉式選單跳轉的部份
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

  $sql = "select m.code, m.company, p.price, p.date, p.change, p.moving, p.PE, ".
         "round(ma5.value,2) ma5, round(ma20.value,2) ma20,".
         "round((d.cash/p.price)*100,2) dividend, ".
         "f.foreigner ".
         "from prices p, company_map m, dividend d, ".
         "(select code, date, value from ma where span=5) ma5, ".
         "(select code, date, value from ma where span=20) ma20, ".
         "(select code, date, foreigner from legals) f ".
         "where 1=1 ".
         "and m.code in ('".$codes."') ".
         "and m.code = p.code ".
         "and m.code = ma5.code ".
         "and m.code = ma20.code ".
         "and m.code = d.code ".
         "and m.code = f.code ".
         "and p.date = '".$_POST['date']."' ".
         "and p.date = ma5.date ".
         "and p.date = ma20.date ".
         "and p.date = f.date ".
         "and d.year = '".$pYear."' ".
         "order by p.moving desc ";

  $result = $conn->query($sql);    
  foreach ($result as $row)
  {   
    echo  "<tr class='row100'>";
    echo  "  <td><a href=finance.php?company=".$row['code'].">".$row['company']."(".$row['code'].")</a></td> ";
    echo  "  <td>".$row['price']."</td> ";
    echo  getPriceMovingTd($row['change'], $row['moving']);
    echo  "  <td>".$row['PE']."</td>";
    echo  "  <td>".$row['dividend']."%</td>";
    echo  "  <td>".$row['ma5']."</td>";
    echo  "  <td>".$row['ma20']."</td>";
    echo  getLegalsTd($row['foreigner']);
    echo  "</tr>";  
  }
  echo "</tbody></table></div>";
  echo "\""; 
  $result->close();
?>
