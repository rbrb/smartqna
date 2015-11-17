<?php
require 'rb-p533.php';
R::setup( 'mysql:host=localhost;dbname=smartqna',
              'root', 'denters0318' );

$agent = R::dispense('agent');
$aid = $_POST['aid'];
$pass = $_POST['pass'];
$name= $_POST['name'];
$oname=$_POST['oname'];
$hp  = $_POST['hp'];
$op = $_POST['op'];
$email = $_POST['email'];
$location = $_POST['location'];
$location_detail = $_POST['location_detail'];
try{
	$existUser = R::findOne('agent',"aid = '$aid'");
	if($existUser){
		echo '<script language="javascript">';
        echo 'alert("이미 존재하는 아이디입니다.");';
        echo 'window.location.href="signin.php";';
        echo '</script>';
	}
$agent->aid		 = 	$aid;
$agent->name	 = 	$name;
$agent->oname 	 =	$oname;
$agent->hp 		 =	$hp;
$agent->op 		 =	$op;
$agent->email	 =  $email;	
$agent->lv0		 =  $location;
$agent->lv1		 =  $location_detail;
$agent->pass	 =  "1234";
$agent->fee	 	 =  '0';
 R::store($agent);
 R::exec("UPDATE agent SET pass = PASSWORD('$pass') WHERE aid ='$aid'");

 echo '<script language="javascript">';

 echo 'alert("회원가입이 완료되었습니다.");';
 echo 'window.location.href="login.php";';
 echo '</script>';


}catch(RedBeanPHP\RedException\SQL $e){
		echo "server error";
}

?>
