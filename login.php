<?php 
    include("files/functions.php");
    if(isset($_POST['login'])){
        $sql = "SELECT * FROM users WHERE username ='{$_POST['username']}' AND password = '{$_POST['password']}' LIMIT 1";
        $res = $conn->query($sql);
        $user = $res->fetch_assoc();
        if(!empty($user)){
            message("Your account was logged in successfully","success");
            $_SESSION['user'] = $user;
            if($user['userType']=='admin'){
                header("Location: admin_all_products.php");
                die();
            }else{
                header("Location: admin_all_products.php");
                die();
            }
        }else{

        }
    }



    if(isset($_POST['register'])){

        $_POST['regdate'] = time();
        $_POST['userType'] ='customer';
        $_POST['idusers'] = rand(10,99999);
        $details = json_encode($_POST);
        $sql = "INSERT INTO users (
                idusers,
                username,
                password,
                regdate,
                userType,
                contact,
                userdetails
            ) VALUES ("
                ."'".$_POST['idusers']."',"
                ."'".$_POST['username']."',"
                ."'".$_POST['password1']."',"
                ."'".$_POST['regdate']."',"
                ."'admin',"
                ."'".$_POST['contact']."',"
                ."'".$details."'"
            .")";

            if($conn->query($sql)){
                message("Your account was created successfully","success");
                $_SESSION['user'] = $_POST;                
                message("Your account was created successfully","success");
                if($user['userType']=='admin'){
                    header("Location: admin_all_products.php");
                }else{
                    header("Location: customer.php");
                }
            }else{

                message("Something went wrong while creating your account. Please try again","danger");
            }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body class="bg-dark">


    <div class="container">

        <div class="row mt-5 pt-5">
            <div class="col mt-5 rounded bg-white">
            	<div class="m-5" id="login-div">
            		<h2>Login</h2>
            		<form id="login-form" method="post" action="login.php" accept-charset="utf-8">
            			<input type="text" placeholder="username" class="form-control mt-3 mb-2" name="username">
            			<input type="password" class="form-control mt-3" placeholder="password" name="password">
            			<button type="submit" class="btn btn-dark d-inline-block mb-5 mt-4 float-right" name="login" value="login" >LOGIN</button>
            		</form>
                </div>
            </div>
            <div class="col">
                <div class="bg-white mt-5 p-5 rounded" id="register-div">
                    <h2>Register</h2>
                    <form id="login-form" action="login.php" method="post" accept-charset="utf-8">
                        <input type="text" class="form-control mb-3 mt-3" required="" name="username" placeholder="username">
                        <input type="number" minlength="8" required="" maxlength="12" class="form-control mb-3 mt-3" required="" name="contact" placeholder="contact"></input>
                        <input type="password" class="form-control mb-3 mt-3" required="" required="" name="password1" placeholder="password">
                        <button type="submit" class="btn btn-dark d-inline-block float-right" name="register" >REGISTER</button>
                    </form>
                </div>  
            </div>
        </div>

        <div class="row">
            <a href="index.php" class="btn bg-white d-block mt-3 mx-auto" title="">GO TO HOME</a>
        </div>
    </div>







