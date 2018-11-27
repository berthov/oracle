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
            <div class="page-title">
              <div class="title_left">
                <h3>Form AP</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Header</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="form_ap" class="form-horizontal form-label-left input_mask" method="post" action="controller/doaddinvoice.php">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Invoice Number</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <input type="text" class="form-control" name="INVOICE_NUM" id="INVOICE_NUM" autocomplete="off" required="required"></input>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Vendor Name </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <input type="text" class="form-control" placeholder="CBA EMPLOYEE" disabled="disabled"></input>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Vendor Site Code </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                              <select class="form-control" name="VENDOR_SITE_CODE" id="VENDOR_SITE_CODE" required="required">
                              <option value="" disabled selected>Select Site</option>
                              <?php
                                $sql = "SELECT VENDOR_SITE_CODE
                                        FROM AP_SUPPLIERS ASA ,
                                        AP_SUPPLIER_SITES_ALL ASSA
                                        WHERE ASA.VENDOR_NAME LIKE '%CBA%'
                                        AND ASA.VENDOR_ID = ASSA.VENDOR_ID";
                                
                                $result = oci_parse($conn,$sql);
                                oci_execute($result);

                              while($row = oci_fetch_array($result, OCI_ASSOC)) {
                              ?>
                              <option value="<?php echo $row["VENDOR_SITE_CODE"] ?>"><?php echo $row["VENDOR_SITE_CODE"] ?></option>                              
                              
                              <?php
                              }
                              ?>

                            </select> 
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Invoice Type</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select class="form-control" name="INVOICE_TYPE_LOOKUP_CODE" id="INVOICE_TYPE_LOOKUP_CODE" required="required">
                              <option value="" disabled selected>Select Invoice Type</option>
                              <option value="PREPAYMENT">Prepayment</option>
                              <option value="EXPENSE REPORT">Expense Report</option>
                              <option value="MIXED">Mixed</option>
                            </select> 
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Invoice Date<span class="required"></span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <div class="form-group">
                              <div class='input-group date' id='myDatepicker2'>
                                  <input type='text' class="form-control" name="INVOICE_DATE" id="INVOICE_DATE" autocomplete="off" required="required">
                                  <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                        </div>
                      </div>
                      
                      <input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2><i class="fa fa-align-left"></i>Line <small>Sub-Title</small></h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">

                            <!-- PO LINE  -->
                            <div class="panel-body">
                              <div class="panel panel-default" style="padding-top: 20px;  border: 0px;">

                                                  
                              <div class="table-responsive" >
                                <table class="table" id="myTable">
                                  <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th></th>
                                  </tr>
                                  <tr>
                                    <td><input type="hidden" class="itemcoun" name="COUNTER[]" id="COUNTER">#</td>
                                    <td>                                   
                                      <select class="form-control itemdesc" id="DISTRIBUTION_SET_ID" name="DISTRIBUTION_SET_ID[]" required="required">
                                      <?php

                                        $sql = "SELECT adsa.distribution_set_id AS DISTRIBUTION_SET_ID, 
                                                adsa.description AS DESCRIPTION
                                                FROM ap_distribution_sets adsa,
                                                AP_DISTRIBUTION_SET_LINES  adsl,
                                                gl_code_combinations_kfv gcc
                                                WHERE
                                                adsa.distribution_set_id = adsl.distribution_set_id
                                                AND adsl.dist_code_combination_id = gcc.code_combination_id
                                                AND adsa.description LIKE '%Biaya%'
                                                and gcc.segment4 = '".$divisi."'";
                                        
                                        $result = oci_parse($conn,$sql);
                                        oci_execute($result);

                                      while($row = oci_fetch_array($result, OCI_ASSOC)) {
                                      ?>

                                      <option value="<?php echo $row["DISTRIBUTION_SET_ID"] ?>"> <?php echo $row["DESCRIPTION"] ?></option>
                                      <?php
                                        }
                                      ?>
                                      </select>
                                    </td>
                                    <td><input type="number" class="form-control itemamo" id="AMOUNT" min="-9999999999" name="AMOUNT[]" required="required" autocomplete="off"></td>
                                    <td></td>
                                  </tr>
                                </table>
                              </div>


                              <button class="btn btn-success" type="button" onclick="myCreateFunction();"> <b>Insert New Row</b>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                              </button>

                              <div class="clear"></div>    
                              </div>
                            </div>
                            <!-- END OF PO LINE -->
                          </div>
                        </div>
                      </div>
                    </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
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
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="../production/common/error.js"></script>
	
    <script type="text/javascript">

    $("#myDatepicker2").on("dp.keydown keypress keyup", false);

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
            format: 'YYYY/MM/DD'
        });
  
    </script>

  </body>
</html>