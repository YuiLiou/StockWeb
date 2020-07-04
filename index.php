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
    <div class="btn-group">
      <button id="movingBtn">近期動態</button>
      <button id="newsBtn">焦點新聞</button>
      <button id="yearYoYBtn">月營收</button>
      <button id="continuousBtn">連續紀錄</button>
      <button id="seasonBtn">每季總匯</button>
      <button id="cashFlowBtn">現金流量</button>
      <button onclick="window.location.href='viewCode.php'">管理持股</button>
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
    document.getElementById('slct').style.visibility = 'visible';
});

/////////////////////// 依照累計營收排序 ///////////////////////
$('#yearYoYBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByMonthly.php'; ?>;
    document.getElementById('slct').style.visibility = 'hidden';
});

/////////////////////// 每季總匯 ///////////////////////
$('#seasonBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewBySeason.php'; ?>;
    document.getElementById('slct').style.visibility = 'visible';
});

/////////////////////// 連續紀錄 ///////////////////////
$('#continuousBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByContinuous.php'; ?>;
    document.getElementById('slct').style.visibility = 'visible';
});

/////////////////////// 焦點新聞 ///////////////////////
$('#newsBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/newsList.php'; ?>;
    document.getElementById('slct').style.visibility = 'hidden';
});

/////////////////////// 現金流量 ///////////////////////
$('#cashFlowBtn').click(function() {
    document.getElementById('companyList').innerHTML = <?php include 'template/overviewByCashFlow.php'; ?>;
    document.getElementById('slct').style.visibility = 'hidden';
});
/////////////////////// 排序表格 ///////////////////////
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  dir = "asc";
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      //x = rows[i].getElementsByTagName("TD")[n].innerHTML.replace("↑","").replace("↓","").match(/([0-9]*\.?[0-9]*)/)[0]; \d+
      x = rows[i].getElementsByTagName("TD")[n].innerHTML.replace("↑","").replace("↓","").match(/\d+/);   
      y = rows[i+1].getElementsByTagName("TD")[n].innerHTML.toLowerCase();
      alert(x);
      if (dir == "asc") {
        if (x > y) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x < y) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
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
            else if ($_POST['type'] == 'continuous')
                echo "$('#continuousBtn').click();";
            else if ($_POST['type'] == 'cashFlow')
                echo "$('#cashFlowBtn').click();";
        }
        else
            echo "$('#movingBtn').click();";        
    ?>
};
</script>
</body>
</html>
