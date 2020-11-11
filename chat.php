<?php
include "files/functions.php";
if (
    isset($_POST['message']) &&
    isset($_POST['sender']) &&
    isset($_POST['receiver']) &&
    isset($_POST['product'])
) {
    $message_body = $_POST['message'];
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $product = $_POST['product'];


    $sql = "SELECT * FROM chats WHERE (
        product = '{$product}' AND 
        receiver = '{$receiver}' AND
        sender = '{$sender}'
        ) OR (
        product = '{$product}' AND 
        sender = '{$receiver}' AND
        receiver = '{$sender}'
        )";

    $results = $conn->query($sql);
    $chat = $results->fetch_assoc();
    $chatthread = "";
    if (isset($chat['chatthread'])) {
        $chatthread = $chat['chatthread'];
    } else {
        $chatthread = rand(1000, 900000000);
    }

    $senttime = time();

    $sql = "INSERT INTO chats (
                chatthread,
                message,
                product,
                receiver,
                sender,
                seentime
            ) VALUES (
                '{$chatthread}',
                '{$message_body}',
                '{$product}',
                '{$receiver}',
                '{$sender}',
                '{$senttime}'
            )";

    if ($conn->query($sql)) {
        //echo "success -> ".$chatthread;
        header("Location: chat.php?chatthread=" . $chatthread);
    } else {
        //echo $sql;
        header("Location: chat.php?chatthread=" . $chatthread);
    }
}

$messageCount = countUnReadMessages($_SESSION['user']['idusers'],$conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ALL Products</title>
    <?php
    $chatthread = "";
    $userId = $_SESSION['user']['idusers'];

    include "files/admin_head.php";
    $chatthread = "";
    if (isset($_GET['chatthread'])) {
        $chatthread = trim($_GET['chatthread']);
    } else {
//        header("Location: index.php");
    }

    //$sql = "SELECT * FROM chats WHERE chatthread = '{$chatthread}' GROUP BY chatthread";

        $sql = "SELECT * FROM chats,products,users WHERE (users.idusers = products.uploadedby AND chats.product = products.idproducts AND sender = '{$userId}') OR (users.idusers = products.uploadedby AND chats.product = products.idproducts AND receiver = '{$userId}')   GROUP BY chatthread ORDER BY seentime DESC";

        $results = $conn->query($sql);
        $chats = array();
        while ($data = $results->fetch_assoc()) {
            array_push($chats, $data);
        }





    ?>

    <div class="container mt-3">
        <?php if (!empty($chats)) { ?>
            <div class="row">
                <div class="col-4 pl-0 pr-0">
                    <div class="list-group pl-0 pr-0 border-0">
                        <a class="list-group-item list-group-item-action border-0 bg-dark text-white rounded-0 ">
                            Message
                        </a>
                        <?php foreach ($chats as $item) {
                            $seen = false;
                            $active = "";
                            if(!$item['seen']){
                                $seen = "bg-light";
                            }else{
                                $seen = "";
                            }

                            if ($chatthread == $item['chatthread']) {
                                $active = "bg-light";
                            }
                            ?>
                            <a href="chat.php?chatthread=<?php echo $item['chatthread']; ?>"
                               class="list-group-item list-group-item-action border-0 <?php echo $active; echo $seen; ?>">
                                <div class="row">
                                    <div class="col-2">
                                        <img class="img-fluid rounded" src="img/uploads/<?php echo $item['photo']; ?>"
                                             alt="">
                                    </div>
                                    <div class="col-10">
                                        <?php echo $item['firstname']; ?>
                                        <?php echo $item['lastname']; ?>
                                        <?php echo $item['username']; ?>
                                        <small class="d-block"><?php echo $item['message']; ?></small>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>

                </div>
                <div class="col-8 pr-0 pb-2">
                    <?php
                    $displayed = false;
                    if (isset($_GET['chatthread'])) {
                        $new_sender = $userId;
                        $chatthread = trim($_GET['chatthread']);
                        $sql = "SELECT * FROM chats,products,users WHERE (users.idusers = chats.receiver AND chats.product = products.idproducts AND chatthread = '{$chatthread}')  OR  (users.idusers = chats.receiver AND chats.product = products.idproducts AND chatthread = '{$chatthread}')    ORDER BY seentime ASC";
                        $res = $conn->query($sql);
                        while ($d = $res->fetch_assoc()) {
                            $new_product_id = $d['product'];

                            if(($d['sender'] != $userId)){
                                $new_receiver = $d['sender'];
                            }else{
                                $new_receiver = $d['receiver'];
                            }

                            if(!$displayed){ ?>


                                <div class="row mb-3 ml-2 border-bottom ">
                                    <div class="col-2">
                                        <img class="img-fluid rounded" style="width: 3.5rem;" src="img/uploads/<?php echo $d['photo']; ?>"
                                             alt="">
                                    </div>
                                    <div class="col-10">
                                        <h3><?php echo($d['productName']); ?></h3>
                                    </div>
                                </div>


                                <?php $displayed = true;
                            }

                            if ($d['sender'] == $userId) {

                                ?>
                                <!--Sender-->

                                <div class="row mb-2 ">
                                    <div class="col-8 p-2 ml-2 border bg-light rounded">
                                        <?php echo $d['message']; ?>
                                        <br>
                                        <small class="small float-right"><?php echo myTime( $d['seentime'])?></small>
                                    </div>
                                </div>

                                <?php
                            } else { ?>

                                <!--Receiver-->
                                <div class="row mb-2 ">
                                    <div class="col-4"></div>
                                    <div class="col-8 p-2   border bg-dark text-white rounded text-right">
                                        <?php 

                                            echo $d['message']; 
                                            $sql = "UPDATE chats set seen = 1 where chatid = '{$d['chatid']}'";
                                            $conn->query($sql);

                                            ?>

                                        <br>
                                        <small class="small float-left "><?php echo myTime( $d['seentime'])?></small>
                                    </div>
                                </div>

                            <?php }
                        }
                    ?>

                    <div class="row border-top pt-3 rounded-0 ">
                        <div class="col-12">
                            <form action="chat.php?chatthread=<?php echo $chatthread; ?>" method="post" class="input-group mb-4">
                                <input type="text" name="message" required="" class="form-control border-dark" placeholder="Type your message here..." aria-label="Type your message here" autofocus aria-describedby="SEARCH">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-dark" type="button" id="button-addon2">SEND MESSAGE</button>
                                </div>

                                <input type="text" required="" name="sender" readonly hidden   value="<?php echo $new_sender; ?>" >
                                <input type="text" required="" name="receiver" readonly hidden   value="<?php echo $new_receiver; ?>" >
                                <input type="text" required="" name="product" readonly hidden   value="<?php echo $new_product_id; ?>" >

                            </form>
                        </div>
                    </div>

                    <?php }else{ ?>
                    <div class="jumbotron mt-2">
                        <h2>Alert</h2>
                        <hr>
                        <p>No Message selected.</p>
                    </div>
                    <?php } ?>

                </div>
            </div>
        <?php } else { ?>
            <div class="jumbotron mt-2">
                <h2>Alert</h2>
                <hr>
                <p>You don't have any message so far.</p>
            </div>
        <?php } ?>
    </div>









