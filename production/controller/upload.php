<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");


if (!file_exists("../uploads/$employee_name")) {
	mkdir("../uploads/$employee_name", 0777, true);

	$target_dir = "../uploads/$employee_name/";
	$target_file = $target_dir . basename( $_FILES['uploaded_file']['name']);
	if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
	      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
	      " has been uploaded";
	      header("Location:../summary_request.php");
	}
	else{
        echo "Your file was unable to upload.  Please try again!";
	$uploadOk = 0;
    }

}else{

	$target_dir = "../uploads/$employee_name/";
	$target_file = $target_dir . basename( $_FILES['uploaded_file']['name']);
	if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
	      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
	      " has been uploaded";
	      header("Location:../summary_request.php");
	}
	else{
        echo "Your file was unable to upload.  Please try again!";
	$uploadOk = 0;
    }

}



?>