<?php
  require_once('db.php');
  $sql = "select m.code, m.company, p.price, p.date, p.change, p.moving, p.PE, l.total ".
         "from company_map m, prices p, legals l, ".
         "(select code from own where user = 'rusiang') o ".         
         "where 1=1 ".
         "and m.code = o.code ".
         "and p.code = o.code ".
         "and l.code = o.code ".
         "and l.date = '".$_POST['date']."' ".
         "and p.date = '".$_POST['date']."' ".
         "order by total desc ";
  $result = $conn->query($sql);

  echo "\""; 
  /*********************************************************************************/
  /* 日期下拉式選單跳轉的部份
  /*********************************************************************************/
  echo "  <input type='hidden' name='type' value='legals'>";
  echo "</form>";
  /*********************************************************************************/
  foreach ($result as $row)
  {   
      echo "<a href=finance.php?company=".$row['code'].">";
      echo "<blockquote>";
      /////////////////////////////// 第一行：公司名稱 ///////////////////////////////
      echo "<p>".$row['company']." (".$row['code'].")</p><br>";
      /////////////////////////////// 第二行：今日收盤價 ///////////////////////////////
      echo "<p>".$row['price']."</p>&nbsp;&nbsp;&nbsp;";
      if ($row['change'] > 0)
          echo "<up>+".$row['change']."(".$row['moving']."%)</up>";
      else if ($row['change'] < 0)
          echo "<down>".$row['change']."(".$row['moving']."%)</down>";
      else
          echo "<same>".$row['change']."(".$row['moving']."%)</same>";
      /////////////////////////////// 第三行：三大法人 ///////////////////////////////
      echo "<br><p>法人買賣超:";
      if ($row['total'] > 0)
          echo "<up>".$row['total']."</up></p>";
      else if ($row['total'] < 0)
          echo "<down>".$row['total']."</down></p>";
      else
          echo "<same>".$row['total']."</same></p>";
      echo "</blockquote>";
      echo "</a>";
  }
  echo "\""; 
  $result->close();
?>
