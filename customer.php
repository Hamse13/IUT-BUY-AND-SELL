<?php 
	header("Location: admin_all_products.php");
	exit();
	die();
	include("files/functions.php");
	if(isset($_SESSION['user'])){
		if($_SESSION['user']['userType']=="customer"){

		}else{

			header("Location: admin_all_products.php");
		}
	}else{

		message("Login before you proceed","warning");
		header("Location: login.php");
	}
?><!DOCTYPE html>
 <html>
 <head>
 	<title>ALL Products</title>
 	<?php include("files/admin_head.php"); ?>
 
 <div class="container mt-5">
 	


<!-- 
	``, 
	``, 
	 `productCategory`, 
	`description`,  
	`photo`,
	`uploadDate`, 
	`details`
 -->
 	<?php  		
		$test = "SELECT * FROM orders WHERE customerId = '{$_SESSION['user']['idusers']}'";
		$tResults = $conn->query($test);
		if($tResults->num_rows>0){
 	 ?>
	 	<table class="table table-bordered table-hover">
		  <thead class="bg-dark text-white">
		    <tr>
		      <th scope="col">ORDER ID</th>
		      <th scope="col">CUSTOMER</th>
		      <th scope="col">ADRESS</th>
		      <th scope="col">TOTAL PRICE</th>
		      <th scope="col">DETAILS</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php while ($order = $tResults->fetch_assoc()) { 
		  			$customer = fetchUser($order['customerId']);
		  			$orderStatus = $order['orderStatus'];
		  	?>
			    <tr>
			      <th scope="row">#<?php echo $order['idorders']; ?></th>
			      <td class="text-capitalize"><?php echo($customer['username']);  ?></td>
			      <td class="text-capitalize"><?php echo json_decode($customer['userdetails'])->Adress; ?></td>
			      <td class="text-capitalize h3 text-center" style="width: 150px;" ><?php echo($order['totalPrice']); ?> Tk</td>
			      <td class="text-capitalize" style="width: 50px;" >
			      	<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
					  <a  href="order.php?id=<?php echo $order['idorders'];  ?>" class="btn btn-dark">VIEW</a>
					 	<?php if($orderStatus == 0){ ?>
						  <a href="#" class="btn btn-warning">PENDING</a>
						<?php }else{ ?>
						  <a href="#" class="btn btn-success">CLEARED</a>
						<?php } ?>
					</div>
			      </td>
			    </tr>
			<?php } ?>
		  </tbody>
		</table>
	<?php }else{ ?>
		<div class="jumbotron">
			<h3>Alert</h3>
			<hr>
			<p>Yo have not placed any order yet. Go to our <a href="shop.php" title="">Shop</a> make some order NOW</p>
		</div>
	<?php } ?>





<?php 	//include("files/footer.php"); ?>