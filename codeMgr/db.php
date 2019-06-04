<?php
  ///////////////////////////////////// DB初始化 /////////////////////////////////////
  // error message
  ini_set('display_errors','1');
  error_reporting(E_ALL);

  define('DB_HOST','localhost');
  define('DB_USER','root');
  define('DB_PASS','842369');
  define('STOCK_DB','stock');

  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,STOCK_DB);

  /* change character set to utf8 */
  if (!$conn->set_charset("utf8")) 
  {
      printf("Error loading character set utf8: %s\n", $conn->error);
      exit();
  }

  ///////////////////////////////////// 公司列表 /////////////////////////////////////
  $sql = "select code ".
         "from own o ".
         "where user = 'rusiang' ";
  $result = $conn->query($sql);
  $aryCodes = array();
  $aryCompanies = array();
  foreach ($result as $row)
  {
      array_push($aryCodes,$row['code']);
  }
  $codes = join("','",$aryCodes); 
?>
