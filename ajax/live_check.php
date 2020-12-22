<?php
  
  $host="localhost";
  $user="root";
  $pass="";
  $dbname="productlist";
  
  $dbcon = new PDO("mysql:host={$host};dbname={$dbname}",$user,$pass);
  
  if($_POST) 
  {
      $name= strip_tags($_POST['name']);
      
	  $stmt=$dbcon->prepare("SELECT user_email FROM logins WHERE user_email=:name");
	  $stmt->execute(array(':name'=>$name));
	  $count=$stmt->rowCount();
	  	  
	  if($count>0)
	  {
		  echo "<span style='color:brown;'>Sorry this email already taken !!!</span>";
	  }
	  else
	  {
		  echo "<span style='color:green;'>This email available</span>";
	  }
  }
?>