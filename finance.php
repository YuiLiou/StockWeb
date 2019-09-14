<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel=stylesheet type="text/css" href="css/stylesheet.css"> 
<link rel=stylesheet type="text/css" href="css/styleTable.css"> 
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
<!--//////////////////////// 標題 ////////////////////////-->
  <?php include 'template/header.php'; ?>

<!--/////////////////////// 側標題 ///////////////////////-->
  <?php include 'template/sidebar.php'; ?>  

<!--/////////////////////// 主頁面 ///////////////////////-->
  <div id="main">
    <?php include 'individual/subTitle.php'; ?>  
    <div class="btn-group">
      <button id="priceBtn">股價</button>
      <button id="peBtn">本益比河流</button>
      <button id="legalsBtn">三大法人</button>
      <button id="newsBtn">新聞</button>
      <button id="monthlyBtn">月營收</button>
      <button id="incomeBtn">營益分析表</button>
      <button id="income2Btn">綜合損益表</button>
      <button id="propertyBtn">資產負債表</button>
      <button id="epsBtn">每股盈餘</button>
      <button id="dividendBtn">股利政策</button>
    </div>    
    <div id="viewTable"></div>    
    <div id="viewChart"></div> 
  </div>  

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script src="js/style.js"></script>
<script>
/////////////////////// 股價走勢 ///////////////////////
$('#priceBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "<canvas id='myChart'></canvas>";   
    document.getElementById('viewTable').innerHTML = "";
    <?php include 'individual/priceChart.php'; ?>
});
/////////////////////// 本益比河流 ///////////////////////
$('#peBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "<canvas id='myChart'></canvas>";   
    document.getElementById('viewTable').innerHTML = "";
    <?php include 'individual/peChart.php'; ?>
});
/////////////////////// 三大法人 ///////////////////////
$('#legalsBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'individual/legalsTable.php'; ?>;
});
/////////////////////// 個股新聞 ///////////////////////
$('#newsBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'individual/newsList.php'; ?>;
});
/////////////////////// 月營收 ///////////////////////
$('#monthlyBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'individual/monthlyTable.php'; ?>;
});
/////////////////////// 營益分析表 ///////////////////////
$('#incomeBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "<canvas id='myChart'></canvas>";   
    document.getElementById('viewTable').innerHTML = <?php include 'individual/incomeTable.php'?>;
    <?php include 'individual/incomeChart.php'; ?>
});
/////////////////////// 綜合損益表 ///////////////////////
$('#income2Btn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'individual/income2Table.php'; ?>;
});
/////////////////////// 資產負債表 ///////////////////////
$('#propertyBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'individual/propertyTable.php'; ?>;
});
/////////////////////// 每股盈餘 ///////////////////////
$('#epsBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'individual/epsTable.php'; ?>;
});
/////////////////////// 股利政策 ///////////////////////
$('#dividendBtn').click(function() {
    document.getElementById('viewChart').innerHTML = "";
    document.getElementById('viewTable').innerHTML = <?php include 'individual/dividendTable.php'; ?>;
});
window.onload = function() {
  <?php
    if (isset($_POST['type']))
    {
        if ($_POST['type'] == 'income2')
            echo "$('#income2Btn').click();";
    }
    else
        echo "$('#priceBtn').click()";
  ?>
};
</script>
</body>
</html>
