<?php
  require('db.php');
  $query = "DELETE FROM own WHERE user = '".$_GET['user']."' and code = '".$_GET['code']."' "; 
  try{
    mysqli_query($conn, $query);
    header("Location: viewCode.php");
  }catch(PDOException $e){
    echo $query."<br>".$e->getMessage();
  }    
?>
