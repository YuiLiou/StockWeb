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
      <button id="movingBtn">漲幅</button>
      <button id="PEBtn">本益比</button>
      <button id="yearYoYBtn">累計營收</button>
      <button id="legalsBtn">三大法人</button>
    </div>
    <div id="companyList"></div>
  </div>  

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script>
/////////////////////// 依照漲幅排序 ///////////////////////
$('#movingBtn').click(function() { 
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByMoving.php'; ?>;   
    
});

/////////////////////// 依照本益比排序 ///////////////////////
$('#PEBtn').click(function() { 
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByPE.php'; ?>;    
});

/////////////////////// 依照累計營收排序 ///////////////////////
$('#yearYoYBtn').click(function() { 
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByYearYoY.php'; ?>;
});

/////////////////////// 依照三大法人排序 ///////////////////////
$('#legalsBtn').click(function() { 
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByLegals.php'; ?>;
});

/////////////////////// load:依照漲幅排序 ///////////////////////
window.onload = function() {
    $('#movingBtn').click();
};
</script>
</body>
</html>
