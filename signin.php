<?php 
error_reporting(1);
    session_start();
    require_once 'connect.php';
    if (isset($_SESSION['mysession'])!="")
    {
       header("Location: index.php");
       exit;
   }

    $ip = $_SERVER['REMOTE_ADDR'];
    

    $result = $con->query("SELECT count(ip_address) AS failed_login_attempt FROM failed_login WHERE ip_address = '$ip'  AND date BETWEEN DATE_SUB( NOW() , INTERVAL 5 MINUTE ) AND NOW()");
    $row  = $result->fetch(PDO::FETCH_ASSOC);
    $failed_login_attempt = $row['failed_login_attempt'];

        if(count($_POST)>0 && isset($_POST["captcha_code"]) && $_POST["captcha_code"]!=$_SESSION["captcha_code"])
        {
             $msg = "You have tried more than 3 invalid attempts. Try again after five minutes";
         }

  else  if(isset($_POST['login'])){
        $email = $_POST['email'];
        $pass = $_POST['pwd'];

        $query = $con->query("SELECT user_id, user_email, user_password FROM logins WHERE user_email='$email'");
        $row =$query->fetch(PDO::FETCH_ASSOC);
        $count = $query->rowCount();

        if(password_verify($pass, $row['user_password']) && $count ==1){
            $_SESSION['mysession'] = $row['user_id'];
            $con->query("DELETE FROM failed_login WHERE ip_address = '$ip'");
            header("Location: index.php");
        }
        else{
            $msg = "Invalid Email or Password !";
            if ($failed_login_attempt < 3) 
		{
			$con->query("INSERT INTO failed_login (ip_address,date) VALUES ('$ip', NOW())");
		} 
	//	else
	//	 {
        //    $msg= "Try again after five minutes"; 
            // header("refresh:30;signin.php");

            
		//}

        }



    }



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/54fedc01a6.js" crossorigin="anonymous"></script>

    <style>
    .btn-succes{
        /* color:white; */
        border-radius:50px;
        /* background-color:blueviolet; */
    }
    .heading, .fa{
        
    color:blueviolet; 
    }
    .bg{
        border-radius:15px;
        box-shadow: 0px 10px 40px -10px rgba(0,0,0,.7)
    }
    .error{
        width:100%;
        height:60px;
        /* border:1px solid red; */
    }
    </style>
</head>
<body>
    <?php require_once 'menu.php' ?>
    <div class="container">
        <div class="error">
        <?php if(isset($msg)){
        echo "<h1 class='text-center text-danger display-5'>$msg</h1>";
    } ?></div>
        <div class="row justify-content-center">
            <div class="col-6 col-md-4 bg mt-5">
                <h1 class="display-2 heading text-center">Sign In</h1>  <hr>
                <form method="POST">
                    <div class="input-group mt-5">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="input-group mt-4">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" name="pwd" required>
                    </div>


                    <?php
                    if (isset($failed_login_attempt) && $failed_login_attempt >= 3) 
                        { 
                            ?>
                    <div class="d-none">
                   <input  type="text" name="captcha_code"><img src="captcha_code.php" />
                    
                    </div>
                    
                    <?php
                    }

                    ?>



                    <input type="submit" value="Log In" name="login" class="btn btn-succes btn-success w-100 mt-3">
                    <hr>
                    <h5 class="my-3">Don't have an account!<a class="text-decoration-none" href="signup.php"> Sign Up Here</a></h5>
                </form>
            </div>
        </div>
    
    </div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>