<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel=stylesheet type="text/css" href="css/stylesheet.css"> 
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
<!--//////////////////////// 標題 ////////////////////////-->
  <?php include 'template/header.php'; ?>
  
<!--/////////////////////// 側標題 ///////////////////////-->
  <?php include 'template/sidebar.php'; ?>

<!--/////////////////////// 主頁面 ///////////////////////-->
  <div id="main">
    <div class="btn-group">
      <button id="movingBtn">漲幅</button>
      <button id="legalsBtn">三大法人</button>
      <button id="newsBtn">焦點新聞</button>
      <button id="PEBtn">本益比</button>
      <button id="yearYoYBtn">累計營收</button>
      <button id="seasonBtn">每季總匯</button>
    </div>
    <?php include 'template/selDate.php'; ?>
    <div id="companyList"></div>
  </div>  

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script>
/////////////////////// 依照漲幅排序 ///////////////////////
$('#movingBtn').click(function() { 
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByMoving.php'; ?>;       
    document.getElementById('slcDate').style.visibility = 'visible';
});

/////////////////////// 依照本益比排序 ///////////////////////
$('#PEBtn').click(function() { 
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByPE.php'; ?>;    
    document.getElementById('slcDate').style.visibility = 'visible';
});

/////////////////////// 依照累計營收排序 ///////////////////////
$('#yearYoYBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByYearYoY.php'; ?>;
    document.getElementById('slcDate').style.visibility = 'visible';
});

/////////////////////// 依照三大法人排序 ///////////////////////
$('#legalsBtn').click(function() { 
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByLegals.php'; ?>;
    document.getElementById('slcDate').style.visibility = 'visible';
});

/////////////////////// 每季總匯 ///////////////////////
$('#seasonBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewBySeason.php'; ?>;
    document.getElementById('slcDate').style.visibility = 'visible';
});

/////////////////////// 焦點新聞 ///////////////////////
$('#newsBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/newsList.php'; ?>;
    document.getElementById('slcDate').style.visibility = 'hidden';
});

/////////////////////// load:依照漲幅排序 ///////////////////////
window.onload = function() {
    <?php 
        if (isset($_POST['type']))
        {
            if ($_POST['type'] == 'yoy')
                echo "$('#yearYoYBtn').click();";
            else if ($_POST['type'] == 'legals')
                echo "$('#legalsBtn').click();";
            else if ($_POST['type'] == 'pe')
                echo "$('#PEBtn').click();";
            else if ($_POST['type'] == 'season')
                echo "$('#seasonBtn').click();";
            else if ($_POST['type'] == 'price')
                echo "$('#movingBtn').click();";
            else if ($_POST['type'] == 'news')
                echo "$('#newsBtn').click();";
        }
        else
            echo "$('#movingBtn').click();";        
    ?>
};
</script>
</body>
</html>
