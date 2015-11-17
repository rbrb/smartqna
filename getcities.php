<?php
require 'rb-p533.php';
R::setup( 'mysql:host=localhost;dbname=smartqna',
                  'root', 'denters0318' );
$region = $_GET['region'];
$sql ="SELECT lv1 FROM region WHERE lv0 ='$region'";
try{
	$cities = R::getAll($sql);
}catch(RedBeanPHP\RedException\SQL $e){
	echo $e;
}
	$obj = array('data'=>$cities);
	echo json_encode($obj);
?>
