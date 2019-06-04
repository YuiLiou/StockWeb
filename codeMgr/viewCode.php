<?php
  require('db.php');
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
    <title>View Records</title>
  </head>
  <body>
    <div class="container">
      <p><a href="../index.php">Dashboard</a> 
      | <a href="insertCode.php">Insert New Record</a> 
    <h2>View Records</h2>
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
      <?php
        $count=1;
        $sel_query="Select user, code from own ORDER BY user desc, code asc ;";
        $result = mysqli_query($conn,$sel_query);
        while($row = mysqli_fetch_assoc($result)) { 
          echo "<tr>";
          echo "<td align='center'>".$count."</td>";
          echo "<td align='center'>".$row["user"]."</td>";
          echo "<td align='center'>".$row["code"]."</td>";
          echo "<td align='center'><a href='deleteCode.php?user=".$row['user']."&code=".$row["code"]."'>Delete</a></td>";
          echo "</tr>";
          $count++; 
        } 
      ?>
      </tbody>
    </table>
    </div>
  </body>
</html>
