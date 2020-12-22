<?php
session_start();
require_once 'connect.php';
if (isset($_SESSION['mysession'])=="")
{
   header("Location: index.php");
   exit;
}




// connect to database
if(isset($_POST['save'])){
    $price = $_POST['price'];
    $desc = $_POST['des'];
    $catagories = $_POST['catagory'];
    $img_name = $_FILES['imgs']['name'];
    $img_tmp = $_FILES['imgs']['tmp_name'];
    $img_size = $_FILES['imgs']['size'];

    if(empty($price)){
        $errMg = "Please Enter Your Product Price";
    }
    else if(empty($desc)){
        $errMg = "Please Enter Your Product Details";
    }
    else if(empty($img_name)){
        $errMg = "Please Select Your Product Image";
    }
    else{
        $upload_dir = "images/";
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $valid_ext = array('jpeg', 'jpg', 'png', 'gif');
        $user_img = rand(1000,1000000).".".$img_ext;
        if(in_array($img_ext, $valid_ext)){
            if($img_size<5000000){
                move_uploaded_file($img_tmp, $upload_dir.$user_img);
            }
            else{
                $errMg = "Sorry Your file is too long";
            }
        }
        else{
            $errMg = "Sorry only jpg, jpeg, gif, png file are allowed";

        }
    }
    if(!isset($errMg)){
        $stmt = $con->query("INSERT INTO product(p_description,product_price, product_img,catagory_id) VALUES('$desc', '$price', '$user_img', '$catagories')");
       // $stmt = $con->prepare('INSERT INTO product(p_description,product_price, product_img) VALUES(:dsc, :prc, :img)');
    //    $stmt->bindParam(':dsc',$desc);
      //  $stmt->bindParam(':prc',$price);
       // $stmt->bindParam(':img',$user_img);

        if($stmt){
            $successMg = "New record successfully inserted..";
          //  header("refresh:5;index.php");
        }
        else {
            $errMg = "Error While Inserting......";
        }

    }

}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/54fedc01a6.js" crossorigin="anonymous"></script>
    <style>
        .bg-color{
            background-color:#efefef;
        }
        .wd{
            width:108px;
        }
    </style>
</head>
<body class="bg-color">

<?php require_once 'menu.php' ?>
<div class="container">
    <div class="row justify-content-center">
    <div class="col-6">
        <h3 class="text-center">
        
        <?php
    	if(isset($errMg))
        	{
           
           echo $errMg;
           
        	}
            
        else if(isset($successMg))
        	{
       
     echo $successMg;
      
    	}
	?>   
        
        </h3>
        <h1 class="text-center my-3 display-4">Add New Product</h1>
        <hr>
        <br>
        
        
        <form method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input type="file" name="imgs" class="form-control">
            </div>
        
            <div class="input-group mt-3">
                <div class="input-group-prepend wd">
                    <span class="input-group-text">Price:</span>
                </div>
                <input type="text" name="price" class="form-control">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend wd">
                    <span class="input-group-text">Description:</span>
                </div>
                <input type="text" name="des" class="form-control">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend wd">
                    <span class="input-group-text">Catagory:</span>
                </div>
               <select name="catagory" id="catagory" class="form-control" required>
               <option value=""> Select Catagory</option>
                <?php
                 $sql = "SELECT * FROM catagory";  
                 $result =$con->query($sql);  
                 while($row = $result->fetch(PDO::FETCH_ASSOC))
        
                 {  ?>

                 <option value="<?php echo $row['catagory_id'];?>"><?php echo $row['catagory_name'];?> </option>

                 <?php
                 } 
                
                ?>
               </select>
            </div>
            <div class="input-group mt-3">
                <input type="submit" name="save" value="save" class="form-control btn btn-success">
            </div><a class="btn btn-warning w-100 mt-2" href="index.php"> view all Product</a>
        
        </form>
    </div>
    </div>
    </div>
    



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>