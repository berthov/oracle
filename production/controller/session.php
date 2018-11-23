<?php

   $user_check = $_SESSION['login_user'];
   if($user_check == null){
      header("location: login.php");
   }
   
   $sqlsession = mysqli_query($conn_php,"select name from employee where name = '$user_check' ");
   
   $row = mysqli_fetch_array($sqlsession,MYSQLI_ASSOC);
   if (!$row) {
		    printf("Error: %s\n", mysqli_error($conn_php));
		    exit();
		}
   
   $login_session = $row['name'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>