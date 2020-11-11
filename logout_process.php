<?php 
	include("files/functions.php");
	if(isset($_SESSION['user'])){
		$_SESSION['user'] = null;
	}
	message("Your account was logged out successfully.","success");
	header("Location: shop.php");
	die();
 ?>