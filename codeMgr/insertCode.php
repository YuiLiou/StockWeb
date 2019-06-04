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
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Insert New Record</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="form">
      <p><a href="../index.php">Dashboard</a> 
       | <a href="viewCode.php">View Records</a></p>
      <div>
        <h1>Insert New Record</h1>
        <form name="form" method="post" action=""> 
        <div class="form-group">
          <p><input class="form-control" type="text" name="user" placeholder="Enter Category" required /></p>
          <p><input class="form-control" type="text" name="code" placeholder="Enter Company" required /></p>
          <p><input class="btn btn-default" name="submit" type="submit" value="Submit" /></p>
        </div>
        </form>
        <p style="color:#FF0000;"><?php echo $status; ?></p>
      </div>
    </div>
  </body>
</html>
