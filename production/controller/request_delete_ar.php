<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$SO_NUMBER = $_REQUEST['SO_NUMBER']; 
$SO_DATE = date("Y-m-d",strtotime($_REQUEST["SO_DATE"]));
$SO_DATE_VAL = $_REQUEST["SO_DATE"];
$SO_ID = $_REQUEST['SO_ID']; 
$FILE_NAME = $_REQUEST['FILE_NAME'];
$CREATION_DATE =  date("Y-m-d H:i:s");
$LAST_UPDATE_DATE =  date("Y-m-d");

		$sql_php = 
		"INSERT INTO approval_list_ar 
		        (so_id,
		        so_number,
		        so_date,
		        file_name,
		        status,
		        creation_date,
		        created_by,
		        last_update_date,
		        lasT_update_by)
		        VALUES
		        ('".$SO_ID."',
		        '".$SO_NUMBER."',
		        '".$SO_DATE."',
		        '".$FILE_NAME."',
		    	'P',
		    	'".$CREATION_DATE."',
		    	'".$employee_id."',
		    	'".$LAST_UPDATE_DATE."',
		    	'".$employee_id."'
		    	)";



		if (mysqli_query($conn_php, $sql_php)) {
		    // echo "New record created successfully";
		    header("Location:../form_upload_audit_AR.php?SO_NUMBER=$SO_NUMBER&SO_ID=$SO_ID&SO_DATE=$SO_DATE_VAL");
		} else {
		    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
		}
?>