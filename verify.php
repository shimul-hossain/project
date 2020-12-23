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
	
	$statusY = "Y";
	$statusN = "N";
	
	$stmt = $con->prepare("SELECT user_id,user_status FROM logins WHERE user_id=:uID AND token_code=:code LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":code"=>$code));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0)
	{
		if($row['user_status']==$statusN)
		{
			$stmt =$con->prepare("UPDATE logins SET user_status=:status WHERE user_id=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();	
			
			$msg = "
		           <div>
				   <strong>WoW !</strong>  Your Account is Now Activated : <a href='index.php'>Click Here To Login</a>
			       </div>
			       ";	
		}
		else
		{
			$msg = "
		           <div>
				   <strong>sorry !</strong>  Your Account is allready Activated : <a href='index.php'>Click Here To Login</a>
			       </div>
			       ";
		}
	}
	else
	{
		$msg = "
		       <div>
			   <strong>sorry !</strong>  No Account Found : <a  href='signup.php'>Click Here To Signup</a>
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
  
    
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-6 mt-5 bg">
            <h1 class="display-5 heading p-3">
            <?php if(isset($msg)) 
				{ 
					echo $msg; 

					} 
					   ?>
            </h1>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>
