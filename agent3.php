<?php
session_start ();
require 'rb-p533.php';
if (! session_is_registered ( "aid" )) {
	header ( "location:login.php" );
}

R::setup ( 'mysql:host=localhost;dbname=smartqna', 'root', 'denters0318' );
?>

<!DOCTYPE html>
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
<style>
.tabs {
	width: 100%;
	display: inline-block;
}
</head>

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
<!--
			<li role="presentation" class="tab-links" onclick='resetRevenue();'><a href="#tab2">매출 입력</a></li>
-->
			<li role="presentation" class="tab-links" onclick='resetRevenue();'><a href="#tab2">매출 입력</a></li>

			<li role="presentation" class="tab-links" 
				style="position:absolute; right:10px;" 
				onclick="window.location='logout.php'" 
				style="float: right">
				<a href="#tab3">로그아웃</a>
			</li>

		</ul>

		<div class="tab-content">
			<div id="tab0" class="tab active">
					<li class="list-group-item">
					 		아이디
						 <? echo $_SESSION['login_user']; ?>
					</li>
					<li class="list-group-item">
						회사이름
					 			<?
									$aid	 = $_SESSION['login_user'];
									$agent = $_SESSION['agent'];
									echo "$agent[oname]";
								?>
					</li>
					<li class="list-group-item">
							 대표자이름 	<? echo "$agent[name]"; ?>
					</li>
					<li class="list-group-item">
							연락처 			<? echo "$agent[hp]"; ?>
					</li>
					<li class="list-group-item">
					 		담당지역		<? echo "$agent[lv0]/$agent[lv1]"; ?>
					</li>
				</ul>
			</div>

			<!--tab0-->
			<div id="tab1" class="tab">

				<div class="panel panel-default" ng-controller="contractCtr">
					<div class="panel-heading" style="font-size: 20px">월별매출</div>
					<div class="panel-body"></div>
					<table id="data" class="table" style="margin-bottom: 50px;">
						<tr>
							<th>월</th>
							<th>매출</th>
							<th>결제금액</th>
						<tr>
						
						<tr ng-repeat = "x in monthlySales" ng-click="loadData(x.month)">
							<td>{{x.month}}</td>
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
						<tr ng-repeat="x in contracts" ng-click="editContract(x)">
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

			<div id="tab2" class="tab" ng-controller="contract_input">

				<form action="contract" method="post" id="revenue_form">

					<input type="hidden" id="contract_id" name="id" value="">

					<div class="ui-widget">
						<label for="sname" style="font-size: medium;">학교이름 (<? echo "$agent[lv0] $agent[lv1]"; ?>) </label>
						<div class="input-group">
							<input id="sname" name="name" type="text" class="form-control"
								placeholder="00고등학교">
						</div>
						<!-- /input-group -->
					</div>

					<input type="hidden" id="sid" name="sid" value="">

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
									for="date_end">계약종료 </label></td>
								<td style="background-color: #fff; border: 0px solid white"><input
									type="date" id="date_end" name="date_end" class="form-control"
									style="width: 200px"></td>
							</tr>
						</table>

					</div>
					<input type="hidden" name="aid" value="<?echo $agent['aid']?>">
					<button class="btn btn-primary" type="submit" value="전송"
						id="revenue_submit" style="margin-top: 20px;">전송</button>

				</form>
			</div> <!--tab2-->

		</div>
	</div>
<!--
	<button class="btn btn-primary" type="submit" value="전송"
		id="revenue_submit" style="position: absolute; right:20px";
		>로그아웃</button>
-->

</body>

<script>

  $(function() {
		<?
			$agent = $_SESSION['agent'];
			echo "var lv0='$agent[lv0]';\n";
			echo "var lv1='$agent[lv1]';\n";
		?>

		$.get( 
			"school",
			{ lv0: lv0, lv1: lv1 },
			function( data ) { 
				var objs = eval('('+data+')').data;
				var len  = objs.length;

				var tags = [];
				for(var i=0; i<len; i++){
					tags[i] = { label: objs[i].name, value: objs[i].id };
				}

				$("#sname").autocomplete({
					source: tags,
					select: function( event, ui ) {
						event.preventDefault();
						//alert('' + ui.item.label + ' ' + ui.item.value);	
						$('#sname').val(ui.item.label);
						$('#sid').val(ui.item.value);
					},
					focus: function(event, ui) {
		        event.preventDefault();
		        $("#sname").val(ui.item.label);
						$('#sid').val(ui.item.value);
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
	var aid = "<? echo $agent['aid']; ?>";

	$scope.loadData = function(month){
		$http.get("contract/"+aid+"/"+month).success(function(response){
			var data = response.data;
			console.log("response data:" + data + " month:" + month);
			$scope.contracts = data;
			$('#spMonth').html(month);
		});
	}

	$scope.editContract = function(contract){
		console.log('edit:' + contract.name + ":" +contract.id);
		//set tab2 values and change ui
		$("#contract_id").attr('value', contract.id); //hidden form not changed at IE
		$("#sname").val(contract.name);
		$("#sid").attr('value', contract.sid);
		$("#price").val(contract.price);
		$("#date_start").val(contract.date_start);
		$("#date_end").val(contract.date_end);

		// Show/Hide Tabs
   		$('.tabs ' + '#tab2').show().siblings().hide();
		// Change/remove current tab to active
		$("a[href='#tab2']").parent('li').addClass('active').siblings().removeClass('active');
	}

	var curMonth =	getCurMonth();
	$scope.loadData(curMonth);

	$scope.monthlySales = [[], [], [], [], [], [], [], [], [], [], [], []];

	$scope.loadSum = function(month) 
	{
		$http.get("contract_sum/"+aid+"/"+month).success(
			function(response){
				var month = response.data.month;
				var sum 	= response.data.sum;
/*
				<?
					$agent = $_SESSION['agent'];
					echo "var fee = $agent[fee];";
				?>
*/
				var fee = 10;
				$scope.monthlySales[month-1].month = month;
				$scope.monthlySales[month-1].price = sum;
				$scope.monthlySales[month-1].cermission = Math.round(sum*fee/100);
			}
		);
	}

	for(var i=1; i<=12; i++)
		$scope.loadSum(i);
}

function contract_input($scope,$http) {
}

$(document).ready(function() {
    $('#tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = $(this).attr('href');
 
        // Show/Hide Tabs
        $('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        $(this).parent('li').addClass('active').siblings().removeClass('active');
 
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
			 	window.location.reload();
				//resetRevenue();
		  }
		});

	return false;
});
	
});

function resetRevenue(){
			  $('#revenue_form')[0].reset();
}
document.getElementById('date_start').valueAsDate = new Date();
document.getElementById('date_end').valueAsDate = new Date();


</script>

</html>
