<?php
include("controller/doconnect.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>Bonne Journée! </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome-2/css/all.css" rel="stylesheet"> 
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        
        <!-- Sidebar Menu -->
        <?php
          if ($_SESSION['userRole'] == "Staff"){
            session_destroy(); 

            session_start();
            $logout = true;
            $_SESSION['logout'] = $logout;
            
            header("location: login.php"); 
          } else if ($_SESSION['userRole'] == "Admin") {
            include("view/sidebar.php");
          }
        ?>
        <!-- End Of Sidebar  -->
        
        <!-- Top Navigation -->
        <?php include("view/top_navigation.php"); ?>
        <!-- End Of Top Navigation -->

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
                    <h2>Account Payable Header</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="POST" action="controller/doaddpo.php">

                      <div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback">
                            <select class="form-control" name="outlets" required="required">
                              <option value="" disabled selected>Select Outlet</option>
                          
                            <?php
                            $sql = "SELECT * 
                            FROM outlet
                            where
                            ledger_id = '".$ledger_new."'
                            and outlet_id = '".$outlet_new."'";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                          ?>
                              <option value="<?php echo $row["name"] ?>"> <?php echo $row["name"] ?></option>
                          <?php
                            }
                          ?>
                          
                            </select>        
                      </div>

                      <div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback">
                       <fieldset>
                          <div class="control-group">
                            <div class="controls">
                              <div class="xdisplay_inputx">
                                <input type="text" class="form-control" id="single_cal3" placeholder="Date" aria-describedby="inputSuccess2Status3" name="po_date">
                                <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>

      
                      <div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback"> 
                        <select class="form-control" name="supplier" required="required">
                              <option value="" disabled selected>Select Supplier</option>
                          
                            <?php
                            $sql = "SELECT * 
                            FROM ap_supplier_all
                            where status = 'Active'
                            and ledger_id = '".$ledger_new."'";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                          ?>
                              <option value="<?php echo $row["party_id"] ?>"> <?php echo $row["supplier_name"] ?></option>
                          <?php
                            }
                          ?>
                          
                            </select> 
                      </div>

                      <div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess5" placeholder="*Ship To" name="ship_to" required="required">
                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Due Date</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">                        
                       <fieldset>
                          <div class="control-group">
                            <div class="controls">
                              <div class="xdisplay_inputx">
                                <input type="text" class="form-control" id="single_cal2" placeholder="Date" aria-describedby="inputSuccess2Status2" name="due_date">
                                <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <input type="text" class="form-control" name="po_description" ></input>
                        </div>
                      </div>

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2><i class="fa fa-align-left"></i> Account Payable Line <small>Sub-Title</small></h2>
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
                                    <th>Item Description</th>
                                    <!-- <th>UOM</th> -->
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th></th>
                                  </tr>
                                  <tr>
                                    <td><input type="hidden" name="counter[]" id="counter">#</td>
                                    <td>                                   
                                      <select class="form-control" id="inventory_item_id" name="inventory_item_id[]" required="required">
                                      <?php

                                        $sql = "SELECT description , id 
                                        FROM inventory 
                                        where ledger_id = '".$ledger_new."'";
                                        $result = $conn->query($sql);
                                        $a = 0;
                                        while($row = $result->fetch_assoc()) {
                                      ?>
                                      <option value="<?php echo $row["id"] ?>"> <?php echo $row["description"] ?></option>
                                      <?php
                                        }
                                      ?>
                                      </select>
                                    </td>
                                    <!-- <td><input type="text" class="form-control" id="uom" name="uom[]" required="required"></td> -->
                                    <td><input type="number" class="form-control" id="qty" min="0" name="qty[]" required="required"></td>
                                    <td><input type="number" class="form-control" id="price" min="0" name="price[]" required="required"></td>
                                    <td>
<!--                                         <button class="btn btn-danger" type="button" onclick="deleteRow(this);"> 
                                          <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> 
                                        </button> -->
                                    </td>
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

        <!-- footer content -->
        <?php include("view/footer.php"); ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

        <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

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
    var cell5 = row.insertCell(4);
    // var cell6 = row.insertCell(5);  
    cell1.innerHTML = '<td><input type="hidden" name="counter[]" id="counter">#</td>';
    cell2.innerHTML = '<td><select class="form-control" id="inventory_item_id" name="inventory_item_id[]" required="required"><?php $sql = "SELECT description , id FROM inventory 
                                        where ledger_id = '".$ledger_new."'";
                                        $result = $conn->query($sql);
                                        $a = 0;
                                        while($row = $result->fetch_assoc()) {
                                      ?><option value="<?php echo $row["id"] ?>"> <?php echo $row["description"] ?></option><?php } ?></select></td>';
    // cell3.innerHTML = '<td><input type="text" class="form-control" id="uom" name="uom[]" required="required"></td>';
    cell3.innerHTML = '<td><input type="text" class="form-control" id="qty" name="qty[]" required="required"></td>';
    cell4.innerHTML = '<td><input type="text" class="form-control" id="price" name="price[]" required="required"></td>';
    cell5.innerHTML = '<td><button class="btn btn-danger" type="button" onclick="deleteRow(this);"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></td>';
}

                                                       

    </script>
	
  </body>
</html>


