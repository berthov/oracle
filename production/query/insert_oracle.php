<?php
	$SOURCE = "WEB";
	// INVOICE ID
	$sql = 
		"SELECT ap_invoices_interface_s.NEXTVAL as INVOICE_ID
		 FROM DUAL";

		$result = oci_parse($conn,$sql);
		oci_execute($result);

	while($row = oci_fetch_array($result, OCI_ASSOC)) {
	   $INVOICE_ID = $row['INVOICE_ID'];
	}
	// END OF INVOICE ID

	// CEK DESCRIPTION DISTRIBUTION_SET_ID
		for ($i=0; $i < sizeof($COUNTER) ; $i++) { 
		
	        $sql = "SELECT adsa.description AS DESCRIPTION,
	        fnd_profile.VALUE('ORG_ID') AS ORG_ID
	        FROM ap_distribution_sets adsa,
	        AP_DISTRIBUTION_SET_LINES  adsl,
	        gl_code_combinations_kfv gcc
	        WHERE
	        adsa.distribution_set_id = adsl.distribution_set_id
	        AND adsl.dist_code_combination_id = gcc.code_combination_id
	        AND adsa.distribution_set_id = '".$DISTRIBUTION_SET_ID[$i]."'";

	        $result = oci_parse($conn,$sql);
	        oci_execute($result);

			while($row = oci_fetch_array($result, OCI_ASSOC)) {
			   $DESCRIPTION[$i] = $row['DESCRIPTION'];
			   $ORG_ID = $row['ORG_ID'];
			}
		}
	// END OF DESCRIPTION DISTRIBUTION_SET_ID
				
	// HEADER
		$sql = 
		"INSERT INTO AP_INVOICES_INTERFACE A
		        (A.INVOICE_ID,
				A.INVOICE_NUM,
				A.INVOICE_TYPE_LOOKUP_CODE,
				A.INVOICE_DATE,
				A.VENDOR_NAME,
				A.VENDOR_SITE_CODE,
				A.INVOICE_AMOUNT,
				A.INVOICE_CURRENCY_CODE,
				A.TERMS_NAME,
				A.LAST_UPDATE_DATE,
				A.LAST_UPDATED_BY,
				A.CREATION_DATE,
				A.CREATED_BY,
				A.SOURCE,
				A.GOODS_RECEIVED_DATE,
				A.INVOICE_RECEIVED_DATE,
				A.GL_DATE,
				A.ORG_ID,
				A.TERMS_DATE)
		        VALUES
		        ('".$INVOICE_ID."',
		        '".$INVOICE_NUM."',
		    	'".$INVOICE_TYPE_LOOKUP_CODE."',
		    	(TO_DATE('".$INVOICE_DATE."', 'yyyy/mm/dd')),
		    	'".$VENDOR_NAME."',
		    	'".$VENDOR_SITE_CODE."',
		    	'".$INVOICE_AMOUNT."',
		    	'".$INVOICE_CURRENCY_CODE."',
		    	'".$TERMS_NAME."',
		        SYSDATE,	
		    	1154,
		        SYSDATE,
		    	1154,
		    	'".$SOURCE."',
		    	(TO_DATE('".$INVOICE_DATE."', 'yyyy/mm/dd')),
		    	(TO_DATE('".$INVOICE_DATE."', 'yyyy/mm/dd')),
		    	(TO_DATE('".$INVOICE_DATE."', 'yyyy/mm/dd')),
		    	fnd_profile.VALUE('ORG_ID'),
		    	(TO_DATE('".$INVOICE_DATE."', 'yyyy/mm/dd'))
		    	)";



		$result = oci_parse($conn,$sql);
		oci_execute($result);
	// END OF HEADER


	// LINE
    for($y = 0; $y < sizeof($COUNTER); $y++ ){
		$flag = $y + 1;
		$sql = 
		"INSERT INTO ap_invoice_lines_interface B
		        (B.INVOICE_ID,
				B.LINE_NUMBER,
				B.LINE_TYPE_LOOKUP_CODE,
				B.AMOUNT,
				B.ACCOUNTING_DATE,
				B.DESCRIPTION,
				B.DISTRIBUTION_SET_ID,
				B.CREATION_DATE,
				B.CREATED_BY,
				B.LAST_UPDATE_DATE,
				B.LAST_UPDATED_BY)
		        VALUES
		        ('".$INVOICE_ID."',
		        '".$flag."',
		        '".$LINE_TYPE_LOOKUP_CODE."',
		        '".$AMOUNT[$y]."',
		        (TO_DATE('".$ACCOUNTING_DATE."', 'yyyy/mm/dd')),
		        '".$DESCRIPTION[$y]."',
		        '".$DISTRIBUTION_SET_ID[$y]."',
		        SYSDATE,
		        1154,
		        SYSDATE,
		        1154)";

		$result = oci_parse($conn,$sql);
		oci_execute($result);
	}
	// END OF LINE
?>