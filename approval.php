<?php
session_start ();
require 'rb-p533.php';
if (! session_is_registered ( "aid" )) {
	header ( "location:basicInfo.php" );
}

R::setup ( 'mysql:host=localhost;dbname=smartqna', 'root', 'denters0318' );

$aid	= $_SESSION['login_user'];
$agent = R::findOne('agent',"aid = '$aid'");
	//temp
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ToonySam</title>

    <!-- Bootstrap Core CSS -->
    <link href="./bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="./bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="./dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./dist/css/sb-admin-2.css" rel="stylesheet">

    <link href="bower_components/font-awesome/css/font-awesome.min.css" 
			rel="stylesheet" type="text/css">


	<script
	src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js">
	</script>


</head>

<body ng-app="">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="basicInfo.html">ToonySam</a>
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="basicInfo.php"><i class="fa fa-dashboard fa-fw"></i> 기본정보</a>
                        </li>
                        <li>
                            <a href="approval.php"><i class="fa fa-bar-chart-o fa-fw"></i> 매출 및 결제 정보</a>
                           
                        </li>
                        <li>
                            <a href="EnterSales.php"><i class="fa fa-table fa-fw"></i> 매출 입력</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">

            <!-- /.row -->
            	<br>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">매출 및 결재 정보</div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default" ng-controller="contractCtr" >
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> 월별 매출
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                            	<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped">
                              	<thead>
                                 	<tr>
													<th>월</th>
													<th>매출</th>
													<th>수수료</th>
													<th>결제완료</th>
                                    </tr>
                                </thead>
                                <tbody>
											<tr ng-repeat="x in monthlySales" 
														ng-click="loadData(x.month)">
												<td>{{x.month}}월</td>
												<td>{{x.price}}원</td>
												<td>{{x.cermission}}원</td>
												<td>{{x.approved}}원</td>
											</tr>
                               	</tbody>
                              </table>
                             </div>
                                    <!-- /.table-responsive -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
   
                    	<div class="panel panel-default">
                        <div class="panel-heading">
                        	<i class="fa fa-bar-chart-o fa-fw"></i> 
										세부내역(<span id="spMonth"></span>월)
                        </div>
                        <div class="panel-body">
                        	<div class="row">
                           <div class="table-responsive">
                           	<table class="table table-bordered table-hover table-striped">
                              <thead>
                                <tr>
                                  <th >학교</th>
                                  <th>계약금액</th>
                                  <th>시작일</th>
                                  <th>종료일</th>
                                  <th>승인</th>
                                </tr>
                              </thead>
                              <tbody>
																<tr ng-repeat="x in contracts" 
																	ng-click="editContract(x)">
																	<td>{{x.name}}</td>
																	<td>{{x.price}}</td>
																	<td>{{x.date_start}}</td>
																	<td>{{x.date_end}}</td>
																	<td>{{x.approved}}</td>
																	<td ng-show="hide">{{x.id}}</td>
																</tr>
                              </tbody>
                              </table>
                          	</div>
                               
                            </div> <!--row  -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                   </div>
                    <!-- /.panel -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="./bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="./bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="./dist/js/sb-admin-2.js"></script>


<script>
  $(function() {
		<?
			echo "var lv0='$agent->lv0';\n";
			echo "var lv1='$agent->lv1';\n";
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
			}
		);
});

var selDispMonth = -1;

function getCurMonth() {
		var d = new Date();
		return d.getMonth() + 1;
}

function contractCtr($scope,$http) {
	var aid = "<? echo $agent->aid; ?>";

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
		window.location = "EnterSales.php"+
												"?contract_id=" 	+ contract.id +
												"&sname=" 				+ contract.name +
												"&sid=" 					+ contract.sid +
												"&price=" 				+ contract.price+
												"&date_start=" 	+ contract.date_start+
												"&date_end=" 		+ contract.date_end;
/*
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
*/
	}

	var curMonth =	getCurMonth();
	$scope.loadData(curMonth);

	$scope.monthlySales = [[], [], [], [], [], [], [], [], [], [], [], []];

	$scope.loadSum = function(month) 
	{
		$http.get("contract_sum/"+aid+"/"+month).success
		(
			function(response)
			{
				var month 				= response.data.month;
				var sales_sum 		= response.data.sales_sum;
				var approved_sum	= response.data.approved_sum;

				<?  echo "var fee = $agent->fee;" ?>

				$scope.monthlySales[month-1].month 			= month;
				$scope.monthlySales[month-1].price 			= sales_sum;
				$scope.monthlySales[month-1].cermission = Math.round(sales_sum		*fee/100);
				$scope.monthlySales[month-1].approved		= Math.round(approved_sum	*fee/100);
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
/*
function resetRevenue(){
			  $('#revenue_form')[0].reset();
}*/
//!fixme
//document.getElementById('date_start').valueAsDate = new Date();
//document.getElementById('date_end').valueAsDate = new Date();


</script>

</body>
</html>

