<?php
  if (empty($_GET))
      $_GET['company'] = '2330';
  /************************顯示公司名稱*************************/
  $sql = "select company ".
         "from company_map ".
         "where code = '".$_GET['company']."' ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); 
  echo "<h3>".$row['company']."</h3>";
  /***********************************************************/
?>
