<?php
ob_start();
	$host="SERVER NAME";
	$user="USERNAME";
	$pwd="PASSWORD";
	$dbname="DATABASE NAME";
	
$conn=mysql_connect($host,$user,$pwd);
mysql_select_db($dbname,$conn);

function cleanUp($x){
 	$x = str_replace("'", "&#39;", $x);
	$x = str_replace("/", "&#47;", $x);
	$x = str_replace("\"", "&#39;", $x);
	$x = str_replace("|", "", $x);
	$x = str_replace(",", "&#44;", $x);
	$x = str_replace(".", "&#46;", $x);
	$x = str_replace("^", "", $x);
	$x = str_replace("<", "&#60;", $x);
	$x = str_replace(">", "&#62;", $x);
	$x = str_replace("<script", "", $x);
	return $x;
}

$q = "select * from theory";
$qq = mysql_query($q) or die(mysql_error());
$qn = mysql_num_rows($qq);
echo "Theory total: ".$qn;

for($i=0; $i<$qn; $i++){ 
	$theoryName[$i] = mysql_result($qq, $i, "theoryName");
	$theoryType[$i] = mysql_result($qq, $i, "theoryType");
	$theoryDesc[$i] = mysql_result($qq, $i, "description");
	$theoryQuotes[$i] = mysql_result($qq, $i, "quotes");
	$theoryScholars[$i] = mysql_result($qq, $i, "scholars");
	$theoryTexts[$i] = mysql_result($qq, $i, "keyText");
	$theoryImplications[$i] = mysql_result($qq, $i, "implications");
	$theorySamples[$i] = mysql_result($qq, $i, "sampleProducts");
}
 
$theoryKey = $_GET['theory'];

if($theoryKey == "")
{
	$theoryKey = 0;	
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?=($theoryName[$theoryKey]);?>- HEXHIVE</title>
<style>
 #hexMap{
	top:0px;
	width:100%;
	height:100%;
	background-color:#fff;
	position:absolute;
	
 }
 
 #theoryData{
	top:0px;
	height:800px;
	width:350px;
	background-color:#aaa;
	left:0px; 
	position:absolute;
 }
 
 #theoryDescriptionDiv{
	position:absolute;
	z-index:100;
	width:300px;
	height:300px;
	border:solid 1px #ccc;
	display:none;
	overflow:scroll;
	font-family:arial;
	font-size:10pt;
	background-color:#fff;
	padding:10px;
 }
</style>

<script type="text/javascript" language="javascript">
function swapTheory(x)
 {
	 window.location = "default.php?theory="+x
 }
</script>

<script type="text/javascript" language="JavaScript">

var tName = new Array();
var tType = new Array();
var tDesc = new Array();
var tQuote = new Array();
var tTexts = new Array();
var tScholars = new Array();
var tImplications = new Array();
var tSamples = new Array();
 
function getTheory(x){
		
		var theoryType = document.getElementById("tType_"+x).innerHTML;

		var tContent = "<b style='font-size:14pt'>"+document.getElementById("tName_"+x).innerHTML+"</b><br>"+document.getElementById("tType_"+x).innerHTML+"<br><br><b>Description</b><br>"+document.getElementById("tDesc_"+x).innerHTML+"<br><br><b>Implications for Learning</b><br>"+document.getElementById("tImplications_"+x).innerHTML+"<br><br><b>Scholars</b><br>"+document.getElementById("tScholars_"+x).innerHTML+"<br><br><b>References</b><br>"+document.getElementById("tTexts_"+x).innerHTML
		document.getElementById("theoryDescriptionDiv").innerHTML = tContent
		
		
		document.getElementById("theoryDescriptionDiv").style.backgroundColor = "#ffffff"	
		getScreenSize()
		
	
	}
	
function getScreenSize(){
	var winWidth = window.innerWidth;
	var winHeight = window.innerHeight;

}

function getCursorXY(e, id) {
	
	var xPos = (window.Event) ? e.layerX : event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
	
	var yPos = (window.Event) ? e.layerY : event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
	

	
	document.getElementById("theoryDescriptionDiv").style.display="block";
	
	
		if(yPos > 680){
			document.getElementById("theoryDescriptionDiv").style.left=xPos-5+'px';
			document.getElementById("theoryDescriptionDiv").style.top=yPos-200+'px';
		}else{
			document.getElementById("theoryDescriptionDiv").style.left=xPos-5+'px';
			document.getElementById("theoryDescriptionDiv").style.top=yPos-0+'px';
		
		}
		stopListeningMove = true;
	
}

function hideDiv(){
	document.getElementById("theoryDescriptionDiv").style.display="none";
	stopListeningMove = false;
}

function getMenu(){
	document.getElementById("theoryDescriptionDiv").style.display="block";
}
</script>
</head>

<body>

<? for($i=0; $i<$qn; $i++){ ?>
<div style="position:absolute; z-index:100; display:none;" id="tName_<?=($i);?>"><?=(cleanUp($theoryName[$i]));?> </div>

<div style="position:absolute; z-index:100; display:none;" id="tType_<?=($i);?>"> <?=(cleanUp($theoryType[$i]));?></div>
<div style="position:absolute; z-index:100; display:none;" id="tDesc_<?=($i);?>" ><?=(cleanUp($theoryDesc[$i]));?>"</div>
<div style="position:absolute; z-index:100; display:none;" id="tQuotes_<?=($i);?>" ><?=(cleanUp($theoryQuotes[$i]));?></div>
<div style="position:absolute; z-index:100; display:none;" id="tTexts_<?=($i);?>" ><?=(cleanUp($theoryTexts[$i]));?></div>
<div style="position:absolute; z-index:100; display:none;" id="tScholars_<?=($i);?>" ><?=(cleanUp($theoryScholars[$i]));?></div>
<div style="position:absolute; z-index:100; display:none;" id="tImplications_<?=($i);?>" ><?=(cleanUp($theoryImplications[$i]));?></div>
<div style="position:absolute; z-index:100; display:none;" id="tSamples_<?=($i);?>" ><?=(cleanUp($theorySamples[$i]));?></div><!---->
<? } ?>


<div id="hexMap">

 	<div id="theoryDescriptionDiv" onMouseOver="getMenu()" onMouseOut="hideDiv()"></div>
 	<img src="hive.jpg" width="1200" usemap="#Map" border="0"/>
	<map name="Map" id="Map"><area shape="poly" coords="624,448,603,483,624,518,665,519,685,483,666,448" href="http://thysector.com/sandbox/theory/default.php?theory=28" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(28)" />
		<area shape="poly" id="hex1" coords="957,446,936,481,957,516,998,517,1018,481,999,446" href="http://thysector.com/sandbox/theory/default.php?theory=33" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(33)"/>
		<area shape="poly" coords="875,495,854,530,875,565,916,566,936,530,917,495" href="http://thysector.com/sandbox/theory/default.php?theory=17" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(17)"/>
		<area shape="poly" coords="874,400,853,435,874,470,915,471,935,435,916,400" href="http://thysector.com/sandbox/theory/default.php?theory=46" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(46)" />
		<area shape="poly" coords="791,446,770,481,791,516,832,517,852,481,833,446" href="http://thysector.com/sandbox/theory/default.php?theory=41" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(41)" />
		<area shape="poly" coords="707,400,686,435,707,470,748,471,768,435,749,400" href="http://thysector.com/sandbox/theory/default.php?theory=28" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(28)" />
		<area shape="poly" coords="788,358,767,393,788,428,829,429,849,393,830,358" href="http://thysector.com/sandbox/theory/default.php?theory=39" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(39)" />
		<area shape="poly" coords="1039,395,1018,430,1039,465,1080,466,1100,430,1081,395" href="http://thysector.com/sandbox/theory/default.php?theory=51" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(17)" />
		<area shape="poly" coords="960,350,939,385,960,420,1001,421,1021,385,1002,350" href="http://thysector.com/sandbox/theory/default.php?theory=58" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(58)" />
		<area shape="poly" coords="870,307,849,342,870,377,911,378,931,342,912,307" href="http://thysector.com/sandbox/theory/default.php?theory=44" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(44)" />
		<area shape="poly" coords="1041,302,1020,337,1041,372,1082,373,1102,337,1083,302" href="http://thysector.com/sandbox/theory/default.php?theory=10" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(10)" />
		<area shape="poly" coords="1127,256,1106,291,1127,326,1168,327,1188,291,1169,256" href="http://thysector.com/sandbox/theory/default.php?theory=50" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(50)" />
		<area shape="poly" coords="1117,164,1096,199,1117,234,1158,235,1178,199,1159,164" href="http://thysector.com/sandbox/theory/default.php?theory=42" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(42)" />
		<area shape="poly" coords="1033,213,1012,248,1033,283,1074,284,1094,248,1075,213" href="http://thysector.com/sandbox/theory/default.php?theory=9" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(9)" />
		<area shape="poly" coords="959,253,938,288,959,323,1000,324,1020,288,1001,253" href="http://thysector.com/sandbox/theory/default.php?theory=47" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(47)" />
		<area shape="poly" coords="870,214,849,249,870,284,911,285,931,249,912,214" href="http://thysector.com/sandbox/theory/default.php?theory=43" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(43)" />
		<area shape="poly" coords="785,259,764,294,785,329,826,330,846,294,827,259" href="http://thysector.com/sandbox/theory/default.php?theory=37" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(37)" />
		<area shape="poly" coords="707,303,686,338,707,373,748,374,768,338,749,303" href="http://thysector.com/sandbox/theory/default.php?theory=27" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(27)" />
		<area shape="poly" coords="1037,112,1016,147,1037,182,1078,183,1098,147,1079,112" href="http://thysector.com/sandbox/theory/default.php?theory=11" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(11)" />
		<area shape="poly" coords="959,159,938,194,959,229,1000,230,1020,194,1001,159" href="http://thysector.com/sandbox/theory/default.php?theory=56" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(56)" />
		<area shape="poly" coords="705,212,684,247,705,282,746,283,766,247,747,212" href="http://thysector.com/sandbox/theory/default.php?theory=26" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(26)" />
		<area shape="poly" coords="785,167,764,202,785,237,826,238,846,202,827,167" href="http://thysector.com/sandbox/theory/default.php?theory=21" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(21)" />
		<area shape="poly" coords="869,120,848,155,869,190,910,191,930,155,911,120" href="http://thysector.com/sandbox/theory/default.php?theory=55" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(55)" />
		<area shape="poly" coords="1113,71,1092,106,1113,141,1154,142,1174,106,1155,71" href="http://thysector.com/sandbox/theory/default.php?theory=40" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(40)" />
		<area shape="poly" coords="1032,24,1011,59,1032,94,1073,95,1093,59,1074,24" href="http://thysector.com/sandbox/theory/default.php?theory=45" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(45)" />
		<area shape="poly" coords="949,71,928,106,949,141,990,142,1010,106,991,71" href="http://thysector.com/sandbox/theory/default.php?theory=54" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(54)" />
		<area shape="poly" coords="868,23,847,58,868,93,909,94,929,58,910,23" href="http://thysector.com/sandbox/theory/default.php?theory=49" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(49)" />
		<area shape="poly" coords="786,74,765,109,786,144,827,145,847,109,828,74" href="http://thysector.com/sandbox/theory/default.php?theory=35" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(35)" />
		<area shape="poly" coords="704,24,683,59,704,94,745,95,765,59,746,24" href="http://thysector.com/sandbox/theory/default.php?theory=62" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(62)" />
		<area shape="poly" coords="705,117,684,152,705,187,746,188,766,152,747,117" href="http://thysector.com/sandbox/theory/default.php?theory=25" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(25)" />
		<area shape="poly" coords="623,69,602,104,623,139,664,140,684,104,665,69" href="http://thysector.com/sandbox/theory/default.php?theory=23" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(23)" />
		<area shape="poly" coords="624,164,603,199,624,234,665,235,685,199,666,164" href="http://thysector.com/sandbox/theory/default.php?theory=20" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(20)" />
		<area shape="poly" coords="541,119,520,154,541,189,582,190,602,154,583,119" href="http://thysector.com/sandbox/theory/default.php?theory=19" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(19)" />
		<area shape="poly" coords="459,74,438,109,459,144,500,145,520,109,501,74" href="http://thysector.com/sandbox/theory/default.php?theory=14" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(14)" />
		<area shape="poly" coords="623,262,602,297,623,332,664,333,684,297,665,262" href="http://thysector.com/sandbox/theory/default.php?theory=29" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(29)" />
		<area shape="poly" coords="542,214,521,249,542,284,583,285,603,249,584,214" href="http://thysector.com/sandbox/theory/default.php?theory=16" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(16)" />
		<area shape="poly" coords="460,168,439,203,460,238,501,239,521,203,502,168" href="http://thysector.com/sandbox/theory/default.php?theory=8" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(8)" />
		<area shape="poly" coords="378,121,357,156,378,191,419,192,439,156,420,121" href="http://thysector.com/sandbox/theory/default.php?theory=7" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(7)" />
		<area shape="poly" coords="623,356,602,391,623,426,664,427,684,391,665,356" href="http://thysector.com/sandbox/theory/default.php?theory=1" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(1)" />
		<area shape="poly" coords="542,310,521,345,542,380,583,381,603,345,584,310" href="http://thysector.com/sandbox/theory/default.php?theory=4" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(4)" />
		<area shape="poly" coords="460,260,439,295,460,330,501,331,521,295,502,260" href="http://thysector.com/sandbox/theory/default.php?theory=15" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(15)" />
		<area shape="poly" coords="378,214,357,249,378,284,419,285,439,249,420,214" href="http://thysector.com/sandbox/theory/default.php?theory=6" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(6)" />
		<area shape="poly" coords="541,401,520,436,541,471,582,472,602,436,583,401" href="http://thysector.com/sandbox/theory/default.php?theory=0" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(0)" />
		<area shape="poly" coords="541,496,520,531,541,566,582,567,602,531,583,496" href="http://thysector.com/sandbox/theory/default.php?theory=31" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(31)" />
		<area shape="poly" coords="456,837,435,872,456,907,497,908,517,872,498,837" href="http://thysector.com/sandbox/theory/default.php?theory=61" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(61)" />
		<area shape="poly" coords="458,741,437,776,458,811,499,812,519,776,500,741" href="http://thysector.com/sandbox/theory/default.php?theory=57" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(57)" />
		<area shape="poly" coords="541,691,520,726,541,761,582,762,602,726,583,691" href="http://thysector.com/sandbox/theory/default.php?theory=60" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(60)" />
		<area shape="poly" coords="539,592,518,627,539,662,580,663,600,627,581,592" href="http://thysector.com/sandbox/theory/default.php?theory=30" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(30)" />
		<area shape="poly" coords="460,640,439,675,460,710,501,711,521,675,502,640" href="http://thysector.com/sandbox/theory/default.php?theory=34" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(34)" />
		<area shape="poly" coords="460,546,439,581,460,616,501,617,521,581,502,546" href="http://thysector.com/sandbox/theory/default.php?theory=13" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(13)" />
		<area shape="poly" coords="379,785,358,820,379,855,420,856,440,820,421,785" href="http://thysector.com/sandbox/theory/default.php?theory=48" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(48)" />
		<area shape="poly" coords="207,789,186,824,207,859,248,860,268,824,249,789" href="http://thysector.com/sandbox/theory/default.php?theory=5" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(5)" />
		<area shape="poly" coords="289,742,268,777,289,812,330,813,350,777,331,742" href="http://thysector.com/sandbox/theory/default.php?theory=38" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(38)" />
		<area shape="poly" coords="375,691,354,726,375,761,416,762,436,726,417,691" href="http://thysector.com/sandbox/theory/default.php?theory=24" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(24)" />
		<area shape="poly" coords="291,646,270,681,291,716,332,717,352,681,333,646" href="http://thysector.com/sandbox/theory/default.php?theory=22" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(22)" />
		<area shape="poly" coords="374,595,353,630,374,665,415,666,435,630,416,595" href="http://thysector.com/sandbox/theory/default.php?theory=3" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(3)" />
		<area shape="poly" coords="290,549,269,584,290,619,331,620,351,584,332,549" href="http://thysector.com/sandbox/theory/default.php?theory=2" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(2)" />
		<area shape="poly" coords="214,501,193,536,214,571,255,572,275,536,256,501" href="http://thysector.com/sandbox/theory/default.php?theory=59" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(59)" />
		<area shape="poly" coords="214,406,193,441,214,476,255,477,275,441,256,406" href="http://thysector.com/sandbox/theory/default.php?theory=0" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(0)" />
		<area shape="poly" coords="295,263,274,298,295,333,336,334,356,298,337,263" href="http://thysector.com/sandbox/theory/default.php?theory=36" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(36)" />
		<area shape="poly" coords="214,310,193,345,214,380,255,381,275,345,256,310" href="http://thysector.com/sandbox/theory/default.php?theory=18" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(18)" />
		<area shape="poly" coords="133,357,112,392,133,427,174,428,194,392,175,357" href="http://thysector.com/sandbox/theory/default.php?theory=12" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(12)" />
		<area shape="poly" coords="50,311,29,346,50,381,91,382,111,346,92,311" href="http://thysector.com/sandbox/theory/default.php?theory=52" onMouseMove="getCursorXY(event, this.id)" onMouseOut="hideDiv()" onMouseOver="getTheory(52)" />
	</map>
</div>
</body>
</html>