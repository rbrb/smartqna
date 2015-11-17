<!DOCTYPE html>
<html>

<head>

<style>
#underscore {
	width:100px;
	height:5px;
	background-color:#8EB4E3;
	position:absolute;
	left:67px;
	top:65px;
	visibility:hidden;
}

#menu0 {
	position:absolute;
	left:  67px; top:20px; width:116px; height:41px;
}
#menu1 {
	position:absolute;
	left: 216px; top:20px; width:116px; height:41px;
}
#menu2 {
	position:absolute;
	left: 390px; top:20px; width:116px; height:41px;
}
#menu3 {
	position:absolute;
	left: 575px; top:20px; width:116px; height:41px;
}
#menu4 {
	position:absolute;
	left: 775px; top:20px; width:116px; height:41px;
}
#menu5 {
	position:absolute;
	left: 770px; top:20px; width:116px; height:41px;
}

#contents {
	width: 100%;
}

#dn_app {
	position:absolute;
	background-color:#88888888
}

#dn_sample {
	position:absolute;
	visibility:hidden;
}
a img {
	width: 100%;
}

#header {
	width: 100%;
	background-color:#CDCDCD;
	font-size : 28px;
	color : #333333
}

.nav{
    border:1px solid #ccc;
    border-width:1px 0;
    list-style:none;
    margin:0;
    padding:0;
    text-align:center;
}
.nav li{
    display:inline;
}
.nav a{
    display:inline-block;
    padding:15px;
}

/*
@media screen and (min-width: 720px) {
	#dn_app {
		right 	: 4%;
		top 		: 28%;
	}
	#dn_sample {
		right 	: 4%;
		top 		: 40%;
	}

	a img {
		width: 90%;
	}
}
*/

	
body	{ width:960px; padding:10px 0; margin:0 auto; font-family:Calibri, sans-serif; }
#nav{
	border:1px solid #0099ff
	border-width:1px 0;
	list-style:none;
	margin:0;
	padding:0;
	text-align:center;
}
#nav li{
	display:inline;
}
#nav a{
	display:inline-block;
	padding:10px;
}
a{
	color:black
	text-decoration:none;
	font-weight:bold;
}
a:hover{
	text-decoration:underline;
}
		
</style>

<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>

var gLeft;
var	gUndTop;
var	gUndWidth;

function init(){
	var scrWidth  = $(window).width();
	var scrHeight	= $(window).height();
	var ratio 		= scrWidth/960;

	var bTop 		= 0, bWidth = 116, bHeight = 41;
	var bLeft		= [ 47, 180, 332, 485, 620, 767 ];

	var tTop 		= Math.round(bTop 	* ratio) +'px';
	var tWidth 	= Math.round(bWidth	* ratio) +'px';
	var tHeight	= Math.round(bHeight* ratio) +'px';

	for(var i=0; i<bLeft.length; i++) {
		bLeft[i] = Math.round(bLeft[i]*ratio) +'px';
		$('#menu'+i).css({'left':bLeft[i], 'top':tTop, 'width':tWidth, 'height':tHeight});
	}

	gLeft = bLeft;

	gUndTop 	 = Math.round(52  * ratio) +'px';
	gUndWidth  = Math.round(120 * ratio) +'px';

	var width  	= $("#header").width();	
	var height	= $("#header").height();	
	console.log('header width	:' + width);
	console.log('header height:' + height);

	var dx 			= (scrWidth 	- width)/2;
	if(dx<0)		dx = 0;

	$("#dn_app").css({
		//'left'		: Math.round(width	*0.080) 	+'px', 
		'left'		: Math.round(dx+width*0.03) 		+'px', 
		'top'			: 110 		+'px',
		//'top'			: Math.round(height	*1.10) 		+'px',
		'width'		: Math.round(width	*0.145) 	+'px',
		'height'	: Math.round(height	*1.410) 	+'px'
/*
		'left'		: Math.round(width	*0.050) 	+'px', 
		'top'			: Math.round(height	*2.72) 		+'px',
		'width'		: Math.round(width	*0.090) 	+'px',
		'height'	: Math.round(height	*0.090) 	+'px'
*/
	});

	$("#dn_sample").css({
		'right'		: Math.round(width	*0.050) 	+'px', 
		'top'			: Math.round(height	*4.00) 		+'px',
		'width'		: Math.round(width	*0.090) 	+'px',
		'height'	: Math.round(height	*0.090) 	+'px'
	});
}

function menu(idx){
	$('#contents').attr('src', './img/intro/menu'+(idx)+'.png')
	$('#underscore').css({'left':gLeft[idx], 'top':gUndTop, 'width':gUndWidth});
//	$('#underscore').css({'visibility':'visible'});

	if(idx==0){
		$('#dn_app')		.css({'visibility':'visible'});	
		//$('#dn_sample')	.css({'visibility':'visible'});	
	} else {
		$('#dn_app')		.css({'visibility':'hidden'});	
		//$('#dn_sample')	.css({'visibility':'hidden'});	
	}

}

</script>

</head>

<body>

<div style="width:100%">
<!--
	<div id="header">
		<span>홈</span>
		<span>회사소개</span>
		<span>투니쌤 서비스</span>
		<span>투니쌤 소개</span>
		<span>투니쌤 툰강</span>
		<span>투니쌤 가격</span>
		<span>투니쌤 앱</span>
	<div>
-->
<!--
	<img id="header" src="./img/intro/top.png">
-->

<div id="header">
	<ul class="nav">
		<li id="active"><a onclick="menu(0)" id="current">홈</a></li>
		<li><a onclick="menu(1)">서비스</a></li>
		<li><a onclick="menu(2)">콘텐츠</a></li>
		<li><a onclick="menu(3)">선생님</a></li>
		<li><a onclick="menu(4)">가격 </a></li>
		<li><a onclick="menu(5)">회사소개</a></li>
	</ul>
</div>

<!--
	<div id="header">
		<span>홈</span> 
		<span>서비스 </span>
 		<span>콘텐츠</span>
		<span>선생님</span>
		<span>가격</span>
		<span>회사소개</span>
	</div>
-->

	<img id="contents" src="./img/intro/menu0.png">
<!--
	<div id="menu0" onclick="menu(0)"></div>
	<div id="menu1" onclick="menu(1)"></div>
	<div id="menu2" onclick="menu(2)"></div>
	<div id="menu3" onclick="menu(3)"></div>
	<div id="menu4" onclick="menu(4)"></div>
	<div id="menu5" onclick="menu(5)"></div>

	<div id="underscore"></div>
-->
	<a id="dn_app" 		href="app.apk" >
	<!--	<img src='./img/intro/dn_app.png'> -->
	</a>

	<a id="dn_sample"	href="img/intro/test_su1A.pdf" >
		<img src='./img/intro/dn_sample.png'>
	</a>

</div>

<script>
$( document ).ready(function() {
	init();
	menu(0);
});
$( window ).resize(function() {
	init();
});


</script>
</body>
</html>
