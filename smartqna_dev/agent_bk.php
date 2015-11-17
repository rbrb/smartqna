<?php
	session_start();
	require 'rb-p533.php';
	if(!session_is_registered("aid")){
		header("location:login.php");
	}

	R::setup( 'mysql:host=localhost;dbname=smartqna',
                    'root', 'denters0318' );
?>

<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>Smart QnA 대리점 페이지</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
	<script type="text/javascript" src="script/autocomplete.js"></script>
	<link rel="stylesheet" href="style/autocomplete.css">

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
 </head>
 </head>
<style>
.tabs {
    width:100%;
    display:inline-block;
}
 
    /*----- Tab Links -----*/
    /* Clearfix */
.tab-links:after {
        display:block;
        clear:both;
        content:'';
}
 
.tab-links li {
        margin:0px 5px;
        float:left;
        list-style:none;
}
 
.tab-links a {
			margin : 12px;
            padding:9px 15px;
            display:inline-block;
            border-radius:3px 3px 0px 0px;
            background:#7FB5DA;
            font-size:16px;
            font-weight:600;
            color:#4c4c4c;
            transition:all linear 0.15s;
}
 
.tab-links a:hover {
            background:#a7cce5;
            text-decoration:none;
}
 
li.active a, li.active a:hover {
        background:#fff;
        color:#4c4c4c;
}
 
    /*----- Content of Tabs -----*/
.tab-content {
        padding:15px;
        border-radius:3px;
        box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
        background:#fff;
}

.tab {
        display:none;
}
 
.tab.active {
        display:block;
}

table, th , td  {
  border: 1px solid grey;
  border-collapse: collapse;
  padding: 5px;
}
table tr:nth-child(odd)	{
  background-color: #f1f1f1;
}
table tr:nth-child(even) {
  background-color: #ffffff;
}

</style>

 <body ng-app="">
	<div class="tabs">

    <ul class="tab-links">
        <li class=""><a href="#tab0">기본 정보</a></li>
        <li><a href="#tab1">매출 및 결제 정보</a></li>
        <li class="active"><a href="#tab2">매출 입력</a></li>
   	</ul>

    <div class="tab-content">

        <div id="tab0" class="tab">          
					<dl>
					<dt>회사이름</dt>
					 <?php 
						try{ 
							$agent = R::findOne('agent',"aid ='test'");
						} catch(RedBeanPHP\RedException\SQL $e){ echo $e; }
								 echo "<dd>".$agent->oname."</dd>";	
						 ?>
					 <dt>대표자이름</dt> 	<?php echo "<dd>$agent->name</dd>"; ?>
					 <dt>연락처</dt> 			<?php echo "<dd>$agent->hp</dd>"; ?>
					 <dt>담당지역</dt>		<?php echo "<dd>$agent->lv0/$agent->lv1</dd>"; ?>
					<dd></dd>
					</dl>
        </div> <!--tab0-->

        <div id="tab1" class="tab">          

					<div ng-controller = "contractCtr">
						<h3> 월별매출 </h3>
						<h5> 해당년도 월별 매출이 기록됨</h5>
						<h5> 상세보기 클릭하면 해당 달 매출이 하단에 표시</h5>
						<h5> 현재 vertical로 되있는데 horizontal로 바꿈이 좋을 듯</h5>
						<table id="data">
							<tr>
								<td>해당월</td>
								<td>매출</td>
								<td>결제금액</td>
							<tr>

							<tr ng-repeat = "x in monthlySales" ng-click="loadData(x.yearmonth)">
								<td>{{x.yearmonth}}</td>
								<td>{{x.price}}</td>
								<td>{{x.cermission}}</td>
							</tr>
						</table>

						<h3> 세부내역2 <span>(월)</span> </h3>
						<h5> 이번달 내용 선택됨</h5>
						<table id="data">
							<tr> 
								<td>학교</td>
								<td>계약금액</td>
								<td>시작일</td>
								<td>종료일</td>
							</tr>
							<tr ng-repeat = "x in contracts">
								<td>{{x.name}}</td>
								<td>{{x.price}}</td>
								<td>{{x.date_start}}</td>
								<td>{{x.date_end}}</td>
							</tr>
						</table>
					</div> <!--controlCtr-->

        </div> <!--tab1-->

        <div id="tab2" class="tab active" ng-controller ="inputCtr">

					<form action ="contract" method = "post">

						<div class="ui-widget">
							<label for="tags">학교이름:  </label>
							<input id="tags" name="name">
						</div>

						<div class="ui-widget">
							<label for="price">계약금액:  </label>
							<input id="price" name="price">
						</div>

							<input type="hidden" name="aid" value="<? echo $agent->aid ?>">

						<!-- fixme : 달력적용-->
						<div class="ui-widget">
							<label for="date_start">계약시작:  </label>
							<input id="date_start" name="date_start">

							<label for="date_end">계약끝:  </label>
							<input id="date_end" name="date_end">
						</div>

						<input type = "submit" value = "입력">

					</form>

        </div> <!--tab2-->

    </div>
	</div>
	 <button onclick = "window.location='logout.php'" style ="float : right">로그아웃</button>

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

function inputCtr($scope,$http) {
}

jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
	
});
</script>
