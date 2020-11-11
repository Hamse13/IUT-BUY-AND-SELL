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

if(isset($_GET['ban'])){
    $userId = trim($_GET['ban']);
    $sql = "UPDATE users SET banned = 1 WHERE idusers = {$userId}";
    if($conn->query($sql)){
        message("User banned successfully.", "warning");
        header("Location: super_admin_all_users.php");
        die();
    }
}

if(isset($_GET['unban'])){
    $userId = trim($_GET['unban']);
    $sql = "UPDATE users SET banned = 0 WHERE idusers = {$userId}";
    if($conn->query($sql)){
        message("Ban remove from user successfully.", "success");
        header("Location: super_admin_all_users.php");
        die();
    }
}


if(isset($_GET['delete'])){
    $userId = trim($_GET['delete']);
    $sql = "DELETE FROM users WHERE idusers = {$userId}";
    if($conn->query($sql)){
        $sql = "DELETE FROM products WHERE uploadedBy = {$userId}";
        $conn->query($sql);
        message("User was deleted successfully.", "success");
        header("Location: super_admin_all_users.php");
        die();
    }
}

?><!DOCTYPE html>
 <html>
 <head>
 	<title>ALL Products</title>
 	<?php include "files/admin_head.php";?>

 <div class="container">


 	<div class="row mt-5">
            <?php if(isset($_GET['confirmDelete'])){
                $userId = trim($_GET['confirmDelete']);
                ?>
        <div class="col-md-12">
            <h2>Are you sure you want to delete user <b>#<?php echo $userId; ?></b></h2>
                <a href="super_admin_all_users.php" class="btn btn-outline-success">CANCEL</a>
                <a href="super_admin_all_users.php?delete=<?php echo $userId; ?>" class="btn btn-danger">DELETE</a>
        </div>
            <?php die();}  ?>
        <div class="col-md-7">
            <h2>All users</h2>
 		</div>

 		<div class="col-5">
	 		<form action="admin_all_products.php" method="get" class="input-group mb-4">
			  <input type="text" name="search" required="" class="form-control border-dark" placeholder="Search a user" aria-label="Search a product" aria-describedby="SEARCH">
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
			  <a href="super_admin.php" class="list-group-item list-group-item-action border-0">All Products</a>
			  <a href="super_admin_all_users.php" class="list-group-item list-group-item-action border-0 bg-light ">All Users</a>
			</div>

 		</div>
 		<div class="col-8 pr-0">


			 <?php
             $sql = "SELECT * FROM users";
			$tResults = $conn->query($sql);
			if ($tResults->num_rows > 0) {
				?>
				 	<table class="table table-bordered table-hover">
					  <thead class="bg-dark text-white">
					    <tr>
					      <th scope="col" style="width: 10px;">#</th>
					      <th scope="col">Name</th>
					      <th scope="col">Products</th>
					      <th scope="col">Action</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php while ($users = $tResults->fetch_assoc()) {
					//$details = json_decode($class['classDetails']);
					?>
						    <tr>
						      <th scope="row"><?php echo $users['idusers']; ?></th>
						      <td class="text-capitalize"><?php echo $users['username']; ?></td>
						      <td class="text-capitalize" style="width: 150px;" >
                                  <?php
                                    echo (countUserProducts($users['idusers']));
                                  ?>
                              </td>
						      <td class="text-capitalize" style="width: 250px;" >
						      	<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <?php if($users['banned'] != 1){ ?>
                                        <a  href="super_admin_all_users.php?ban=<?php echo $users['idusers']; ?>" class="btn btn-success">BAN USER</a>
                                    <?php }else{ ?>
                                        <a  href="super_admin_all_users.php?unban=<?php echo $users['idusers']; ?>" class="btn btn-warning">REMOVE BAN</a>
                                    <?php } ?>
								  <a href="super_admin_all_users.php?confirmDelete=<?php echo $users['idusers']; ?>" class="btn btn-danger">DELETE</a>
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
<!--
firstname

lastname
password
regdate
userdetails
username
userType

-->


<?php //include("files/footer.php"); ?>