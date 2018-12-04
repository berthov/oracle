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
          <div class="panel-body">
            <div class="panel panel-default" style="padding-top: 20px;  border: 0px;">

                                                  
                                <table class="table" id="myTable">
                                  <tr>
                                    <th>#</th>
                                    <th>Invoice Date</th>
									<th>Invoice Number</th>
									<th>Invoice Type</th>
                                    <th>Requestor</th>
									<th>Invoice Amount</th>
									<th>Approval Date</th>
									<th>Status</th>
                                    <th></th>
                                  </tr>
								  <div class="clearfix"></div>
								                           
                                      <?php
									  $sql = "SELECT aia.CREATION_DATE as CREATION_DATE,
													 aia.INVOICE_NUM as INVOICE_NUM,
													 aia.INVOICE_TYPE_LOOKUP_CODE as INVOICE_TYPE,
													 emp.name as EMP_NAME,
													 aia.INVOICE_AMOUNT as INVOICE_AMOUNT,
													 aia.STATUS as STATUS,
													 aia.INVOICE_ID as INVOICE_ID,
													 aia.APPROVAL_DATE,
													 aia.INVOICE_DATE
												FROM ap_invoices_header aia,
													 employee emp
												WHERE aia.CREATED_BY = emp.employee_id
													AND aia.STATUS = 'P'";
												$result = $conn_php->query($sql);
												$tmpCount = 0;
												
												if ($result->num_rows > 0) {
													// output data of each row
													while($row = $result->fetch_assoc()) {
														$tmpCount ++;
														
														?>
														<tr>    
														<td><?php echo $tmpCount;	?></td>
														<td><?php echo $row["INVOICE_DATE"];	?></td>
														<td><?php echo $row["INVOICE_NUM"];	?></td>
														<td><?php echo $row["INVOICE_TYPE"];	?></td>
														<td><?php echo $row["EMP_NAME"];	?></td>
														<td><?php echo $row["INVOICE_AMOUNT"];	?></td>
														<td><?php echo $row["APPROVAL_DATE"];	?></td>
														<td><?php echo $row["STATUS"];	?></td>
														<td><a href="submit.php?INVOICE_ID=<?php echo $row['INVOICE_ID'] ?>"><button class="btn btn-success">Submit</button>
														
													<?php
													
													}
												} else {
													echo "0 results";
												}
												?>
								 </table>
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