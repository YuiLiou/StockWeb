/*
*	程式設計師:???
*	程式名稱:mops1.js(utf-8)
*	程式功能:T88K 新版mops所需之javascript, T88G2 測試機
*	修改紀錄:(格式=>西元日期+版次+程式設計師)
	2019100760vensan:(T88K)調整投資專區->臺灣存託憑證專區 ,移除t132sb05 新增t132sb05_1 ~ t132sb05_7
	2019092459hsin:(T88K)即時重大訊息t05sr01_1/轉換公司債轉換變動情形一覽表 t98sb05/每月營業收入彙總表 t21sc04_ifrs改階層，調整重大訊息，第一及第二上市櫃查詢路徑整併為同一路徑
	2019090458thomas:(T88K)改字「國內公司普通股每股面額非新台幣10元資訊專區」改為「採彈性面額(每股面額非新台幣10元)公司專區」
	2019082757:thomas:(T88K)拿掉t110sb01
	2019062756thomas:(T88K)改字「公司治理組織架構部分」改為「公司治理組織架構部分(含董事會組成之基本資訊)」
	2019062055thomas:(T88K)修改跑馬燈
    2019060354twse1097:(T88K)判斷處理來源是https的request
    2019051053awat:(T88K)修改股利分派情形相關連結
	2019042952ivy:(T88K)增加 t05sb12
	2019041851thomas:(T88K)增加 t204sb01、t204sb02、t204sb03、t204sb04、t204sb05、t204sb06
	2019041850vensan:(T88K)增加	t204sb07重大訊息 t204sb08公告查詢
	2019032149vensan:(T88K)增加	t100sb14財務報告附註揭露之員工福利(薪資)資訊
								t100sb15非擔任主管職務之全時員工薪資資訊
	2019013048vensan:(T88K)增加	投資專區/ETN資訊 -> 公開說明書(t204sb09)
	2019010247thomas:(T88K)所有項目順序大調整(與前一版完全不同了)
    2018100346ivy:(T88K)調整公司治理項下選單連結
	2018092845vensan:(T88K)增加證券商財務資料動態查詢系統
	2018092744vensan:(T88K)修改文字 財務比較專區 --> 財務比較e點通 及修改連結
						XBRL改版增加項目
						[xbrl資訊平台-單一公司案例文件查詢及下載]	t203sb01
						[xbrl資訊平台-案例文件整批下載]		t203sb02
						[xbrl資訊平台-分類標準下載]			t203sb03
	2018082943vensan:(T88K)增加 o_t78sb34 櫃買指數/加掛外幣股票型期貨信託基金
					 「櫃買國外成分股及債券成分之指數股票型基金」改為「櫃買國外成分股及債券成分/加掛外幣之指數股票型基金」
					 「櫃買槓桿/反向指數股票型基金」改為「櫃買槓桿/反向/加掛外幣指數股票型基金」
	2018062842awat:(T88K)修改 t93sb05 標題文字
	2018052541vensan:(T88K)增加o_t33sb03
	2018052540vensan:(T88K)修改t95sb03標題文字,增加t33sb03,修改 t150sb02標題文字
    2018052539vensan:(T88K)修改t95sb03標題文字,增加t33sb03,修改 t150sb02標題文字
    2018041738Garfield:(T88K)將keyword從cookies自動填入中刪除
	2018020737twse1175: (T88K) 增加 t167sb02 自願揭露退休董事長或總經理回任公司顧問
	2018013136hang: (T88K) 增加 t167sb02 自願揭露退休董事長或總經理回任公司顧問
	2018012535thomas:(T88K)增加跑馬燈function getMsg();
	2017112734thomas:(T88K)增加 t198sb04
	2017090833:ivy:(T88K)電子投票彙總表改成超連結
	2017090836:ivy:(T88G2)電子投票彙總表改成超連結
	2017090635:ivy:(T88G2)電子投票彙總表改成超連結
	2017081432twse1097:(T88K)修正auto_complete問題
	2017080931twse1097:(T88K)修正auto_complete問題
	2017073130ivy:(T88K)修改公司治理項下連結之各項報表
	2017072729money:(T88K)修改ETF專區「上市ETF專區」「上櫃ETF專區」連結
	2017070728thomas:(T88K)增加 t198sb03
	2017061427thomas:(T88K)增加 t113sb01
	2017051526thomas:(T88K)修改原為「年度自結綜合損益(未經會計師查核)達成情形(完整式)」改為「年度自結綜合損益達成情形及差異原因(完整式)」
	2017051225thomas:(T88K)增加 t198sb01
	2017050424thomas:(T88K)修改「上櫃ETF專區」連結
	2017021323oliver:(T88K)t114sb07改字，配發改成分派，紅利改成酬勞
	2017011122thomas:(T88K)增加 t66sb02_q1 , t66sb03_q1 , t66sb04_q1 , t163sb11_q1 , t163sb12_q1
	2016122021oliver:(T88K)修改o_t78sb32  o_t78sb21  o_t78sb20  新增o_t78sb33
	2017010621oliver:(T88K)修正chrome列印BUG
	2016123020oliver:(T88K)選單改字換位置t100sb07,t144sb11,t93sc03_1,t93sc01_1,t56sb29_q1,t144sb09,t150sb04
	2016091319money:(T88K)修改原為「槓桿/反向指數股票型基金」改為「槓桿/反向/加掛外幣指數股票型基金」 原為「指數股票型期貨信託基金」改為「指數/加掛外幣股票型期貨信託基金」
	2016082922thomas:(T88G2)增加 o_t95sb07
	2016082418money:(T88K)修改原為「實收資本額達新臺幣50億元以上應採電子投票之上市上櫃公司，尚未採候選人提名制選舉全體董事、監察人之公司名單」，改為「實收資本額達新臺幣20億元以上應採電子投票之上市上櫃公司，尚未採候選人提名制選舉全體董事、監察人之公司名單」文字
	2016080817thomas:(T88K)修改原為「國外成分證券指數股票型基金」，改為「國外成分/加掛外幣證券指數股票型基金」文字
	2016072516oliver:(T88K)增加 t193sb03,t193sb04,t193sb01
	2016071815thomas:(T88K)修改「ETF發行單位數異動查詢」文字 && 「國外成分證券指數股票型基金」文字
	2016062914thomas:(T88K)修改t111sb02標題文字
	2016053013thomas:(T88K)增加 t193sb02
	2016050412ivy:(T88K)新增105年股東會採行電子投票之上市櫃公司名單
	2016042611awat:(T88K) add t114sb07員工酬勞及董事、監察人酬勞資訊彙總表
	2016041551edward:(T88K2)mops改版
	2016022650thomas:(T88K2)增加t119sb06(稅後損益與董監酬金變動之關聯性與合理性) && 改回問題回報(reportError)導向t146sb09
	2016012649edward:(T88K2)增加t191sb01
	2016011948thomas:(T88K2)修改問題回報(reportError)導向網址
	2015122947edward:(T88K2)增加t189sb01
	2015111646edward:(T88K2)修改t66sb06名稱
	2015111645edward:(T88K2)新增普通公司債承銷公告連結,修改資產證券化交易資訊查詢
	2015100744thomas:(T88K2)增加Google Analytics
	2015100743thomas:(T88K2)程式上線
	2015091142edward:(T88K2)增加o_t78sb36
	2015083141awat:(T88K2)前五項配合需求修改增加104年的資料
	2015081239thomas:(T88K2)修改原為「ETF發行單位數查詢」改為「ETF發行單位數異動查詢」。
	2015072938thomas:(T88K2)增加 t06sf09_1_q1「截至各季綜合損益財測達成情形(完整式)」。
	2015062937thomas:(T88K2)增加 t78sb36
	2015060536thomas:(T88K2)增加t163sb13a,t163sb13b,t163sb13c,t163sb11,t163sb12
	2015051835thomas:(T88K2)修改原為「企業社會責任報告書/永續報告書」改為「企業社會責任報告書」。
	2015042434awat:(T88G2)新增104年股東會採行電子投票之上市櫃公司名單
	2015030633thomas:(T88K2)拿掉「公債交易資訊」,「公司債/金融債/受益證券/外國債券/分割債券交易資訊」,「轉(交)換債交易資訊」，大項「交易資訊」增加link到櫃買中心網頁
	2015030632:edward:(T88K2)增加 t90sb03 , o_t90sb03
	2015030331:awat:(T88K2)增加 o_t33sbAfa03 上櫃認購(售)權證公開銷售說明書查詢
	2015022630edward:(T88K2)新增 t150sb04
	2014122529thomas:(T88K2)修改下拉BUG,拿掉 $$keys 的 "submit_data"
	2014121129thomas:(T88K2)修改原為「獨立董監事兼任情形」改為「獨立董監事兼任情形彙總表」。
	2014120929thomas:(T88K2)修改原為「董事會出席與獨立董事兼任情形(個別)」改為「董事及監察人出(列)席董事會及進修情形與獨立董事兼任情形(個別)」。
	2014112429leo:(T88K2)基金每日淨資產價t78sb01_q2 為 t78sb35
	2014102829thomas:(T88K2)修改原為「召開股東常(臨時)會日期、地點資料彙總表」改為「召開股東常(臨時)會日期、地點及採用電子投票情形等資料彙總表」。
	2014111428peggy:(T88K2)增加t78sb34
	2014092927thomas:(T88K2)修改原為[公司治理自評報告]改為[公司治理自評報告(自2014/10/13起停止上傳)]
	2014093026thomas:(T88K2)調整文字 原為「經營權異動資訊專區」，改為「經營權及營業範圍異(變)動專區」。
	2014093025edward:(T88K2)增加 t123sb14_q1 及 t123sb22
	2014092524edward:(T88K2)增加 t78sb33
	2014090923peggy:(T88K2)新增符合主管機關規定應強制採電子投票之上市櫃公司執行情形彙總表-103年
	2014082022andy:(T88K2)新增員工福利政策及權益維護措施揭露-個別公司查詢,彙總資料查詢
	2014081821andy:(T88K2)新增章程明訂全體董事(含獨立董事)選舉應採候選人提名制之上市櫃公司彙總表-102年、103年,於股東常會採行逐案票決之上市櫃公司彙總表-102年、103年,提供英文議事手冊之上市櫃公司彙總表-102年、103年
	2014080720thomas:(T88K2)新增券商對媒體轉載之澄清或說明
	2014080520thomas:()修改上櫃ETF專區連結
	2014070719thomas:(T88K2)新增投資專區, 財務重點專區, 興櫃公司選項
	2014062618lucas:(T88K2)新增企業社會責任報告書/永續報告書
	2014050717awat:(T88K2)新增103年股東會採行電子投票之上市櫃公司名單
	2014041416kevin:(T88K2)新增t158sb06
	2014032815kevin:(T88K2)新增t163sb19
	2014032114awat:(T88K2)修改 101年度起股東會應採行電子投票....公司名單  功能名稱及檔案
	2014022713kevin:(T88K2)拿掉經營權異動資訊專區子選單
	2014022512kevin:(T88K2)新增t132sb23,t132sb24,t132sb25, 投資專區彙總報表位置調整
	2013123110kevin:(T88K2)新增t51sb09
	2013121299edward:(T88K)增加t116sb01_new
	2013121298kevin:(T88K)新增t174sb01_q1
	2013103197leo:(T88K)加上判斷物件dialog-mask是否存在 
	2013102296kevin:(T88K)參考149,siitest, 拿掉dialogmask, 修改原因是因為點選重大訊息後, 「個股」選項文字仍會變色, 但是149, siitest無此問題
	2013101495awat:(T88K) 修改股東會採電子投票之上市上櫃公司名單選單
	2013100393kevin:(T88K)t158sb04==>t158sb04_new
	2013082092kevin:(T88K)新增t163sb15 t163sb16 t163sb17 t163sb18
	2013081390kevin:(T88K)改標題,取得或處分資產之財務資料表 => 財務資料表, 母子公司交互資訊 => 母子公司交互資訊(自102年6月起免申報)
	2013072289kevin:(T88K)t158sb03改字
	2013071588kevin:(T88K)拿掉外國債券選單, 修改選單文字, 修改投資專區階層
	2013062887kevin:(T88K)新增t162sb02, t162sb01階層位置調整
	2013062885kevin:(T88K)員工認股權憑證申報欄位位置調整
	2013061384awat:(T88K)新增 「薪資報酬委員會運作效益之衡量與評估」調查報告
	2013043083leo:(T88K)新增t56sb29_q3,t163sb14
	2013040982edward:修改外國企業第一上市櫃專區
	2013050281:leo:(T88K)修改t135sb02文字
	2013041280:edward:(T88K)增加t168sb01
	2013041279:leo:(T88K)新增t66sb06
	2013040878:awat:修改股東會採行電子投票之上市櫃公司名單成101年及102年
	2013040377:leo:(T88K)修改文字
	2013033076:leo:(T88K)新增t163sb04,t163sb05,t06sf09_2_q1,t06sf09_3_q1,t163sb06,t163sb07,t164sb03,t164sb04,t164sb05,t164sb06,t163sb03,t164sb02,t163sb08,t163sb09,t05st25_q1,t05st26_q1
	2013031575:awat:(T88K)add t33sbAfa03 認購（售）權證銷售說明書查詢
	2013030674leo:(T88K)新增t167sb01
	2013013173leo:(T88K)新增t21sc04_ifrs 修改t21sc04 t21sb06新增t05st10_ifrs修改t05st10
	2013013072leo:(T88K)將取得或處分資產之財務資料表搬移到母子公司交互資訊上
	2012122971tobey:(T88K)修改 將menu2財務比率分析、menu5財務預測公告、menu7財務比率分析拆為IFRSs前後
	2012122870awat:(T88K)add 101年度起股東會應採行電子投票，且未修正章程採候選人提名制選舉董事、監察人之上市上櫃公司名單
	2012122569leo:(T88K)新增t123sb14
	2012122568leo:(T88K)新增t123sb14
	2012111267leo:(T88K)新增t51sb12 t51sb13
	2012101866leo:(T88K)新增t35sb00_1 t35sb00_2 t35sb00_3 t35sb00_4 t35sb00_5 t35sb00_6
	2012081665lucas:(T88K)add t123sb01_TDR
	2012071164lucas:(T88K)移除公司採行通訊投票之情形shareholder_w
	2012070463lucas:(T88K)修改t160sb02標題文字
	2012062962lucas:(T88K)增加t162sb01,修改t57sb01_q4標題
	2012062561lucas:(T88K)於公司冶理底下增下一選項-符合主管機關規定應強制採電子投票之上市櫃公司執行情形彙總表
	2012060760lucas:(T88K)修改t160sb02標題文字
	2012051859tobey:(T88K)新增t160sb01 t160sb02 t160sb04 t158sb05
	2012051758lucas:(T88K)股東會及股利大項>>增加「股東會採行電子投票之上市櫃公司名單」選單(於除權息公告選單上方)
	2012051057lucas:(T88K)修改上線
	2012050455lucas:(T88K)新增function/formSubmit讓MOPS程式可以按下查詢後連到新的server-java的程式
	2012043054lucas:(T88K)修正t100sb02_1拿掉外部選單以及t100sb02_2顯示
	2012041853lucas:(T88K)修正t51sb11_q1,t51sb11_otc
	2012041752lucas:(T88K)修正t95sb06,o_t95sb06,t111sb01,o_t111sb01
	2012040551lucas:(T88K)修改t66sb22文字
	2012021750lucas:(T88K)新增t66sb20,21,22,23
	2012020249lucas:(T88K)更改內部控制專區階層位置
	2012020148lucas:(T88G)新增內部控制專區(t06sg20,t06hsg20)
	2012011747tobey:(T88K)新增o_t132sb17_q1
	2012011346awat:(T88K)add t90sbfa01權證搜尋器
	2011121543tobey:(T88K)新增t158sb01換掉t47sa17 新增t158sb02換掉t70sb01
	2011110442twse1097:(T88K)修正「合併關係企業財務報表」之子項目名稱(財資產負債表-->資產負債表，財損益表-->損益表)
	2011110441twse1097:(T88K)紀錄個股&精華版快速查詢輸入之公司代號
	2011110232tobey:(T88K)新增 t100sb10
	2011110231tobey:(T88K)新增 t100sb10
	2011100430draco:新增t132sb21 t132sb22
	2011092229tobey:(T88K)新增封閉型基金 國內成分證券指數股票型基金 及 t78sb32
	2011091428tobey:(T88K)修正27版 位置不對調
	2011091327tobey:(T88k)修改t56sb31和t05st23e_q3位置對調及修改財務預測報表標題
*	2011081326edward(T88K)新增t21sb06
*   2011072022awat(T88K)t144sb11修改標題
*   2011071521awat(T88K)修改功能名稱+（含牛熊證）
*   2011071520awat(T88K)新增t33sbAfa02
*	2011070719tobey:(T88K)新增o_t132sb17 之 下拉選項 並 合併t132sb17及o_t132sb17為選單8-14
*   2011063018eddie:(T88K)新增o_t111sb01 t33sbAfa01
*   2011060917eddie:(T88K)新增t150sb02
*   2011060816blue:(T88K)新增t51sb11_otc
*	2011051115eddie:(T88G)新增t95sb07  之 下拉選項
*	2011033113tyler:(T88K)新增t98sb05
*	2011031412eddie:(T88G)新增t132sb20 之 下拉選項
*	2011031011edward:(T88G)新增t153sb01_q1 & t153sb01_q2 之 下拉選項
*/


//Google Analytics
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-68490422-1', 'auto');
ga('send', 'pageview');

//增加監聽事件
function addListener(object,func,act){
	if (window.attachEvent)
		object.attachEvent("on"+func,act);
	else
		object.addEventListener(func,act,false);
}

var exp = new Date();
exp.setTime(exp.getTime()+(24*60*60*1000));

function setCookie(name, value, expires){
	document.cookie = name + "=" + escape(value) + "; path=/" + ((expires==null)?"":";expires="+expires.toGMTString());
}

function getCookie(name){
	var cname = name + "=";
	var dc = document.cookie;
	if (dc.length > 0){
		begin = dc.indexOf(cname);
		if (begin != -1){
			begin +=  cname.length;
			end = dc.indexOf(";",begin);
			if (end == -1){
				end = dc.length;
			}
			return unescape(dc.substring(begin,end));
		}
	}
	return null;
}

function delCookie(name){
	document.cookie = name + "=; expires=Thu, 01-Jan-70 00:00:01 GMT" + "; path=/";
}
function getRadioValue(ns1){
		if(ns1!=null){
			for(var i=0;i<ns1.length;i++){
				if(ns1[i].checked==true) return ns1[i].value;
				//alert(ns1[i].value);
			}
		}
		return null;

}

function setChip(cookie, name, value){
//	if(name=='TYPEK1') alert('--- set chip '+name+' = '+value);
	var dc = getCookie(cookie);
	var cv = getChip(cookie, name);
	var cn = name + '=';
	if (cv != null){
		var start = dc.indexOf(cn);
		if (start != -1){
			var end = dc.indexOf('|',start);
			setCookie(cookie, dc.substring(0,start) + cn + value + '|' + dc.substring(end + 1,dc.length), exp);
		}
	}
	else {
		if (dc != null){
			dc += cn + value + '|';
		}else{
			dc = cn + value + '|';
		}
		setCookie(cookie, dc, exp);
	}
}
//setChip("cookieName", "ChipName", "ChipValue");

function getChip(cookie, name){
	var cn = name + '=';
	var dc = getCookie(cookie);
	if (dc != null){
		var start = dc.indexOf(cn);
		if (start != -1){
			start += cn.length;
			var end = dc.indexOf('|',start);
			if (end != -1){
				return unescape(dc.substring(start,end));
			}
		}
	}
	return null;
}
//getChip("CookieName", "ChipName");

function delChip(cookie, name){
	var dc = getCookie(cookie);
	var cv = getChip(cookie, name);
	var cn = name + '=';
	if (cv != null){
		var start = dc.indexOf(cn);
		var end = dc.indexOf('|',start);
		setCookie(cookie, dc.substring(0,start) + dc.substring(end + 1, dc.length), exp);
	}
}
//delChip("CookieName", "ChipName");


function doZoom(size){
	var zoom = document.getElementById("zoom");
	if (zoom != null){
		document.getElementById("zoom").className = size;
	}
	
/*
	document.getElementById("fontSize1").src = "images/txt_b02_1.gif";
	document.getElementById("fontSize2").src = "images/txt_b02_2.gif";
	document.getElementById("fontSize3").src = "images/txt_b02_3.gif";
	document.getElementById("fontSize4").src = "images/txt_b02_4.gif";

	if (size=="fontSize1"){
		document.getElementById("fontSize1").src = "images/txt_b02_1s.gif";
	}
	if (size=="fontSize2"){
		document.getElementById("fontSize2").src = "images/txt_b02_2s.gif";
	}
	if (size=="fontSize3"){
		document.getElementById("fontSize3").src = "images/txt_b02_3s.gif";
	}
	if (size=="fontSize4"){
		document.getElementById("fontSize4").src = "images/txt_b02_4s.gif";
	}
*/
}

function showDetail() { 
	var bgObj=document.getElementById("bgDiv"); 
	bgObj.style.width = document.body.offsetWidth + "px";  
	bgObj.style.height = screen.height + "px"; 

	var msgObj=document.getElementById("msgDiv"); 
	msgObj.style.marginTop = -30 +  document.documentElement.scrollTop + "px"; 

	document.getElementById("msgShut").onclick = function(){ 
	bgObj.style.display = msgObj.style.display = "none"; 
	} 
	msgObj.style.display = bgObj.style.display = "block"; 
	msgDetail.style.display = "block" ; 
}

function closex(){
	if(document.getElementById('main').style.display =='inline'){
		document.getElementById('main').style.display ='none';
		document.getElementById('pic').src = 'images/pic24.gif';
//		document.getElementById('nav02').style.width = "985px";
	}else{
		document.getElementById('main').style.display ='inline';
		document.getElementById('pic').src = 'images/pic23.gif';
//		document.getElementById('nav02').style.width = "800px";
	}
}

function showhide(spanID,imgID){
	var what = document.getElementById(spanID);
	var what2 = document.getElementById(imgID);
	if (what.style.display=='none'){
		what.style.display='';
		what2.src='images/plus3.gif';
		what2.Open=""
	}
	else{
		what.style.display='none'
		what2.src='images/minus3.gif';
		what2.Closed=""
	}
}

//20160315 EDWARD ALICE begin:增加彈跳視窗
function openWindow(form1 , specs){
	var input = form1.getElementsByTagName('input');
	var action = form1.action;
	var parameter = '';
	for(var i = 0 ; i < input.length ; i ++){
		var itype = input[i].type;
		var iname = input[i].name;
		var ivalue = input[i].value;
		if(itype == 'button'){
			continue;
		}
		parameter += "<input type='hidden' name='" + iname + "' value='" + ivalue + "'/>";
	}

	var select = form1.getElementsByTagName('select');
	for(var i = 0 ; i < select.length ; i ++){
		var itype = select[i].type;
		var iname = select[i].name;
		var ivalue = select[i].value;
		if(itype == 'button'){
			continue;
		}
		parameter += "<input type='hidden' name='" + iname + "' value='" + ivalue + "'/>";
	}

	var caption_str="";
	var caption = document.getElementById("caption");
	if (caption!=null && caption!=undefined){
		caption_str = caption.innerHTML;
	}

	var date = new Date();

	var formName = "form"+date.getDate()+date.getTime();

	var str1 = "<html>"
			 + "<head>"
			 + "<script type=\"text/javascript\" src=\"js/mops.js\"></script>"
			 + "<link href=\"css/css.css\" rel=\"stylesheet\" type=\"text/css\" />"
			 + "</head>"
			 + "<body style='background-color:white !important;'>"
			 + "<div id='nav02'>"
			 + "<div class='t01' id='caption'>"
			 + caption_str
			 + "</div>"
			 + "<div id='zoom'><div id='table01'>"
			 + "<form id='"+formName+"' name='autoRunScript' method='post' action='" + action + "'>"
			 + parameter
			 + "</form>"
			 + "<script type='text/javascript'>"
			 + "setTimeout(function(){ ajax1(document.getElementById('"+formName+"') , 'table01'); } , 1000);"
			 + "</script>"
			 + "</div></div>"
			 + "</div>"
			 + "</body>"
			 + "</html>"
	if ( specs.length == 0 ){
		specs = "toolbar=no, scrollbars=yes, resizable=yes, location=no, menubar=no, status=no, width=800, height=500";
	}
	var win = window.open("" , "newWin"+date.getDate()+date.getTime() , specs);
	win.document.writeln(str1);
}

function openWindowAction(form1 , specs){

	var input = form1.getElementsByTagName('input');
	var action = form1.action;
	var parameter = '';
	for(var i = 0 ; i < input.length ; i ++){
		var itype = input[i].type;
		var iname = input[i].name;
		var ivalue = input[i].value;
		if(itype == 'button'){
			continue;
		}
		parameter += "<input type='hidden' name='" + iname + "' value='" + ivalue + "'/>";
	}

	var select = form1.getElementsByTagName('select');
	for(var i = 0 ; i < select.length ; i ++){
		var itype = select[i].type;
		var iname = select[i].name;
		var ivalue = select[i].value;
		if(itype == 'button'){
			continue;
		}
		parameter += "<input type='hidden' name='" + iname + "' value='" + ivalue + "'/>";
	}

	var date = new Date();

	var formName = "form"+date.getDate()+date.getTime();

	var str1 = "<html>"
			 + "<head>"
			 + "<script type=\"text/javascript\" src=\"/mops.js\"></script>"
			 + "<link href=\"/style.css\" rel=\"stylesheet\" type=\"text/css\" />"
			 + "</head>"
			 + "<body style='background-color:white !important;'>"

			 + "<form id='"+formName+"' name='"+formName+"' method='post' action='" + action + "'>"
			 + parameter
			 + "</form>"
			 + "<script type='text/javascript'>"
			 + "document."+formName+".submit();"
			 + "</script>"
			 + "</div></div>"
			 + "</div>"
			 + "</body>"
			 + "</html>"
	if ( specs.length == 0 ){
		specs = "toolbar=no, scrollbars=yes, resizable=yes, location=no, menubar=no, status=no, width=865, height=500";
	}
	var win = window.open("" , "newWin"+date.getDate()+date.getTime() , specs);
	win.document.writeln(str1);
}
//20160315 EDWARD ALICE end:增加彈跳視窗

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function outputNewWindow(){
	if (document.getElementById("table01").innerHTML==""){
		return;
	}
	var str2="";
	var table01 = document.getElementById("table01");
	if (table01!=null && table01!=undefined){
		str2 = table01.innerHTML;
	}
	var caption_str="";
	var caption = document.getElementById("caption");
	if (caption!=null && caption!=undefined){
		caption_str = caption.innerHTML;
	}
	var date = new Date();
	var str1="<html>";
	str1+="<head>";
	str1+="<script type=\"text/javascript\" src=\"js/mops.js\"></script>";
	str1+="<link href=\"css/css.css\" rel=\"stylesheet\" type=\"text/css\" />";
//	str1+="<link href=\"css/tag.css\" rel=\"stylesheet\" type=\"text/css\" />";
//	str1+="<link href=\"css/tablea.css\" rel=\"stylesheet\" type=\"text/css\" />";
	str1+="</head>";
	str1+="<body style='background-color:white !important;'>";
	str1+="<div id='nav02'>";
	str1+="<div class='t01' id='caption'>";
	str1+=caption_str;
	str1+="</div>";
	str1+="<div id='zoom'><div id='table01'>";
	str1+=str2;
	str1+="</div></div>";
	str1+="</div>";
	str1+="</body>";
	str1+="</html>";
	str1+="";
	var win = window.open("","newWin"+date.getDate()+date.getTime());
//	win.document.body.innerHTML=str1;
	win.document.writeln(str1);

//	win.document.close();

//	win.focus();
/*
	var win = window.open("","newWin");
	win.document.writeln("<html>");
	win.document.writeln("<head>");
	win.document.writeln("<script type=\"text/javascript\" src=\"js/mops.js\"></script>");
	win.document.writeln("<link href=\"css/css.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("<link href=\"css/tag.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("<link href=\"css/tablea.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("</head>");
	win.document.writeln("<body style='background-color:white !important;'>");
	win.document.writeln("<div id='nav02'>");
	win.document.writeln("<div class='t01' id='caption'>");
	win.document.writeln("</div>");
	win.document.writeln("<div id='zoom'><div id='table01'>");
	win.document.writeln("</div></div>");
	win.document.writeln("</div>");
	win.document.writeln("</body>");
	win.document.writeln("</html>");

	//var caption = document.getElementById("caption");
	//if (caption!=null && caption!=undefined){
	//	win.document.getElementById("caption").innerHTML = caption.innerHTML;
	//}
	var table01 = document.getElementById("table01");
	if (table01!=null && table01!=undefined){
		win.document.getElementById("table01").innerHTML = table01.innerHTML;
	}
	win.document.close();
*/
}

function outputNewWindowPrint(){
	if (document.getElementById("table01").innerHTML==""){
		return;
	}
	var str2="";
	var table01 = document.getElementById("table01");
	if (table01!=null && table01!=undefined){
		str2 = table01.innerHTML;
	}
	var caption_str="";
	var caption = document.getElementById("caption");
	if (caption!=null && caption!=undefined){
		caption_str = caption.innerHTML;
	}

	var str1="<html>";
	str1+="<head>";
//	str1+="<script type=\"text/javascript\" src=\"js/mops.js\"></script>";
	str1+="<link href=\"css/css.css\" rel=\"stylesheet\" type=\"text/css\" />";
	str1+="<link href=\"css/tag.css\" rel=\"stylesheet\" type=\"text/css\" />";
	str1+="<link href=\"css/tablea.css\" rel=\"stylesheet\" type=\"text/css\" />";
	str1+="</head>";
	str1+="<body style='background-color:white !important;'>";
	str1+="<div id='nav02'>";
	str1+="<div class='t01' id='caption'>";
	str1+=caption_str;
	str1+="</div>";
	str1+="<div id='zoom'><div id='table01'>";
	str1+=str2;
	str1+="</div></div>";
	str1+="</div>";
	str1+="</body>";
	str1+="</html>";
	str1+="";
	var win = window.open("","newWin");
	win.document.writeln(str1);
	win.document.close();
	//20170106 OLIVER 堅權 begin:修正chrome列印BUG
	//win.print();
	//win.close();
	setTimeout(function(){ win.print(); }, 100);
	setTimeout(function(){ win.close(); }, 100);
	//20170106 OLIVER 堅權 end:修正chrome列印BUG
	
/*
	var win = window.open("","newWin");
	win.document.writeln("<html>");
	win.document.writeln("<head>");
	win.document.writeln("<script type=\"text/javascript\" src=\"js/mops.js\"></script>");
	win.document.writeln("<link href=\"css/css.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("<link href=\"css/tag.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("<link href=\"css/tablea.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("</head>");
	win.document.writeln("<body style='background-color:white !important;'>");
	win.document.writeln("<div id='nav02'>");
	win.document.writeln("<div class='t01' id='caption'>");
	win.document.writeln("</div>");
	win.document.writeln("<div id='zoom'><div id='table01'>");
	win.document.writeln("</div></div>");
	win.document.writeln("</div>");
	win.document.writeln("</body>");
	win.document.writeln("</html>");

	//var caption = document.getElementById("caption");
	//if (caption!=null && caption!=undefined){
	//	win.document.getElementById("caption").innerHTML = caption.innerHTML;
	//}
	var table01 = document.getElementById("table01");
	if (table01!=null && table01!=undefined){
		win.document.getElementById("table01").innerHTML = table01.innerHTML;
	}
	win.document.close();
*/
}

function reportError(){
	//20160119 THOMAS SABRINA begin:修改問題回報(reportError)導向網址
	//var win = window.open("t146sb09?funcName="+document.fh.funcName.value,"newWin");
	//20160226 THOMAS SABRINA begin:修改問題回報(reportError)導向t146sb09
	//var win = window.open("http://suggestionbox.twse.com.tw/swsfront35/SWSF/SWSF01014.aspx","newWin");
	var win = window.open("t146sb09?funcName="+document.fh.funcName.value,"newWin");
	//20160226 THOMAS SABRINA end:修改問題回報(reportError)導向t146sb09
	//20160119 THOMAS SABRINA end:修改問題回報(reportError)導向網址
	win.opener = window;
/*
	win.document.writeln("<html>");
	win.document.writeln("<link href=\"css/css.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("<link href=\"css/tag.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("<link href=\"css/tablea.css\" rel=\"stylesheet\" type=\"text/css\" />");
	win.document.writeln("<body style='background-color:white !important;'>");
	win.document.writeln("<form action='' method='post'>");

	var nav_str = "";
	for (var i in navigator){
		nav_str += ","+i;
		win.document.writeln("<input type=\"hidden\" name=\"navigator_"+i+"\" value=\""+navigator[i]+"\">");
	}
	win.document.writeln("<input type=\"hidden\" name=\"navigator_properties_list\" value=\""+nav_str.substring(1)+"\">");

	win.document.writeln("<div style='padding:10px;'>");
	win.document.writeln("<h3>問題回報單</h3>");
	win.document.writeln("<div style='padding:10px;'>");
	win.document.writeln("問題提報人: <input type=\"text\" name=\"q_name\" size='10'>&nbsp;&nbsp;&nbsp;");
	win.document.writeln("稱謂: <select name='q_sex'><option value='M'>先生</option><option value='F'>小姐</option><option value='D'>教授</option></select>");
	win.document.writeln("</div>");
	win.document.writeln("<div style='padding:10px;'>");
	win.document.writeln("方便連絡電話: <input type=\"text\" name=\"q_tel\" size='20'>&nbsp;&nbsp;&nbsp;");
	win.document.writeln("常用E-mail: <input type=\"text\" name=\"q_email\" size='30'><br>");
	win.document.writeln("<font color='red' size='-1'>(連絡電話與e-mail請至少填寫其中一種)</font><br>");
	win.document.writeln("</div>");
	win.document.writeln("<div style='padding:10px;'>");
	win.document.writeln("問題種類: <select name='q_kind'><option value='1'>資料錯誤</option><option value='2'>畫面錯誤</option><option value='3'>其他問題</option></select>");
	win.document.writeln("</div>");
	win.document.writeln("<div style='padding:10px;'>");
	win.document.writeln("問題描述: <br><textarea name='content' cols='80' rows='6'></textarea><br>");
	win.document.writeln("</div>");
	win.document.writeln("<div style='padding:10px;'>");
	win.document.writeln("<input type='submit' value='填寫完畢，送出！'><br>");
	win.document.writeln("</div>");
	win.document.writeln("</div>");

	win.document.writeln("<input type='hidden' id='q_html' name='q_html'>");

	win.document.writeln("</form>");

	win.document.writeln("<div id='nav02' style='width:200px;height:150px;'></div>");

	win.document.writeln("</body>");
	win.document.writeln("</html>");
	win.document.writeln("<script>");
	win.document.writeln("document.getElementById('q_html').value=opener.document.getElementsByTagName('html')[0].innerHTML;");
	win.document.writeln("</script>");
*/
	win.document.close();
}
function formSubmit(formname){
	var formObj=document.forms[formname]; 
	formObj.submit();
}

function showCompanyData(){
	showValue("showCompanyID","companyID");
	showValue("showCompanyName","companyName");
	showValue("showCompanyMarket","companyMarket");
}

function showValue(obj,val){
	var eO = document.getElementById(obj);
	var eV = document.getElementById(val);
	if (eO!=null && eO!=undefined){
		if (eV!=null && eV!=undefined && eV.type=="hidden"){
			eO.innerHTML = eV.value;
		}else{
			eO.innerHTML = "";
		}
	}
}




var $$system_name = "newmops2";
//20180417 Garfield 將keyword從cookies自動填入中刪除
var $$keys = ["TYPEK","co_id","warrant_id",
				"year","season","month","date","date1","date2",
				"co_id_1","co_id_2","noticeDate","yymmdd1","yymmdd2","noticeKind","sort","num","BEG_SETDATE","END_SETDATE","index","YYYY","co1","co2","T1","T2","sid1","sid2","OSDATE","OEDATE","SDATE","EDATE","BOND_KIND","BOND_YRN","BOND_SUBN","YEAR","MONTH","b_date","e_date","types","CK1","CK2","co_id1","co_id2","date_1","date_2","sortKey","YYYYMM","TK","yymm1","yymm2","bid1","bid2","coid1","coid2","kind","qryType","bond_kind","r","bond_id","smonth","emonth","beg_co_id","end_co_id","beg_occur_date","end_occur_date","d1","d2","rid","wid","sid"
				,"slt","name","sbond_id","ebond_id","skind","CHO1","CHO2","CHO3","CHO4","issuer_stock_code","yy","mm","YY","PUD1","PUD2","data_kind","order","desc","YM","warrant_class","warrant_id","stock_no","publish_date","close_date","wt_1","wt_2","wt_3","wt_4","wt_5","wt_6","wt_7","wt_8","effective_date_1","effective_date_2","in_month","code"
				];

var $$sub_name = "newmops2_sub";

function setFormVisible(){
	var f = document.form1;
	if (f!=null && f!=undefined){
		var isnew = null;
		if (f.isnew!=null && f.isnew!=undefined){
			isnew = f.isnew.value;
		}
		if (isnew==null){
			return;
		}
		var bVisible = (isnew!="true");
		for (var i=0;i<$$keys.length;i++){
			if ($$keys[i]=="isnew" || $$keys[i]=="TYPEK" || $$keys[i]=="co_id" || $$keys[i]=="warrant_id"){
				continue;
			}
			setObjectVisible(f[$$keys[i]],bVisible);
		}
	}
}

function setObjectVisible(obj,bVisible){
	if (obj==null || obj==undefined || obj.type==null || obj.type==undefined){
		return;
	}else{
		obj.style.visibility = (bVisible?"":"hidden");
	}
}

function setFormValue(){
	var f = document.form1;
	if (f!=null && f!=undefined){
		for (var i=0;i<$$keys.length;i++){
			setObjectValue(f[$$keys[i]],getChip($$system_name,$$keys[i]));
		}
	}
}

function saveFormValue(){
	var f = document.form1;
	if (f!=null && f!=undefined){
		for (var i=0;i<$$keys.length;i++){
			var v = getObjectValue(f[$$keys[i]]);
			if (v!=null){
				setChip($$system_name,$$keys[i],v);
			}
		}
	}
}

function getObjectType(obj){
	if (obj==null || obj==undefined || obj.type==null || obj.type==undefined){
		return undefined;
	}else{
		return obj.type;
	}
}

function getObjectValue(obj){
	var oType = getObjectType(obj);
	if (oType==undefined){
		return null;
	}else{
		if (oType=="text" || oType=="textarea"){
			return obj.value;
		}else if (oType=="select-one"){
			return obj.value;
		}else if (oType=="radio"){
			for (var i=0;i<obj.length;i++){
				if (obj[i].checked){
					return obj[i].value;
				}
			}
		}else if (oType=="checkbox"){
			var ar = new Array();
			for (var i=0;i<obj.length;i++){
				if (obj[i].checked){
					ar[ar.length] = obj[i].value;
				}
			}
			return ar;
		}
	}

	return null;
}

function setObjectValue(obj,values){
	if (values==null){
		return;
	}

	var oType = getObjectType(obj);
	if (values instanceof Array){
		if (oType=="text" || oType=="textarea"){
			obj.value = values[0];
		}else if (oType=="select-one"){
			obj.value = values[0];
		}else if (oType=="radio"){
			for (var i=0;i<obj.length;i++){
				if (obj[i].value==values[0]){
					obj[i].checked=true;
				}
			}
		}else if (oType=="checkbox"){
			for (var i=0;i<obj.length;i++){
				for (var j=0;j<values.length;j++){
					if (obj[i].value==values[j]){
						obj[i].checked=true;
					}
				}
			}
		}
	}else{
		if (oType=="text" || oType=="textarea"){
			obj.value = values;
		}else if (oType=="select-one"){
			obj.value = values;
		}else if (oType=="radio"){
			for (var i=0;i<obj.length;i++){
				if (obj[i].value==values){
					obj[i].checked=true;
				}
			}
		}else if (oType=="checkbox"){
			for (var i=0;i<obj.length;i++){
				if (obj[i].value==values){
					obj[i].checked=true;
				}
			}
		}
	}
}

function openSubMenu(){
	var o = document.getElementById("subMenuID");
	if (o!=null && o!=undefined){
		var labelID = o.value;
		if (labelID!=null && labelID!=undefined && labelID!=""){
			if (labelID.substring(0,1)=="[" && labelID.substring(labelID.length-1)=="]"){
//				labelID = eval(labelID);
				labelID = labelID.replace("[" , "");
				labelID = labelID.replace("]" , "");
				var tmpLabel = labelID.split(",");

				for (var i=0;i<tmpLabel.length;i++){
					var test = document.getElementById("level-"+tmpLabel[i]);
					if (test!=null && test!=undefined){
						showhide("level-"+tmpLabel[i],"img-"+tmpLabel[i]);
					}
				}
			}else{
				var test = document.getElementById("level-"+labelID);
				if (test!=null && test!=undefined){
					showhide("level-"+labelID,"img-"+labelID);
				}
			}
		}
	}
}

function addListenerIsNew(){
	if (document.form1==null || document.form1==undefined){
		return;
	}
	if (document.form1.isnew==null || document.form1.isnew==undefined){
		return;
	}
	addListener(document.form1.isnew,"change",setFormVisible);
	setFormVisible();
}

addListener(window,"load",setFormValue);
addListener(window,"load",openSubMenu);
addListener(window,"load",addListenerIsNew);

//	控制顯示快速查詢
	function showsh3(id,obj){
		var dv = document.getElementById(""+id+"");
		dv.style.display = "block";
		var obj1 = document.getElementById(""+obj+"");  
		var x = getLeft(obj1);
		var y = getTop(obj1)+20;
		
		document.getElementById(""+id+"").style.left=x+"px";
		document.getElementById(""+id+"").style.top=y+"px";
	}
	//=function showsh(id,img){
	//=	var dv = document.getElementById(""+id+"");
		//var   version   =   parseFloat(navigator.appVersion.split("MSIE")[1]); 

		//if (version<=7){
			//=dv.style.display = "";

			//=var obj = document.getElementById(""+img+"");  
			//=dv.style.width = obj.clientWidth;
		//}
		//else{
		//	dv.style.display = "block";
		//	var obj = document.getElementById(""+img+"");  
		//	var x = realPosX(obj);
		//	var y = realPosY(obj)+17;
			
		//	document.getElementById(""+id+"").style.left=x+"px";
		//	document.getElementById(""+id+"").style.top=y+"px";

		//}

	//=}



	function realPosX1(oTarget) {
			var realX = oTarget.offsetLeft;
			if (oTarget.offsetParent.tagName.toUpperCase() != "BODY" && oTarget.offsetParent.tagName.toUpperCase() != "TD") {
				realX += realPosX1(oTarget.offsetParent); 
			}
			return realX;
	}
	function realPosY1(oTarget) {
			var realY = oTarget.offsetTop;
			if (oTarget.offsetParent.tagName.toUpperCase() != "BODY"  && oTarget.offsetParent.tagName.toUpperCase() != "TD") {
				realY += realPosY1(oTarget.offsetParent);

			}
			return realY;
	}

	function getLeft(obj) {
        if (obj == null)
            return null;
        var mendingObj = obj;
        var mendingLeft = mendingObj.offsetLeft;
        while (mendingObj != null && mendingObj.offsetParent != null && mendingObj.offsetParent.tagName != "BODY") {
            mendingLeft = mendingLeft + mendingObj.offsetParent.offsetLeft;
            mendingObj = mendingObj.offsetParent;
        }

        return mendingLeft;
    }
    function getTop(obj) {
        if (obj == null)
            return null;
        var mendingObj = obj;
        var mendingTop = mendingObj.offsetTop;
        while (mendingObj != null && mendingObj.offsetParent != null && mendingObj.offsetParent.tagName != "BODY") {
            mendingTop = mendingTop + mendingObj.offsetParent.offsetTop;
            mendingObj = mendingObj.offsetParent;
        }
        return mendingTop;
    }


	function GetAbsoluteY(Obj){
	  var TempObj = Obj; 
	  var rtData = 0;
	   
	  do{ 
		rtData = rtData + TempObj.offsetTop; 
		TempObj = TempObj.offsetParent; 
	  }while(TempObj != document.body)
	  
	  return rtData;
	}

	//找尋輸入物件的X軸絕對位置(指的是相對於網頁最左上端)
	function GetAbsoluteX(Obj){
	  var TempObj = Obj; 
	  var rtData = 0;
	  
	  do{ 
		rtData = rtData + TempObj.offsetLeft; 
		TempObj = TempObj.offsetParent; 
	  }while(TempObj != document.body)
	  
	  return rtData;
	} 

	function showsh2(id,obj){
//		alert('-- show'+id+' '+obj);
		var dv = document.getElementById(""+id+"");
		dv.style.display = "block";
		var obj1 = document.getElementById(""+obj+"");  
		var x = getLeft(obj1);
		var y = getTop(obj1)+50;
		
		document.getElementById(""+id+"").style.left=x+"px";
		document.getElementById(""+id+"").style.top=y+"px";
	}

	function hideIt2(div){
		document.getElementById(""+div+"").style.display = "none";
	}

//20160121 EDWARD ALICE begin:因改為全站檢索，所以下方的程式都用不到了
/*
	function showIt5(){ //公告
		document.getElementById("search_txt").style.display = "none";
		//document.getElementById("selflike").style.display = "none";
		document.getElementById("keyword").value = "請輸入公司代號或簡稱";
		document.getElementById("stockid").style.display = "inline";
		document.getElementById("sltdate").style.display = "inline";
		document.getElementById("sltitem").style.display = "inline";
		document.getElementById("keyword3").style.display = "none";
		document.getElementById("keyword").size = "20";

	}

	function showIt4(){ //重大訊息
		document.getElementById("search_txt").style.display = "inline";
		//document.getElementById("selflike").style.display = "none";
		document.getElementById("keyword").value = "請輸入公司代號或簡稱";
		document.getElementById("stockid").style.display = "inline";
		document.getElementById("sltdate").style.display = "inline";
		document.getElementById("sltitem").style.display = "none";
		document.getElementById("keyword3").style.display = "inline";
		document.getElementById("keyword3").value = "請輸入關鍵字";
		document.getElementById("keyword").size = "20";
		showBanner("1");
	}

	function showIt3(){ //精華版
		document.getElementById("search_txt").style.display = "none";
		//document.getElementById("selflike").style.display = "none";
		document.getElementById("keyword").value = "請輸入公司代號或簡稱";
		document.getElementById("stockid").style.display = "inline";
		document.getElementById("sltdate").style.display = "none";
		document.getElementById("sltitem").style.display = "none";
		document.getElementById("keyword3").style.display = "none";
		document.getElementById("keyword").size = "45";

	}

	function showIt2(){ //個股
		document.getElementById("search_txt").style.display = "none";
		//document.getElementById("selflike").style.display = "none";
		document.getElementById("keyword").value = "請輸入公司代號或簡稱";
		document.getElementById("stockid").style.display = "inline";
		document.getElementById("sltdate").style.display = "none";
		document.getElementById("sltitem").style.display = "none";
		document.getElementById("keyword3").style.display = "none";
		document.getElementById("keyword").size = "45";
	}
	function showIt1(){ //資訊項目
		document.getElementById("search_txt").style.display = "inline";
		//document.getElementById("keyword").value ="彙總表";
		document.getElementById("keyword").value = "請輸入報表名稱關鍵字";
		//document.getElementById("selflike").style.display = "none";
		document.getElementById("stockid").style.display = "none";
		document.getElementById("sltdate").style.display = "none";
		document.getElementById("sltitem").style.display = "none";
		document.getElementById("keyword3").style.display = "none";
		document.getElementById("keyword").size = "45";
		showBanner("0");
	}
	function chantxt1(){ //資訊項目
		document.getElementById("itm1").style.color = "yellow";
		document.getElementById("itm2").style.color = "white";
//		document.getElementById("itm3").style.color = "white";
		document.getElementById("itm4").style.color = "white";
		//document.getElementById("itm5").style.color = "white";
		document.getElementById("itm6").style.color = "white";
	}
	function chantxt2(){ //精華版2.0
		document.getElementById("itm1").style.color = "white";
		document.getElementById("itm2").style.color = "yellow";
//		document.getElementById("itm3").style.color = "white";
		document.getElementById("itm4").style.color = "white";
		//document.getElementById("itm5").style.color = "white";
		document.getElementById("itm6").style.color = "white";
	}

//	function chantxt3(){ //
//		document.getElementById("itm3").style.color = "yellow";

//		document.getElementById("itm1").style.color = "white";
//		document.getElementById("itm2").style.color = "white";
//		document.getElementById("itm4").style.color = "white";
		//document.getElementById("itm5").style.color = "white";
	
//	}

	function chantxt4(){ //重大訊息
		document.getElementById("itm4").style.color = "yellow";
		document.getElementById("itm1").style.color = "white";
		document.getElementById("itm2").style.color = "white";
		document.getElementById("itm6").style.color = "white";
//		document.getElementById("itm3").style.color = "white";
		//document.getElementById("itm5").style.color = "white";
	
	}

//	function chantxt5(){ //公告
//		document.getElementById("itm5").style.color = "yellow";

//		document.getElementById("itm1").style.color = "white";
//		document.getElementById("itm2").style.color = "white";
//		document.getElementById("itm3").style.color = "white";
//		document.getElementById("itm4").style.color = "white";
	
//	}


	function chantxt6(){ //個股
		document.getElementById("itm6").style.color = "yellow";
		document.getElementById("itm1").style.color = "white";
		document.getElementById("itm2").style.color = "white";
		document.getElementById("itm4").style.color = "white";
	
	}
	function closex1(){//個股時，打開左邊submenu
		document.getElementById('main').style.display ='none';
		document.getElementById('pic').src = 'images/pic24.gif';

	}
	function closex2(){//個股時，關閉左邊submenu
		document.getElementById('main').style.display ='inline';
		document.getElementById('pic').src = 'images/pic23.gif';

	}


	function goaction(menu){
		if (menu=="1"){
			document.fh.action="/mops/web/t146sb08";
			//closex2();
			document.fh.step.value="1";
			document.fh.keycon.value="1";
			document.fh.submit();

			
		}
		if (menu=="2"){
			document.fh.action="/mops/web/t146sb03";
			//closex2();
			//在將公司代號+公司名稱送出時，以空白為分隔符號，只將公司代號當作參數送出去
			var a=document.fh.keyword.value+" ";
			var b=a.search(" ");
			document.fh.keyword.value=a.substring(0,b);
			document.fh.co_id.value=document.fh.keyword.value;
			//================
			document.fh.step.value="1";
			document.fh.keycon.value="1";

			//twse1097
			setChip($$system_name,"co_id",document.fh.co_id.value);
			document.fh.submit();

		}
		if (menu=="3"){
			document.fh.action="/mops/web/t146sb03";
			//closex1();
			var a=document.fh.keyword.value+" ";
			var b=a.search(" ");
			document.fh.keyword.value=a.substring(0,b);
			document.fh.co_id.value=document.fh.keyword.value;
			document.fh.step.value="1";
			document.fh.keycon.value="1";

			document.fh.submit();

		}
		if (menu=="4"){
			document.fh.Stp.value="MH";
			document.fh.step.value="2";

			document.fh.action="/mops/web/t51sb10_q1";
			//document.fh.co_id.value=document.fh.keyword.value;
			//closex2();
			if (document.fh.keyword.value=="請輸入公司代號"){
				document.fh.keycon.value="0";
				alert("公司代號未輸入");
				
			}
			else{
				if (document.fh.keyword3.value=="請輸入關鍵字"){
					document.fh.keyword3.value="";
				}
				var a=document.fh.keyword.value+" ";
				var b=a.search(" ");
				document.fh.keyword.value=a.substring(0,b);
				document.fh.keycon.value="1";

				document.fh.submit();

			}
		}
		if (menu=="5"){
			document.fh.action="/mops/web/t146sb10";
			document.fh.date.value=document.fh.select.value;
			document.fh.noticeKind.value=document.fh.select1.value;

			var a=document.fh.keyword.value+" ";
			var b=a.search(" ");
			document.fh.co_id_1.value=a.substring(0,b);
			document.fh.co_id_2.value=a.substring(0,b);
			document.fh.step.value="1";
			document.fh.keycon.value="1";

			document.fh.submit();

			//closex2();
		}
		if (menu=="6"){
			document.fh.action="/mops/web/t05st03";
			var a=document.fh.keyword.value+" ";
			var b=a.search(" ");
			document.fh.keyword.value=a.substring(0,b);
			document.fh.co_id.value=document.fh.keyword.value;
			document.fh.step.value="1";
			document.fh.keycon.value="1";
			
			//twse1097
			setChip($$system_name,"co_id",document.fh.co_id.value);
			document.fh.submit();

			//closex2();
		}

	}

*/

	function goaction(thisValue , type , funcNo){

		if ( thisValue == '' ){
			thisValue = document.fh.keyword.value;
		}

		if ( type != "0" ){//公司代號
			setChip($$system_name,"co_id",thisValue);

			document.fh.action="/mops/web/t146sb05";
			document.fh.co_id.value=thisValue;
			document.fh.firstin.value="Y";
			document.fh.step.value="1";
		}else{
			if ( funcNo == "" || funcNo == undefined ){
				funcNo = "t146sb08";

				document.fh.firstin.value="Y";
			}else{
				document.fh.firstin.value="";
			}

			document.fh.action="/mops/web/"+funcNo;
			document.fh.keyword.value=thisValue;
			document.fh.step.value="1";
		}

		document.fh.submit();
	}

//20160121 EDWARD ALICE end:因改為全站檢索，所以下方的程式都用不到了

	function saveCsv(a,b){//儲存csv要呼叫的函式，目前的execcommand為ie only，firefox要想辦法
		var new_win = window.open('about:blank','Export','width=120,height=50');
		var f = document.forms[0];
		//for (var i=0;i<eval(f.csvCount.value);i++){
			new_win.document.writeln(a);
		//}
		new_win.document.execCommand('SaveAs',null,b);
		new_win.close();
	//	exportToText();
	}
	function bringv(a){//點選常用項目的連結後，將字帶到對應的欄位
		if (document.fh.menusave.value=="4")
			document.fh.keyword3.value=a;
		else
			document.fh.keyword.value=a;

	}
	function clskeyword(){
		if (document.fh.keyword.value=="請輸入公司代號"){
			document.fh.keyword.value="";
		}
		if (document.fh.keyword.value=="請輸入公司代號或簡稱"){
			document.fh.keyword.value="";
		}
		if (document.fh.keyword.value=="請輸入關鍵字"){
			document.fh.keyword.value="";
		}
		if (document.fh.keyword.value=="請輸入報表名稱關鍵字"){
			document.fh.keyword.value="";
		}
	}
	function clskeyword1(){
		if (document.fh.keyword3.value=="請輸入關鍵字"){
			document.fh.keyword3.value="";
		}
	}
	function proceval(){

	}
/*
	//表格加入mouseover及mouseout事件
	function chgColor(){
		var ptr = new Array();
		if (document.getElementById("zoom01") != null){
			ptr = document.getElementById("zoom01").getElementsByTagName("tr");
		}
		if (document.getElementById("zoom") != null){
			ptr = document.getElementById("zoom").getElementsByTagName("tr");
		}
		if (ptr != null){
			for(var i=0;i<ptr.length;i++) {
				if (ptr[i].className=="even" || ptr[i].className=="odd"){
					var obj = ptr[i];
					var clasName = ptr[i].className;
					onMouseOv(obj);
					onMouseOt(obj,clasName);
				}
			}
		}
	}
	

	function onMouseOv(obj){
		//alert(ptt.className);
		if (obj.addEventListener){
			obj.addEventListener("mouseover",function(){obj.className = "mouseOn";},false);
		}else{
			obj.attachEvent("onmouseover",function(){obj.className = "mouseOn";});
		}
	}

	function onMouseOt(obj,clasName){
		//alert(ptt.className);
		if (obj.addEventListener){
			obj.addEventListener("mouseout",function(){obj.className=clasName;},false);
		}else{
			obj.attachEvent("onmouseout",function(){obj.className=clasName;});
		}
	}
*/
	function showBanner(step){
		var str = "";
		str += "<table border='0'><tr><td>";
		str += "<div style=\"background-image: url(images/map01.jpg) ; height: 19px; width:32px;background-position:-161px 0px;\"></div>";
		if (step=="0"){
			str += "</td><td>";
			str += " <a href=\"#\" onclick=\"bringv('股東會');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">股東會</a>";
			str += " <a href=\"#\" onclick=\"bringv('除權息');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">除權息</a>";
			str += " <a href=\"#\" onclick=\"bringv('電子書');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">電子書</a>";
			str += " <a href=\"#\" onclick=\"bringv('法說會');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">法說會</a>";
			str += " <a href=\"#\" onclick=\"bringv('庫藏股');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">庫藏股</a>";
			str += " <a href=\"#\" onclick=\"bringv('董監持股');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">董監持股</a>";
			str += " <a href=\"#\" onclick=\"bringv('獨立董事');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">獨立董事</a>";
			str += " <a href=\"#\" onclick=\"bringv('董監酬金');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">董監酬金</a>";
			str += " <a href=\"#\" onclick=\"bringv('ETF');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">ETF</a>";
			str += " <a href=\"#\" onclick=\"bringv('TDR');fh.key1h.value=fh.keyword3.value;fh.keyh.value=fh.keyword.value;fh.slth.value=fh.select.value;fh.slt1h.value=fh.select1.value;hideIt2('quicksearch');hideIt2('quicksearch2');goaction(fh.menusave.value);\">TDR</a>";
		}
		if (step=="1"){
			str += "</td><td><a href=\"#\" onclick=\"bringv('股東會');\">股東會</a>";
			str += " <a href=\"#\" onclick=\"bringv('股利');\">股利</a>";
			str += " <a href=\"#\" onclick=\"bringv('收購');\">收購</a>";
			str += " <a href=\"#\" onclick=\"bringv('增資');\">增資</a>";
			str += " <a href=\"#\" onclick=\"bringv('減資');\">減資</a>";
			str += " <a href=\"#\" onclick=\"bringv('重整');\">重整</a>";
		}
		str += "</td></tr></table>";
		document.getElementById("search_txt").innerHTML = str;
	}

/* 備份 

function ajax1(form1,targets) {
	saveFormValue();
	var str='encodeURIComponent=1';
	var es = form1.elements;
	for (var i=0;i<es.length;i++){
		var value1=encodeURIComponent(es[i].value);
		if(es[i].name=='') continue;
		if(es[i].type=="checkbox") { if(!es[i].checked) continue;}
		if(es[i].type=="radio") { if(!es[i].checked) continue;}
		str=str+'&'+es[i].name+'='+value1;
	}
//	alert(str);
	var url=form1.action;
	var xmlDoc;
	if (window.XMLHttpRequest)
	{
		xmlDoc = new XMLHttpRequest();alert(url);
		xmlDoc.open("POST", url, false);
		xmlDoc.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xmlDoc.send(str); 
	} else if (window.ActiveXObject) { // IE
		isIE = true;alert('3');
		try {
			xmlDoc = new ActiveXObject ("Msxml2.XMLHTTP");
		} catch (e) {
			xmlDoc = new ActiveXObject ("Microsoft.XMLHTTP");
		}

		if (xmlDoc)
		{
			xmlDoc.open ("POST", url, false);
			xmlDoc.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			xmlDoc.send(str);
		}
	}
	var target1=document.getElementById(targets);
	if(target1==null){
		alert('Targets '+targets+' not found!');
	} else {alert(xmlDoc.responseText);
		target1.innerHTML=xmlDoc.responseText;
	}
	return false;
}
*/




// global variables //
var TIMER = 5;
var SPEED = 10;
var WRAPPER = 'content';

// calculate the current window width //
function pageWidth() {
  return window.innerWidth != null ? window.innerWidth : document.documentElement && document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body != null ? document.body.clientWidth : null;
}

// calculate the current window height //
function pageHeight() {
  return window.innerHeight != null? window.innerHeight : document.documentElement && document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body != null? document.body.clientHeight : null;
}

// calculate the current window vertical offset //
function topPosition() {
  return typeof window.pageYOffset != 'undefined' ? window.pageYOffset : document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ? document.body.scrollTop : 0;
}

// calculate the position starting at the left of the window //
function leftPosition() {
  return typeof window.pageXOffset != 'undefined' ? window.pageXOffset : document.documentElement && document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ? document.body.scrollLeft : 0;
}

// build/show the dialog box, populate the data and call the fadeDialog function //
function showDialog(title,message,type,autohide) {
  if(!type) {
    type = 'error';
  }
  var dialog;
  var dialogheader;
  var dialogclose;
  var dialogtitle;
  var dialogcontent;
  var dialogmask;
//  alert(document.getElementById('dialog'));
  if(!document.getElementById('dialog')) {
    dialog = document.createElement('div');
    dialog.id = 'dialog';
    dialogheader = document.createElement('div');
    dialogheader.id = 'dialog-header';
    dialogtitle = document.createElement('div');
    dialogtitle.id = 'dialog-title';
    dialogclose = document.createElement('div');
    dialogclose.id = 'dialog-close'
    dialogcontent = document.createElement('div');
    dialogcontent.id = 'dialog-content';
    dialogmask = document.createElement('div');
    dialogmask.id = 'dialog-mask';
    document.body.appendChild(dialogmask);
    document.body.appendChild(dialog);
    dialog.appendChild(dialogheader);
    dialogheader.appendChild(dialogtitle);
    dialogheader.appendChild(dialogclose);
    dialog.appendChild(dialogcontent);;
    dialogclose.setAttribute('onclick','hideDialog()');
    dialogclose.onclick = hideDialog;
  } else {
    dialog = document.getElementById('dialog');
    dialogheader = document.getElementById('dialog-header');
    dialogtitle = document.getElementById('dialog-title');
    dialogclose = document.getElementById('dialog-close');
    dialogcontent = document.getElementById('dialog-content');
    dialogmask = document.getElementById('dialog-mask');
    dialogmask.style.visibility = "visible";
    dialog.style.visibility = "visible";
  }
  dialog.style.opacity = .00;
  dialog.style.filter = 'alpha(opacity=0)';
  dialog.alpha = 0;
  var width = pageWidth();
  var height = pageHeight();
  var left = leftPosition();
  var top = topPosition();
  var dialogwidth = dialog.offsetWidth;
  var dialogheight = dialog.offsetHeight;
  var topposition = top + (height / 3) - (dialogheight / 2)+60;
  var leftposition = left + (width / 2) - (dialogwidth / 2);
  dialog.style.top = topposition + "px";
  dialog.style.left = leftposition + "px";
  dialogheader.className = type + "header";
  dialogtitle.innerHTML = title;
  dialogcontent.className = type;
//  dialogcontent.innerHTML = '<iframe frameBorder=0 style="width:100%;height:100%;"><html><body>'+message+'</html></iframe>';
  dialogcontent.innerHTML = message;
//  var content = document.getElementById(WRAPPER);
  var content = document.body;
  dialogmask.style.height = content.offsetHeight + 'px';
//  alert(' dialog.timer1='+dialog.timer);
  if(dialog.timer!=null){
    clearInterval(dialog.timer);
  }
  dialog.timer = setInterval("fadeDialog(1)", TIMER);

  if(autohide) {
    dialogclose.style.visibility = "hidden";
    window.setTimeout("hideDialog()", (autohide * 1000));
  } else {
    dialogclose.style.visibility = "visible";
  }


}
// hide the dialog box //
function hideDialog() {
  var dialog = document.getElementById('dialog');
//	alert(dialog);
  clearInterval(dialog.timer);
  dialog.timer = setInterval("fadeDialog(0)", TIMER);
}

// fade-in the dialog box //
function fadeDialog(flag) {
  if(flag == null) {
    flag = 1;
  }
  var dialog = document.getElementById('dialog');
  var value;
  if(flag == 1) {
    value = dialog.alpha + SPEED;
  } else {
    value = dialog.alpha - SPEED;
  }
  dialog.alpha = value;
  dialog.style.opacity = (value / 100);
  dialog.style.filter = 'alpha(opacity=' + value + ')';
//  alert('value='+value+' dialog.timer1='+dialog.timer);
  if(value >= 99) {
    clearInterval(dialog.timer);
    dialog.timer = null;
  } else if(value <= 1) {
    dialog.style.visibility = "hidden";
//20121226 leo begin: 加上判斷物件是否存在 
	if (document.getElementById('dialog-mask') != null) {
		document.getElementById('dialog-mask').style.visibility = "hidden";
	}
//20121226 leo end: 加上判斷物件是否存在 
    clearInterval(dialog.timer);
  }
}
var ajax_target=new Array();

var xmlDoc=new Array();
function monitor1(index,targets){
	if(ajax_target[index]!=null){
		var rsData=xmlDoc[index].readyState+',';
		if(xmlDoc[index].readyState==1){
//			alert('rsData='+rsData+' ajax_target='+ajax_target);
//			showDialog('','資料載入中，請稍候..','SUCESS');
			showDialog('','<div style="width:100%;height:100%;border:ridge 0px #777;color:#0000ff;font-size:16;vertical-align:middle;text-align:center;"><img src="images/Clock1.gif"></img></div>','SUCESS');
		} else if(xmlDoc[index].readyState==4){ 
                        alert(xmlDoc[index].status);
                        alert(xmlDoc[index].responseText);
//			alert('rsData='+rsData+' ajax_target'+ajax_target);
			var target1=document.getElementById(ajax_target[index]);
			if(target1==null){
				alert('Targets '+targets+' not found!');
				ajax_target[index]=null;
			} else {
				REC1.push(target1);
				REC2.push(target1.innerHTML);

				if(REC3.lneght==0){

					var param1=new Array();
					var param2=new Array();
					try{
					var es = form1.elements;
					for (var i=0;i<es.length;i++){
						var value1=es[i].value;
						if(es[i].name=='') continue;
						if(es[i].type=="checkbox") { if(!es[i].checked) continue;}
						if(es[i].type=="radio") { if(!es[i].checked) continue;}
						param1.push(es[i]);
						param2.push(value1);
					}
					} catch(ee){}
					REC3.push(param1);
					REC4.push(param2);

				}

				var param1=new Array();
				var param2=new Array();
				try{
				var es = form1.elements;
				for (var i=0;i<es.length;i++){
					var value1=es[i].value;
					if(es[i].name=='') continue;
					if(es[i].type=="checkbox") { if(!es[i].checked) continue;}
					if(es[i].type=="radio") { if(!es[i].checked) continue;}
					param1.push(es[i]);
					param2.push(value1);
				}
				} catch(ee){}

				var POSY=0;
				try{
					POSY=f_scrollTop();

//			alert('-- sc_x='+f_scrollTop());
				} catch(ee){}

				REC5.push(POSY);

				REC3.push(param1);
				REC4.push(param2);
				RECP++; 
                                
				target1.innerHTML=xmlDoc[index].responseText;
				ajax_target[index]=null;

				if(document.getElementById('ajax_back_button')!=null){
					document.getElementById('ajax_back_button').style.visibility='visible';
				}

				if (fullVersion=="7"){
					
					setTimeout("doZoom('fontSize2');", 100);

//					setTimeout("changeZoom();", 100);
	
				}
				window.scrollTo(0,0);


			}
			var allOK=true;
			for (var i=0;i<ajax_target.length;i++){
				if (ajax_target[i]!=null){
					allOK = false;
				}
			}
			if (allOK){ 
				hideDialog();
				if(document.getElementById('__special_script')!=null){
					var text1=document.getElementById('__special_script').innerHTML;
					document.getElementById('__special_script').innerHTML='';
//					var text1=document.getElementById('__special_script').innerText;
//					document.getElementById('__special_script').innerText='';
//					alert('text1');
					if(text1!=null){
						eval(text1);
					} 
				} 
			} 
		}
	}
//	var stData=xmlDoc.status+',';
//	var rtData=xmlDoc.statusText+',';
//	alert('rsData='+rsData);
}
function f_scrollTop() {
	var t1=0;
	var t2=0;
	var t3=0;
	if(window.pageYOffset) t1=window.pageYOffset;
	if(document.documentElement) t2=document.documentElement.scrollTop;
	if(document.body) t3=document.body.scrollTop;

	var max=0;
	if(t1>max) max=t1;
	if(t2>max) max=t2;
	if(t3>max) max=t3;
	return max;
}

function ajax_back(){
	if(RECP<0) return;
	if(REC1.length==0) return;
	var t1=REC1.pop();
	var t2=REC2.pop();

	var t5=REC5.pop();
//	alert('set to '+t5+' RECP='+RECP+' '+REC5.length);

	RECP--;

	var t3=REC3[RECP];
	var t4=REC4[RECP];
	REC3.pop();
	REC4.pop();
	if(t3!=null){
		for(i=0;i<t3.length;i++){
			t3[i].value=t4[i];
		}
	}


	if(REC1.length==0){
		if(document.getElementById('ajax_back_button')!=null){
			document.getElementById('ajax_back_button').style.visibility='hidden';
		}
	}

	t1.innerHTML=t2;

	if(window.pageYOffset) window.pageYOffset=t5;
	if(document.documentElement) document.documentElement.scrollTop=t5;
	if(document.body) document.body.scrollTop=t5;


}

var REC1=new Array();
var REC2=new Array();
var REC3=new Array();
var REC4=new Array();
var REC5=new Array();
var RECP=-1;

function ajax1(form1,targets) {
	saveFormValue();
	if(document.getElementById('__special_script')!=null){
		document.getElementById('__special_script').innerHTML='';
//		document.getElementById('__special_script').innerText='';
	}
	var str='encodeURIComponent=1';
	var es = form1.elements;
	for (var i=0;i<es.length;i++){
//		if(es[i].name=='co_id') alert('co_id='+es[i].value);
		var value1=encodeURIComponent(es[i].value);
		if(es[i].name=='') continue;
		if(es[i].type=="checkbox") { if(!es[i].checked) continue;}
		if(es[i].type=="radio") { if(!es[i].checked) continue;}
		str=str+'&'+es[i].name+'='+value1;
	}
//	alert(str);
	var index = -1;
	for (var i=0;i<ajax_target.length && index==-1;i++){
		if (ajax_target[i]==null){
			index = i;
		}
	}
	if (index==-1){
		index = ajax_target.length;
	}
	ajax_target[index]=targets;

	var url=form1.action;
//	var xmlDoc;
	if (window.XMLHttpRequest)
	{
		xmlDoc[index] = new XMLHttpRequest(); 
		xmlDoc[index].onreadystatechange=function(){monitor1(index,targets);}
		xmlDoc[index].open("GET", url, true);alert(url);
		xmlDoc[index].setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xmlDoc[index].send(str);
	} else if (window.ActiveXObject) { // IE
		isIE = true; 
		try {
			xmlDoc[index] = new ActiveXObject ("Msxml2.XMLHTTP");
		} catch (e) {
			xmlDoc[index] = new ActiveXObject ("Microsoft.XMLHTTP");
		}

		if (xmlDoc[index])
		{
			xmlDoc[index].onreadystatechange=function(){monitor1(index,targets);}
			xmlDoc[index].open ("POST", url, true);
			xmlDoc[index].setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			xmlDoc[index].send(str);
		}
	}
/*
	var target1=document.getElementById(targets);
	if(target1==null){
		alert('Targets '+targets+' not found!');
	} else {
		target1.innerHTML=xmlDoc[index].responseText;
	}
*/
	return false;
}


function getVersion() {
	var nAgt = navigator.userAgent;
	var fullVersion  = 0;
	if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
		fullVersion  = parseFloat(nAgt.substring(verOffset+5));
	}
	return fullVersion;
}

var fullVersion=getVersion();

//2010/08/12:edward:begin:為了連動下拉選單,再增加一個function讓它可以直接把form送出
	function isAction() {
		var tmpfileName = ["t123sb09_q1","t123sb10_q1","t123sb09_q2","t123sb10_q2","p_t112sb02_q1",
									"p_t112sb02_q2","t127sb00_q1","t127sb00_q2","p_t56sb25","t129sb01","t127sb00",
									"t198sb04_q1","t198sb04"
									];
		var file_name = document.fh.funcName.value;
		var nedAction = true;
		for (var i=0;i<tmpfileName.length;i++){
			if (tmpfileName[i] == file_name){
				nedAction = false;
			}
		}
		var typek = document.form1.TYPEK;
//		alert(typek.value);
		if (nedAction){
			if (typek != null || typek != undefined){
				ajax1(document.form1,'search');
			}
		}
	}
//2010/08/12:edward:end:為了連動下拉選單,再增加一個function讓它可以直接把form送出

/*
function changeZoom() {
	var nAgt = navigator.userAgent;
	var fullVersion  = 0;
	var fileName = document.fh.funcName.value;
	if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
		fullVersion  = parseFloat(nAgt.substring(verOffset+5));
	}
	//if (fullVersion=="7" && fileName == "t51sb01"){
	if (fullVersion=="7"){
		doZoom("fontSize2");
	}
}
*/

/*20160204 EDWARD ALICE 自動完成*/
var keyIndex = 0;
var oldAction = "";
function chkKeyDown(form , obj , targetDiv , evnt){
	if ( obj.value.length == 0 ){
		return false;
	}

	document.getElementById('oldKeyWord').value = obj.value;

	var thisAction = form.action;
	if ( thisAction.indexOf("auto") == -1 ){
		oldAction = thisAction;
	}

	var keyCode;
	if ( window.event ){
		keyCode = event.keyCode;
	}else{
		keyCode = evnt.which;
	}

	if ( keyCode == 13 ){//ENTER
		if ( obj == document.getElementById("keyword") ){
			form.action="/mops/web/autoAction";
			hideDiv2(obj);
			form.submit();
		}else{
			form.action = oldAction;
			hideDiv2(obj);
			ajax1(form , "table01");
		}
	}else{
		form.action="/mops/web/ajax_autoComplete";
	}

	if ( keyCode == 37 || keyCode == 39 ){//Left || Right
		if ( keyIndex > 0 ){
			obj.value = document.getElementById("autoDiv-"+(keyIndex)).value;

			//為了讓左右鍵按下時，自動完成會重新顯示，所以這邊要先把舊的值清空
			document.getElementById('oldKeyWord').value = "";
		}
	}else{
		var dataLength = 0;
		var divBody;

		if ( keyCode == 38 || keyCode == 40 ){
			if ( document.getElementById("dataLength") ){
				dataLength = parseInt(document.getElementById("dataLength").value);
			}
		}

		if ( keyCode == 38 ){//UP
			//復原
			try{
				chgClass(1 , keyIndex , obj)
			}catch (e){}

			keyIndex--;

			chgPosition(keyCode , dataLength , targetDiv);

			if ( keyIndex < 1 ){
				keyIndex = dataLength;
			}

			//轉變
			try{
				chgClass(0 , keyIndex , obj)
			}catch (e){
				
			}
			obj.value = document.getElementById("autoDiv-"+(keyIndex)).value;
		}
		if ( keyCode == 40 ){//Down
			//復原
			try{
				chgClass(1 , keyIndex , obj)
			}catch (e){}

			keyIndex++;

			chgPosition(keyCode , dataLength , targetDiv);

			if ( keyIndex > dataLength ){
				keyIndex = 1;
			}

			//轉變
			try{
				chgClass(0 , keyIndex , obj)
			}catch (e){
				
			}

			obj.value = document.getElementById("autoDiv-"+(keyIndex)).value;
		}
	}
}

var minScrollTop = 0;
var maxScrollTop = 300;
function chgPosition(keyCode , dataLength , targetDiv){
	var addIndex = 0;//需額外加上的
	var tmpIndex = keyIndex;
	var tmpScrollTop = maxScrollTop;

	if ( keyIndex > dataLength ){
		minScrollTop = -26;
		maxScrollTop = 274;

		tmpIndex = 1;
	}else if ( keyIndex < 1 ){
		var titleLength = parseInt(document.getElementById("titleLength").value);

		maxScrollTop = (dataLength*26+(titleLength*26));
		minScrollTop = (maxScrollTop-274);

		tmpIndex = dataLength;
	}

	if ( keyCode == 38 ){//UP
		minScrollTop -= 26;
		maxScrollTop -= 26;

		if ( document.getElementById("autoSub-"+(tmpIndex)) != null ){
			addIndex -= 26;
		}
	}else if ( keyCode == 40 ){//Down
		minScrollTop += 26;
		maxScrollTop += 26;

		if ( document.getElementById("autAdd-"+(tmpIndex)) != null || document.getElementById("autoSub-"+(tmpIndex)) != null ){
			addIndex += 26;
		}
	}

	var divObj = document.getElementById(""+targetDiv+"");
	divBody = document.getElementById("autoCompilete-dbody"+(tmpIndex));
	var divTop = divBody.offsetTop;//選擇到的 div 的位置

	if ( divTop < 274 ){

		if ( keyIndex <= dataLength ){
			if ( keyCode == 38 ){//UP
				if ( maxScrollTop < 300 ){
					return false;
				}
			}else if ( keyCode == 40 ){//Down
				if ( minScrollTop < 274 ){
					return false;
				}
			}
		}
	}

	if ( keyIndex > dataLength ){
		divObj.scrollTop = minScrollTop;
	}else if ( keyIndex < 1 ){
		divObj.scrollTop = maxScrollTop;
	}else{
		divObj.scrollTop = divTop-274;
	}
}

function autoComplete(form1 , objDiv , targetDiv , evnt){
	var keyCode;
	if ( window.event ){
		keyCode = event.keyCode;
	}else{
		keyCode = evnt.which;
	}
	if ( keyCode != 38 && keyCode != 40 ){
		keyIndex = 0;//將index歸0

		minScrollTop = 0;//將minScrollTop初始化
		maxScrollTop = 300;//將maxScrollTop初始化
		var timeOut = 300;//300毫秒
		setTimeout(function(){ callAjax(form1 , objDiv , targetDiv); } , timeOut);
	}
}

function callAjax(form1 , objDiv , targetDiv){
	var keyWord = "";
	try{
		keyWord = document.getElementById(""+objDiv+"").value.trim();//本次輸入值
	}catch (e){
		keyWord = document.getElementById(""+objDiv+"").value;//本次輸入值
	}
	var oldKeyWord = document.getElementById('oldKeyWord').value;//上次輸入值

	document.getElementById('oldKeyWord').value = keyWord;

	if ( keyWord != oldKeyWord && keyWord.length > 0 ){//若值不為空白，或不和上次一樣，就要重新搜尋一次
		runAjax(form1 , objDiv , targetDiv);
	}else if ( keyWord.length == 0 ){
		hideDiv(targetDiv);
	}
}

function runAjax(form1 , objDiv , targetDiv){
	//抓取server的IP
	var href = document.location.href;
	var serverDNS = "";
	var url = "";
	if ( href.indexOf("http://") == 0 ){
		var x = href.indexOf("/", 7);
		if (x == -1) x = href.length;
		serverDNS = href.substring(7,x);
		url = "http://"+serverDNS+"/mops/web/ajax_autoComplete";
	}

	//20190603 twse1097 begin：判斷處理來源是https的request
	if ( href.indexOf("https://") == 0 ){
		var x = href.indexOf("/", 8);
		if (x == -1) x = href.length;
		serverDNS = href.substring(8,x);
		url = "https://"+serverDNS+"/mops/web/ajax_autoComplete";
	}
	//20190603 twse1097 end：判斷處理來源是https的request

	var xhttp;

	if ( window.XMLHttpRequest ){
		xhttp = new XMLHttpRequest();
	}else if ( window.ActiveXObject ){
		try{
			xhttp = new ActiveXObject ("Msxml2.XMLHTTP");
		} catch (e) {
			xhttp = new ActiveXObject ("Microsoft.XMLHTTP");
		}
	}

	try{
		xhttp.async = false;
	}catch (e){}

	var str='encodeURIComponent=1';
	var es = form1.elements;
	for (var i=0;i<es.length;i++){
		var value1 = encodeURIComponent(es[i].value);
		if(es[i].name=='') continue;
		if(es[i].type=="checkbox") { if(!es[i].checked) continue;}
		if(es[i].type=="radio") { if(!es[i].checked) continue;}
		str=str+'&'+es[i].name+'='+value1;
	}

	var sstep = "1";
	if ( objDiv.indexOf("2") != -1 || objDiv.indexOf("end_") != -1 ){
		sstep = "2";
	}

	str=str+'&sstep'+'='+sstep;

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			runKeyWord(form1 , objDiv , targetDiv , xhttp);
		}
	};

	xhttp.open("POST", url , true);
	xhttp.send(str);
}

function runKeyWord(form1 , objDiv , targetDiv , xhttp){
	var tmpText = xhttp.responseText;
	if ( tmpText.indexOf("<div id=\"zoom\"></div>") != -1 ){
		hideDiv(targetDiv);
	}else{
		document.getElementById(""+targetDiv+"").innerHTML = tmpText;
		if ( checkHTML(objDiv , targetDiv , form1) ){
			showDiv(objDiv , targetDiv , 250);
		}else{
			hideDiv(targetDiv);
			runAjax(form1 , objDiv , targetDiv);
		}
	}

	return;
}

//改變 div 的 className
function chgClass(type , divIndex , objDiv){
	var obj = document.getElementById(""+objDiv+"");
	var className = "";

	var divHead = document.getElementById("autoCompilete-dhead"+divIndex+"");

	if ( divHead != null ){
		if ( type == 0 ){
			className = "auto-mousover";
			divHead.className = className+"-box";
		}else{
			className = "auto-mousout";
			divHead.className = className+"-box";
		}
	}
}
//檢查產出的 HTML 是不是跟此次的吻合
function checkHTML(objDiv , targetDiv , form1){
	var oValue = document.getElementById(""+objDiv+"").value;//本次輸入值

	var chkStr = "source_str=\""+oValue+"\"";
	var target = document.getElementById(""+targetDiv+"").innerHTML;

//	if ( target.indexOf(chkStr) == -1 ){
//		return false;
//	}else{
		return true;
//	}

}
//顯示自動完成
function showDiv(objDiv , targetDiv , maxLength){
	var dv = document.getElementById(""+targetDiv+"");
	dv.style.display = "block";

	var obj = document.getElementById(""+objDiv+"");
	var x = realPosX(obj);
	var y = realPosY(obj)+22;

	//IE6
	if ( navigator.userAgent.indexOf("MSIE 6.0") > 0 ){
		if ( objDiv == "keyword" ){
			dv.style.width = (maxLength*12)/1.8 + "px";
		}
	}

	dv.style.left = x+"px";
	dv.style.top = y+"px";
	dv.scrollTop = 0+"px";
}
//計算 X 軸
function realPosX(oTarget) {
	var realX = oTarget.offsetLeft
	if (oTarget.offsetParent.tagName.toUpperCase() != "BODY") {
		realX += realPosX(oTarget.offsetParent); 
	}
	return realX;
}
//計算 Y 軸
function realPosY(oTarget) {
		var realY = oTarget.offsetTop;
		if (oTarget.offsetParent.tagName.toUpperCase() != "BODY") {
			realY += realPosY(oTarget.offsetParent);
		}
		return realY;
}
//關閉自動完成
function hideDiv(targetDiv){
	var dv = document.getElementById(""+targetDiv+"");

		try{
			var minTop = dv.offsetLeft;
			var minLeft = dv.offsetTop;

			var width = dv.offsetWidth;
			var heigh = dv.offsetHeight;

			var maxTop = minTop + width;
			var maxLeft = minTop + heigh;

			if ( (mouseX < minTop) || (mouseX > maxTop) || (mouseY < minLeft) || (mouseY > maxLeft) ){
				dv.innerHTML = "";
				dv.style.display = "none";
			}
		}catch (e){}
}
//關閉自動完成 for 公司代號
function hideDiv2(objDiv){
	var dv = null;

	var dv1 = document.getElementById("auto-complete-data");
	var dv2 = document.getElementById("auto-complete-data2");
	var dvName = "";

	if ( dv1.style.display != "none" ){
		dv = dv1;
		dvName = "auto-complete-data";
	}else if ( dv2.style.display != "none" ){
		dv = dv2;
		dvName = "auto-complete-data2";
	}

	if ( dv != null ){
		dv.innerHTML = "";
		dv.style.display = "none";
	}

	//將old
	document.getElementById('oldKeyWord').value = objDiv.value;

	//將原本的 form action 還原，不然會跑到自動完成的程式
	if ( document.form1 ){
		document.form1.action = '/mops/web/ajax_' + document.fh.funcName.value;
	}
}

//檢查是否要關閉自動完成
function checkautoComplete(){
	var dv = null;

	var dv1 = document.getElementById("auto-complete-data");
	var dv2 = document.getElementById("auto-complete-data2");
	var dvName = "";

	if ( dv1.style.display != "none" ){
		dv = dv1;
		dvName = "auto-complete-data";
	}else if ( dv2.style.display != "none" ){
		dv = dv2;
		dvName = "auto-complete-data2";
	}

	if ( dv != null ){
		try{
			var minTop = dv.offsetLeft;
			var minLeft = dv.offsetTop;

			var width = dv.offsetWidth;
			var heigh = dv.offsetHeight;

			var maxTop = minTop + width;
			var maxLeft = minTop + heigh;

			if ( (mouseX < minTop) || (mouseX > maxTop) || (mouseY < minLeft) || (mouseY > maxLeft) ){
				dv.innerHTML = "";
				dv.style.display = "none";
			}

		}catch (e){}
	}

	return true;
}

//取得滑鼠座標
var IE = document.all?true:false;
if (!IE) document.captureEvents(Event.MOUSEMOVE);
document.onmousemove = getMouseXY;
document.onclick = checkautoComplete;
var mouseX = 0;
var mouseY = 0;
function getMouseXY(e) {
	if (IE){
		mouseX = event.clientX + document.body.scrollLeft;
		mouseY = event.clientY + document.body.scrollTop;
	}else{
		mouseX = e.pageX;
		mouseY = e.pageY;
	}

	if (mouseX < 0){mouseX = 0;}
	if (mouseY < 0){mouseY = 0;}
	return true;
}

/*
function getMsg() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.querySelector("form").className="bw";
			var resp = this.responseText;
			console.log(resp);
			//setTimeout(function() {
				eval(resp);
			//},5000);
		}
	}
	
	setTimeout(function() {
		xhttp.open("POST", "/server-java/AjaxCheck", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("step=0");
	},0);

	setInterval(
		function(){
			xhttp.open("POST", "/server-java/AjaxCheck", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("step=0");
		}
	,300000);
}
*/
function getMsg() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			/*首頁搜尋列跑馬*/
			if(!document.querySelector("#marquee")){
			document.querySelector("#nav").style.paddingLeft="32px";
			document.querySelector("#nav").innerHTML = "<style>#marquee{width:430px;}</style><marquee id='marquee' onMouseOver='this.stop()' onMouseOut='this.start()' behavior='side' direction='left' scrollamount='4''></marquee>";
			}else{
			document.querySelector("#marquee").innerHTML = "";
			};

			document.querySelector("form").className="bw";
			var resp = this.responseText;
			//console.log(resp);
			eval(resp);

			setTimeout(function(){getMsg()},20000);
		};
	};
	xhttp.open("POST", "/server-java/AjaxCheck", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("step=0");
};

getMsg();

function menuAction(fileName , usually){
	document.fh2.usually.value=usually;
	document.fh2.action="/mops/web/"+fileName;
	document.fh2.submit();
}

/**
(1) href='t146sb03'  要改為 href=\'t146sb03\'
(2) 有子項目的，在<ul>前面要加上<img src="arrow_r.gif" class="liArrow" />
**/
var menu0 = '\
			<li class = "L01_Item" onclick="menuAction(\'t05st03\' , \'Y\');">公司基本資料</li>\
			<li class = "L01_Item" onclick="menuAction(\'t05st10_ifrs\' , \'Y\');">採用IFRSs後之月營業收入資訊</li>\
			<li class = "L01_Pop">重大訊息<img src="arrow_r.gif" class="liArrow" /><ul>\
				<li class = "L02_Item" onclick="menuAction(\'t05sr01_1\' , \'Y\');">即時重大訊息</li>\
				<li class = "L02_Item" onclick="menuAction(\'t05st02\' , \'Y\');">當日重大訊息</li>\
				<li class = "L02_Item" onclick="menuAction(\'t05st01\' , \'Y\');">歷史重大訊息</li>\
			</ul>\
			</li>\
			<li class = "L01_Pop">財務報表<img src="arrow_r.gif" class="liArrow" /><ul>\
				<li class = "L02_Item" onclick="menuAction(\'t163sb01\' , \'Y\');">財務報告公告</li>\
				<li class = "L02_Item" onclick="menuAction(\'t164sb03\' , \'Y\');">資產負債表</li>\
				<li class = "L02_Item" onclick="menuAction(\'t164sb04\' , \'Y\');">綜合損益表</li>\
				<li class = "L02_Item" onclick="menuAction(\'t164sb05\' , \'Y\');">現金流量表</li>\
				<li class = "L02_Item" onclick="menuAction(\'t164sb06\' , \'Y\');">權益變動表</li>\
				<li class = "L02_Item" onclick="menuAction(\'t163sb15\' , \'Y\');">簡明綜合損益表(四季)</li>\
				<li class = "L02_Item" onclick="menuAction(\'t163sb16\' , \'Y\');">簡明資產負債表(四季)</li>\
				<li class = "L02_Item" onclick="menuAction(\'t163sb17\' , \'Y\');">簡明綜合損益表(三年)</li>\
				<li class = "L02_Item" onclick="menuAction(\'t163sb18\' , \'Y\');">簡明資產負債表(三年)</li>\
			</ul>\
			</li>\
			<li class = "L01_Pop">股東會及股利<img src="arrow_r.gif" class="liArrow" /><ul>\
				<li class = "L02_Item" onclick="menuAction(\'t05st09_2\' , \'Y\');">股利分派情形</li>\
				<li class = "L02_Item" onclick="menuAction(\'t108sb19_q1\' , \'Y\');">決定分配股息及紅利或其他利益</li>\
			</ul>\
			</li>\
			<li class = "L01_Pop">電子書<img src="arrow_r.gif" class="liArrow" /><ul>\
				<li class = "L02_Item" onclick="menuAction(\'t57sb01_q1\' , \'Y\');">財務報告書</li>\
				<li class = "L02_Item" onclick="menuAction(\'t57sb01_q3\' , \'Y\');">公開說明書</li>\
			</ul>\
			</li>\
			<li class = "L01_Item" onclick="menuAction(\'stapap1\' , \'Y\');">董監事持股餘額明細資料</li>\
			<li class = "L01_Item" onclick="menuAction(\'query6_1\' , \'Y\');">內部人持股異動事後申報表</li>\
			<li class = "L01_Item" onclick="menuAction(\'t100sb02_1\' , \'Y\');">法人說明會一覽表</li>\
			<li class = "L01_Pop">投資資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
				<li class = "L02_Item" onclick="menuAction(\'t05st15\' , \'Y\');">赴大陸投資資訊(實際數)</li>\
				<li class = "L02_Item" onclick="menuAction(\'t05st16\' , \'Y\');">投資海外子公司資訊(實際數)</li>\
			</ul>\
			</li>\
';

var menu1='\
							<li class = "L01_Item" onclick="window.location.href=\'t146sb05\';">精華版3.0</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t05st03\';">公司基本資料</li>\
							<li class = "L01_Pop">重要子公司基本資料<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t79sb02\';">重要子公司基本資料</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t79sb03\';">重要子公司異動說明</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t102sb01\';">被投資控股公司基本資料</li>\
							<li class = "L01_Pop">電子書<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_q1\';">財務報告書</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_q2\';">財務預測書</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_q3\';">公開說明書</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_q4\';">公開收購說明書(101年7月後請至「公開收購專區」查詢)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_2\';">公開招募說明書</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_q5\';">年報及股東會相關資料(含存託憑證資料)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'WDLReader\';">WDL Reader(請至威鋒數位軟體下載區下載)</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">董監大股東持股、質押、轉讓<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'stapap1_all\';">董事、監察人、經理人及大股東持股餘額彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'stapap1\';">董監事持股餘額明細資料</li>\
									<li class = "L02_Pop">內部人持股轉讓事前申報表(個別公司)<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb21_q1\';">持股轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb21_q2\';">持股未轉讓日報表</li>\
										</ul>\
									</li>\
									<li class = "L02_Pop">內部人持股轉讓事前申報彙總表<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb21_q3\';">持股轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb21_q4\';">持股未轉讓日報表</li>\
										</ul>\
									</li>\
									<li class = "L02_Pop">董監事股權異動統計彙總表<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB160\';">公司增減資表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB170\';">新公司彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB140\';">轉讓持股達100萬股以上者彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB150\';">取得股份達100萬股以上者彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB190\';">董事、監察人質權設定在100萬股以上彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB200\';">董事、監察人質權解除在100萬股以上彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB110\';">董事、監察人、經理人及百分之十以上大股東股權異動彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB130\';">董事、監察人、經理人及百分之十以上大股東質權設定彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'IRB180\';">董事、監察人質權設定佔董事及監察人實際持有股數彙總表</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'query6_1\';">內部人持股異動事後申報表</li>\
									<li class = "L02_Pop">內部人設質解質彙總公告<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'STAMAK03_q1\';">依照日期排序</li>\
											<li class = "L03_Item" onclick="window.location.href=\'STAMAK03_q2\';">依照公司代號排序</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'STAMAK03_1\';">內部人設質解質公告(個別公司)</li>\
									<li class = "L02_Pop">股權轉讓資料查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb12_q1\';">上市公司持股轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb12_q2\';">上櫃公司持股轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb12_q3\';">興櫃公司持股轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb12_q4\';">公開發行公司持股轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb12_q5\';">上市公司持股未轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb12_q6\';">上櫃公司持股未轉讓日報表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t56sb12_q7\';">興櫃公司持股未轉讓日報表</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'IRB100\';">董事、監察人持股不足法定成數彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'IRB210\';">董事、監察人持股不足法定成數連續達3個月以上彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t93sb06\';">公司董事、監察人及持股10%以上大股東為法人之彙總查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t93sb06_1\';"> 持股10%以上大股東最近異動情形</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">庫藏股(已移至「投資專區」項下「庫藏股資訊專區」)<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb00_1\';">申請庫藏股買回基本資料(已移至「投資專區」項下「庫藏股資訊專區」)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb00_2\';">申請庫藏買回達一定標準(已移至「投資專區」項下「庫藏股資訊專區」)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb00_3\';">查詢期間屆滿(執行完畢)及已辦理消除及轉讓股份(已移至「投資專區」項下「庫藏股資訊專區」)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb00_4\';">庫藏股轉讓予員工基本資料查詢(已移至「投資專區」項下「庫藏股資訊專區」)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb00_5\';">董事會決議變更買回股份轉讓員工辦法之公告事項查詢(已移至「投資專區」項下「庫藏股資訊專區」)</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">買回臺灣存託憑證<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb08\';">買回臺灣存託憑證基本資料</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb10\';">買回臺灣存託憑證達一定標準</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb09\';">查詢買回臺灣存託憑證期間屆滿或執行完畢</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'bfhtm_q1\';">募資計畫</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t05st05\';">歷年變更登記</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t16sn02\';">股權分散表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t98sb04\';">國內海外有價證券轉換情形</li>\
							<li class = "L01_Pop">國內有價證券<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb12\';">特別股權利基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb05\';">附認股權特別股基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb06\';">一般公司債基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb17\';">一般公司債月報表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb07\';">轉換公司債基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb18\';">轉換公司債月報表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb08\';">附認股權公司債基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb19\';">附認股權公司債月報表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb11\';">附認股權公司債利率查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb20\';">金融債券月報表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb01\';">分離後認股權憑證發行基本資料查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">海外有價證券<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb03_q1\';">海外股票基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb24\';">海外股票流通餘額報表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb03_q2\';">海外存託憑證基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb25\';">海外存託憑證暨其所表彰有價證券流通餘額查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb03_q3\';">海外一般公司債基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb21\';">海外一般公司債異動情形報表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb03_q4\';">海外轉換公司債基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb22\';">海外轉換公司債異動情形報表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb03_q5\';">海外附認股權公司債基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb23\';">海外附認股權公司債異動情形報表查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">員工認股權憑證<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sb09\';">員工認股權憑證基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t158sb02\';">員工認股權憑證發行次日暨經理人、部門及分支機構主管取得認股權憑證情形之申報資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t158sb05_new\';">員工認股權憑證發行期間屆滿次日暨經理人、部門及分支機構主管取得認股權憑證情形之申報資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t158sb03\';">員工認股權憑證經理人、部門及分支機構主管認購情形之資訊－認購次日內申報（自102年7月4日起免申報）</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t158sb04_new\';">員工認股權憑證經理人、部門及分支機構主管當季認購認股權情形資料－按季結束十日內申報</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47sc18\';">員工認股權憑證年度已執行及未執行資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t158sb01\';">員工認股權憑證年度經理人、部門及分支機構主管與前十大員工之取得及認購情形資訊</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">限制員工權利新股<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t160sb01\';">限制員工權利新股發行辦法及對股東權益可能稀釋情形(包含變更發行辦法、實際發行資料)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t160sb02\';">員工達成既得條件之解除限制資訊</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t111sb02\';">關係企業組織圖(自102年度起免申報)</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t98sb02\';">僑外投資持股情形統計表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t132sb20\';">外國發行人之股票、臺灣存託憑證、債券流通情形</li>\
';
var menu2='\
							<li class = "L01_Pop">基本資料<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb01\';">基本資料查詢彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t79sb04\';">重要子公司基本資料彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t47hsc01\';">國內公司發行海外存託憑證彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb00_6\';">庫藏股統計表(已移至「投資專區」項下「庫藏股資訊專區」)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb04_q1\';">員工認股權憑證基本資料彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t158sb06\';">員工認股權憑證實際發行資料及已(未)執行認股情形彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t160sb04\';">限制員工權利新股基本資料彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb04_q2\';">國內其他有價證券資料彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb03\';">海外有價證券基本資料彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t98sb05\';">轉換公司債轉換變動情形一覽表</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">股東會及股利<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Pop">股東會公告<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t108sb31_q1\';">召開股東常(臨時)會日期、地點及採用電子投票情形等資料彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t108sb26\';">召集股東常(臨時)會公告資料彙總表(95年度起適用)</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb11\';">採候選人提名制、累積投票制、全額連記法選任董監事及當選資料彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb09\';">股東行使提案權情形彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t150sb04\';">股東會議案決議情形</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t05sb12\';">普通股股利分派頻率暨普通股年度(含第4季或後半年度)現金股息及紅利決議層級彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st09_new\';">股利分派情形</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t66sb06\';">僅分派員工紅利及董監酬勞而未分派股利之公司查詢(自104年度起不適用)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t66sb23\';">TDR股利分派情形(101年起適用)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb27\';">除權息公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb31new\';">股東會及除權息日曆</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb02_1\';">法人說明會一覽表</li>\
							<li class = "L01_Pop">財務報表<img src="arrow_r.gif" class="liArrow" /><ul>\
								<li class = "L02_Pop">採用IFRSs後<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L03_Item" onclick="window.location.href=\'t163sb04\';">綜合損益表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t163sb05\';">資產負債表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t56sb29_q3\';">財務報告經監察人承認情形</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t163sb14\';">會計師查核(核閱)報告</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t163sb19\';">各產業EPS統計資訊</li>\
									</ul>\
								</li>\
								<li class = "L02_Pop">採用IFRSs前<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L03_Item" onclick="window.location.href=\'t51sb08\';">損益表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t51sb07\';">資產負債表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t51sb13\';">合併損益表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t51sb12\';">合併資產負債表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t132sb21\';">第一上市櫃損益季節查詢彙總表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t132sb22\';">第一上市櫃資產負債季節查詢彙總表</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t56sb29_q2\';">財務報告經監察人承認情形</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t06se09_1\';">會計師查核(核閱)報告</li>\
									</ul>\
								</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">財務預測<img src="arrow_r.gif" class="liArrow" /><ul>\
								<li class = "L02_Pop">採IFRSs後<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L03_Pop">財測達成情形<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L04_Item" onclick="window.location.href=\'t06sf09_1_q1\';">截至各季綜合損益財測達成情形(完整式)</li>\
										<li class = "L04_Item" onclick="window.location.href=\'t163sb11\';">年度自結綜合損益達成情形及差異原因(完整式)</li>\
										<li class = "L04_Item" onclick="window.location.href=\'t163sb12\';">年度實際綜合損益(經會計師查核)達成情形(完整式)</li>\
										<li class = "L04_Item" onclick="window.location.href=\'t06sf09_2_q1\';">各季綜合損益財測達成情形(簡式)</li>\
										<li class = "L04_Item" onclick="window.location.href=\'t06sf09_3_q1\';">當季綜合損益經會計師查核(核閱)數與當季預測數差異達百分之十以上者，<br>或截至當季累計差異達百分之二十以上者(簡式)</li>\
										</ul>\
									</li>\
									</ul>\
								</li>\
								<li class = "L02_Pop">採IFRSs前<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Pop">財測達成情形<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L04_Item" onclick="window.location.href=\'t06sf09_1\';">截至各季稅前損益財測達成情形</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t52sb01\';">年度自結稅前損益(未經會計師查核)達成情形</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t52sb02\';">年度實際稅前損益(經會計師查核)達成情形</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t06sf09_2\';">各季稅前損益財測達成情形(簡式)</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t06sf09_3\';">當季稅前損益經會計師查核(核閱)數與當季預測數差異達百分之十以上者，<br>或截至當季累計差異達百分之二十以上者(簡式)</li>\
											</ul>\
										</li>\
										<li class = "L03_Pop">處記缺失情形<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L04_Item" onclick="window.location.href=\'t52sc03_4\';">完整式處記缺失情形</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t52sc03_3\';">簡式處記缺失情形</li>\
											</ul>\
										</li>\
										<li class = "L03_Pop">財務預測相關資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L04_Item" onclick="window.location.href=\'t21sc02\';">完整式</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t21sc02_1\';">簡式</li>\
											</ul>\
										</li>\
										<li class = "L03_Item" onclick="window.location.href=\'finance_w1\';">上市公司各季財測彙總資料</li>\
										<li class = "L03_Pop">期間別財測公告情形<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L04_Item" onclick="window.location.href=\'t56sb02n_1_all\';">完整式財務預測彙總查詢</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t56sball_1\';">簡式財務預測彙總查詢</li>\
											</ul>\
										</li>\
										<li class = "L03_Pop">合併財務預測相關資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L04_Item" onclick="window.location.href=\'t21sc02c\';">完整式</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t21sc02_1c\';">簡式</li>\
											</ul>\
										</li>\
									</ul>\
								</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">公告<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t67sb07\';">取得或處分資產公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t116sb02\';">取得或處分私募有價證券公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t100hsb05\';">董事會議決事項未經審計委員會通過，或獨立董事有反對或保留意見公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t138sb01\';">自結損益公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t132sb16\';">公開發行股票全面轉換無實體發行公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06hsb07\';">財務報告無虛偽或隱匿聲明書公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06hsb09\';">會計主管不符資格條件調整職務公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb08_1_q1\';">轉換(附認股權)公司債公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t127sb00_q1\';">普通公司債暨金融債券公告</li>\
									<li class = "L02_Pop">海外公司債公告<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t47sb03_q6\';">海外一般公司債</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t47sb03_q7\';">海外轉換公司債</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t47sb03_q8\';">海外附認股權公司債</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb02\';">分離後認股權憑證之公告</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">營運概況<img src="arrow_r.gif" class="liArrow" /><ul>\
								<li class = "L02_Pop">每月營收<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L03_Item" onclick="window.location.href=\'t21sc04_ifrs\';">採用IFRSs後每月營業收入彙總表</li>\
									<li class = "L03_Pop">採用IFRSs前營業收入彙總表<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L04_Item" onclick="window.location.href=\'t21sc04\';">每月營業收入統計彙總表</li>\
										<li class = "L04_Item" onclick="window.location.href=\'t21sb06\';">每月合併營業收入統計彙總表</li>\
									</ul>\</li>\
									<li class = "L03_Item" onclick="window.location.href=\'t05st08_all\';">各項產品業務營收統計彙總表</li>\
									</ul>\
								</li>\
								<li class = "L02_Pop">財務比率分析<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L03_Item">採IFRSs後<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "Level04_ItemStyle" onclick="window.location.href=\'t51sb02_q1\';">財務分析資料查詢彙總表</li>\
											<li class = "Level04_ItemStyle" onclick="window.location.href=\'t163sb06\';">營益分析查詢彙總表</li>\
											<li class = "Level04_ItemStyle" onclick="window.location.href=\'t163sb07\';">毛利率彙總表</li>\
										</ul>\
									</li>\
									<li class = "L03_Item">採IFRSs前<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "Level04_ItemStyle" onclick="window.location.href=\'t51sb02\';">財務分析資料查詢彙總表</li>\
											<li class = "Level04_ItemStyle" onclick="window.location.href=\'t51sb06\';">營益分析查詢彙總表</li>\
											<li class = "Level04_ItemStyle" onclick="window.location.href=\'t51sb05\';">毛利率彙總表</li>\
										</ul>\
									</li>\
									</ul>\
								</li>\
								<li class = "L02_Item" onclick="window.location.href=\'t05st16_all\';">投資海外子公司資訊彙總表</li>\
								<li class = "L02_Item" onclick="window.location.href=\'t92sb05\';">赴大陸投資資料查詢彙總表</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t51sb01_1\';">下市/下櫃/撤銷登錄興櫃/不繼續公開發行彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'edco_w\';">初次上市(櫃)公司(IPO)穩定價格措施</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t116sb01_new\';">辦理私募之應募人為內部人或關係人</li>\
';
var menu3='\
							<li class = "L01_Pop">股東常會(臨時會)公告<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb16_q1\';">召開股東常(臨時)會及受益人大會(94.5.5後之上市櫃/興櫃公司)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t59sb06\';">召開股東常(臨時)會(公開發行及94.5.5前之全體公司)</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.open(\'http://cgc.twse.com.tw/electronicVoting/chPage\');">股東常會採行電子投票之上市櫃公司名單彙總表</li>\
							<li class = "L01_Pop">除權息公告<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb19_q1\';">決定分配股息及紅利或其他利益(94.5.5後之上市櫃/興櫃公司)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t59sb07\';">決定分派股息及紅利或其他利益(公開發行及94.5.5前之全體公司)</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t05st09_2\';">股利分派情形</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t66sb20\';">TDR股利分派情形-經董事會通過擬議者適用</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t66sb21\';">TDR股利分派情形-經股東會通過者適用</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t66sb22\';">TDR股利分派情形-僅需董事會通過無需經股東會通過者適用</li>\
';
//20181218 調整順序
var menu4='\
							<li class = "L01_Pop">公司治理結構<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t100sb01_1\';">公司治理組織架構部分(含董事會組成之基本資訊)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t100sb03_1\';">設立功能性委員會及組織成員</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb10_w\';">年報前十大股東相互間關係彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb08\';">董事長兼任總經理情形彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t100sb04_1\';">訂定公司治理之相關規程規則</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">董事及監察人相關資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t100sb07\';">董事及監察人出(列)席董事會及進修情形暨獨立董事現職、經歷及兼任情形(個別)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t93sc01_1\';">獨立董事現職、經歷及兼任情形彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t93sc03_1\';">董事及監察人出(列)席董事會及進修情形彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t93sb05\';">獨立董事設置情形</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t119sb07\';">員工酬勞及董事、監察人酬勞資訊彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t119sb04\';">董監事酬金相關資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t119sb05\';">公司年度稅後虧損惟董監事酬金總金額或平均每位董監事酬金卻增加</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t119sb06\';">稅後損益與董監酬金變動之關聯性與合理性</li>\
									<li class = "L02_Item" onclick="window.location.href=\'IRB100_q1\';">董事、監察人持股不足法定成數彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t135sb03\';">董事及監察人投保責任險情形</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t167sb01\';">依據「上市上櫃公司治理實務守則」第24條規定公告彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t167sb02\';">自願揭露退休董事長或總經理回任公司顧問</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">股東常會相關之公司治理統計資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'http://cgc.twse.com.tw/nomination/chPage\';">採候選人提名制之上市櫃公司</li>\
									<li class = "L02_Item" onclick="window.location.href=\'http://cgc.twse.com.tw/enProcedureManual/chPage\';">股東常會提供英文議事手冊之上市櫃公司</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">企業社會責任相關資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t152sb01\';">溫室氣體排放及減量資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t100sb11\';">企業社會責任報告書</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t114sb07\';">分派員工酬勞之經理人姓名及分派情形</li>\
									<li class = "L02_Pop">員工福利及薪酬統計相關資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t100sb14\';">財務報告附註揭露之員工福利(薪資)資訊</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t100sb15\';">非擔任主管職務之全時員工薪資資訊</li>\
										<li class = "L03_Pop">員工福利政策及權益維護措施揭露<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L04_Item" onclick="window.location.href=\'t100sb12\';">個別公司查詢</li>\
											<li class = "L04_Item" onclick="window.location.href=\'t100sb13\';">彙總資料查詢</li>\
										</ul>\
									</ul>\
								</ul>\
							</li>\
							<li class = "L01_Pop">內部控制專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t06sg20\';">內控聲明書公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06hsg20\';">內部控制專案審查報告</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">投保中心對公司起訴或公司已依規發布重大訊息之訴訟案件<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'sfipc_w\';">投保中心現正進行中之團體求償相關訴訟案件</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb07\';">公司已依規發布重大訊息之訴訟案件</li>\
								</ul>\
							</li>\
';
/*
var menu4='\
                            <li class = "L01_Item" onclick="window.open(\'http://cgc.twse.com.tw/electronicVoting/chPage\');">於股東常會採行電子投票之上市櫃公司</li>\
							<li class = "L01_Item" onclick="window.open(\'http://cgc.twse.com.tw/nomination/chPage\');">採候選人提名制之上市櫃公司</li>\
                            <li class = "L01_Item" onclick="window.open(\'http://cgc.twse.com.tw/ballotCase/chPage\');">於股東常會採行逐案票決之上市櫃公司彙總表</li>\
                            <li class = "L01_Item" onclick="window.open(\'http://cgc.twse.com.tw/enProcedureManual/chPage\');">股東常會提供英文議事手冊之上市櫃公司</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb01_1\';">公司治理組織架構部分</li>\
							<li class = "L01_Pop">內部控制專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t06sg20\';">內控聲明書公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06hsg20\';">內部控制專案審查報告</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb07\';">董事及監察人出(列)席董事會及進修情形暨獨立董事現職、經歷及兼任情形(個別)</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t93sc01_1\';">獨立董事現職、經歷及兼任情形彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t93sc03_1\';">董事及監察人出(列)席董事會及進修情形彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t93sb05\';">獨立董事設置情形</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t119sb07\';">員工酬勞及董事、監察人酬勞資訊彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t119sb04\';">董監事酬金相關資訊</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t119sb05\';">公司年度稅後虧損惟董監事酬金總金額或平均每位董監事酬金卻增加</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t119sb06\';">稅後損益與董監酬金變動之關聯性與合理性</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t167sb02\';">自願揭露退休董事長或總經理回任公司顧問</li>\
							<li class = "L01_Item" onclick="window.location.href=\'IRB100_q1\';">董事、監察人持股不足法定成數彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t135sb03\';">董事及監察人投保責任險情形</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb03_1\';">設立功能性委員會及組織成員</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb04_1\';">訂定公司治理之相關規程規則</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb10\';">公司治理自評報告(自2014/10/13起停止上傳)</li>\
							<li class = "L01_Item" onclick="window.location.href=\'http://mops.twse.com.tw/nas/protect/report.pdf\';">「薪資報酬委員會運作效益之衡量與評估」調查報告</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t135sb02\';">依證交法第14條之4設立審計委員會彙總表(已移至「設立功能性委員會及組織成員」項下查詢)</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t114sb07\';">分派員工酬勞之經理人姓名及分派情形</li>\
							<li class = "L01_Pop">投保中心對公司起訴或公司已依規發布重大訊息之訴訟案件<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'sfipc_w\';">投保中心現正進行中之團體求償相關訴訟案件</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t144sb07\';">公司已依規發布重大訊息之訴訟案件</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t144sb08\';">董事長兼任總經理情形彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'cga_w\';">通過中華公司治理協會「公司治理制度評量」認證之公司名單</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t144sb10_w\';">年報前十大股東相互間關係彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'best_company_w\';">公司治理網站揭露較佳參考範例</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t152sb01\';">溫室氣體排放及減量資訊</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t167sb01\';">依據「上市上櫃公司治理實務守則」第24條規定公告彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb11\';">企業社會責任報告書</li>\
							<li class = "L01_Pop">員工福利政策及權益維護措施揭露<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t100sb12\';">個別公司查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t100sb13\';">彙總資料查詢</li>\
								</ul>\
							</li>\
';	
*/			
/*
							<li class = "L01_Pop">內部控制專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t06sg20\';">內控聲明書公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06hsg20\';">內部控制專案審查報告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06sb06\';">內部稽核單位基本資料</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06sb04\';">內部控制主要缺失與改善情形</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t06sb05\';">內部控制及內部稽核運作情形查詢作業</li>\
								</ul>\
							</li>\

*/
var menu5='\
							<li class = "L01_Pop">採IFRSs後<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t163sb01\';">財務報告公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t56sb31_q1\';">財務報告更(補)正查詢作業</li>\
									<li class = "L02_Pop">財務預測公告<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb10\';">財務預測公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t66sb02_q1\';">實際數與自結數差異公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t66sb03_q1\';">實際數與預測數差異公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t66sb04_q1\';">年度終了預計損益表達成情形公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb11_q1\';">年度自結綜合損益達成情形及差異原因(完整式)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb12_q1\';">年度實際綜合損益(經會計師查核)達成情形(完整式)</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">合併/個別報表<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t164sb03\';">資產負債表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t164sb04\';">綜合損益表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t164sb05\';">現金流量表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t164sb06\';">權益變動表</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">簡明報表<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb15\';">簡明綜合損益表(四季)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb16\';">簡明資產負債表(四季)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb17\';">簡明綜合損益表(三年)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb18\';">簡明資產負債表(三年)</li>\
									</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t163sb03\';">會計師查核(核閱)報告</li>\
									<li class = "L02_Pop">財務預測報表(完整式)<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb13a\';">財務預測-資產負債表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb13b\';">財務預測—綜合損益表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb13c\';">財務預測—簡明財測資料</li>\
									</ul>\
									</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">採IFRSs前<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t56sb01n_1\';">財務報告公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t56sb31\';">財務報告更(補)正查詢作業</li>\
									<li class = "L02_Pop">財務預測公告<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t56sb02n_1_q1\';">原編公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t56sb02n_1_q2\';">更新/更正/重編公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t56sb02n_1_q3\';">仍屬有效公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t56sb02n_1_q4\';">不適用之公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t56sb02n_1_q5\';">簡式財務預測公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t56sb02n_1c_q1\';">合併財務預測公告原編</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t56sb02n_1c_q2\';">合併財務預測公告更新/更正/重編)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t66sb04\';">年度終了預計損益表達成情形及差異原因公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t66sb02\';">實際數與自結數差異公告</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t66sb03\';">實際數與預測數差異公告</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">個別報表<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st32\';">損益表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st31\';">資產負債表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st35\';">股東權益變動表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st36\';">現金流量表</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">合併報表<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st34\';">損益表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st33\';">資產負債表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st38\';">股東權益變動表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st39\';">現金流量表</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">簡明報表<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st21\';">簡明損益表(三年)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st20\';">簡明資產負債表(三年)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st30\';">簡明損益表(四季)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st29\';">簡明資產負債表(四季)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st30_c\';">簡明合併損益表(四季)</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st29_c\';">簡明合併資產負債表(四季)</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">會計師查核(核閱)報告<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st37\';">個別</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st40\';">合併</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t20sb01c\';">合併關係企業</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">財務預測報表(完整式)<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st23e_q2\';">財務預測-損益表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st23e_q3\';">財務預測-簡明財測資料</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st23e_q1\';">財務預測-資產負債表</li>\
									</ul>\
									</li>\
									<li class = "L02_Pop">合併關係企業財務報表<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t20sb01a\';">資產負債表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t20sb01b\';">損益表</li>\
									</ul>\
									</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">XBRL資訊平台<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t203sb01\';">單一公司案例文件查詢及下載</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t203sb02\';">案例文件整批下載</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t203sb03\';">分類標準下載</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.open(\'http://mopsfin.twse.com.tw/\');">財務比較e點通</li>\
							<li class = "L01_Item" onclick="window.open(\'http://mopsfin.twse.com.tw/brkfin/\');">證券商財務資料動態查詢系統</li>\
';
var menu6='\
							<li class = "L01_Item" onclick="window.location.href=\'t05sr01_1\';">即時重大訊息</li>\
							<li class = "L01_Pop">重大訊息綜合查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st02\';">當日重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st01\';">歷史重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb10_q1\';">重大訊息主旨全文檢索</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t132sb12\';">臺灣存託憑證收盤價彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t100sb07_1\';">法說會</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t146sb10\';">公告查詢</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t178sb01\';">券商對媒體轉載之澄清或說明</li>\
';
var menu7='\
							<li class = "L01_Pop">每月營收<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st10_ifrs\';">採用IFRSs後之月營業收入資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st10\';">採用IFRSs前之開立發票及營業收入資訊(含合併營收)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st08\';">各項產品業務營收統計表</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">資金貸與及背書保證<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st11\';">背書保證與資金貸放餘額資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t65sb04\';">資金貸與及背書保證明細表資訊</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t79sb01\';">重要子公司月營收、背書保證及資金貸放餘額</li>\
							<li class = "L01_Pop">關係人交易專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st11_q2\';">背書保證與資金貸放餘額明細</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t65sb04_q2\';">資金貸與及背書保證明細表資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t79sb01_q2\';">重要子公司月營收、背書保證與資金貸放餘額</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t12sc01_q2\';">月取得或處分資產資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t141sb02\';">與關係人取得處分資產、進貨銷貨、應收及應付款項相關資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t141sb03\';">關係人交易申報數與查核（核閱）數差異說明</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t12sc01_q3\';">財務資料表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t12sc01_q1\';">母子公司交互資訊(自102年6月起免申報)</li>\
							<li class = "L01_Pop">赴大陸投資資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st15\';">赴大陸投資資訊（實際數）</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t92sb01\';">赴大陸投資資訊（自結數）</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">投資海外子公司資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st16\';">投資海外子公司資訊（實際數）</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t92sb03\';">投資海外子公司資訊（自結數）</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">財務比率分析<img src="arrow_r.gif" class="liArrow" /><ul>\
								<li class = "L02_Pop">採IFRSs後<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb08\';">營益分析表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st22_q1\';">財務分析資料</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t163sb09\';">毛利率</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st25_q1\';">存貨週轉率</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st26_q1\';">應收帳款周轉率</li>\
									</ul>\
								</li>\
								<li class = "L02_Pop">採IFRSs前<img src="arrow_r.gif" class="liArrow" /><ul>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st24\';">營益分析表</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st22\';">財務分析資料</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st27\';">毛利率</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st25\';">存貨周轉率</li>\
										<li class = "L03_Item" onclick="window.location.href=\'t05st26\';">應收帳款周轉率表</li>\
									</ul>\
								</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t15sf\';">衍生性商品交易資訊</li>\
							<li class = "L01_Pop">自結損益公告<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t138sb02_q1\';">自結損益公告-月申報</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t138sb02_q2\';">自結損益公告-季申報</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">創業投資公司投資資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t193sb01\';">創業投資公司查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t193sb02\';">創業投資公司每月投資資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t193sb03\';">創業投資公司每季投資資訊-被投資公司資訊</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t193sb04\';">未投資資金投資上市（櫃）有價證券資訊</li>\
								</ul>\
							</li>\
';
var menu8='\
							<li class = "L01_Pop">銀行(金融控股公司)大股東持股變動及設質情形專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t142sb01\';">銀行(金融控股公司)大股東持股變動情形申報表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t142sb02\';">銀行(金融控股公司)大股東設質情形申報表查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">財務重點專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Pop">上市公司<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb04_q1\';">股票停止買賣者</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb05_q1\';">變更交易方法者</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb06_q1\';">全體上市公司</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb14\';">全體第一上市公司</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb09_q1\';">按產業類別查詢</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb10_q1\';">按個別公司查詢</li>\
										</ul>\
									</li>\
									<li class = "L02_Pop">上櫃公司<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb04_q2\';">股票停止買賣者</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb05_q2\';">變更交易方法者</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb11_q1\';">管理股票</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb06_q2\';">全體上櫃公司</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb14_q1\';">全體第一上櫃公司</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb09_q2\';">按產業類別查詢</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb10_q2\';">按個別公司查詢</li>\
										</ul>\
									</li>\
									<li class = "L02_Pop">興櫃公司<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb04_q3\';">股票停止買賣者</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb06_q3\';">全體興櫃公司</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb22\';">全體外國興櫃公司</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb09_q3\';">按產業類別查詢</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t123sb10_q3\';">按個別公司查詢</li>\
										</ul>\
									</li>\
									<li class = "L02_Pop" onclick="window.location.href=\'t123sb01_TDR\';">TDR發行公司</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">受輔導專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t68sb01_q1\';">輔導中公司名單</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t68sb01_q2\';">外國企業輔導中公司名單</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t68sb02\';">暫停或終止輔導公司名單</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t68sh02\';">重大事項對公司財務業務影響情形之公告查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'bfhtm_q2\';">募資計劃執行專區</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t51sb09\';">採彈性面額(每股面額非新台幣10元)公司專區</li>\
							<li class = "L01_Pop">外國企業第一上市櫃專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t132sb02\';">個別公司資訊</li>\
									<li class = "L02_Pop">彙總報表<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Pop">採用IFRSs後<img src="arrow_r.gif" class="liArrow" /><ul>\
												<li class = "L04_Item" onclick="window.location.href=\'t132sb23\';">外國企業各季損益表</li>\
												<li class = "L04_Item" onclick="window.location.href=\'t132sb24\';">外國企業各季資產負債季節查詢彙總表</li>\
												<li class = "L04_Item" onclick="window.location.href=\'t132sb25\';">外國企業財務分析</li>\
												</ul>\
											</li>\
											<li class = "L03_Pop">採用IFRSs前<img src="arrow_r.gif" class="liArrow" /><ul>\
												<li class = "L04_Item" onclick="window.location.href=\'t132sb21_q1\';">外國企業各季損益表</li>\
												<li class = "L04_Item" onclick="window.location.href=\'t132sb22_q1\';">外國企業各季資產負債季節查詢彙總表</li>\
												<li class = "L04_Item" onclick="window.location.href=\'t51sb02_q2\';">外國企業財務分析</li>\
												</ul>\
											</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t51sb01_q1\';">外國企業基本資料彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t108sb26_q1\';">外國企業召開股東常(臨時)會公告資料</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t05st09_new_q1\';">外國企業股利分派情形</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t108sb27_q1\';">外國企業除權息公告</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t21sc04_ifrs_q1\';">外國企業每月營業收入</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t138sb01_q1\';">外國企業自結損益</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t100sb02_1_q1\';">外國企業法人說明會一覽表</li>\
										</ul>\
									</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">臺灣存託憑證專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t132sb05_1\';">個別公司資訊</li>\
									<li class = "L02_Pop">彙總報表<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t132sb05_2\';">臺灣存託憑證收盤價彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t132sb05_3\';">臺灣存託憑證發行人簡明財務報表彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t132sb05_4\';">臺灣存託憑證發行人財務報告更(補)正查詢作業</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t132sb05_5\';">臺灣存託憑證發行單位數一覽表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t132sb05_6\';">原股上市地財務報告公告期限彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t132sb05_7\';">臺灣存託憑證財務重點專區 </li>\
										</ul>\
									</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t132sb08\';">科技事業專區</li>\
							<li class = "L01_Pop">私募專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t116sb01\';">私募資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t116sb03\';">投保中心新聞稿查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t105sb01\';">債信專區</li>\
							<li class = "L01_Pop">基金資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb11_q2\';">基金基本資料彙總表</li>\
									<li class = "L02_Pop">封閉型基金<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb01_q1\';">基金每日淨資產價值彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb02_q1\';">基金每週投資產業類股比例彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb03_q1\';">基金每月持股前五大個股彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb04_q1\';">基金每季投資個股彙總表</li>\
										</ul>\
									</li>\
									<li class = "L02_Pop">國內成分證券指數股票型基金<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb35\';">基金每日淨資產價值</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb02_q2\';">基金每週投資產業類股比例</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb03_q2\';">基金每月持股前五大個股</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb04_q2\';">基金每季持股明細表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb05\';">基金淨值及指數歷史表現比較表</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t78sb30\';">連結式指數股票型基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t78sb31\';">境外指數股票型基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t78sb32\';">國外成分/加掛外幣證券指數股票型基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t78sb33\';">槓桿/反向/加掛外幣指數股票型基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t78sb34\';">指數/加掛外幣股票型期貨信託基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t78sb21\';">最近三月歷史重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t78sb20\';">歷史重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t51sb11\';">櫃買基金基本資料彙總表</li>\
									<li class = "L02_Pop">櫃買國內成分股及債券成分之指數股票型基金<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'o_t78sb01\';">櫃買基金每日淨資產價值彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'o_t78sb02\';">櫃買基金每週投資產業類股比例彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'o_t78sb03\';">櫃買基金每月持股前五大個股彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'o_t78sb05\';">櫃買基金淨值及指數歷史表現比較表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'o_t78sb04\';">櫃買基金每季投資個股彙總表</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t78sb32\';">櫃買國外成分股及債券成分/加掛外幣之指數股票型基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t78sb33\';">櫃買槓桿/反向/加掛外幣指數股票型基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t78sb34\';">櫃買指數/加掛外幣股票型期貨信託基金</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t78sb21\';">櫃買基金最近三月歷史重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t78sb20\';">櫃買基金歷史重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb30\';">基金、ETF、REITs公告彙總查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_q6\';">基金財務報告書</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t57sb01_q7\';">基金公開說明書</li>\
									<li class = "L02_Pop">ETF發行單位(轉換)數異動查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t78sb36\';">上市ETF</li>\
											<li class = "L03_Item" onclick="window.location.href=\'o_t78sb36\';">上櫃ETF</li>\
										</ul>\
									</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">ETN資訊<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb05\';">ETN個別基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb06\';">ETN彙總基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb01\';">每日指標價值</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb03\';">每月資金運用情形</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb04\';">歷史表現表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb07\';">重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb08\';">公告查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb09\';">公開說明書</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t204sb02\';">發行單位數異動查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">信用評等專區<img src="arrow_r.gif" class="liArrow" /><ul>\
								<li class = "L02_Pop">證券商信用評等專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t109sb03_w1\';">證券商代號查詢</li>\
										<li class = "L02_Item" onclick="window.location.href=\'t109sb02_w1\';">證券商信用評等資料查詢</li>\
									</ul>\
								</li>\
								<li class = "L02_Pop" onclick="window.location.href=\'t191sb01\';">上市公司信用評等專區</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">證券商資本適足比率及風險管理資訊專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t122sb01_q1\';">證券商風險管理相關品質化資訊查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t17sc13_1_w1\';">證券商資本適足比率資訊查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">ETF專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L01_Item" onclick="window.location.href=\'http://www.twse.com.tw/zh/ETF/news\';">上市ETF專區</li>\
									<li class = "L01_Item" onclick="window.open(\'http://www.tpex.org.tw/web/link/index.php?l=zh-tw&t=545&s=6\');">上櫃ETF專區</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t168sb01\';">金管會證券期貨局裁罰案件專區</li>\
							<li class = "L01_Pop">違反資訊申報、重大訊息及說明記者會規定專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t132sb17\';">上市公司</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t132sb17\';">上櫃公司</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t132sb17_q1\';">興櫃公司</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">公開收購資訊專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t162sb01\';">公開收購資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t162sb02\';">公開收購統計彙總表</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">庫藏股資訊專區<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb01_q1\';">庫藏股買回基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb01_q2\';">庫藏買回達一定標準查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb01_q3\';">期間屆滿(執行完畢)公告事項查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb06\';">庫藏股轉讓予員工基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sb07\';">董事會決議變更買回股份轉讓員工辦法之公告事項查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t35sc09\';">庫藏股統計彙總表</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t174sb01_q1\';">經營權及營業範圍異(變)動專區</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t189sb01\';">企業併購法資訊專區</li>\
';
var menu9='\
							<li class = "L01_Item" onclick="window.location.href=\'t90sbfa01\';">認購(售)權證搜尋器</li>\
							<li class = "L01_Pop">權證庫存不足500張彙總表<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t90sb03\';">上市權證造市專戶庫存不足500張彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t90sb03\';">上櫃權證造市專戶庫存不足500張彙總表</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">個別權證基本資料查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st48_q1\';">上市認購（售）權證個別權證基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t05st48_q2\';">上櫃認購（售）權證個別權證基本資料查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">權證基本資料彙總查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t90sb01\';">認購（售）權證基本資料彙總表（含下市權證）</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t110sb02\';">上市、櫃認購（售）權證基本資料彙總查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">認購(售)權證履約價格／履約點數重設公告彙總表查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t95sb03\';">上市認購（售）權證履約價格／履約點數重設公告彙總表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t95sb03\';">上櫃認購（售）權證履約價格／履約點數重設公告彙總表查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">認購(售)權證履約價格及行使比例調整公告彙總表查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t95sb02\';">上市認購（售）權證履約價格及行使比例調整公告彙總表查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t95sb02\';">上櫃認購（售）權證履約價格及行使比例調整公告彙總表查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t150sb02\';">國內標的之上市（櫃）認購（售）權證到期日結算價格／結算點數彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t132sb11\';">上市、櫃認購(售)權證發行人累計註銷權證數量彙總表查詢</li>\
							<li class = "L01_Pop">國內標的查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb11_q1\';">上市認購（售）權證（含牛熊證）標的證券為ETF查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t51sb11_otc\';">上櫃認購（售）權證（含牛熊證）標的證券為ETF查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t111sb01\';">上市認購（售）權證（含牛熊證）標的證券查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t111sb01\';">上櫃認購（售）權證（含牛熊證）標的證券查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t95sb06\';">上市認購（售）權證（含牛熊證）標的指數查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t95sb06\';">上櫃認購（售）權證（含牛熊證）標的指數查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t95sb07\';">上櫃認購(售)權證(含牛熊證)其他標的查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t33sb03\';">上市期貨型權證標的查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t33sb03\';">上櫃期貨型權證標的查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">發行人公告查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t95sb01\';">上市認購（售）權證發行人公告查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t95sb01\';">上櫃認購（售）權證發行人公告查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">認購(售)權證公開銷售說明書查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t33sbAfa03\';">上市認購(售)權證公開銷售說明書查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t33sbAfa03\';">上櫃認購(售)權證公開銷售說明書查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">發行人基本資料查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb05_q1\';">上市認購（售）權證發行人基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb05_q2\';">上櫃認購（售）權證發行人基本資料查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">重大訊息<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb01_q1\';">上市認購（售）權證發行人即時重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb01_q2\';">上櫃認購（售）權證發行人即時重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb04_q1\';">上市認購（售）權證當日重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb04_q2\';">上櫃認購（售）權證當日重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb02_q1\';">上市認購（售）權證歷史重大訊息</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t49asb02_q2\';">上櫃認購（售）權證歷史重大訊息</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t129sb01\';">發行人發行海外認購(售)權證基本資料查詢</li>\
                                 <li class = "L01_Pop">國外標的查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t150sb01\';">外國標的收盤資訊彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t33sb01\';">上市認購(售)權證之外國標的彙總查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'o_t33sb02\';">上櫃認購(售)權證之外國標的彙總查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t153sb01_q1\';">上市權證外國標的公司公告資訊查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t153sb01_q2\';">上櫃權證外國標的公司公告資訊查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t95sb07\';">權證發行資料彙總表查詢</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t33sbAfa01\';">認購(售)權證可能達到上（下）限價格或指數彙總表</li>\
							<li class = "L01_Item" onclick="window.location.href=\'t33sbAfa02\';">認購(售)權證當日達到上（下）限價格或指數彙總表</li>\
';
var menu10='\
							<li class = "L01_Pop">綜合資料查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Pop">債券發行資訊查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t120sb02_q1\';">最近三個月現況查詢</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t120sb02_q2\';">歷史資料查詢(未含最近三個月資料)</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sg03\';">債券訊息市場公告</li>\
									<li class = "L02_Pop">債券相關彙總報表查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t120sg08_w1\';">新發行債券狀況一覽表 </li>\
											<li class = "L03_Item" onclick="window.location.href=\'t120sg08_w2\';">債券上櫃掛牌及到期下櫃明細彙總表</li>\
										</ul>\
									</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">政府債券<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q3\';">歷史資料查詢(未含最近三個月資料)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q4\';">最近三個月現況查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">普通公司債<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q5\';">歷史資料查詢(未含最近三個月資料)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q6\';">最近三個月現況查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">金融債券<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q7\';">歷史資料查詢(未含最近三個月資料)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q8\';">最近三個月現況查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_w1\';">各銀行金融債未發行餘額狀況</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">轉(交)換公司債與附認股權公司債<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q9\';">歷史資料查詢(未含最近三個月資料)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb02_q10\';">最近三個月現況查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">外國發行人之債券(股權商品未於我國掛牌交易者)<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t113sb01_1\';">國外公司代號查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t113sb01\';">發行人基本資料</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t113sb02\';">外幣計價國際債券及新台幣計價外國債券基本資料查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t113sb03\';">年報電子資料查詢作業</li>\
									<li class = "L02_Pop">債券重大訊息查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L02_Item" onclick="window.location.href=\'t113sb04_q1\';">當日重大訊息查詢</li>\
											<li class = "L02_Item" onclick="window.location.href=\'t113sb04_q2\';">歷史重大訊息查詢</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t198sb04_q1\';">債券到期前餘額變動各項公告查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t198sb03\';">綠色債券評估意見或資金運用情形公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t113sb05\';">債息對照表查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t113sb06\';">銷售說明書查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t113sb07\';">公開說明書查詢作業</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.open(\'http://www.gretai.org.tw/ch/bond/publish/international_bond_search/memo.php\');">國際債券</li>\
							<li class = "L01_Pop">分割債券<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w56\';">代碼一覽表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w57\';">資料表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w58\';">債利息分攤基礎表</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">公告<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb08_1_q2\';">轉換(附認股權)公司債公告彙總表</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t127sb00_q2\';">普通公司債暨金融債券各項公告查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t108sb08\';">轉換(附認股權)公司債公告(94.5.5起適用)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t59sb09\';">發行新股、公司債暨有價證券交付或發放股利前辦理之公告(公司法第252及273條)</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t56sb24\';">債券訊息市場公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t198sb01\';">綠色債券評估意見或資金運用情形公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t59sb08\';">股票或公司債核准上市(櫃)或終止上市(櫃)之公告</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t59sb12\';">因轉換公司債、附認股權公司債轉換而發行新股公告</li>\
									<li class = "L02_Item" onclick="window.open(\'http://web2.twsa.org.tw/bond\');">普通公司債承銷公告(僅限銷售予專業投資人)</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop">債券法規查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w001\';">全部相關法規</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w002\';">政府債券</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w003\';">普通公司債及金融債券</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w004\';">外國債券/國際債券</li>\
									<li class = "L02_Item" onclick="window.location.href=\'t120sb04_w005\';">證券法令規章</li>\
								</ul>\
							</li>\
							<li class = "L01_Pop" onclick="window.open(\'http://www.tpex.org.tw/web/bond/link/index.php?l=zh-tw&t=2&s=6\');">交易資訊</li>\
';
var menu11='\
							<li class = "L01_Pop">綜合資料查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t112sb02_q1\';">證券資訊查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t127sb06\';">資產證券化各項商品流通在外餘額統計表</li>\
									<li class = "L02_Pop">受益證券每日淨資產價值彙整表查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
											<li class = "L03_Item" onclick="window.location.href=\'t112sb01_q5\';">不動產投資信託受益證券每日淨資產價值彙總表</li>\
											<li class = "L03_Item" onclick="window.location.href=\'t112sb01_q6\';">不動產資產信託受益證券每日淨資產價值彙總表</li>\
										</ul>\
									</li>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t112sb07\';">重大訊息查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t112sb08\';">公告事項查詢</li>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t112sb14_q2\';">債息對照表查詢作業</li>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t112_w01\';">私募證券化受益證券資訊揭露</li>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t56sb25\';">資產池查詢</li>\
								</ul>\
							</li>\
							<li class = "L01_Item" onclick="window.location.href=\'p_t112sb02_q2\';">依證券代號、受託機構或特殊目的公司代號查詢</li>\
							<li class = "L01_Item" onclick="window.location.href=\'p_t112sb03\';">不動產投資信託受益證券</li>\
							<li class = "L01_Item" onclick="window.location.href=\'p_t112sb04\';">不動產資產信託受益證券</li>\
							<li class = "L01_Item" onclick="window.location.href=\'p_t112sb05\';">金融資產受益證券</li>\
							<li class = "L01_Item" onclick="window.location.href=\'p_t112sb06\';">金融資產基礎證券</li>\
							<li class = "L01_Item" onclick="window.location.href=\'p_t57sb01_w\';">電子書查詢</li>\
							<li class = "L01_Item" onclick="window.open(\'http://www.tpex.org.tw/web/bond/link/index.php?l=zh-tw&t=2&s=6\');">交易資訊查詢</li>\
							<li class = "L01_Pop">資產證券化法規查詢<img src="arrow_r.gif" class="liArrow" /><ul>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t112_w001\';">不動產證券化</li>\
									<li class = "L02_Item" onclick="window.location.href=\'p_t112_w002\';">金融資產證券化</li>\
								</ul>\
							</li>\
';
