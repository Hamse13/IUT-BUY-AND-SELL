<?php
include "files/functions.php";
?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IUT Buy & Sell</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="stylesheet" href="index.css">
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
                    <li><a id="sign" href="chat.php">Chats</a></li>
                    <?php if($_SESSION['user']['userType']  == "superAdmin"){?>
                        <li><a id="sign" href="super_admin.php">SUPER ADMIN</a></li>
                    <?php } ?>
                <?php } else { ?>
                    <li><a id="sign" href="login.php">Sign in</a></li>
                <?php } ?>

                <!-- <li><i class="fas fa-envelope fa-2x"></i> -->

            </ul>
        </nav>
    </div>

</section>


<section class="wrapper container">
    <section class="sidebar">
        <div class="sidebar-header">
            <!-- <p>Access Level: <span id="sidebar-nav-close"><i class="fa fa-times fa-2x" aria-hidden="true"></i></span></p> -->
            <h3>Categories</h3>
        </div>

        <nav class="sidebar-nav">

            <ul>
                <li><a href="index.php?cat=Smartphones" style="text-decoration: none; color: white;" title="">Smartphones</a>
                </li>
                <li><a href="index.php?cat=Computers" style="text-decoration: none; color: white;"
                       title="">Computers</a></li>
                <li><a href="index.php?cat=Accessories" style="text-decoration: none; color: white;" title="">Accessories</a>
                </li>
                <li><a href="index.php?cat=Books" style="text-decoration: none; color: white;" title="">Books</a></li>
                <li><a href="index.php?cat=Sports" style="text-decoration: none; color: white;" title="">Sports</a></li>
            </ul>
        </nav>
    </section>

    <section class="main-page">
        <div class="main-page-header">
            <?php IF (isset($_GET['cat'])) { ?>
                <h3><?php echo($_GET['cat']) ?> Category</h3>
            <?php } else { ?>
                <h3>Latest items</h3>
            <?php } ?>
        </div>

        <!--
        date("Y/m/d")
        $date->format('U = Y-m-d H:i:s') . "\n";
         -->
        <!--
           print_r($product['uploadDate']);
         -->
        <?php
        if (isset($_GET['cat'])) {
            $products = getCategoryProducts($_GET['cat'], 100);
        } else {
            $products = getAllProducts(100);
        }
        if (!empty($products)) {
        ?>

        <div class="main-page-product">
            <?php foreach ($products as $product) {
                ?>
                <div class="card">
                    <img src="img/uploads/<?php echo($product['photo']); ?>" alt="Avatar">
                    <div class="item">
                        <h4>
                            <b><a href="product.php?id=<?php echo($product['idproducts']); ?>"><?php echo($product['productName']); ?></a></b>
                        </h4>
                        <small><?php echo myTime($product['uploadDate']); ?></small>
                        <p id="con"><?php if (isset($product['condition'])) {
                                echo $product['condition'];
                            } ?></p>
                        <p id="price">Price: BDT <?php echo($product['price']); ?></p>
                    </div>
                </div>
            <?php } ?>

            <?php } else {
                ?>

                <style>
                    .my-jumbotron {
                        margin: 10%;
                        background-color: white;
                        color: black;
                        padding: 70px;
                        border: #e0e1dd solid 2px;
                        font-size: 30px;
                        border-radius: 15px;
                    }

                </style>

                <div class="my-jumbotron">
                    <h2>Alert</h2>
                    <hr>
                    <br>
                    <p>There is no item uploaded in <?php echo($_GET['cat']); ?> category so far. Please try another
                        category.</p>
                </div>
            <?php } ?>
        </div>
    </section>
</section>


</body>

</html>