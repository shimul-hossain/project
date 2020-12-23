<?php
error_reporting(1);

  require_once 'connect.php';
if(empty($_GET['id']) && empty($_GET['code']))
{
    header("Location: index.php");

}
if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	
	$stmt = $con->prepare("SELECT * FROM logins WHERE user_id=:uID AND token_code=:code LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":code"=>$code));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() == 1)
	{
		if(isset($_POST['btn-reset-pass']))
		{
            $pass = $_POST['pass'];
            $cpass = $_POST['confirm-pass'];
            if($cpass!==$pass)
			{
				$msg = "<div>
						<strong>Sorry!</strong>  Password Doesn't match. 
						</div>";
            }
            else
			{
                $uid = $row['user_id'];
				$password = password_hash($cpass, PASSWORD_DEFAULT);
				$stmt = $con->query("UPDATE logins SET user_password='$password' WHERE user_id='$uid'");
				
				
				$msg = "<div>
						Password Changed.
						</div>";
				header("refresh:5;index.php");
			}

		}
	
	}
	else
	{
		$msg = "
		       <div>
			  No Account Found, Try again
			   </div>
			   ";
	}	
}







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
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
  
    
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-5 mt-5 py-3 bg">

        <div class="text-info">
			<strong>Hello !</strong>  <?php echo $row['user_name'] ?> you are here to reset your forgetton password.
		</div><hr />
            <h1 class="display-5 heading">
            <?php if(isset($msg)) 
				{ 
					echo $msg; 

					} 
					   ?>
            </h1>

        <form  method="post">
        <input type="password" class="form-control" placeholder="New Password" name="pass" required /><br>
        <input type="password" class="form-control" placeholder="Confirm New Password" name="confirm-pass" required />
     	<hr />
        <button type="submit" class="form-control btn-outline-danger" name="btn-reset-pass">Reset Your Password</button>
        
      </form>



        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>
