<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="/stock/css/cssMop.css" rel="stylesheet" type="text/css" Media="Screen"/>
<link href="/stock/css/print_css1.css" rel="stylesheet" type="text/css" Media="Print"/>
<link href="/stock/css/clickmenu.css"rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/stock/js/jquery-1.1.4.pack.js"></script>
<script type="text/javascript" src="/stock/js/jquery.clickmenu.js"></script>
<script type="text/javascript" src="/stock/js/mop.js"></script>
</head>

<body>
<form id="form1" name="form1" action="https://mops.twse.com.tw/mops/web/ajax_t164sb03" onsubmit="return false;" method="post">
	<input type="hidden" name="step" value="1">
	<input type="hidden" name="firstin" value="ture">
	<input type="hidden" name="off" value="1">
	<input type="hidden" name="keyword4">
	<input type="hidden" name="code1">
	<input type="hidden" name="TYPEK2">
	<input type="hidden" name="checkbtn">
	<input type="hidden" name="queryName" value="co_id">
	<input type="hidden" name="inpuType" value="co_id">
	<input type="hidden" name="isnew" value="true">
	<input type="hidden" name="co_id" value="4104">	
	<input type="hidden" name="year" value="108">	
	<input type="hidden" name="season" value="2">					
	<input type="button" value=" 查詢 " onclick="javascript:doAction();ajax1(document.form1,'table01');"/>
</form>     

<div id="zoom"><div id="table01"></div></div>

<script>
function doAction() {
	if (document.form1.step!=null && document.form1.step!=undefined && document.form1.step.value!='')
	{
		if (document.form1.step.value!='0')
		{
			document.form1.step.value='1';
		}
	}
	if (document.form1.firstin!=null && document.form1.firstin!=undefined && document.form1.firstin.value!='')
	{
		document.form1.firstin.value='1';
	}
	document.form1.action='https://mops.twse.com.tw/mops/web/ajax_t164sb03';
}
function checkAutoRunScript(){
	if (document.autoForm!=null && document.autoForm!=undefined && document.autoForm.run.value==''){
		document.autoForm.run.value='Y';
		ajax1(document.autoForm,'table01');
	}

	if (document.autoRunScript!=null && document.autoRunScript!=undefined && document.autoRunScript.run.value!=''){
		var s = document.autoRunScript.run.value;
		document.autoRunScript.run.value = '';
		new function(){
			eval(s);
		};
	}

}

setInterval("checkAutoRunScript()",100);

</script>
</html>
