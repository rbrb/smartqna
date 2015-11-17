<?php
require 'rb-p533.php';
R::setup( 'mysql:host=localhost;dbname=smartqna',
                  'root', 'denters0318' );
?>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name = "viewport" content = "width=device-width, initial-scale = 1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <title>Smart QnA 대리점 회원가입</title>
 </head>
 <body>
  <div class = "container">
	<h2>회원가입 </h2>
	<form action ="checksignin.php" class="form-horizontal" role="form"  method = "post" name="signinForm">
		<div class = "form-group">
			<label for="aid">ID : </label>
			<input type = "text" class = "form-control" id = "aid" name = "aid" placeholder = " 아이디를 입력하세요">
		</div>
		<div class = "form-group">
			<label for="pass">Password : </label>
			<input type = "password" class = "form-control" id = "pass" name = "pass" placeholder = "비밀번호를 입력하세요">
		</div>
		<div class = "form-group">
			<label for="repass">confirm Password : </label>
			<input type = "password" class = "form-control" id = "repass" name = "repass" placeholder = "비밀번호 확인">
		</div>
		<div class = "form-group">
			<label for="name">name  : </label>
			<input type = "text" class = "form-control" id = "name" name = "name" placeholder = "이름">
		</div>
		<div class = "form-group">
			<label for="oname">office name : </label>
			<input type = "text" class = "form-control" id = "oname" name = "oname" placeholder = "회사이름">
		</div>
		<div class = "form-group">
			<label for="hp">hp: </label>
			<input type = "text" class = "form-control" id = "hp" name = "hp" placeholder = "핸드폰 번호">
		</div>
		<div class = "form-group">
			<label for="op">office phone : </label>
			<input type = "text" class = "form-control" id = "op" name = "op" placeholder = "회사 번호">
		</div>
		<div class = "form-group">
			<label for="email">email : </label>
			<input type = "email" class = "form-control" id = "email" name = "email" placeholder = "이메일">
		</div>
		<div class= "form-group">
			<label for="location">sales location : </label>
			<select class = "form-control" id = "location" name = "location"> 
				<option value='nonselect'>도 또는 특별시를 선택하세요</option>
				<?php
					try{
						$sql = "SELECT DISTINCT lv0 FROM region";
						$region =R::getAll($sql);
					}catch(RedBeanPHP\RedException\SQL $e){
						echo $e;
					} 
					foreach($region as $city){
						echo "<option value='".$city['lv0']."'>".$city['lv0']."</option>";
					}
				?>		
			</select>
			<select class ="form-control" id ="location_detail" name = "location_detail">
				<option value = 'nonselect2'>세부 지역을 선택하세요</option>
			</select> 
		</div>
		<br><button type = "button" class = "btn btn-default" onclick="_sign_in()">가입</button>
	</form>
  </div>
 </body>
</html>
<script>
$('select#location').change(function(){
	$.ajax({
		type:'GET',
		url:'getcities.php',
		data:{region : $('select#location').val()},
		success:function(result){
			var data = JSON.parse(result);
			changeOption(data.data);
		},
		error:function(){
			alert("서버 에러");
		}
	});
	return false;
});
function changeOption(data){
	for(j = document.signinForm.location.options.length-1; j>=0; j--){
		document.signinForm.location_detail.options.remove(j);	
	}	
	for(i =0 ; i < data.length ;i++){
		var optn = document.createElement("OPTION");
		optn.text = data[i].lv1;
		optn.value = data[i].lv1;
		document.signinForm.location_detail.options.add(optn);	
	} 
}
function _sign_in(){
	if(document.signinForm.aid.value ==""){
		alert("아이디를 입력하세요");
		return;
	}else if(document.signinForm.pass.value==""){
		alert("비밀번호를 입력하세요");
		return;
	}else if(document.signinForm.pass.value!=document.signinForm.repass.value){
		alert("비밀번호가 일치하지 않습니다");
		return;
	}else if(document.signinForm.name.value===""){
		alert("이름을 입력하세요");
		return;
	}else if(document.signinForm.oname.value===""){
		alert("대리점 이름을 입력하세요");
		return;
	}else if(document.signinForm.hp.value===""){
		alert("핸드폰 번호를 입력하세요");
		return;
	}else if(document.signinForm.op.value===""){
		alert("대리점 번호를 입력하세요");
		return;
	}else if(document.signinForm.location.value=="nonselect"){
		alert("지역을 선택하세요");
		return;	
	}else if(document.signinForm.location_detail.value===""){
		alert("세부 지역을 선택하세요");
		return;
	}else{
		document.signinForm.submit();
	}

}
</script>
