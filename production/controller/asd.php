<?php
session_start();

$INVOICE_NUM = $_REQUEST['INVOICE_NUM']; 


if ($INVOICE_NUM === $_REQUEST['INVOICE_NUM']) {
	echo "Invoice already exist";
}else{

    header("Location:../form_ap.php");
}
?>