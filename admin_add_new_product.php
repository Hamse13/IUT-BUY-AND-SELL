<?php 
	include("files/functions.php");
	if(isset($_POST['addNewProduct'])){



		$target_dir = "img/uploads/";
		$filename =  basename($_FILES["productPhoto"]["name"]);
		$filename = time()."_".$filename;
		$target_file = $target_dir . $filename;	

		move_uploaded_file($_FILES["productPhoto"]["tmp_name"], $target_file);

		unset($_POST['addNewProduct']);
		$_POST['photo'] = $filename;
		$_POST['uploadDate'] = time();
		$details = json_encode($_POST);

		$_POST['productName'] = $city = $conn->real_escape_string($_POST['productName']);
		$_POST['description'] = $city = $conn->real_escape_string($_POST['description']);
		$details  = $city = $conn->real_escape_string($details);
/*
INSERT INTO `products`(   , ,) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])
*/

		$sql = "INSERT INTO `products` (
					`productName`, 
					`price`, 
					 `productCategory`, 
					`description`,  
					`photo`,
					`uploadDate`,
					`uploadedBy`, 
					`details` 
				) VALUES (
					'{$_POST['productName']}',
					{$_POST['price']},
					'{$_POST['productCategory']}',
					'{$_POST['description']}',
					'{$_POST['photo']}',
					'{$_POST['uploadDate']}',
					'{$_SESSION['user']['idusers']}',
					'{$details}'
				)";
		
		if($conn->query($sql)){
			message("New prodduct was uploaded successfully","success");
			header("Location: admin_all_products.php");
		}else{
			message("Something went wrong while uploading a new product. Please try again","danger");
		}

	}
?><!DOCTYPE html>
 <html>
 <head>
 	<title>ALL STUDENTS</title>
 	<?php include("files/admin_head.php"); ?>
 
 <div class="container mt-5">
 	
 
	<form enctype="multipart/form-data" action="admin_add_new_product.php" method="post" class="border p-4 pb-5 rounded">
 	<h3 class="mb-3">Adding new product</h3>
	  <div class="form-row">
	    <div class="form-group col-md-8">
	      <label for="productName">Product Name</label>
	      <input type="text" name="productName" required="" class="form-control" id="productName" autofocus="">
	    </div>
	    <div class="form-group col-md-4">
	      <label for="price">Price</label>
	      <input type="number" class="form-control text-center" name="price" id="price" >
	    </div>
	  </div>

	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="productCategory">Product Category</label>
	      <select name="productCategory" required="" id="productCategory" class="form-control">
	      	<option ></option>
	      	<option value="Sports">Sport</option>
	      	<option value="Smartphones">Smartphones</option>
	      	<option value="Computers">Computers</option>
	      	<option value="Accessories">Accessories</option>
	      	<option value="Books">Books</option>
	      </select>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="phtot">Product Photo</label>
	      <input accept=".png,.jpg,.jpeg" type="file" class="form-control" name="productPhoto" id="phtot" placeholder="Product Photo">
	    </div>
	  </div>

	  <div class="form-row mb-3">
	  	 <label for="phtot">Product Description</label>
	  	<textarea class="form-control" rows="4" name="description" required=""></textarea>
	  </div>

	  <button type="submit" name="addNewProduct" value="addNewProduct" class="btn btn-primary float-right">ADD NEW Product</button>
	</form>
