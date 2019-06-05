<?php
  require('db.php');
  $status = "";
  if(isset($_POST['user']) && isset($_POST['code'])){
      $sql="insert into own (`user`,`code`)values ('".$_POST['user']."','".$_POST['code']."')";
      mysqli_query($conn,$sql)
      or die(mysql_error());
      $status = "New Record Inserted Successfully"; 
  }
?>
