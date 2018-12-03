<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("doconnect.php");   
include("../query/cek_employee.php");   

$sql = "SELECT   aia.CREATION_DATE as CREATION_DATE,
				 aia.INVOICE_NUM as INVOICE_NUM,
				 aia.INVOICE_TYPE_LOOKUP_CODE as INVOICE_TYPE,
				 emp.name as EMP_NAME,
				 aia.INVOICE_CURRENCY_CODE,
				 aia.INVOICE_AMOUNT as INVOICE_AMOUNT,
				 aia.STATUS as STATUS,
				 aia.VENDOR_NAME,
				 aia.VENDOR_SITE_CODE,
				 aia.TERMS_NAME as TERMS_NAME
			FROM ap_invoices_header aia,
				 employee emp
			WHERE aia.CREATED_BY = emp.employee_id
				and aia.STATUS = 'P'";

$sql_line = "SELECT aila.INVOICE_ID,
				aila.AMOUNT,
				aila.INVOICE_DATE,
				aila.LINE_TYPE_LOOKUP_CODE,
				aila.DISTRIBUTION_SET_ID,
				aila.DESCRIPTION
			FROM ap_invoices_line aila
			WHERE 1 = 1";

$id = $_REQUEST['id']; 
$approve_date = date('Y-m-d');

// echo $id;

$sql = "UPDATE ap_invoices_header SET STATUS='A', APPROVAL_DATE = '".$approve_date."', LAST_UPDATE_DATE = '".$approve_date."', LAST_UPDATED_BY = '".$employee_id."' WHERE INVOICE_ID='".$id."'";
$sql_line = "UPDATE ap_invoices_line SET LAST_UPDATE_DATE = '".$approve_date."', LAST_UPDATED_BY = '".$employee_id."'";

if (mysqli_query($conn_php, $sql)) {
		    header("Location:../form_pending_req.php");
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn_php);
		}

		
		// ORACLE		
				// include("../query/insert_oracle.php");
		// END OF ORACLE
?>