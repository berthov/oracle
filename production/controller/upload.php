<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$INVOICE_NUM = $_REQUEST['INVOICE_NUM']; 
$INVOICE_ID = $_REQUEST['INVOICE_ID']; 

$name = $_FILES["uploaded_file"]["name"];
// $ext = (explode(".", $name)); # extra () to prevent notice
// $tes = end($ext);

// if (file_exists("../uploads/$employee_name/$INVOICE_NUM/$name")) {
//     echo "The file exists";
// } else {
//     echo "The file does not exist";
// }

	// if (file_exists("../uploads/$employee_name/$INVOICE_NUM/$name")) {
	// 	echo '<script type="text/javascript">
	//         	alert("File Already Exist !");
	//         	window.history.back();
	//           </script>';
	// }


if ($name === '') {
	echo '<script type="text/javascript">
        	alert("Please Upload Your File !");
        	window.history.back();
          </script>';
}
else if (!file_exists("../uploads/$employee_name/$INVOICE_NUM")) {
	mkdir("../uploads/$employee_name/$INVOICE_NUM", 0777, true);


	if (file_exists("../uploads/$employee_name/$INVOICE_NUM/$name")) {
		echo '<script type="text/javascript">
	        	alert("File Already Exist !");
	        	window.history.back();
	          </script>';
	}else{

		$target_dir = "../uploads/$employee_name/$INVOICE_NUM/";
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

}else{

	if (file_exists("../uploads/$employee_name/$INVOICE_NUM/$name")) {
		echo '<script type="text/javascript">
	        	alert("File Already Exist !");
	        	window.history.back();
	          </script>';
	}else{

		$target_dir = "../uploads/$employee_name/$INVOICE_NUM/";
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

}


?>