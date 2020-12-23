<?php
error_reporting(1);
session_start();

  require_once 'connect.php';
  if (isset($_SESSION['mysession'])!="")
 {
	header("Location: index.php");
	exit;
}
if(isset($_POST['btn-submit']))
{
	$email = $_POST['txtemail'];
    $stmt = $con->query("SELECT user_id FROM logins WHERE user_email = '$email'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['user_id']);
		$code = md5(uniqid(rand()));
		
		$stmt = $con->query("UPDATE logins SET token_code='$code' WHERE user_email='$email'");
        $message= "
				   Hello , $email
				   <br /><br />
				   We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
				   <br /><br />
				   Click Following Link To Reset Your Password 
				   <br /><br />
				   <a href='http://localhost/dataase/CRUD-HW/reset.php?id=$id&code=$code'>click here to reset your password</a>
				   <br /><br />
				   thank you :)
                   ";
        $subject = "Password Reset";
        require 'class/class.phpmailer.php';
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); 
        $mail->SMTPDebug  = 0;                     
        $mail->SMTPAuth   = true;                  
        $mail->SMTPSecure = "tls";                 
        $mail->Host       = "smtp.gmail.com";      
        $mail->Port       = 587;             
        $mail->AddAddress($email);
        $mail->Username='sbshimul000@gmail.com';  
        $mail->Password= 'Shimul2573';            
        $mail->SetFrom('sbshimul000@gmail.com','Coders builder');
        $mail->AddReplyTo("sbshimul000@gmail.com","Coders builder");
        // $mail->WordWrap = 50;
        // $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
         
        $mail->Send(); 
        if($mail->Send())
        {
            $success =" Please check your email to Reset your password";
        }
    }
	else
	{
		$msg = "<div>
					<strong>Sorry!</strong>  this email not found. 
			    </div>";
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
        <div class="col-6 mt-5 p-3 bg">
        <h1 class=" text-center heading">
            Forgot Password
        </h1>
            <h4 class="text-info p-3">
            <?php
            
            
            if(isset($msg)) 
				{ 
					echo $msg; 

                    }  
            
         else if(isset($success)) 
				{ 
					echo $success; 

                    }  
        ?>
        </h4>
            <form method="POST">
            <input type="email" placeholder="Enter Your Email Address" name="txtemail" class="form-control" required />
            <br> 
     	<hr />
        <button type="submit" class="form-control btn btn-outline-success " name="btn-submit">Generate new Password</button>
            
            </form>

        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>
