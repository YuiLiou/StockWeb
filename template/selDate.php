<?php
  require_once('db.php');
  ///////////////////////////////////// 日期選單 /////////////////////////////////////
  $sql = "select distinct date ".
         "from prices ".
         "order by date desc ";
  $result = $conn->query($sql);
  echo "<form action='index.php' method='POST' class='form-inline pull-right'>";  
  echo "  <select id='slcDate' name=date onchange='this.form.submit()'>";  
  foreach ($result as $row)
  {
      if (empty($_POST['date']))
      {
          $_POST['date'] = $row['date']; // 預設為當天
      }      
      if ($_POST['date'] == $row['date']) // 顯示被選擇的日期
          echo "<option selected='selected' value='".$row['date']."'>".$row['date']."</option>";
      else
          echo "<option value='".$row['date']."'>".$row['date']."</option>";
  }
  echo "  </select>";

  ////////////////////////////////////////////////////////////////////////////////////////
  // 日期下拉式選單的部份未完,不同的分頁寫的不一樣 <input type='hidden' name='type' value='price'>
  // 寫在各自的overviewBy template
  ////////////////////////////////////////////////////////////////////////////////////////
?>
