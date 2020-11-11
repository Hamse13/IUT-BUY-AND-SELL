<?php
include "files/functions.php";
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE idproducts = '{$id}'";
$re = $conn->query($sql);
$data = $re->fetch_assoc();

$photo = "img/uploads/" . $data['photo'];

if (file_exists($photo)) {
	unlink($photo);
}

$sql = "DELETE FROM products WHERE idproducts = '{$id}'";
if ($conn->query($sql)) {
	message("Product was deleted successfully.", "success");
} else {
	message("Something went wrong while deleting the product. Please try again.", "danger");
}
header("Location: admin_all_products.php");
?>