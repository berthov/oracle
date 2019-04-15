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
            <?php
              if ($_SESSION['userRole'] == "Staff"){
                include("view/side_bar_staff.php");
              } else if ($_SESSION['userRole'] == "Admin") {
                include("view/side_bar.php");
              }
            ?>
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
                                <th>Uploaded File</th>
                                <th>View</th>
                              </tr>
                            </thead>
                            <tbody>
							
							<?php

                            $sql = 
                            "SELECT DISTINCT PRHA.SEGMENT1 PR_NUMBER,
									POH.SEGMENT1 PO_NUMBER,
									RT.TRANSACTION_DATE RCV_DATE,
									RSH.RECEIPT_NUM RECEIPT_NUMBER,
									AIA.INVOICE_NUM INVOICE_NUM,
									NVL(TO_CHAR(ACA.CHECK_NUMBER), 'NOT PAID') PAY_NUM,
									APS.VENDOR_NAME VENDOR_NAME
							FROM PO_REQUISITION_HEADERS_ALL PRHA,
								PO_REQUISITION_LINES_ALL PRLA,
								PO_REQ_DISTRIBUTIONS_ALL PRDA,
								PO_DISTRIBUTIONS_ALL PDA,
								PO_HEADERS_ALL POH,
								PO_LINES_ALL POL,
								PO_LINE_LOCATIONS PLL,
								AP_SUPPLIERS APS,
								ORG_ORGANIZATION_DEFINITIONS OOD,
								RCV_TRANSACTIONS RT,
								RCV_SHIPMENT_HEADERS RSH,
								AP_INVOICE_LINES_V AILA,
								AP_INVOICES_ALL AIA,
								AP_PAYMENT_SCHEDULES_ALL APSA,
								AP_CHECKS_ALL ACA,
								AP_INVOICE_PAYMENTS_ALL AIPA
							WHERE TRUNC(RT.TRANSACTION_DATE) BETWEEN '".$newDate."' AND '".$newDate2."'
								 AND PRHA.REQUISITION_HEADER_ID(+) = PRLA.REQUISITION_HEADER_ID
								 AND PRLA.REQUISITION_LINE_ID(+) = PRDA.REQUISITION_LINE_ID
								 AND PRDA.DISTRIBUTION_ID(+) = PDA.REQ_DISTRIBUTION_ID
								 AND PDA.PO_HEADER_ID = POH.PO_HEADER_ID
								 AND PDA.PO_LINE_ID = POL.PO_LINE_ID
								 AND POH.VENDOR_ID = APS.VENDOR_ID(+)
								 AND POH.PO_HEADER_ID = POL.PO_HEADER_ID
								 and pda.LINE_LOCATION_ID(+) = pll.LINE_LOCATION_ID
								 AND PLL.SHIP_TO_ORGANIZATION_ID = OOD.ORGANIZATION_ID(+)
								 AND POL.PO_LINE_ID = RT.PO_LINE_ID(+)
								 AND RT.SHIPMENT_HEADER_ID = RSH.SHIPMENT_HEADER_ID(+)
								 AND AILA.PO_HEADER_ID(+) = POH.PO_HEADER_ID
								 AND AILA.RECEIPT_NUMBER(+) = RSH.RECEIPT_NUM
								 AND AILA.INVOICE_ID = AIA.INVOICE_ID(+)
								 AND APSA.INVOICE_ID(+) = AIA.INVOICE_ID
								 AND AIPA.INVOICE_ID(+) = APSA.INVOICE_ID
								 AND ACA.CHECK_ID(+) = AIPA.CHECK_ID
								 AND AP_INVOICES_PKG.GET_APPROVAL_STATUS (AIA.INVOICE_ID,
																		   AIA.INVOICE_AMOUNT,
																		   AIA.PAYMENT_STATUS_FLAG,
																		   AIA.INVOICE_TYPE_LOOKUP_CODE) <> 'CANCELLED'
								 AND RT.TRANSACTION_TYPE = 'DELIVER'
								 AND NVL(POL.CANCEL_FLAG,0) <> 'Y'
							ORDER BY POH.SEGMENT1,
											RSH.RECEIPT_NUM,
											AIA.INVOICE_NUM";
                                                           
                              $result = oci_parse($conn,$sql);
                                oci_execute($result);

                              while($row = oci_fetch_array($result, OCI_ASSOC)) {
                              ?>
                              <tr>
            								  <td><?php echo $row["PR_NUMBER"]; ?></td>
            								  <td><?php echo $row["PO_NUMBER"]; ?></td>
            								  <td><?php echo date('d-M-Y',strtotime($row["RCV_DATE"])); ?></td>
            								  <td><?php echo $row["RECEIPT_NUMBER"]; ?></td>
            								  <td><?php echo $row["INVOICE_NUM"]; ?></td>
            								  <td><?php echo $row["PAY_NUM"]; ?></td>
            								  <td><?php echo $row["VENDOR_NAME"]; ?></td>
                              <td align="center">
                                <?php
                                  $flag = 0;
                                  $PR_NUMBER = $row["PR_NUMBER"];
                                  $dir = "uploads/AP/$PR_NUMBER";

                                  if (is_dir($dir)) {
                                    if ($handle = opendir($dir)) {
                                        while (false !== ($entry = readdir($handle))) {
                                            if ($entry != "." && $entry != "..") {
                                                $flag++;
                                              }
                                            }
                                          }
                                        }
                                        echo $flag;
                                ?>
                              </td>
                              <td><a href="form_upload_audit_AP.php?PR_NUMBER=<?php echo $row['PR_NUMBER'] ?>&PO_NUMBER=<?php echo $row['PO_NUMBER'] ?>&RCV_DATE=<?php echo $row['RCV_DATE'] ?>"><button class="btn btn-primary">Upload</button></a></td>
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