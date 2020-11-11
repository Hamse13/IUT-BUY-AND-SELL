<?php 
    include("files/functions.php");
    if(isset($_SESSION['cart'])){
      if(count($_SESSION['cart'])<1){
        message("Please add some items in cart before you proceed","danger");
        header("Location: shop.php");
        die();
      }
    }else{
        message("Please add some items in cart before you proceed","danger");
        header("Location: shop.php");
        die();
    }
    include("files/header.php");
?>

    <div class="title" >
        <h1>YOUR CART</h1>
        <p>We give you the quality that you deserve!</p>
    </div>

    <div class="container">
      
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
          
          <?php $tot = 0; foreach($_SESSION['cart'] as $item) { $tot += $item['price']; ?>
              <tr>
                <th scope="row" style="width: 25px;"><?php echo $item['idproducts']; ?></th>
                <td style="width: 100px;"><img width="100" src="img/uploads/<?php echo $item['photo']; ?>" alt=""></td>
                <td class="h4 pt-5"><?php echo $item['productName']; ?></td>
                <td class="h3 pt-5"><?php echo $item['price']; ?> Tk</td>
              </tr>
           <?php } ?>
        </tbody>
        <tr>
          <th colspan="3" headers="" scope="" class="h4">TOTAL</th>
          <td class=" h3"><u><?php echo $tot; ?> Tk.</u></td>
        </tr>
      </table>

      <a href="place_order_process.php" class="btn btn-dark btn-lg float-right mb-5 mt-2" title="">PLACE MY ORDER NOW</a>
    </div>

<!-- 
    [] => 26
    [] => Masuri Prem Helmet Jn92
    [description] => You can get your order delivered to participating stores within the UK. Once your order has been delivered to your chosen store, you’ll get an email confirming it’s ready to be collected.
    [] => 1556338380_85502322_l.jpg
    [price] => 3000
    [details] => {"productName":"Masuri Prem Helmet Jn92","price":"3000","productCategory":"others","description":"You can get your order delivered to participating stores within the UK. Once your order has been delivered to your chosen store, you\u2019ll get an email confirming it\u2019s ready to be collected.","photo":"1556338380_85502322_l.jpg","uploadDate":1556338380}
    [uploadDate] => 1556338380
    [productCategory] => others
)
            

 -->





        <a href="shop.php" class="add-to-cart mb-5" title="">BACK TO SHOPPING</a>

<?php 
    include("files/footer.php");
?>