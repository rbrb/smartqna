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
  <title>Smart QnA 사용자 회원가입</title>
 </head>
 <body>
  <div class = "container">
	<h2>사용자 회원가입 </h2>
	<form action ="checkUserSignIn.php" class="form-horizontal" role="form"  method = "post" name="signinForm">
		<div class = "form-group">
			<label for="uid">ID : </label>
			<input type = "text" class = "form-control" id = "uid" name = "uid" placeholder = " 아이디를 입력하세요">
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
			<label for="orgname">organization name : </label>
			<input type = "text" class = "form-control" id = "orgname" name = "orgname" placeholder = "기관이름">
		</div>
		<div class = "form-group">
			<label for="hp">hp: </label>
			<input type = "text" class = "form-control" id = "hp" name = "hp" placeholder = "핸드폰 번호">
		</div>
		<br><button type = "button" class = "btn btn-default" onclick="_sign_in()">가입</button>
	</form>
  </div>
 </body>
</html>
<script>
function _sign_in(){
	if(document.signinForm.uid.value ==""){
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
	}else if(document.signinForm.orgname.value===""){
		alert("대리점 이름을 입력하세요");
		return;
	}else if(document.signinForm.hp.value===""){
		alert("핸드폰 번호를 입력하세요");
		return;
	}else{
		document.signinForm.submit();
	}

}
</script>
