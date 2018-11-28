<?php
	// HEADER
		$sql_php = 
		"INSERT INTO ap_invoices_header 
		        (INVOICE_ID,
				INVOICE_NUM,
				INVOICE_TYPE_LOOKUP_CODE,
				INVOICE_DATE,
				VENDOR_NAME,
				VENDOR_SITE_CODE,
				INVOICE_AMOUNT,
				INVOICE_CURRENCY_CODE,
				TERMS_NAME,
				LAST_UPDATE_DATE,
				LAST_UPDATED_BY,
				CREATION_DATE,
				CREATED_BY,
				SOURCE,
				GOODS_RECEIVED_DATE,
				INVOICE_RECEIVED_DATE,
				GL_DATE,
				ORG_ID,
				TERMS_DATE,
				STATUS,
				COUNT_PRINT)
		        VALUES
		        ('".$INVOICE_ID."',
		        '".$INVOICE_NUM."',
		    	'".$INVOICE_TYPE_LOOKUP_CODE."',
		    	'".$INVOICE_DATE_L."',
		    	'".$VENDOR_NAME."',
		    	'".$VENDOR_SITE_CODE."',
		    	'".$INVOICE_AMOUNT."',
		    	'".$INVOICE_CURRENCY_CODE."',
		    	'".$TERMS_NAME."',
		        '".$LAST_UPDATE_DATE_L."',
		    	'".$employee_id."',
		        '".$CREATION_DATE_L."',
		    	'".$employee_id."',
		    	'".$SOURCE."',
		    	'".$GOODS_RECEIVED_DATE_L."',
		    	'".$INVOICE_RECEIVED_DATE_L."',
		    	'".$GL_DATE_L."',
		    	'".$ORG_ID."',
		    	'".$TERMS_DATE_L."',
		    	'P',
		    	0
		    	)";



		if (mysqli_query($conn_php, $sql_php)) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
		}
	// END OF HEADER

	// LINE
    for($x = 0; $x < sizeof($COUNTER); $x++ ){
		$flag1 = $x + 1;
		$sql_php = 
		"INSERT INTO AP_INVOICES_LINE 
		        (INVOICE_ID,
				LINE_NUMBER,
				LINE_TYPE_LOOKUP_CODE,
				AMOUNT,
				ACCOUNTING_DATE,
				DESCRIPTION,
				DISTRIBUTION_SET_ID,
				CREATION_DATE,
				CREATED_BY,
				LAST_UPDATE_DATE,
				LAST_UPDATED_BY)
		        VALUES
		        ('".$INVOICE_ID."',
		        '".$flag1."',
		        '".$LINE_TYPE_LOOKUP_CODE."',
		        '".$AMOUNT[$x]."',
		        '".$ACCOUNTING_DATE_L."',
		        '".$DESCRIPTION[$x]."',
		        '".$DISTRIBUTION_SET_ID[$x]."',
		        '".$CREATION_DATE_L."',
		        '".$employee_id."',
		        '".$LAST_UPDATE_DATE_L."',
		        '".$employee_id."')";

		if (mysqli_query($conn_php, $sql_php)) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
		}
	}
	// END OF LINE
?>