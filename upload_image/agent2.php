<?php
session_start ();
require 'rb-p533.php';
if (! session_is_registered ( "aid" )) {
	header ( "location:login.php" );
}

R::setup ( 'mysql:host=localhost;dbname=smartqna', 'root', 'denters0318' );
?>

<html lang="en">
<head>
<meta charset="UTF-8">
<title>Smart QnA 대리점 페이지</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script
	src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
<script type="text/javascript" src="script/autocomplete.js"></script>
<link rel="stylesheet" href="style/autocomplete.css">

<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
</head>
<style>
.tabs {
	width: 100%;
	display: inline-block;
}

/*----- Tab Links -----*/
/* Clearfix */
.tab-links:after {
	display: block;
	clear: both;
	content: '';
}

.tab-links li {
	margin: 0px 5px;
	float: left;
	list-style: none;
}

.tab-links a {
	padding: 9px 15px;
	display: inline-block;
	border-radius: 3px 3px 0px 0px;
	background: #7FB5DA;
	font-size: 16px;
	font-weight: 600;
	color: #4c4c4c;
	transition: all linear 0.15s;
}

.tab-links a:hover {
	background: #a7cce5;
	text-decoration: none;
}

li.active a, li.active a:hover {
	background: #fff;
	color: #4c4c4c;
}

/*----- Content of Tabs -----*/
.tab-content {
	padding: 15px;
	border-radius: 3px;
	box-shadow: -1px 1px 1px rgba(0, 0, 0, 0.15);
	background: #fff;
}

.tab {
	display: none;
}

.tab.active {
	display: block;
}

table, th, td {
	border: 1px solid grey;
	border-collapse: collapse;
	padding: 5px;
}

table tr:nth-child(odd) {
	background-color: #f1f1f1;
}

table tr:nth-child(even) {
	background-color: #ffffff;
}

.ui-widget {
	margin-top: 20px;
}
</style>
<body ng-app="">
	<div class="tabs">

		<ul class="nav nav-pills" id="tabs">
			<li role="presentation" class="tab-links active"><a href="#tab0">기본
					정보</a></li>
			<li role="presentation" class="tab-links"><a href="#tab1">매출 및 결제 정보</a></li>
			<li role="presentation" class="tab-links"><a href="#tab2">매출 입력</a></li>
		</ul>

		<div class="tab-content">

			<div id="tab0" class="tab">
				<dl>
					<dt>회사이름</dt>
					 <?php
						try {
							$agent = R::findOne ( 'agent', "aid ='test'" );
						} catch ( RedBeanPHP\RedException\SQL $e ) {
							echo $e;
						}
						echo "<dd>" . $agent->oname . "</dd>";
						?>
					 <dt>대표자이름</dt> 	<?php echo "<dd>$agent->name</dd>"; ?>
					 <dt>연락처</dt> 			<?php echo "<dd>$agent->hp</dd>"; ?>
					 <dt>담당지역</dt>		<?php echo "<dd>$agent->lv0/$agent->lv1</dd>"; ?>
					<dd></dd>
				</dl>
			</div>
			<!--tab0-->

			<div id="tab1" class="tab">

				<div class="panel panel-default" ng-controller="contractCtr">
					<div class="panel-heading" style="font-size: 20px">월별매출</div>
					<div class="panel-body"></div>
					<table id="data" class="table" style="margin-bottom: 50px;">
						<tr>
							<th>년월</th>
							<th>매출</th>
							<th>결제금액</th>
						<tr>
						
						<tr ng-repeat = "x in monthlySales" ng-click="loadData(x.yearmonth)">
							<td>{{x.yearmonth}}</td>
							<td>{{x.price}}</td>
							<td>{{x.cermission}}</td>
						</tr>
					</table>

					<div class="panel-heading" style="font-size: 20px">세부내역(<span id="spMonth"></span>월)</div>
					<div class="panel-body"></div>
					<table id="data" class="table">
						<tr>
							<th>학교</th>
							<th>계약금액</th>
							<th>시작일</th>
							<th>종료일</th>
						</tr>
						<tr ng-repeat="x in contracts" ng-click="showData(x)">
							<td>{{x.name}}</td>
							<td>{{x.price}}</td>
							<td>{{x.date_start}}</td>
							<td>{{x.date_end}}</td>
							<td ng-show="hide">{{x.id}}</td>
						</tr>
					</table>
				</div>
				<!--controlCtr-->

			</div>
			<!--tab1-->

			<div id="tab2" class="tab active" ng-controller="contract_input">

				<form action="contract" method="post" id="revenue_form">

					<div class="ui-widget">
						<label for="tags" style="font-size: medium;">학교이름 </label>
						<div class="input-group">
							<input id="tags" name="name" type="text" class="form-control"
								placeholder="00고등학교">
						</div>
						<!-- /input-group -->
					</div>

					<div class="ui-widget">
						<label for="price" style="font-size: medium;">계약금액 </label>
						<div class="input-group">
							<input id="price" name="price" type="text" class="form-control"
								placeholder="1000">
						</div>
					</div>

					<!-- fixme : 달력적용-->
					<div class="ui-widget">
						<table style="background-color: #fff; border: 0px solid white">
							<tr>
								<td style="background-color: #fff; border: 0px solid white"><label
									for="date_start">계약시작</label></td>
								<td style="background-color: #fff; border: 0px solid white"><input
									type="date" id="date_start" name="date_start"
									class="form-control" style="width: 200px"></td>
							</tr>
							<tr>
								<td style="background-color: #fff; border: 0px solid white"><label
									for="date_end">계약끝: </label></td>
								<td style="background-color: #fff; border: 0px solid white"><input
									type="date" id="date_end" name="date_end" class="form-control"
									style="width: 200px"></td>
							</tr>
						</table>

					</div>
					<input type="hidden" name="aid" value="<?echo $agent->aid?>">
					<button class="btn btn-primary" type="submit" value="전송"
						id="revenue_submit" style="margin-top: 20px;">전송</button>

				</form>

			</div>
			<!--tab2-->

		</div>
	</div>
	<button onclick="window.location='logout.php'" style="float: right">로그아웃</button>

</body>
</html>

<script>

  $(function() {
		var lv0 = '충북';
		var lv1 = '청주시';
	
		$.get( 
			"school",
			{ lv0: lv0, lv1: lv1 },
			function( data ) { 
				var objs = eval('('+data+')').data;
				var len  = objs.length;

				var tags = [];
				for(var i=0; i<len; i++){
					tags[i] = objs[i].name;
				}

				$("#tags").autocomplete({
					source: tags,
					select: function( event, ui ) {
						//alert('' + ui.item.label + ' ' + ui.item.value);	
					} 
				});                                                   			}

		);

	});

var selDispMonth = -1;

function getCurMonth() {
		var d = new Date();
		return d.getMonth() + 1;
}

function contractCtr($scope,$http) {
	var aid = "<? echo $agent->aid ?>";
	console.log("contractCtr");

	$scope.loadData = function(month) {
		$http.get("contract/"+aid+"/"+month).success(function(response){
			console.log("response data:" + response.data);
			$scope.contracts = response.data;
			$('#spMonth').html(month);
		});
	}

	var curMonth =	getCurMonth();
	$scope.loadData(curMonth);

	$scope.monthlySales = [[], []];
	$scope.monthlySales[0].yearmonth 	= curMonth - 1;
	$scope.monthlySales[0].price			= 1;
	$scope.monthlySales[0].cermission = 2;

	$scope.monthlySales[1].yearmonth 	= curMonth;
	$scope.monthlySales[1].price			= 1;
	$scope.monthlySales[1].cermission = 2;
}

function contract_input($scope,$http) {
}

jQuery(document).ready(function() {
    jQuery('#tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });

$('#revenue_form').on("submit", function(){
	 var $form = $(this);
    var serializedData = $form.serialize();

	        
	$.ajax({
		  type: "POST",
		  url: "contract",
		  data: serializedData,
		  success: function(data){
			  alert("저장되었습니다");
			  $('#revenue_form')[0].reset();
		  }
		});

	return false;
});
	
});
document.getElementById('date_start').valueAsDate = new Date();
document.getElementById('date_end').valueAsDate = new Date();


</script>
