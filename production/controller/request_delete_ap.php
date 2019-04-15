<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");



$PR_NUMBER = $_REQUEST['PR_NUMBER']; 
$FILE_NAME = $_REQUEST['FILE_NAME'];
$PO_NUMBER = $_REQUEST['PO_NUMBER'];
$CREATION_DATE =  date("Y-m-d H:i:s");
$LAST_UPDATE_DATE =  date("Y-m-d");

		$sql_php = 
		"INSERT INTO approval_list_ap
		        (pr_number,
		        file_name,
				po_number,
		        status,
		        creation_date,
		        created_by,
		        last_update_date,
		        lasT_update_by)
		        VALUES
		        ('".$PR_NUMBER."',
		        '".$FILE_NAME."',
				'".$PO_NUMBER."',
		    	'P',
		    	'".$CREATION_DATE."',
		    	'".$employee_id."',
		    	'".$LAST_UPDATE_DATE."',
		    	'".$employee_id."'
		    	)";



		if (mysqli_query($conn_php, $sql_php)) {
		    // echo "New record created successfully";
		    header("Location:../form_upload_audit_AP.php?PR_NUMBER=$PR_NUMBER&FILE_NAME=$FILE_NAME&PO_NUMBER=$PO_NUMBER");
		} else {
		    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
		}
?>