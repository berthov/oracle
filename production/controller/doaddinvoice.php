<?php
session_start();
include("doconnect.php");
include("doconnect_php.php");
include("session.php");

// HEADER
$COUNTER = $_REQUEST['COUNTER']; 
$INVOICE_NUM = $_REQUEST['INVOICE_NUM']; 
$INVOICE_TYPE_LOOKUP_CODE ='EXPENSE REPORT';
$INVOICE_DATE = $_REQUEST['INVOICE_DATE']; 
$VENDOR_NAME = 'CBA EMPLOYEE'; 
$VENDOR_SITE_CODE = $_REQUEST['VENDOR_SITE_CODE']; 
$INVOICE_AMOUNT = 0;
$INVOICE_CURRENCY_CODE = 'IDR';
$TERMS_NAME = '5 HARI';
$SOURCE = 'WEB';
$GOODS_RECEIVED_DATE = $_REQUEST['INVOICE_DATE'];  
$INVOICE_RECEIVED_DATE = $_REQUEST['INVOICE_DATE']; 
$GL_DATE =  $_REQUEST['INVOICE_DATE'];   
$TERMS_DATE = $_REQUEST['INVOICE_DATE'];

// LINE
$LINE_TYPE_LOOKUP_CODE = 'ITEM';
$AMOUNT = $_REQUEST['AMOUNT'];
$ACCOUNTING_DATE = $_REQUEST['INVOICE_DATE'];	
$DISTRIBUTION_SET_ID = $_REQUEST['DISTRIBUTION_SET_ID'];


// HEADER PHP
$INVOICE_DATE_L = date('Y-m-d', strtotime($_REQUEST['INVOICE_DATE']));
$GOODS_RECEIVED_DATE_L = date('Y-m-d', strtotime($_REQUEST['INVOICE_DATE']));
$INVOICE_RECEIVED_DATE_L = date('Y-m-d', strtotime($_REQUEST['INVOICE_DATE']));
$GL_DATE_L =  date('Y-m-d', strtotime($_REQUEST['INVOICE_DATE']));
$TERMS_DATE_L = date('Y-m-d', strtotime($_REQUEST['INVOICE_DATE']));
$CREATION_DATE_L =  date("Y-m-d");
$LAST_UPDATE_DATE_L =  date("Y-m-d");


// LINE PHP
$ACCOUNTING_DATE_L = date('Y-m-d', strtotime($_REQUEST['INVOICE_DATE']));


for($y = 0; $y < sizeof($COUNTER); $y++ ){
	$INVOICE_AMOUNT = $INVOICE_AMOUNT + $AMOUNT[$y];
	}

// if($_POST['form_token'] != $_SESSION['form_token'])
// {
//         echo 'Access denied';
// } else {

	if($_SERVER["REQUEST_METHOD"]=="POST"){
		
		$sql_check = "SELECT INVOICE_NUM
		FROM AP_INVOICES_INTERFACE 
		WHERE INVOICE_NUM = '".$INVOICE_NUM."' 
		";

		$result_invoice = oci_parse($conn,$sql_check);
		oci_execute($result_invoice);
		$existing_result = oci_fetch_assoc($result_invoice);


		if ($existing_result) { 
		     if ($existing_result['INVOICE_NUM'] === $INVOICE_NUM) {
		      echo "Invoice already exist";
		    }
		}
		else{

			// ORACLE		
				include("../query/insert_oracle.php");
			// END OF ORACLE

			// PHP
				include("../query/insert_php.php");
			// END OF PHP

			// header("Location:../form_ap.php");
		}


	}    
// }


?>