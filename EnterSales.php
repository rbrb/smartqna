<!DOCTYPE html>
<?php
session_start ();
require 'rb-p533.php';
if (! session_is_registered ( "aid" ) || !isset($_SESSION['login_user']) ) {
	header ( "location:agent.php" );
}

R::setup ( 'mysql:host=localhost;dbname=smartqna', 'root', 'denters0318' );

$aid	= $_SESSION['login_user'];
$agent = R::findOne('agent',"aid = '$aid'");

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

  <!-- ... -->
  <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />


    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/timeline.css" rel="stylesheet">
    <!-- /#wrapper -->
    <!-- Custom Theme JavaScript -->
    <script src="./dist/js/sb-admin-2.js"></script>
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">


    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<script
	src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
<link rel="stylesheet" href="bower_components/autocomplete.js/dist/autocomplete.css">
<script src="bower_components/autocomplete.js/dist/autocomplete.min.js"></script>

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
                        <li>
                        	<a href="notice.php"><i class="fa fa-bell fa-fw"></i> 공지사항</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
           <br>
             <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">매출 입력</div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-lg-8">
	         	<div class="panel panel-default" ng-controller="contract_input">
	            	<div class="panel-heading">
	                            매출 입력
	               </div>
	              
						<div class="panel-body">
							<form role="form" id="revenue_form" 
									action"contract" method="post">
								<!----------   학교 이름 ----------->
								<input type="hidden" 
										id="contract_id" name="id" 
										value="">
								<div class="form-group has-success">
									<label class="control-label" for="sname">
										학교이름(<? echo "$agent->lv0 $agent->lv1"; ?>)
									</label>
								   <input type="text" class="form-control" 
											id="sname" name="name"
											placeholder="00고등학교">
								</div>
								<input type="hidden" 
										id="sid" name="sid" 
										value="">
								<!----------    계약 금액 ----------->
								<div class="form-group has-warning">
									<label class="control-label" for="price">
										계약금액
									</label>
									<input type="text" class="form-control" 
											id="price" name="price"
											placeholder="1000">
								</div>
								<!----------    계약 기간 ----------->
								<div class="form-group input-group">
                        	<span class="input-group-addon">
										계약 시작
									</span>
                           <input type="text" class="form-control"
											id="date_start" name="date_start" 
											placeholder="2015-04-01">
                        </div>
                        <div class="form-group input-group">
                        	<span class="input-group-addon">
									계약 종료
									</span>
                        	<input id="date_end" name="date_end"
											type="text" class="form-control" 
										placeholder="2015-04-30">
                       	</div>
								<input type="hidden" name="aid"
										value="<?echo $agent->aid?>">
                        <button type="submit" id="revenue_submit"
										value="전송"
										class="btn btn-outline btn-primary">
									전송
								</button>
							</form>
						</div>
					</div>
				</div>
           </div>
        </div>
        <!-- /#page-wrapper -->

    </div>

</body>
<script>

  $(function() {
		<?
			echo "var lv0='$agent->lv0';\n";
			echo "var lv1='$agent->lv1';\n";
		?>

		$("#date_start").datetimepicker({
			format:'YYYY-MM-DD'
		});
		$("#date_end").datetimepicker({
			format:'YYYY-MM-DD'
		});

		$.get( 
			"school",
			{ lv0: lv0, lv1: lv1 },
			function( data ) { 
				var objs = eval('('+data+')').data;
				var len  = objs.length;

				var tags = [];
				for(var i=0; i<len; i++){
					console.log(objs[i].name);
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

function contract_input($scope,$http) {
	var contract_id = getParam('contract_id');	
	console.log(contract_id);
	if(contract_id!=null){
		$('#contract_id').val(contract_id);
		$('#sname').val( decodeURIComponent(getParam('sname')) );	
		$('#sid').val( getParam('sid') );	
		$('#price').val( getParam('price') );	
		$('#date_start').val( getParam('date_start') );	
		$('#date_end').val( getParam('date_end') );	
	}
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

	if($form.find( "input[name='price']" ).val()==""){
		alert('금액을 입력해 주세요');
		return false;
	}
	if($form.find( "input[name='date_start']" ).val()==""){
		alert('계약 시작 기간을 입력해 주세요');
		return false;
	}
	        
	if($form.find( "input[name='date_end']" ).val()==""){
		alert('계약 종료 기간을 입력해 주세요');
		return false;
	}
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

/*
	var contract_id = getParam('contract_id');	
	console.log(contract_id);
	if(contract_id!=null){
		$('#contract_id').val(contract_id);
		$('sname').val( getParam('sname') );	
		$('sid').val( getParam('sid') );	
		$('price').val( getParam('price') );	
		$('date_start').val( getParam('date_start') );	
		$('date_end').val( getParam('date_end') );	
	}
	*/
});

$('#date_start').val(new Date());
$('#date_end').val( new Date());

function getParam(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
			console.log(pair[1]);
      return pair[1];
    }
  } 
  //alert('Query Variable ' + variable + ' not found');
  console.log('Query Variable ' + variable + ' not found');
}
</script>
</html>

