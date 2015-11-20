<?php
session_start ();
require 'rb-p533.php';
if (! isset ( $_SESSION ['login_user'] )) {
	// if(!session_is_registered("uid")){
	header ( "location:intro.php" );
}
R::setup ( 'mysql:host=localhost;dbname=smartqna', 'root', '' );

if (is_ajax ()) {
	returnData ();
}
// Function to check if the request is an AJAX request
function is_ajax() {
	return isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest';
}
function returnData() {
	$return = $_POST;
	// Do what you need to do with the info. The following are some examples.
	// if ($return["favorite_beverage"] == ""){
	// $return["favorite_beverage"] = "Coke";
	// }
	// $return["favorite_restaurant"] = "McDonald's";
	R::dispense ( 'user' );
	$id = $_SESSION ['login_user'];
	$user = R::findOne ( 'user', "uid = '$id'" );
	
	$return ["userName"] = $user->name;
	$return ["userHp"] = $user->hp;
	
	//$return ["json"] = json_encode ( $return );
	echo json_encode ( $return );
}
?>