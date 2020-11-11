<?php 
	include("files/functions.php");
	$sql = "SELECT * FROM products WHERE idproducts = '{$_GET['id']}'";
	$res = $conn->query($sql);
	$pro = $res->fetch_assoc();

	$_SESSION['cart'][$pro['idproducts']] = $pro;
	message("Product was added to cart successfully","success");
	header("Location: shop.php");
 ?>