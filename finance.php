<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel=stylesheet type="text/css" href="css/stylesheet.css"> 
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
<!--//////////////////////// 標題 ////////////////////////-->
  <div id="showcase">
    <div class="container">
      <a href="index.php"><h1>神秘的投資小站</h1></a>
    </div>
  </div>

<!--/////////////////////// 側標題 ///////////////////////-->
  <?php include 'template/sidebar.php'; ?>  

<!--/////////////////////// 主頁面 ///////////////////////-->
  <div id="main">
    <div class="btn-group">
      <button id="priceBtn">股價</button>
      <button id="incomeBtn">損益表</button>
      <button id="monthlyBtn">月營收</button>
    </div>
    <div id="viewChart"></div>
    <div id="viewTable"></div>    
  </div>  

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script src="js/style.js"></script>
<script>
/////////////////////// 股價走勢 ///////////////////////
$('#priceBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "<canvas id='myChart'></canvas>";   
    document.getElementById('viewTable').innerHTML = "";
    <?php include 'template/priceChart.php'; ?>
});

/////////////////////// 損益表 ///////////////////////
$('#incomeBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "<canvas id='myChart'></canvas>";   
    document.getElementById('viewTable').innerHTML = "";
    <?php include 'template/incomeChart.php'; ?>
});

/////////////////////// 月營收 ///////////////////////
$('#monthlyBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'template/monthlyTable.php'; ?>;
});
window.onload = function() {
    $('#priceBtn').click();
};
</script>
</body>
</html>
