<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

// $DO_NUM = $_REQUEST['DO_NUM'];

$INVOICE_NUM = $_REQUEST['INVOICE_NUM']; 
$INVOICE_ID = $_REQUEST['INVOICE_ID']; 

$name = $_FILES["uploaded_file"]["name"];

if ($name === '') {
	echo '<script type="text/javascript">
        	alert("Please Upload Your File !");
        	window.history.back();
          </script>';
}
else if (!file_exists("../uploads/$employee_name/$DO_NUM")) {
	mkdir("../uploads/$employee_name/$DO_NUM", 0777, true);


	if (file_exists("../uploads/$employee_name/$DO_NUM/$name")) {
		echo '<script type="text/javascript">
	        	alert("File Already Exist !");
	        	window.history.back();
	          </script>';
	}else{

		$target_dir = "../uploads/$employee_name/$DO_NUM/";
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

	if (file_exists("../uploads/$employee_name/$DO_NUM/$name")) {
		echo '<script type="text/javascript">
	        	alert("File Already Exist !");
	        	window.history.back();
	          </script>';
	}else{

		$target_dir = "../uploads/$employee_name/$DO_NUM/";
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