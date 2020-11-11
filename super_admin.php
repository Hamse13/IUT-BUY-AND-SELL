<?php
include "files/functions.php";

if (isset($_SESSION['user']['userType'])) {
	if ($_SESSION['user']['userType'] == "admin") {
	} else {
		//header("Location: customer.php");
	}
} else {
	message("Login before you proceed", "warning");
	header("Location: login.php");
}
?><!DOCTYPE html>
 <html>
 <head>
 	<title>ALL Products</title>
 	<?php include "files/admin_head.php";?>

 <div class="container">


 	<div class="row mt-5">

 		<div class="col-md-7">
	 		<a href="admin_add_new_product.php" class="btn btn-dark" title="Add New Student">Add New Product</a>
 		</div>

 		<div class="col-5">
	 		<form action="admin_all_products.php" method="get" class="input-group mb-4">
			  <input type="text" name="search" required="" class="form-control border-dark" placeholder="Search a product" aria-label="Search a product" aria-describedby="SEARCH">
			  <div class="input-group-append">
			    <button type="submit" class="btn btn-outline-dark" type="button" id="button-addon2">SEARCH</button>
			  </div>
			</form>
 		</div>
 	</div>

 	<div class="row">
 		<div class="col-4 pl-0 pr-0"> 
			<div class="list-group pl-0 pr-0 border-0">
			  <a  class="list-group-item list-group-item-action border-0 bg-dark text-white rounded-0 ">
			    Super Admin
			  </a>
			  <a href="super_admin.php" class="list-group-item list-group-item-action border-0 bg-light">All Products</a>
			  <a href="super_admin_all_users.php" class="list-group-item list-group-item-action border-0">All Users</a>
			</div>

 		</div>
 		<div class="col-8 pr-0">
 			

			 <?php
			if (isset($_GET['search'])) {
				$search = $_GET['search'];
				$sql = "SELECT * FROM products WHERE productName LIKE '%$search%'";
			} else {
				$sql = "SELECT * FROM products";
			}
			$tResults = $conn->query($sql);
			if ($tResults->num_rows > 0) {
				?>
				 	<table class="table table-bordered table-hover">
					  <thead class="bg-dark text-white">
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Product</th>
					      <th scope="col">Price</th>
					      <th scope="col">Photo</th>
					      <th scope="col">Action</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php while ($pro = $tResults->fetch_assoc()) {
					//$details = json_decode($class['classDetails']);
					?>
						    <tr>
						      <th scope="row"><?php echo $pro['idproducts']; ?></th>
						      <td class="text-capitalize"><?php echo $pro['productName']; ?></td>
						      <td class="text-capitalize"><?php echo $pro['price']; ?></td>
						      <td class="text-capitalize" style="width: 150px;" ><center><img src="img/uploads/<?php echo $pro['photo']; ?>" width="50" alt=""></center></td>
						      <td class="text-capitalize" style="width: 50px;" >
						      	<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
								  <a  href="product.php?id=<?php echo $pro['idproducts']; ?>" class="btn btn-info">VIEW</a>
								  <a href="delete_process.php?id=<?php echo $pro['idproducts']; ?>" class="btn btn-danger">DELETE</a>
								</div>
						      </td>
						    </tr>
						<?php }?>
					  </tbody>
					</table>
				<?php } else {?>
					<div class="jumbotron">
						<h3>Alert</h3>
						<hr>
						<p>There was no product found on database.</p>
					</div>
				<?php }?>

	 		</div>
	 	</div>



<?php //include("files/footer.php"); ?>