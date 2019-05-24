<?php
  require_once('db.php');
  echo "\"";
  /*********************************************************************************/
  /* 日期下拉式選單跳轉的部份
  /*********************************************************************************/
  echo "  <input type='hidden' name='type' value='price'>";
  echo "</form>";
  /*********************************************************************************/
  ///////////////////////////////////// 公司列表 ///////////////////////////////////// 
  $sql = "select m.code, m.company, p.price, p.date, p.change, p.moving, p.PE ".
         "from prices p, company_map m ".
         "where 1=1 ".
         "and m.code in ('".$codes."') ".
         "and p.code = m.code ".
         "and p.date = '".$_POST['date']."' ".
         "order by p.moving desc ";

  $result = $conn->query($sql);
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
