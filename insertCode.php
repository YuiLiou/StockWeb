<?php include 'codeMgr/insertCode.php'; ?>      
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel=stylesheet type="text/css" href="css/stylesheet.css"> 
    <title>Insert New Record</title>
  </head>
  <body>
    <?php include 'template/header.php'; ?>    
    <div class="form">
      <div>
        <h2>Insert New Record</h2> 
        <div class="btn-group">
          <button onclick="window.location.href='viewCode.php'">View Records</button>
          <button onclick="window.location.href='index.php'">Dashboard</button>
        </div>  
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
