<?php
  require_once('db.php');
  ///////////////////////////////////// 月份選單 /////////////////////////////////////
  $sql = "select distinct month ".
         "from monthly ".
         "order by month desc ";
  $result = $conn->query($sql);

  echo "\"<select id='slcMonth' onchange='location=this.value;'>";  
  foreach ($result as $row)
  {
      if (empty($_GET['month']))
          $_GET['month'] = $row['month']; // 預設為當月
      if ($_GET['month'] == $row['month']) // 顯示被選擇的月份
          echo "<option selected='selected' value='index.php?month=".$row['month']."'>".$row['month']."</option>";
      else
          echo "<option value='index.php?month=".$row['month']."'>".$row['month']."</option>";
  }
  echo "</select><br>";

  ///////////////////////////////////// 公司列表 /////////////////////////////////////
  $sql = "select map.code, map.company, p.price, p.moving, p.change, m.Yearly_YoY ".
         "from company_map map, prices p, monthly m, ".
         "(select code from own where user = 'rusiang') o ,".
         "(select date from prices order by date desc limit 0,1) today ".
         "where 1=1 ".
         "and map.code = o.code ".
         "and p.code = o.code ".
         "and p.date = today.date ".
         "and m.code = o.code ".
         "and m.month = '".$_GET['month']."' ".
         "order by Yearly_YoY desc ";

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
      /////////////////////////////// 第三行：累計營收 ///////////////////////////////
      echo "<br><p>累計營收:";
      if ($row['Yearly_YoY'] > 0)
          echo "<up>".$row['Yearly_YoY']."%</up></p>";
      else if ($row['Yearly_YoY'] < 0)
          echo "<down>".$row['Yearly_YoY']."%</down></p>";
      else
          echo "<same>".$row['Yearly_YoY']."%</same></p>";
      echo "</blockquote>";
      echo "</a>";
  }
  echo "\""; 
  $result->close();
?>
