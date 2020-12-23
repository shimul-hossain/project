<?php
  session_start();
  if (isset($_SESSION['mysession'])!=""){
    session_destroy();
	unset($_SESSION['mysession']);
	header("Location: index.php");
  }

?>