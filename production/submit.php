<?php
session_start();
include("controller/doconnect_php.php");
include("controller/session.php");
include("controller/doconnect.php");   
include("query/cek_employee.php");   

$INVOICE_ID = $_REQUEST['INVOICE_ID']; 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include("view/title.php"); ?>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    
    <!-- Custom styling plus plugins -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <?php include("view/home.php"); ?>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php include("view/menu_profile.php"); ?>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php
              if ($_SESSION['userRole'] == "Staff"){
                // session_destroy(); 

                // session_start();
                // $logout = true;
                // $_SESSION['logout'] = $logout;
                
                // header("location: login.php"); 
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
              <div class="col-md-12">
                <div class="x_panel">
                      
                  <?php
                      $sql_invoice = 
                      "SELECT 
                      AI.* 
                      FROM AP_INVOICES_HEADER AI
                      where INVOICE_ID = '".$INVOICE_ID."'
                      ";

                      $result_invoice = mysqli_query($conn_php,$sql_invoice);
                      $existing_invoice = mysqli_fetch_assoc($result_invoice);
                  ?>

                  <div class="x_title">
                    <h2>
                        <?php 
                          if ($existing_invoice['STATUS'] === 'P') {
                             echo "Need Approval";
                           } else{
                             echo "Approved";
                           } 
                        ?>  
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <section class="content invoice" id="printableArea">
                      <!-- title row -->
                      <div class="row">
                        <div class="col-xs-6 invoice-header">
                          <h3>
                              <?php echo $existing_invoice['INVOICE_TYPE_LOOKUP_CODE']; ?>
                          </h3> 
                        </div>
                        <div class="col-xs-6 invoice-header">
                          <h3>
                              <small class="pull-right">Invoice Date: <?php echo date('d-M-Y',strtotime($existing_invoice['INVOICE_DATE'])); ?></small>
                          </h3> 
                        </div>
                        <!-- /.col -->
                      </div>
                      
                      <!-- end of title row -->
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                          Vendor Name
                          <address>
                              <strong><?php echo $existing_invoice['VENDOR_NAME']; ?></strong>
                          </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          Vendor Site 
                          <address>
                              <strong><?php echo $existing_invoice['VENDOR_SITE_CODE']; ?></strong>
                          </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          Invoice Number
                          <br><b> <?php echo $existing_invoice['INVOICE_NUM']; ?></b>
                          <br>
                          <br>
                          <b>Terms :</b> <?php echo $existing_invoice['TERMS_NAME']; ?>
                          <br>
                          <b>Terms Date :</b> <?php echo date('d-M-Y',strtotime($existing_invoice['TERMS_DATE'])); ?>
                          <br>
                          <b>Currency :</b> <?php echo $existing_invoice['INVOICE_CURRENCY_CODE']; ?>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- Table row -->
                      <div class="row">
                        <div class="col-xs-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Line Number</th>
                                <th>Type</th>
                                <th style="width: 59%">Description</th>
                                <th>Subtotal</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php

                              $sql = 
                              "SELECT AIL.*
                               FROM ap_invoices_line AIL
                               WHERE invoice_id = '".$INVOICE_ID."'
                               ";
                                
                                $amount_invoice = 0;
                                $result = $conn_php->query($sql);
                                while($row = $result->fetch_assoc()) {
                                  $amount_invoice = $amount_invoice + $row["AMOUNT"];
                              ?>

                              <tr>
                                <td><?php echo $row["LINE_NUMBER"]; ?></td>
                                <td><?php echo $row["LINE_TYPE_LOOKUP_CODE"]; ?></td>
                                <td><?php echo $row["DESCRIPTION"]; ?>
                                </td>
                                <td>IDR <?php echo number_format($row["AMOUNT"]); ?></td>
                              </tr>
                              
                              <?php
                              
                              }
                              
                              ?>
                              <tr>
                                <td colspan="3" align="right"><strong><h2>Total</h2></strong></td>
                                <td><h2>IDR <?php echo number_format($amount_invoice); ?></h2></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
					  <div align="right">
                          <!-- Small modal -->
                          <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal_pending_apprv">Approve</button>

                          <!-- Modal Pending Approve -->
							<!-- Modal -->
							<div id="modal_pending_apprv" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Warning!</h4>
								  </div>
								  <div class="modal-body">
									<p>Are you sure to Approve this Invoice?</p>
								  </div>
								  <div class="modal-footer">
									<a href="controller/doupdatepending.php?id=<?php echo $existing_invoice['INVOICE_ID'] ?>"><button class="btn btn-success" > Yes</button></a>
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- Modal Pending Approve -->
                        </div>
                      <!-- /.row -->
                    </section>

                      <!-- this row will not appear when printing -->

                        


                        <!-- /modals -->
                      </div>
                      <!-- /.row -->
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
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script type="text/javascript">
      function printDiv(divName) {
           var printContents = document.getElementById(divName).innerHTML;
           var originalContents = document.body.innerHTML;

           document.body.innerHTML = printContents;

           window.print();
           document.body.innerHTML = originalContents;   
           document.location.href = 'controller/docountinvoice.php?INVOICE_ID=<?php echo $INVOICE_ID ?>';


      }
    </script>

  </body>
</html>