<?php 
	include("files/functions.php");

	$order['customerId'] = $_SESSION['user']['idusers'];
	$order['customer'] = $_SESSION['user'];
	$order['products'] = $_SESSION['cart'];
	$customers = json_encode($_SESSION['user']);
	$products = json_encode($order['products']);
	$products= $conn->real_escape_string($products);
	$order['orderDate'] = time();
	$details = $conn->real_escape_string(json_encode($order));
	

	$tot = 0; 
	foreach($_SESSION['cart'] as $item) { $tot += $item['price']; }
	$order['totalPrice'] = $tot;

	$sql = "INSERT INTO orders (
			customerId,
			details,
			orderDate,
			products,
			customer,
			totalPrice
		) VALUES (
			'{$order['customerId']}',
			'{$details}',
			'{$order['orderDate']}',
			'{$products}',
			'{$customers}',
			'{$order['totalPrice']}'
		)";

	if($conn->query($sql)){
		unset($_SESSION['cart']);
		message("Your order was placed successfully","success");
		header("Location: customer.php");
		die();
	}else{
		die($sql);
		message("Something went wrong while placing your order. Please try again.","danger");
		header("Location: shop.php");
	}
/*
customerId
details
idorders
orderDate
products
*/
 ?>