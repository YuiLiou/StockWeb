<?php

// error message
ini_set('display_errors','1');
error_reporting(E_ALL);

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','842369');
define('STOCK_DB','stock');

try{
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,STOCK_DB);
}catch (\mysqli_sql_exception $e) {
    throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
}

/* change character set to utf8 */
if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
}

?>
