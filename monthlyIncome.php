<?php
  /**********************************************************************************/
  /* Date     Author   ChangeList
  /* --------------------------------------------------------------------------------  
  /* 20200223 rusiang  獨立月營收
  /**********************************************************************************/ 
?>
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
    <div id="viewTable"></div>    
  </div>  

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script src="js/style.js"></script>
<script>
window.onload = function() 
{
  document.getElementById('viewTable').innerHTML = <?php include 'individual/monthlyTable.php'; ?>;
  <?php include 'individual/monthGrowthChart.php'; ?>
  <?php include 'individual/yearlyIncomeChart.php'; ?>
  <?php include 'individual/seasonIncomeChart.php'; ?>
};
</script>
</body>
</html>
