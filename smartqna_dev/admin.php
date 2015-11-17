<?php 
	session_start();
	require 'rb-p533.php';
	if(!session_is_registered("uid")){
		header("location:login.php");
	}
?>

<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	<meta charset=euc-kr>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

</head>

<body ng-app="">

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
<div class="tabs">

    <ul class="tab-links">
        <li class="active"><a href="#tab1">책 등록</a></li>
        <li><a href="#tab2">책 관리</a></li>
        <li><a href="#tab3">멘토 등록</a></li>
		<li><a href="#tab4">멘토 관리</a></li>
		<li><a href="#tab5">개인 가입자 통계</a></li>
		<li><a href="#tab6">대리점 통계</a></li>
		<li><a href="#tab7">계약 학교 통계</a></li>
		<li><a href="#tab8">설정</a></li>
   </ul>
 
    <div class="tab-content">
        <div id="tab1" class="tab active">          
		  <div ng-controller = "bookController">
			<form action ="http://www.fccrm.co.kr/smartqna/book" name = "upload_book" method = "post" enctype ="multipart/form-data">
				<label for ="name">*책 제목		:	</label>
				<input type = "text" name = "name" id ="name"><br><br>
				<label for ="publisher">퍼블리셔:	</label>
				<input type ="text" name = "publisher" id ="publisher"><br><br>
				<label for = "file">파일 이름   :   </label>
				<input type = "file" name ="file" id = "file">
				<br><br>
				<label for = "book_mentor" > 멘토 선택 :</label>
				<select id = "book_mentor" name = "book_mentor" ng-model = "book_mentor" ng-options = "item.id as item.name for item in obj" >
					
				</select>
				<br><br>
				<input type = "button" value = "전송" onclick="_upload_book()">
			</form>
		   </div>
        </div>
        <div id="tab2" class="tab">
			<div ng-controller = "bookController">
				<form ng-show ="inputForm">
					제목 :  <input type = text ng-model =selectedRow.name ng-disabled = "val" > 
					출판사 : <input type = text ng-model = selectedRow.publisher ng-disabled="val">
					<br><br>
					<input type = "button" value  = "수정" ng-click = "update()" ng-show = "val" >
					<input type = "submit" value = "수정완료" ng-click="update_ok()"  ng-show="!val"> 
					<input type = "submit" value = "삭제" ng-click="delete()">
				</form>
				<table id="data">
					<tr> 
						<td>제목</td>
						<td>출판사</td>				
					</tr>
					<tr ng-repeat = "x in names" ng-click="showData(x)">
						<td>{{x.name}}</td>
						<td>{{x.publisher}}</td>
						<td ng-show ="hide">{{x.id}}</td>
					</tr>
		 		 </table>
			</div>
        </div>
        <div id="tab3" class="tab">
          <div ng-controller = "mentorController">
				<form action ="http://www.fccrm.co.kr/smartqna/mentors" name = "upload_mentor" method = "post" enctype ="multipart/form-data">
					<label for ="name">*멘토 이름		:	</label>
					<input type = "text" name = "name" id ="name"><br><br>
					<label for ="publisher">소속 :	</label>
					<input type ="text" name = "dept" id ="dept"><br><br>
					<label for = "motto">모토   :   </label>
					<input type = "text" name ="motto" id = "motto"><br><br>
					<label for = "msg">메세지   :   </label>
					<input type = "textarea" name ="msg" id = "msg"><br><br>
					<label for = "file">이미지 업로드   :   </label>
					<input type = "file" name ="file" id = "file"/>
					<br><br>
					<input type = "button" value = "전송" onclick="_upload_mentor()">
				</form>
			</div>
		</div>
		<div id = "tab4" class = "tab">
			<div ng-controller = "mentorController">
				<form ng-show ="inputForm">
					이름 :  <input type = text ng-model =selectedRow.name ng-disabled = "val"> 
					소속 :  <input type = text ng-model = selectedRow.dept ng-disabled = "val">
					모토 :  <input type = text ng-model = selectedRow.motto ng-disabled = "val">
					메세지 : <input type = text ng-model = selectedRow.msg ng-disabled = "val">
						<br><br>
					<input type = "button" value  = "수정" ng-click = "update()" ng-show = "val" >
					<input type = "submit" value = "수정완료" ng-click="update_ok()"  ng-show="!val"> 
					<input type = "submit" value = "삭제" ng-click="delete()">
				</form>
				<table id="data">
					<tr> 
						<td>이름</td>
						<td>소속</td>
						<td>모토</td>
						<td>메세지</td>
					</tr>
					<tr ng-repeat = "x in names" ng-click="showData(x)">
						<td>{{x.name}}</td>
						<td>{{x.dept}}</td>
						<td>{{x.motto}}</td>
						<td>{{x.msg}}</td>
						<td ng-show ="hide">{{x.id}}</td>
					</tr>
		 		</table>
			</div>
		</div>
		<div id = "tab5" class = "tab">
			<div ng-controller = "userController">
				<form ng-show ="inputForm">
					id :  <input type = text ng-model =selectedRow.uid ng-disabled="true"> 
					이름 : <input type = text ng-model = selectedRow.name ng-disabled="true">
					기관명 : <input type = text ng-model = selectedRow.orgname>
					만기일 :  <input type = text ng-model = selectedRow.expdate>
					사용자타입 :  <input type = text ng-model = selectedRow.usertype>
					<br><br>
					<input type = "submit" value = "수정" ng-click="update()"> 
				</form>
				<table id="data">
					<tr> 
						<td>아이디</td>
						<td>이름</td>
						<td>기관명</td>
						<td>등록일</td>
						<td>만기일</td>
						<td>무료사용일</td>
						<td>사용자타입</td>
					</tr>
					<tr ng-repeat = "x in names" ng-click="showData(x)">
						<td>{{x.uid}}</td>
						<td>{{x.name}}</td>
						<td>{{x.orgname}}</td>
						<td>{{x.regtime}}</td>
						<td>{{x.expdate}}</td>
						<td>{{x.democnt}}</td>
						<td>{{x.usertype}}</td>
						<td ng-show ="hide">{{x.id}}</td>
					</tr>
		 		 </table>
			</div>
		</div>
		<div id = "tab6" class = "tab">
		  <div ng-controller = "agentController">
		    <form ng-show ="inputForm">
			 대표 이름 :  <input type = text ng-model =selectedRow.name ng-disabled = "true" > 
			 대리점 이름 : <input type = text ng-model = selectedRow.oname ng-disabled="true">
			 수수료 정보 : <input type = text  ng-model = selectedRow.fee ng-disabled = "!val">
			 <input type = "button" value  = "수수료 입력" ng-click = "addFee()" ng-show ="!val">
			 <input type = "button" value  = "확인" ng-click = "updateFee()" ng-show = "val">
			 <br>
			 <input type = "button" value  = "삭제" ng-click = "delete()">
			</form>
			<table id="data">
			 <tr> 
			  <td>대표 이름</td>
			  <td>대리점 이름</td>
			  <td>핸드폰 번호</td>	
			  <td>오피스 번호</td>
			  <td>담당 지역</td>			
			  <td>수수료   </td>
			 </tr>
			 <tr ng-repeat = "x in names" ng-click="showData(x)">
			  <td>{{x.name}}</td>
			  <td>{{x.oname}}</td>
			  <td>{{x.hp}}</td>
			  <td>{{x.op}}</td>
			  <td>{{x.lv0}} {{x.lv1}}</td>
			  <td>{{x.fee}}</td>
			  <td ng-show ="hide">{{x.id}}</td>
			 </tr>
		     </table>
		   </div>

		</div>
		<div id = "tab7" class = "tab">
		   <div ng-controller = "schoolContractController">
			<table id ="student">
			 <tr>
			   <td>이름</td>
			   <td>아이디</td>
			   <td>전화번호</td>
			   <td>학교</td>
			 </tr>
			 <tr ng-repeat = "x in obj">
			   <td>{{x.name}}</td>
			   <td>{{x.uid}}</td>
			   <td>{{x.hp}}</td>
			   <td>{{x.school}}</td>
			 </tr>	
			</table>
		   	<table id="data">
			 <tr> 
			  <td>학교 이름 </td>
			  <td>주소 </td>
			  <td>전화번호</td>	
			  <td>홈페이지</td>
			  <td>팩스</td>			
			  <td>계약 대리점 </td>
			  <td>계약 금액 </td>
			 </tr>
			 <tr ng-repeat = "x in names" ng-click="showData(x)">
			  <td>{{x.name}}</td>
			  <td>{{x.address}}</td>
			  <td>{{x.phone}}</td>
			  <td>{{x.homepage}}</td>
			  <td>{{x.fax}}</td>
			  <td>{{x.oname}}</td>
			  <td>{{x.price}}</td>
			  <td>{{x.id}}</td>
			  <td ng-show ="hide">{{x.sid}}</td>
			 </tr>
		     </table>
		   </div>

		</div>
 
		<div id = "tab8" class = "tab">
			
			<form name='form'>
				기존 패스워드 :<input type = "password" name = 'password'  placeholder ='password' required><br>
				새로운 패스워드 :<input  type="password" name='new_password' placeholder='new password' required><br>
				패스워드 확인 :<input  type="password" name='confirm_new_password' placeholder='confirm new password' required>    
			</form>

		</div>

    </div>





	 <button onclick = "window.location='logout.php'" style ="float : right">로그아웃</button>
</div>

<script>
$(document).ready(function() {
    $('.tabs .tab-links li a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
	
});
function userController($scope,$http){
  $http.get("http://www.fccrm.co.kr/smartqna/user")
  .success(function(response){
	 $scope.names = response.data;
	});

	$scope.showData =function(x){
	$scope.selectedRow = x;
	if(!$scope.inputForm==true)
		$scope.inputForm =true;
	};
};
function mentorController($scope,$http){
  $http.get("http://www.fccrm.co.kr/smartqna/mentors")
  .success(function(response){
	 $scope.names = response.data;
	});

	$scope.showData =function(x){
		$scope.selectedRow = x;
		if(!$scope.inputForm==true)
			$scope.inputForm =true;
		$scope.val = true;
	};
	 $scope.update_ok = function(){
	$scope.inputForm = !$scope.inputForm;
	var jsonObject = {name : $scope.selectedRow.name, publisher : $scope.selectedRow.publisher};
	//console.log(jsonObject);
	var res = $http.put('http://www.fccrm.co.kr/smartqna/mentors/'+$scope.selectedRow.id,jsonObject);
	res.success(function(data, status, headers, config){	
			alert("수정 완료");	
	});
	res.error(function(data,status,headers, config){
			alert("업데이트 실패"+JSON.stringify({data: data}));	
	});
  };
  $scope.update = function(){
	$scope.val = false;	
  };
  $scope.delete= function(){
	$scope.inpuForm = !$scope.inputForm;
	var res = $http.delete('http://www.fccrm.co.kr/smartqna/mentors/'+$scope.selectedRow.id);
	res.success(function(data,status,headers,config){
			alert("삭제 완료");
			window.location.reload();
	});
	res.error(function(data,status,headers,config){
			alert("삭제 실패"+JSON.stringlyfy({data:data}));
	});
   };
};
function agentController($scope,$http){
	$http.get("http://www.fccrm.co.kr/smartqna_dev/agent")
		.success(function(response){
			$scope.names = response.data;
			$scope.val = false;
		});

  $scope.showData =function(x){
		$scope.selectedRow = x;
		if(!$scope.inputForm==true)
			$scope.inputForm =true;
  };

  $scope.addFee = function(){
		$scope.val = true;
  };

	$scope.updateFee = function(){
	 $scope.val = false;
	 var jsonObject = {aid : $scope.selectedRow.aid, fee : $scope.selectedRow.fee};
     var res = $http.post("http://www.fccrm.co.kr/smartqna_dev/agent",jsonObject);
     res.success(function(data,status,headers,config){
		alert("업데이트 성공");
		window.location.reload();
	 });
	 res.error(function(data,status,headers,config){
		alert("업데이트 실패");	
	});
   };

};
function schoolContractController($scope,$http){
  $http.get("http://www.fccrm.co.kr/smartqna_dev/schoolContract")
	.success(function(response){
    	$scope.names = response.data;
  });
  $scope.showData = function(x){
	  var res = $http.get("http://www.fccrm.co.kr/smartqna_dev/student/"+x.id);
 	  res.success(function(data,status,headers,config){
		$scope.obj = data.data;
	  });
  };
};

function bookController($scope,$http) {
  $http.get("http://www.fccrm.co.kr/smartqna/book")
  .success(function(response) {
	  $scope.names = response.data;
	  });
  $http.get("http://www.fccrm.co.kr/smartqna/mentors")
  .success(function(response){
	 $scope.obj = response.data;
	});	
  $scope.showData =function(x){
	$scope.selectedRow = x;
	if(!$scope.inputForm==true)
		$scope.inputForm =true;
	$scope.val = true;
  };

  $scope.submit = function(){
	  var res = $http.post('http://www.fccrm.co.kr/smartqna/book')
	  .success(function(response){

	  });
  };

  $scope.update_ok = function(){
	$scope.inputForm = !$scope.inputForm;
	var jsonObject = {name : $scope.selectedRow.name, publisher : $scope.selectedRow.publisher};
	//console.log(jsonObject);
	var res = $http.put('http://www.fccrm.co.kr/smartqna/book/'+$scope.selectedRow.id,jsonObject);
	res.success(function(data, status, headers, config){	
			alert("수정 완료");	
	});
	res.error(function(data,status,headers, config){
			alert("업데이트 실패"+JSON.stringify({data: data}));	
	});
  };
  $scope.update = function(){
	$scope.val = false;	
  };
  $scope.delete= function(){
	$scope.inpuForm = !$scope.inputForm;
	var res = $http.delete('http://www.fccrm.co.kr/smartqna/book/'+$scope.selectedRow.id);
	res.success(function(data,status,headers,config){
			alert("삭제 완료");
			window.location.reload();
	});
	res.error(function(data,status,headers,config){
			alert("삭제 실패"+JSON.stringlyfy({data:data}));
	});
   };
};
</script>
<SCRIPT LANGUAGE = "JavaScript">
function _upload_book(){
	if(document.upload_book.file.value ==""){
		alert("파일을 첨부하세요");
		return;
	}else if(document.upload_book.name.value==""){
		alert("제목을 입력하세요");
		return;
	}else{
		document.upload_book.submit();
	}		
}
function _upload_mentor(){
	if(document.upload_mentor.name.value ==""){
		alert("이름을 입력하세요");
	}else{
		document.upload_mentor.submit();
	}
}
</SCRIPT>
</body>
</html>

