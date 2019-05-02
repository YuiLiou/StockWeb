<?php
  require_once('db.php');
  $sql = "select m.code, m.company, p.price, p.date, p.change, p.moving, p.PE ".
         "from company_map m, prices p, ".
         "(select date from prices order by date desc limit 0,1) today, ".
         "(select code from own where user = 'rusiang') o ".
         "where 1=1 ".
         "and o.code = m.code ".
         "and p.code = o.code ".
         "and p.date = today.date ".
         "order by p.PE asc ";
  $result = $conn->query($sql);

  echo "\""; 
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
      /////////////////////////////// 第三行：本益比  ///////////////////////////////
      echo "<br><p>本益比:".$row['PE']."</p>";
      echo "</blockquote>";
      echo "</a>";
  }
  echo "\""; 
  $result->close();
?>
