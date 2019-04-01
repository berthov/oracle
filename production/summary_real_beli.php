<?php
session_start();
include("controller/doconnect_php.php");
include("controller/session.php");
include("controller/doconnect.php");   
include("query/cek_employee.php");   

if(isset($_REQUEST['START_DATE'])){
      $START_DATE = $_REQUEST['START_DATE'] ;
	  }else{
      $START_DATE = null;
     }

if(isset($_REQUEST['END_DATE'])){
      $END_DATE = $_REQUEST['END_DATE'];
	  }else{
      $END_DATE = null;
     }
	 


$newDate = date("d/M/Y", strtotime($START_DATE));
$newDate2 = date("d/M/Y", strtotime($END_DATE));


$form_token = uniqid();
$_SESSION['form_token'] = $form_token;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Toastr -->
    <link rel="stylesheet" href="../vendors/toastr/toastr.min.css">
    <script src="../vendors/toastr/jquery-1.9.1.min.js"></script>
    <script src="../vendors/toastr/toastr.min.js"></script>
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet"> 
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="form_ap.php" class="site_title"><i class="fa fa-paw"></i> <span> CBA </span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php include("view/menu_profile.php"); ?>
            <!-- /menu profile quick info -->
            <br />

            <!-- sidebar menu -->
            <?php include("view/side_bar.php"); ?>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        <?php include("view/top_nav.php"); ?>
        <!-- /top navigation -->

        <!-- page content -->
			<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Summary Real Beli</h2>
                    <div class="clearfix"></div>
                  </div>
				  <div class="x_content">
					<br />
					
					<form action="summary_real_beli.php" method="post">
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-1" for="last-name">Start Date<span class="required"></span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
						
                          <div class="form-group">
                              <div class='input-group date' id='myDatepicker2'>
                                  <input type='text' class="form-control" name="START_DATE" id="START_DATE" autocomplete="off" required="required" placeholder = <?php echo $START_DATE?> >
                                  <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                        </div>
						<label class="control-label col-md-1 col-sm-1 col-xs-1" for="last-name">End Date<span class="required"></span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <div class="form-group">
                              <div class='input-group date' id='myDatepicker3'>
                                  <input type='text' class="form-control" name="END_DATE" id="END_DATE" autocomplete="off" required="required" placeholder = <?php echo $END_DATE?> >
                                  <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                        </div>
						 &nbsp
						<input type="submit" >
						</div>
                      </div>
					  </form>
					  
					  <div class="x_content">
                        <div class="card-box table-responsive">             
                          <table id="datatable" class="table table-striped">
                            <thead>
                              <tr>
                                <th>Nomor PR</th>
                                <th>Nomor PO</th>
								<th>Tanggal RI</th>
                                <th>Nomor RI</th>
                                <th>Nomor PI</th>
                                <th>Nomor Payment</th>
                                <th>Nama Vendor</th>
                              </tr>
                            </thead>
                            <tbody>
							
							<?php

                            $sql = 
                            "SELECT DISTINCT PRHA.SEGMENT1 NOMOR_PR,
									PHV.SEGMENT1 NOMOR_PO,
									RVTV.TRANSACTION_DATE RCV_DATE,
									RSH.RECEIPT_NUM RECEIPT_NUMBER,
									AI.INVOICE_NUM INVOICE_NUM,
									NVL(TO_CHAR(ACA.CHECK_NUMBER), 'NOT PAID') PAY_NUM,
									PHV.VENDOR_NAME VENDOR_NAME
							FROM PO_HEADERS_V PHV,
								 PO_LINES_V PLV,
								 PO_LINE_LOCATIONS_ALL PLLA,
								 PO_DISTRIBUTIONS_ALL PDA,
								 PO_REQ_DISTRIBUTIONS_ALL PRDA,
								 PO_REQUISITION_LINES_ALL PRLA,
								 PO_REQUISITION_HEADERS_ALL PRHA,
								 RCV_VRC_TXS_V RVTV,
								 RCV_SHIPMENT_HEADERS RSH,
								 AP_INVOICES_V AI,
								 AP_INVOICE_LINES_V AILA,
								 AP_PAYMENT_SCHEDULES APS,
								 AP_CHECKS_ALL ACA,
								 AP_INVOICE_PAYMENTS_ALL AIPA,
								 AP_VIEW_PREPAYS_V AVPV,
								 ( 
								  SELECT   TO_NUMBER (COUNT (SHIPMENT_LINE_ID)) A, SHIPMENT_LINE_ID
									  FROM RCV_VRC_TXS_V rvtv1
									 WHERE TRUNC (RVTV1.TRANSACTION_DATE) BETWEEN '".$newDate."'
																			  AND '".$newDate2."'
										   AND transaction_type != 'RETURN TO RECEIVING'
								  GROUP BY SHIPMENT_LINE_ID) X
							 WHERE  
									TRUNC (RVTV.TRANSACTION_DATE) BETWEEN '".$newDate."' AND '".$newDate2."'
									 AND PHV.PO_HEADER_ID = PLV.PO_HEADER_ID(+)
									 AND PLLA.PO_LINE_ID(+) = PLV.PO_LINE_ID
									 AND PLLA.LINE_LOCATION_ID = PDA.LINE_LOCATION_ID
									 AND PDA.PO_HEADER_ID(+) = PLV.PO_HEADER_ID
									 AND PDA.REQ_DISTRIBUTION_ID = PRDA.DISTRIBUTION_ID(+)
									 AND PRDA.REQUISITION_LINE_ID = PRLA.REQUISITION_LINE_ID(+)
									 AND PRLA.REQUISITION_HEADER_ID = PRHA.REQUISITION_HEADER_ID(+)
									 AND RVTV.po_header_id(+) = PLV.po_header_id
									 AND RSH.SHIPMENT_HEADER_ID(+) = RVTV.SHIPMENT_HEADER_ID
									 AND RVTV.TRANSACTION_TYPE = 'DELIVER'
									 AND AILA.PO_HEADER_ID(+) = PHV.PO_HEADER_ID
									 AND AILA.RECEIPT_NUMBER = RSH.RECEIPT_NUM
									 AND AILA.INVOICE_ID = AI.INVOICE_ID(+)
									 AND APS.INVOICE_ID(+) = AI.INVOICE_ID
									 AND AIPA.INVOICE_ID(+) = APS.INVOICE_ID
									 AND ACA.CHECK_ID(+) = AIPA.CHECK_ID
									 AND NVL (AI.APPROVAL_STATUS_LOOKUP_CODE, ' ') NOT IN ('CANCELLED')
									 AND PDA.LINE_LOCATION_ID = RVTV.PO_LINE_LOCATION_ID(+)
									 AND AI.INVOICE_ID = AVPV.INVOICE_ID(+)
									 AND NVL (invoice_type_lookup_code, ' ') NOT IN ('PREPAYMENT')
									 AND (XXCBA_CHECK_TRX (RVTV.TRANSACTION_TYPE, x.A) = 1)
									 AND X.SHIPMENT_LINE_ID = RVTV.SHIPMENT_LINE_ID
									 AND RSH.RECEIPT_NUM = AILA.RECEIPT_NUMBER(+)
							ORDER BY PHV.SEGMENT1,
											RSH.RECEIPT_NUM,
											AI.INVOICE_NUM";
                                                           
                              $result = oci_parse($conn,$sql);
                                oci_execute($result);

                              while($row = oci_fetch_array($result, OCI_ASSOC)) {
                              ?>
                              <tr>
								  <td><?php echo $row["NOMOR_PR"]; ?></td>
								  <td><?php echo $row["NOMOR_PO"]; ?></td>
								  <td><?php echo date('d-M-Y',strtotime($row["RCV_DATE"])); ?></td>
								  <td><?php echo $row["RECEIPT_NUMBER"]; ?></td>
								  <td><?php echo $row["INVOICE_NUM"]; ?></td>
								  <td><?php echo $row["PAY_NUM"]; ?></td>
								  <td><?php echo $row["VENDOR_NAME"]; ?></td>
							  </tr>
                              
                              <?php
                              }
                              ?>
                            
							
							
                            </tbody>
                          </table>
                        </div>


                    </div>
					</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>  
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="../production/common/error.js"></script>
	
    <script type="text/javascript">

	
	$("#myDatepicker2").on("dp.keydown keypress keyup", false);
	
	$("#myDatepicker3").on("dp.keydown keypress keyup", false);
	
function myDeleteFunction() {
    document.getElementById("myTable").deleteRow(1);
}

function deleteRow(row) {
  var i = row.parentNode.parentNode.rowIndex;
  document.getElementById('myTable').deleteRow(i);
}



function myCreateFunction() {
    var table = document.getElementById("myTable");
    var row = table.insertRow(1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    
    cell1.innerHTML = '<td><input type="hidden" class="itemcoun" name="COUNTER[]" id="COUNTER">#</td>';
    cell2.innerHTML = '<td><select class="form-control itemdesc" id="DISTRIBUTION_SET_ID" name="DISTRIBUTION_SET_ID[]" required="required"><?php $sql = "SELECT adsa.distribution_set_id AS DISTRIBUTION_SET_ID, 
                    adsa.description AS DESCRIPTION
                    FROM ap_distribution_sets adsa,
                    AP_DISTRIBUTION_SET_LINES  adsl,
                    gl_code_combinations_kfv gcc
                    WHERE
                    adsa.distribution_set_id = adsl.distribution_set_id
                    AND adsl.dist_code_combination_id = gcc.code_combination_id
                    AND adsa.description LIKE '%Biaya%'";                                 
                    $result = oci_parse($conn,$sql);
                    oci_execute($result);
                    while($row = oci_fetch_array($result, OCI_ASSOC)) {
                    ?><option value="<?php echo $row["DISTRIBUTION_SET_ID"] ?>">                                  <?php echo $row["DESCRIPTION"] ?></option><?php } ?> </select> </td>';
    cell3.innerHTML = '<td><input type="text" class="form-control itemamo" id="AMOUNT" name="AMOUNT[]" required="required" autocomplete="off"></td>';
    cell4.innerHTML = '<td><button class="btn btn-danger" type="button" onclick="deleteRow(this);"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></td>';
}


    $('#myDatepicker2').datetimepicker({
        format: 'MM/DD/YYYY'
    });
	
	 $('#myDatepicker3').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    </script>

  </body>
</html>