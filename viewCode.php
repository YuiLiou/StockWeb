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
    <title>View Records</title>
  </head>
  <body>
    <?php include 'template/header.php'; ?>    
    <div class="container"> 
    <h2>View Records</h2> 
    <div class="btn-group">
      <button onclick="window.location.href='insertCode.php'">Insert code</button>
      <button onclick="window.location.href='index.php'">Dashboard</button>
    </div>         
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th>No.</th>
          <th><strong>Category</strong></th>
          <th><strong>Company</strong></th>
          <th><strong>Delete</strong></th>
        </tr>
      </thead>
      <tbody>
      <?php include 'codeMgr/viewCode.php'; ?>      
      </tbody>
    </table>
    </div>
  </body>
</html>
