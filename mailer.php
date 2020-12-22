<?php 
 session_start();
 if (isset($_SESSION['mysession'])=="")
{
   header("Location: index.php");
   exit;
}

//  if (isset($_SESSION['mysession'])!="")
//  {
//     header("Location: index.php");
//     exit;
// }



  $error = '';
  $name = '';
  $email = '';
  $subject = '';
  $message = '';
  
  function clean_text($string)
{
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}
if(isset($_POST["submit"]) )

{
    $pass = $_POST['password'];
    if(empty($_POST["name"]))
    {
        $error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
    }
    else
    {
        $name = clean_text($_POST["name"]);
        if(!preg_match("/^[a-zA-Z ]*$/",$name))
        {
            $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
        }
    }
    if(empty($_POST["email"]))
    {
        $error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
    }
    else
    {
        $email = clean_text($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error .= '<p><label class="text-danger">Invalid email format</label></p>';
        }
    }
    if(empty($_POST["subject"]))
    {
        $error .= '<p><label class="text-danger">Subject is required</label></p>';
    }
    else
    {
        $subject = clean_text($_POST["subject"]);
    }
    if(empty($_POST["message"]))
    {
        $error .= '<p><label class="text-danger">Message is required</label></p>';
    }
    else
    {
        $message = clean_text($_POST["message"]);
    }
    if($error == '')
    {
        require 'class/class.phpmailer.php';
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); 
        $mail->SMTPDebug  = 0;                     
        $mail->SMTPAuth   = true;                  
        $mail->SMTPSecure = "tls";                 
        $mail->Host       = "smtp.gmail.com";      
        $mail->Port       = 587;             
        $mail->AddAddress('sbshimul000@gmail.com');
        $mail->Username=$email;  
        $mail->Password= $pass;            
        $mail->SetFrom('sbshimul000@gmail.com','belancer');
        $mail->AddReplyTo("sbshimul000@gmail.com","belancer");
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Subject = $_POST["subject"];             //Sets the Subject of the message
        $mail->Body = $_POST["message"];    
        $mail->Send();  //Adds a "Cc" address
                                    //Sets word wrapping on the body of the message to a given number of characters
                                    //Sets message type to HTML             
                    //An HTML or plain text message body
        if($mail->Send())                               //Send an Email. Return true on success or false on error
        {
            $error = '<label class="text-success">Thank you for contacting us</label>';
        }
        else
        {
            $error = '<label class="text-danger">There is an Error</label>';
        }
        $name = '';
        $email = '';
        $subject = '';
        $message = '';
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
 
</head>
<body>
<?php require_once 'menu.php' ?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-6">
            <h1 class="text-center display-3 mb-4">Send Feedback</h1>
            <h3 class="text-center"><?php echo $error; ?></h3>
            <form method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="name" placeholder="Enter name" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="email" placeholder="Enter email" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" placeholder="Enter password" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="subject" placeholder="Enter subject" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="message" placeholder="Enter message" class="form-control">
                </div>
                <input type="submit" name="submit" class="form-control btn btn-success">
            </form>
 
        </div>
    </div>
</div>
 
 
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
</body>
</html>
