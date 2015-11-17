<?php

require 'rb-p533.php';
R::setup( 'mysql:host=localhost;dbname=smartqna',
                  'root', 'denters0318' );
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id 	= $_POST["id"];
	$pass = $_POST["pass"];
	if($_POST["option"]=="admin"){
		R::dispense('user');
		$user = R::findOne('user',"uid = '$id' AND pass = PASSWORD('$pass') AND usertype ='10'");
		if(isset($user)){
			session_register('uid');
			$_SESSION['login_user'] = $id;
			header("location: admin.php");
		}else{
			echo '<script language="javascript">';
			echo 'alert("아이디 또는 패스워드가 잘못되었습니다");';
			echo 'window.location.href="login.php";';
			echo '</script>';
		}
	}else if($_POST["option"]=="agent"){
		R::dispense('agent');
		$agent = R::findOne('agent',"aid = '$id' AND pass = PASSWORD('$pass')");
		$agent = R::exportAll($agent);
		if(isset($agent)){
			session_register('aid');
			$_SESSION['login_user'] = $id;
			$_SESSION['agent'] = $agent[0];
			header("location: agent.php");
		}else{
			echo '<script language="javascript">';
			echo 'alert("아이디 또는 패스워드가 잘못되었습니다");';
			echo 'window.location.href="login.php";';
			echo '</script>';
		}
	}else{
			echo '<script language="javascript">';
			echo 'alert("사용자 타입을 선택해 주세요");';
			echo 'window.location.href="login.php";';
			echo '</script>';
	}
}
?>
