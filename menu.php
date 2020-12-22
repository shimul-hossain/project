
<div class="row">
        <div class="col-12">
        <nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a href="index.php" class="navbar-brand"><i class="fa fa-home text-light"></i></a>
    <div class="d-flex">

 <?php 
   if (isset($_SESSION['mysession'])!=""){
 ?>

<a href="add.php" class="btn btn-outline-success">Add Product</a>
<a href="mailer.php" class="btn btn-outline-success mx-3">Contact</a>
<a href="javascript:void(0)" class="btn btn-outline-success">Profile</a>
<a href="logout.php" class="btn btn-outline-success mx-3">logOut</a>

   

    <?php }
    else{
      ?>
    <a href="signin.php" class="btn btn-outline-success">SignIn</a>
    <a href="signup.php" class="btn btn-outline-success mx-3">signUp</a>
    <?php } ?>
    </div>
  </div>
</nav>
        </div>
    </div>
