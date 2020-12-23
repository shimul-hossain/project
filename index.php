<?php 
session_start();
    require_once 'connect.php';
    function fill_brand($take_connection)  
    {  
         $output = '';  
         $sql = "SELECT * FROM catagory";  
         $result =$take_connection->query($sql);  
         while($row = $result->fetch(PDO::FETCH_ASSOC))

         {  
              $output .= '<option value="'.$row["catagory_id"].'">'.$row["catagory_name"].'</option>';
         }  
         return $output;  
    }  
    function fill_product($take_connection)  
    {  
         $output = '';  
         $sql = "SELECT * FROM product ORDER BY product_id DESC";  
         $result =$take_connection->query($sql);   
         while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            ?>
            <div class="col-3 mb-5">
              <div class="row">
                  <div class="col-12">
                  
                   <img  src="images/<?php echo $product_img ?>" class="img-thumbnail im">
                  </div>
                  <div class="col-12 my-2">
                      <h3 class="text-center">
                          <?php echo $p_description?>
                      </h3>
                  </div>
                  <div class="col-12 my-2">
                      <h4 class="text-center border py-2">
                     Price: &#36;<?php echo $product_price ?>
                      </h4>
                  </div>
    
                  <?php 
                     if (isset($_SESSION['mysession'])!=""){
                ?>
                  <div class="col-6">
                 <a href="edit.php?edit_id=<?php echo $product_id;?>" class="btn btn1 w-100"> Edit</a>
                  </div>
                  <div class="col-6">
                 <a href="?delete_id=<?php echo $product_id;?>" class="btn btn2 w-100"> Delete</a>
                  </div>
                  <?php }
                   else{
                     ?>
    
                  <div class="col-6">
                 <a href="edit.php?edit_id=<?php echo $product_id;?>" class="btn btn1 w-100 disabled"> Edit</a>
                  </div>
                  <div class="col-6">
                 <a href="?delete_id=<?php echo $product_id;?>" class="btn btn2 w-100 disabled"> Delete</a>
                 </div>
                 
                  <?php } ?>
    
                  <div class="col-12  my-2">
                 <a href="order.php?edit_id=<?php echo $product_id;?>" class="btn btn-sm btn-outline-success w-100"> Order Now</a>
                  </div>
              </div>
              
            </div>
                               
            <?php  
          }
    }  




    if(isset($_GET['delete_id'])){

        $stmt_select = $con->query('SELECT product_img FROM product WHERE product_id='.$_GET['delete_id']);
       // $stmt_select = $con->prepare('SELECT product_img FROM product WHERE product_id=:pid');
       // $stmt_select->execute(array(':pid'=>$_GET['delete_id']));
        $img_row=$stmt_select->fetch(PDO::FETCH_ASSOC);
        unlink("images/".$img_row['product_img']);

        $stmt_delete = $con->query('DELETE FROM product WHERE product_id='.$_GET['delete_id']);
       // $stmt_delete = $con->prepare('DELETE FROM product WHERE product_id=:pid');
        //$stmt_delete->bindParam(':pid', $_GET['delete_id']);
       // $stmt_delete->execute();
        header("Location: index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> <script src="https://kit.fontawesome.com/54fedc01a6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">

    <style>
        .optioncolor{
            color:blueviolet;
        }
    </style>
</head>
<body>


<?php require_once 'menu.php' ?>

<div class="container">
 <?php if(isset($_GET['error']))
  echo $_GET['error'];
 ?>
    <div class="row ">
        <div class="col mt-3">
                     <select name="catagory"                id="catagory" class="p-2 optioncolor">  
                          <option value="">Select Catagory</option>  
                          <?php echo fill_brand($con); ?>  
                     </select>  

        </div> 
        </div>
                     <br />
                     <div class="row" id="show_product">  
                          <?php echo fill_product($con);?>  
                     </div>  
               
                  <!-- <h1 class="text-center display-1">Our Product List</h1> -->
           <hr>
            <br>      
        
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>

<script>  
 $(document).ready(function()
 {  
      $('#catagory').change(function()
      {  
           var catagory_id = $(this).val();  
           $.ajax({  
                url:"ajax/load_data.php",  
                method:"POST",  
                data:{catagory_id:catagory_id},  
                success:function(data)
                {  
                     $('#show_product').html(data);  
                }  
           });  
      });  
 });  
 </script>  