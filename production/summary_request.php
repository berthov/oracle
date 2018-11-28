<?php
session_start();
include("controller/doconnect_php.php");
include("controller/session.php");
include("controller/doconnect.php");   
include("query/cek_employee.php");   

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

    <?php include("view/title.php"); ?>

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
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
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
                    <h2>Summary Request</h2>
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content">
                        <div class="card-box table-responsive">             
                          <table id="datatable" class="table table-striped">
                            <thead>
                              <tr>
                                <th>Invoice Number</th>
                                <th>Invoice Date</th>
                                <th>Invoice Type</th>
                                <th>Amount</th>
                                <th>Approval Date</th>
                                <th>Requestor</th>
                                <th>Status</th>
                                <th>Detail</th>
                              </tr>
                            </thead>
                            <tbody>

                            <?php

                            $sql = 
                            "SELECT 
                             AIH.INVOICE_ID,
                             AIH.INVOICE_DATE,
                             AIH.INVOICE_TYPE_LOOKUP_CODE,
                             AIH.INVOICE_NUM,
                             AIH.INVOICE_AMOUNT,
                             AIH.APPROVAL_DATE,
                             AIH.STATUS,
                             e.name
                             FROM 
                             ap_invoices_header AIH,
                             employee e
                             WHERE 
                             e.employee_id = AIH.CREATED_BY";
                                                           
                              $result = $conn_php->query($sql);
                              while($row = $result->fetch_assoc()) {                               
                            ?>

                            <tr>
                              <td><?php echo $row["INVOICE_NUM"]; ?></td>
                              <td><?php echo date('d-M-Y',strtotime($row["INVOICE_DATE"])); ?></td>
                              <td><?php echo $row["INVOICE_TYPE_LOOKUP_CODE"]; ?></td>
                              <td>IDR <?php echo number_format($row["INVOICE_AMOUNT"]); ?></td>
                              <td><?php 
                                  if ($row["STATUS"] === 'P') {
                                    echo "Need Approval";
                                  } else{
                                    echo date('d-M-Y',strtotime($row["APPROVAL_DATE"]));
                                  }
                                  ?>  
                              </td>
                              <td><?php echo $row["name"]; ?></td>
                              <td><strong>
                                <?php 
                                  if ($row["STATUS"] === 'P') {
                                    echo "Need Approval";
                                  } else{
                                    echo "Approved";
                                  }
                                ?>
                                  
                                </strong></td>
                              <td><a href="invoice.php?INVOICE_ID=<?php echo $row['INVOICE_ID'] ?> "><button class="btn btn-primary">View Detail</button></a></td>
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
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.js"></script>

    <script src="../production/common/error.js"></script>

  </body>
</html>