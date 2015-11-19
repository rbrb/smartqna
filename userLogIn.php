<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name = "viewport" content = "width=device-width, initial-scale = 1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <title>Smart QnA 사용자 로그인</title>
 </head>
 <body>
  <div class = "container">
	<h2>사용자 로그인 </h2>
	<form action ="checklogin.php" class="form"  method = "post" role="form">
		<div class = "form-group">
			<label for="uid">ID : </label>
			<input type = "text" class = "form-control" id = "uid" name = "id" placeholder = "사용자 아이디를 입력하세요">
		</div>
		<div class = "form-group">
			<label for="pass">Password : </label>
			<input type = "password" class = "form-control" id = "pass" name = "pass" placeholder = "비밀번호를 입력하세요">
		</div>
		<input type = "hidden" name = "option" value="user" checked="true">
		<br><button type = "submit" class = "btn btn-default">로그인</button>
	</form>
		 <button class = "btn btn-default" onclick = "window.location='userSignIn.php'" style ="float : right">사용자 회원가입</button>
  </div>
 </body>
</html>
