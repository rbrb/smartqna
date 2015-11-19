<?php

require 'rb-p533.php';
R::setup( 'mysql:host=localhost;dbname=smartqna',
                  'root', '' );
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id 	= $_POST["id"];
	$pass = $_POST["pass"];
	if($_POST["option"]=="admin"){
		R::dispense('user');
		$user = R::findOne('user',"uid = '$id' AND pass = PASSWORD('$pass') AND usertype ='10'");
		if(isset($user)){
			session_start();
			$_SESSION['login_user'] = $id;
			session_write_close();
			header("location: admin_core.php");

		}else{
			echo '<script language="javascript">';
			echo 'alert("아이디 또는 패스워드가 잘못되었습니다");';
			echo 'window.location.href="admin.php";';
			echo '</script>';
		}
	}
	else if($_POST["option"]=="agent"){
		R::dispense('agent');
		$agent = R::findOne('agent',"aid = '$id' AND pass = PASSWORD('$pass')");
		if(isset($agent)){
			session_start();
			$_SESSION['login_user'] = $id;
			session_write_close();
			header("location: basicInfo.php");
		}else{
			echo '<script language="javascript">';
			echo 'alert("아이디 또는 패스워드가 잘못되었습니다");';
			echo 'window.location.href="agent.php";';
			echo '</script>';
		}
	}
	else if($_POST["option"] == "user")
	{
		R::dispense('user');
		$user = R::findOne('user',"uid = '$id' AND pass = PASSWORD('$pass')");
		if(isset($user)){
			session_start();
			$_SESSION['login_user'] = $id;
			session_write_close();
			header("location: intro.php");
		}else{
			echo '<script language="javascript">';
			echo 'alert("아이디 또는 패스워드가 잘못되었습니다");';
			echo 'window.location.href="userLogIn.php";';
			echo '</script>';
		}
	}
	else{
			echo '<script language="javascript">';
			echo 'alert("사용자 타입을 선택해 주세요");';
			echo 'window.location.href="intro.php";';
			echo '</script>';
	}
}
?>
