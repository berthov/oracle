<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$INVOICE_ID = $_REQUEST['INVOICE_ID']; 
$DATE = date('Y-m-d');


	// HEADER
		$sql_php = 
		"UPDATE ap_invoices_header 
		SET LAST_UPDATE_DATE= '".$DATE."', 
		LAST_PRINT_BY ='".$employee_id."', 
		LAST_PRINT_DATE ='".$DATE."', 
		COUNT_PRINT = COUNT_PRINT + 1 
		WHERE INVOICE_ID = '".$INVOICE_ID."'";

		if (mysqli_query($conn_php, $sql_php)) { 
			header("Location:../summary_request.php");
		} else {
		    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
		}

	// END OF HEADER

?>