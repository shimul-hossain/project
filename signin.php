<?php 
error_reporting(1);
    session_start();
    require_once 'connect.php';
    if (isset($_SESSION['mysession'])!="")
    {
       header("Location: index.php");
       exit;
   }

     if(isset($_POST['login'])){
        $email = $_POST['email'];
        $pass = $_POST['pwd'];

        $query = $con->query("SELECT user_id, user_email, user_password, user_status FROM logins WHERE user_email='$email'");
        $row =$query->fetch(PDO::FETCH_ASSOC);
        $count = $query->rowCount();
        if($row['user_status']==='N'){
            $msg = "your Account Is'n verified  !";
            header("Location: index.php?error=$msg");
        }
        else if(password_verify($pass, $row['user_password']) && $count ==1){
            $_SESSION['mysession'] = $row['user_id'];
            $con->query("DELETE FROM failed_login WHERE ip_address = '$ip'");
            header("Location: index.php");
        }
        else{
            $msg = "Invalid Email or Password !";
       header("Location: index.php?error=$msg");

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
