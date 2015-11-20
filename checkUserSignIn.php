<?php
require 'rb-p533.php';
R::setup( 'mysql:host=localhost;dbname=smartqna',
              'root', 'denters0318' );

$user = R::dispense('user');
$uid = $_POST['uid'];
$pass = $_POST['pass'];
$name= $_POST['name'];
$orgname=$_POST['orgname'];
$hp  = $_POST['hp'];
try{
	$existUser = R::findOne('user',"uid = '$uid'");
	if($existUser){
		echo '<script language="javascript">';
        echo 'alert("이미 존재하는 아이디입니다.");';
        echo 'window.location.href="userSignIn.php";';
        echo '</script>';
	}
$user->uid		 = 	$uid;
$user->name	 = 	$name;
$user->orgname 	 =	$orgname;
$user->hp 		 =	$hp;
$user->pass	 =  $pass;
$user->regtime = date("Y-m-d",time());
 R::store($user);
 R::exec("UPDATE user SET pass = PASSWORD('$pass') WHERE uid ='$uid'");

 echo '<script language="javascript">';

 echo 'alert("회원가입이 완료되었습니다.");';
 echo 'window.location.href="intro.php";';
 echo '</script>';


}catch(RedBeanPHP\RedException\SQL $e){
		echo "server error";
}

?>
