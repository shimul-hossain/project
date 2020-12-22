<?php
error_reporting(1);
session_start();

  require_once 'connect.php';
  if (isset($_SESSION['mysession'])!="")
 {
	header("Location: index.php");
	exit;
}

    if(isset($_POST['create'])){
        $name = $_POST['uname'];
        $email = $_POST['email'];
        $pass = $_POST['pwd'];
        $captcha = $_POST['captcha_code'];

        $encpwd = password_hash($pass, PASSWORD_DEFAULT);
    
        $checkMail = $con->query("SELECT user_email FROM logins WHERE user_email = '$email'");

        $count = $checkMail->rowCount();
        if($count == 0){
            $query ="INSERT INTO logins(user_name, 	user_email, user_password) VALUES('$name', '$email', '$encpwd')";

            if($captcha != $_SESSION['captcha_code']){
                $msg = "Please Enter correct captcha code &#128544;";
            }
           else if($con->query($query)){
                $msg = "Successfully Registration";
            }
            else{
                $msg = "error While registering";
            }
        }
        else {
            $msg = "Sorry email already taken!! &#128531;";
        }
     //   $con->close();

    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/54fedc01a6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <style>
    .btn-succes{
        color:white;
        border-radius:50px;
        background-color:blueviolet;
    }
    .bg{
        border-radius:15px;
        box-shadow: 0px 10px 40px -10px rgba(0,0,0,.7)
    }
    .heading, .fa{
        
        color:blueviolet; 
        }
        .input-mr{
            margin-right:10px;
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
    <div class="error text-center">
    <h1 class="display-5 text-center"  id="result"></h1>
        <?php if(isset($msg)){
        echo "<h1 class='text-center text-danger display-5'>$msg</h1>";
       // header("refresh:3;signup.php"); 
    } ?></div>
        <div class="row justify-content-center">
            <div class="col-6 col-md-4 bg mt-3">
                <h1 class="display-2 heading text-center">Sign Up</h1>  <hr>
                <form action="" method="POST">
                    <div class="input-group mt-5">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="User Name" name="uname" required>
                    </div>
                    <div class="input-group my-4">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control" placeholder="Email Address" id="name" name="email" required>
                    </div>
                    <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" name="pwd" required>
                    </div>
                    <div class="input-group mt-4">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock-open"></i></span>
                    <input type="text" class="form-control input-mr" placeholder="Enter captcha code" name="captcha_code" required>
                    <img src="captcha_code.php" />
                    </div>
                    <input type="submit" name="create" value="Create Account" class="btn btn-succes w-100 my-4">
                </form>
            </div>
        </div>
    
    </div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>

<script type="text/javascript">
	
$(document).ready(function()
{    
	$("#name").blur(function()
	{		
		var name = $(this).val();	
		
		if(name.length > 3)
		{		
			$("#result").html('checking...');
			
			/*$.post("username-check.php", $("#reg-form").serialize())
				.done(function(data){
				$("#result").html(data);
			});*/
			
			$.ajax({
				
				type : 'POST',
				url  : 'ajax/live_check.php',
				data : {name:name}, //The serialize() method creates a URL encoded text string by serializing form values. The serialized values can be used in the URL query string when making an AJAX request.
				success : function(data)
						  {
					         $("#result").html(data);
					      }
				});
				return false;
			
		}
		else
		{
			$("#result").html('');
		}
	});
	
});
</script>