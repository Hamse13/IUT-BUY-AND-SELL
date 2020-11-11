<?php 
	include("files/functions.php");	
	$sql = "UPDATE orders SET orderStatus = '1' WHERE idorders = '{$_GET['id']}'";
	if($conn->query($sql)){
		message("Order was cleared successfully.","success");
	}else{
		message("Something went wrong while clearing order.","danger");
	}
	header("Location: orders.php");
 ?>