<?php
include "files/functions.php";

$sql = "SELECT * FROM products,users WHERE idproducts= '{$_GET['id']}' AND uploadedBy =  idusers";
$results = $conn->query($sql);
$pro = $results->fetch_assoc();
$ready_to_send = false;


$receiver = "";
$product_id = "";
$sender = "";
if (isset($_SESSION['user']['idusers'])) {
    $sender = $_SESSION['user']['idusers'];
    $product_id = $pro['idproducts'];
    $receiver = $pro['uploadedBy'];
    if ($receiver != $sender) {
        $ready_to_send = true;
    }
}




?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="stylesheet" href="product.css">
    <link href="fontawesome-free-5.7.2-web/css/all.css" rel="stylesheet">
    <script src="main.js"></script>


</head>

<body>

<section class="header-section">
    <div class="container">
        <nav class="header-items">
            <ul>
                <li><a id="home" href="index.php">IUT Buy & Sell</a></li>
                <li id="search"><input type="text" placeholder="Search..."></li>

                <?php if (isset($_SESSION['user']['username'])) { ?>
                    <li><a id="sign" href="admin_all_products.php">Dashboard</a></li>
                <?php } else { ?>
                    <li><a id="sign" href="login.php">Sign in</a></li>
                <?php } ?>

            </ul>
        </nav>
    </div>

</section>


<section class="container wrapper ">

    <section class="main-page">
        <div class="main-page-header">
            <h3><?php echo($pro['productName']); ?></h3>
            <small><?php echo myTime($pro['uploadDate']); ?></small>
            <p>By: <?php echo $pro['username']; ?></p>
        </div>

        <div class="main-page-product container">
            <img src="img/uploads/<?php echo($pro['photo']); ?>" alt="Avatar">
            <img src="img/uploads/<?php echo($pro['photo']); ?>" alt="Avatar">
        </div>
    </section>

    <section class="sidebar">
        <div class="sidebar-header">
            <h3>Chat with seller</h3>
            <?php if ($ready_to_send) { ?>
                <form action="chat.php" method="post">
                <textarea style="width: 100%; margin-top: .6rem; font-size: 1.3rem;"
                          placeholder="Type your message here.." name="message" required rows="10" id="message"
                          class="input-control"></textarea>
                    <input type="text" required="" name="sender" readonly hidden value="<?php echo $sender; ?>" >
                    <input type="text" required="" name="receiver" readonly hidden value="<?php echo $receiver; ?>" >
                    <input type="text" required="" name="product" readonly hidden value="<?php echo $product_id; ?>" >
                    <button type="submit"
                            style="padding: 10px; float: right; background-color: #fe7a4a; border-color: #fe7a4a; color: white; font-weight: bold; font-size: 17px;">
                        SEND MESSAGE
                    </button>
                </form>
            <?php }else{ ?>
                <a href="login.php">Login to chat</a>
            <?php } ?>
        </div>


        <div class="product-details">
            <h3>Product Details</h3>
            <div>
                <strong>ID</strong>
                <span>#<?php echo $pro['idproducts']; ?></span>
            </div>
            <div>
                <strong>Product Name</strong>
                <span><?php echo($pro['productName']); ?></span>
            </div>
            <div>
                <strong> </strong>
                <span><?php echo($pro['condition']); ?></span>
            </div>
            <div>
                <strong>Price</strong>
                <br>
                <span>BDT <?php echo($pro['price']); ?></span>
            </div>
            <div><br>
                <strong>Description</strong>
                <span><?php echo($pro['description']); ?></span>
            </div>
        </div>
    </section>
</section>


<!-- <section class="product-details">
    <div class="container">
        <h3>Product Details</h3>
        <div>
            <strong>ID</strong>
        </div>
        <div>
            <strong>Product Name</strong>
        </div>
        <div>
            <strong>Condition</strong>
        </div>
        <div>
            <strong>Price</strong>
        </div>
    </div>

</section> -->


</body>

</html>