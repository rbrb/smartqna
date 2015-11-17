<?php

require 'rb-p533.php';
R::setup( 'mysql:host=localhost;dbname=smartqna',
                  'root', 'denters0318' );
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$uid = $_POST['mid'];
	$pass = $_POST['password'];
	$newPass = $_POST['new_password'];
	$cnewPass = $_POST['confirm_new_password'];

	$user = R::findOne('user',"uid ='$uid' AND pass = PASSWORD('$pass') AND usertype = '10'");
	if(!isset($user)){		
 	     echo '<script language="javascript">';
         echo 'alert("비밀번호가 일치하지 않습니다");';
         echo '</script>';
	}else if($newPass!= $cnewPass){
		 echo '<script language="javascript">';
         echo 'alert("새로운 비밀번호와 새로운 비밀번호 확인이 일치하지 않습니다");';
         echo '</script>';
	}else{
		$sql = "UPDATE user SET pass = PASSWORD('$newPass') WHERE uid = '$uid'";
		try{
			R::exec($sql);
		}catch(RedBeanPHP\RedException\SQL $e){
			echo $e;
		}
		echo '<script language="javascript">';
        echo 'alert("변경되었습니다");';
        echo '</script>';
	}
	   
  echo '<script language="javascript">';
  echo 'window.location.href="admin.php";';
  echo '</script>';
}

?>
