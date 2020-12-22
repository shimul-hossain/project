<?php  
 //load_data.php  
 require_once '../connect.php';  
 $output = '';  
 if(isset($_POST["catagory_id"]))  
 {  
      if($_POST["catagory_id"] != '')  
      {  
           $sql = "SELECT * FROM product WHERE catagory_id = '".$_POST["catagory_id"]."' ORDER BY product_id DESC";  
      }  
      else  
      {  
           $sql = "SELECT * FROM product";  
      }  
      $result = $con->query($sql); 
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

      ?>  

<?php  

       
    //   while($row = mysqli_fetch_array($result))  
    //   {  
    //        $output .= '<div class="col-md-3"><div style="border:1px solid #ccc; padding:20px; margin-bottom:20px;">'.$row["product_name"].'</div></div>';  
    //   }  
    //   echo $output;  
 ?>  