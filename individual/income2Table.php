<?php
  if (empty($_GET))
      $_GET['company'] = '2330';

  echo "\"";
  echo "<div class='table100 ver1' id='monthlyTbl'>";
  echo "  <table data-vertable='ver1'>";
  echo "    <thead>";
  echo "      <tr class='row100 head'>";
  echo "        <th>欄位</th>";
  echo "        <th>數值</th>";
  echo "      </tr>";
  echo "    </thead>";
  echo "    <tbody>";

  $sql = "select i.col_name, i.value ".
         "from income_2 i ".
         "where i.code = '".$_GET['company']."' ";

  $result = $conn->query($sql);
  $total_records = mysqli_num_rows($result);  // 取得記錄數
  for ($i=0;$i<$total_records;$i++)
  {
      $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引
      echo "<tr class='row100'>";
      echo "  <td>".$row['col_name']."</td>";
      echo "  <td>".$row['value']."</td>";
      echo "</tr>";
  }
  echo "    </tbody>";
  echo "  </table>";
  echo "</div>\"";
?>
