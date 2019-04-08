<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$SO_NUMBER = $_REQUEST['SO_NUMBER'];

$name = $_FILES["uploaded_file"]["name"];

if ($name === '') {
	echo '<script type="text/javascript">
        	alert("Please Upload Your File !");
        	window.history.back();
          </script>';
}
else if (!file_exists("../uploads/AR/$SO_NUMBER")) {
	mkdir("../uploads/AR/$SO_NUMBER", 0777, true);


	if (file_exists("../uploads/AR/$SO_NUMBER/$name")) {
		echo '<script type="text/javascript">
	        	alert("File Already Exist !");
	        	window.history.back();
	          </script>';
	}else{

		$target_dir = "../uploads/AR/$SO_NUMBER/";
		$target_file = $target_dir . basename( $_FILES['uploaded_file']['name']);
		if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
		      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
		      " has been uploaded";
		      header("Location:../audit_ar.php");
		}
		else{
	        echo "Your file was unable to upload.  Please try again!";
		$uploadOk = 0;
	    }
	}

}else{

	if (file_exists("../uploads/AR/$SO_NUMBER/$name")) {
		echo '<script type="text/javascript">
	        	alert("File Already Exist !");
	        	window.history.back();
	          </script>';
	}else{

		$target_dir = "../uploads/AR/$SO_NUMBER/";
		$target_file = $target_dir . basename( $_FILES['uploaded_file']['name']);
		if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
		      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
		      " has been uploaded";
		      header("Location:../audit_ar.php");
		}
		else{
	        echo "Your file was unable to upload.  Please try again!";
		$uploadOk = 0;
	    }
	}

}


?>