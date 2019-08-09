<?php
  if (empty($_GET))
      $_GET['company'] = '2330';
  /************************顯示公司名稱*************************/
  $sql = "select company, code, grp ".
         "from company_map ".
         "where code = '".$_GET['company']."' ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); 
  echo "<h3>".$row['company']."(".$row['code'].")"." - ".$row['grp']."</h3>";
  /***********************************************************/
?>
