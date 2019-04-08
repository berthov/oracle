<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$id = $_REQUEST['id']; 
$SO_ID = $_REQUEST['SO_ID']; 
$SO_DATE = $_REQUEST["SO_DATE"];
$SO_NUMBER = $_REQUEST['SO_NUMBER']; 
$myFile  = $_REQUEST['myFile']; 
$DATE = date('Y-m-d');


	$sql_php = 
	"UPDATE approval_list_ar 
	SET last_update_date= '".$DATE."', 
	last_update_by ='".$employee_id."', 
	status ='DELETED'
	WHERE ID = '".$id."'";

	if (mysqli_query($conn_php, $sql_php)) { 
		unlink($myFile) or die("Couldn't delete file");
		header("Location:../form_upload_audit_AR.php?SO_NUMBER=$SO_NUMBER&SO_ID=$SO_ID&SO_DATE=$SO_DATE_VAL");
	} else {
	    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
	}

		
?>