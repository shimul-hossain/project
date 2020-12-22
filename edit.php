<?php
session_start();
require_once 'connect.php';
if(isset($_GET['edit_id']) && !empty($_GET['edit_id']) ){
    $id = $_GET['edit_id'];
    $stmt_edit = $con->query('SELECT p_description,product_price, product_img FROM product WHERE product_id='.$id);
   // $stmt_edit = $con->prepare('SELECT p_description,product_price, product_img FROM product WHERE product_id=:pid');
  //  $stmt_edit->execute(array(':pid'=>$id));

    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
}
else{
    header("Location: index.php");
}



// connect to database
if(isset($_POST['update'])){
    $price = $_POST['price'];
    $desc = $_POST['des'];

    $img_name = $_FILES['imgs']['name'];
    $img_tmp = $_FILES['imgs']['tmp_name'];
    $img_size = $_FILES['imgs']['size'];

   
    if($img_name){
        $upload_dir = "images/";
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $valid_ext = array('jpeg', 'jpg', 'png', 'gif');
        $user_img = rand(1000,1000000).".".$img_ext;
        if(in_array($img_ext, $valid_ext)){
            if($img_size<5000000){
                unlink($upload_dir.$product_img);
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
    else{
        $user_img = $product_img;
    }
    if(!isset($errMg)){
        $stmt = $con->query("UPDATE product SET p_description='$desc',product_price='$price', product_img='$user_img' WHERE product_id=".$id);
      //  $stmt = $con->prepare('UPDATE product SET p_description=:dsc,product_price=:prc, product_img=:img WHERE product_id=:pid');
      //  $stmt->bindParam(':dsc',$desc);
      //  $stmt->bindParam(':prc',$price);
       // $stmt->bindParam(':img',$user_img);
      //  $stmt->bindParam(':pid',$id);


        if($stmt){
            $successMg = "New record successfully updated..";
           // header("location :index.php");
        }
        else {
            $errMg = "Error While updating......";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> <script src="https://kit.fontawesome.com/54fedc01a6.js" crossorigin="anonymous"></script>
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
<?php
//	error_reporting( ~E_NOTICE );
	if(isset($errMg))
	{
            ?>
            <script>
                alert('<?php echo $errMg?>');
            </script>
            <?php
	}
	
	else if(isset($successMg))
	{
        ?>
        <script>
                alert('<?php echo $successMg?>');
                window.location.href='index.php';
        </script>
        <?php
	}
	?>   

<?php require_once 'menu.php' ?>
<div class="container">
    <div class="row justify-content-center">
    <div class="col-6">
        <h1 class="text-center my-3 display-4">Update Product List</h1>
        <hr>
      <div class="container border my-3">
      <table class="w-100 my-3 text-center mx-auto">
        <tr>
        <td>Current Image:</td>
        <td><img class="img-thumbnail" src="images/<?php echo $product_img; ?>" width="220" height="150" alt="Image Not Found"></td>
        </tr></table>
        </div>
        
        <form method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input type="file" name="imgs" class="form-control">
            </div>
        
            <div class="input-group mt-3">
                <div class="input-group-prepend wd">
                    <span class="input-group-text">Price:</span>
                </div>
                <input type="text" name="price" value="<?php echo $product_price; ?>" class="form-control">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend wd">
                    <span class="input-group-text">Description:</span>
                </div>
                <input type="text" name="des" value="<?php echo $p_description; ?>" class="form-control">
            </div>
            <div class="input-group mt-3">
                <input type="submit" name="update" value="update" class="form-control btn btn-primary">
            </div><a class="btn btn-warning w-100 mt-2" href="index.php"> Cencel</a>
        
        </form>
    </div>
    </div>
    </div>
    



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>