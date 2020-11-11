<?php 
	include("files/functions.php");
	if(isset($_SESSION['user']['userType'])){

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

 	<?php  		
		$test = "SELECT * FROM orders WHERE idorders = '{$_GET['id']}'";
		$tResults = $conn->query($test);
		$item = $tResults->fetch_assoc();
    $orderStatus = $item['orderStatus'];
		$detail = json_decode($item['details']); 
		if($tResults->num_rows>0){
 	 ?>

 	 <h3>ORDER ID <span class="badge mb-4 badge-dark">#<?php echo($item['idorders']); ?></span></h3>

      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Thumbnail</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
          </tr>
        </thead>
        <tbody>
          
          <?php 
          				$products = json_decode($item['products']);
          $tot = 0; foreach($products as $pro) { $tot += $pro->price; ?>
              <tr>
                <th scope="row" style="width: 25px;"><?php echo $pro->idproducts; ?></th>
                <td style="width: 100px;"><img width="100" src="img/uploads/<?php echo $pro->photo; ?>" alt=""></td>
                <td class="h4 pt-5"><?php echo $pro->productName;  ?></td>
                <td class="h3 pt-5"><?php echo $pro->price; ?> Tk</td>
              </tr>
           <?php } ?>
        </tbody>
        <tr>
          <th colspan="3" headers="" scope="" class="h4">TOTAL</th>
          <td class=" h3"><u><?php echo $tot; ?> Tk.</u></td>
        </tr>
      </table>
      <?php if(($orderStatus != 1)  && $_SESSION['user']['userType']=="admin" ){ ?>
        <a href="clear_order_process.php?id=<?php echo($item['idorders']); ?>" class="float-right btn-success btn btn-lg mt-3" title="">CLEAR ORDER</a>
      <?php }else{ ?>
        <a href="orders.php" class="float-right btn-dark btn btn-lg mt-3 mb-5" title="">BACK TO ALL ORDERS</a>
      <?php } ?>
<?php 	 } //include("files/footer.php"); ?>