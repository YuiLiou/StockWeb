<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200222 rusiang  
  /**********************************************************************************/ 
  if (empty($_GET)) $_GET['company'] = '2330';
  require_once('finFunc.php');
  /*********************************************************************************/
  /*【公司名稱/行業別】                                              
  /*********************************************************************************/
  $sql = "select company, code, grp ".
         "from company_map ".
         "where code = '".$_GET['company']."' ";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result); 
  /*********************************************************************************/
  /*【副標題】                                              
  /*********************************************************************************/
  echo "<h3>".$row['company']."(".$row['code'].")"." - ".$row['grp']."</h3>";
  echo "  <div class='btn-group'>";
  echo "    <button id='priceBtn' onclick=\"javascript:location.href='price.php?company=".$row['code']."'\">股價</button>";
  echo "    <button id='peBtn' onclick=\"javascript:location.href='peFlow.php?company=".$row['code']."'\">本益比河流</button>";
  echo "    <button id='legalsBtn' onclick=\"javascript:location.href='legals.php?company=".$row['code']."'\">三大法人</button>";
  echo "    <button id='newsBtn' onclick=\"javascript:location.href='shareRatio.php?company=".$row['code']."'\">集保股權異動表</button>";
  echo "    <button id='monthlyBtn' onclick=\"javascript:location.href='monthlyIncome.php?company=".$row['code']."'\">月營收</button>";
  echo "    <button id='incomeBtn' onclick=\"javascript:location.href='income.php?company=".$row['code']."'\">營益分析表</button>";
  echo "    <button id='income2Btn' onclick=\"javascript:location.href='income2.php?company=".$row['code']."'\">綜合損益表</button>";
  echo "    <button id='propertyBtn' onclick=\"javascript:location.href='property.php?company=".$row['code']."'\">資產負債表</button>";
  echo "    <button id='cashFlowBtn' onclick=\"javascript:location.href='cashFlow.php?company=".$row['code']."'\">現金流量表</button>";
  echo "    <button id='epsBtn' onclick=\"javascript:location.href='eps.php?company=".$row['code']."'\">每股盈餘</button>";
  echo "    <button id='dividendBtn' onclick=\"javascript:location.href='dividend.php?company=".$row['code']."'\">股利政策</button>";
  echo "  </div>    ";
?>
