<?php
session_start();
include("controller/doconnect_php.php");
include("controller/session.php");
include("controller/doconnect.php");   
include("query/cek_employee.php");   

$form_token = uniqid();
$_SESSION['form_token'] = $form_token;


if (isset($_POST['remove_file']))
		{
				$file_name = $_POST['dir1'];
				
				if (file_exists($file_name))
				{
					unlink($file_name);
				}
		}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body {font-family: Arial;}

		/* Style the tab */
		.tab {
		  overflow: hidden;
		  border: 1px solid #ccc;
		  background-color: #f1f1f1;
		}

		/* Style the buttons inside the tab */
		.tab button {
		  background-color: inherit;
		  float: left;
		  border: none;
		  outline: none;
		  cursor: pointer;
		  padding: 14px 16px;
		  transition: 0.3s;
		  font-size: 17px;
		}

		/* Change background color of buttons on hover */
		.tab button:hover {
		  background-color: #ddd;
		}

		/* Create an active/current tablink class */
		.tab button.active {
		  background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent {
		  display: none;
		  padding: 6px 12px;
		  border: 1px solid #ccc;
		  border-top: none;
		}
		</style>
	
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
                    <h3>Approval Pending Request</h3>
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content">
					<div class="tab">
		  <button class="tablinks" onclick="openCity(event, 'London')">Approve Penjualan</button>
		  <button class="tablinks" onclick="openCity(event, 'Paris')">Approve Pembelian</button>
		</div>

		<div id="London" class="tabcontent">
		  <div class="card-box table-responsive">             
                          <table id="datatable" class="table table-striped">
                            <thead>
                              <tr>
                                <th>SO Number</th>
                                <th>SO Date</th>
                                <th>File Name</th>
                                <th>Request Date</th>
                                <th>View Detail</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>

                            <?php

                            $sql = 
                            "SELECT 
                             ala.*
                             FROM 
                             approval_list_ar ala
                             WHERE 
                             ala.status = 'P'  
                             ";
                                                           
                              $result = $conn_php->query($sql);
                              while($row = $result->fetch_assoc()) {                               
                            ?>

                            <tr>
                              <td><?php echo $row["so_number"]; ?></td>
                              <td><?php echo date('j F Y',strtotime($row["so_date"])); ?></td>
                              <td><?php echo $row["file_name"]; ?></td>
                              <td><?php echo date('j F Y, g:i a',strtotime($row["creation_date"])); ?></td>
                              <td><a href="form_upload_audit_AR.php?SO_NUMBER=<?php echo $row['so_number'] ?>&SO_DATE=<?php echo $row['so_date'] ?>&SO_ID=<?php echo $row['so_id'] ?>"><button class="btn btn-success">View</button></a></td>
                              <td><a href="controller/approve_delete_file_ar.php?id=<?php echo $row['id'] ?>"><button class="btn btn-primary">Approve</button></a></td>
                            </tr>
                                                    
                            <?php

                            }
                            
                            ?>
                            </tbody>
                          </table>
                        </div>
		</div>

		<div id="Paris" class="tabcontent">
		  <div class="card-box table-responsive">             
                          <table id="datatable-responsive" class="table table-striped">
                            <thead>
                              <tr>
                                <th>PR Number</th>
                                <th>PO Number</th>
                                <th>File Name</th>
                                <th>Request Date</th>
                                <th>View Detail</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>

                            <?php

                            $sql = 
                            "SELECT 
                             ala.*
                             FROM 
                             approval_list_ap ala
                             WHERE 
                             ala.status = 'P'  
                             ";
                                                           
                              $result = $conn_php->query($sql);
                              while($row = $result->fetch_assoc()) {                               
                            ?>

                            <tr>
                              <td><?php echo $row["pr_number"]; ?></td>
							  <td><?php echo $row["po_number"]; ?></td>
                              <td><?php echo $row["file_name"]; ?></td>
                              <td><?php echo date('j F Y, g:i a',strtotime($row["creation_date"])); ?></td>
                              <td><a href="form_upload_audit_AP.php?pr_number=<?php echo $row['pr_number'] ?>&po_number=<?php echo $row['po_number'] ?>"><button class="btn btn-success">View</button></a></td>
                              <td><a href="controller/approve_delete_file_ap.php?ap_approval_id=<?php echo $row['ap_approval_id'] ?>&file_name=<?php echo $row['file_name'] ?>&pr_number=<?php echo $row['pr_number'] ?>"><button class="btn btn-primary">Approve</button></a></td>
                            </tr>
                                                    
                            <?php

                            }
                            
                            ?>
                            </tbody>
                          </table>
                        </div>

		<div id="Tokyo" class="tabcontent">
		  <h3>Tokyo</h3>
		  <p>Tokyo is the capital of Japan.</p>
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
	<!-- Tab Scripts -->
	<script>
	function openCity(evt, cityName) {
	  var i, tabcontent, tablinks;
	  tabcontent = document.getElementsByClassName("tabcontent");
	  for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	  }
	  tablinks = document.getElementsByClassName("tablinks");
	  for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	  }
	  document.getElementById(cityName).style.display = "block";
	  evt.currentTarget.className += " active";
	}
	</script>
	
  </body>
</html>