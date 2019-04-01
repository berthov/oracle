<?php
session_start();
include("controller/doconnect_php.php");
include("controller/session.php");
include("controller/doconnect.php");   
include("query/cek_employee.php");   

if(isset($_REQUEST['START_DATE'])){
      $START_DATE = date("d-M-Y", strtotime($_REQUEST['START_DATE']));
     }else{
      $START_DATE = null;
     }

if(isset($_REQUEST['END_DATE'])){
      $END_DATE = date("d-M-Y", strtotime($_REQUEST['END_DATE']));
     }else{
      $END_DATE = null;
     }



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
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet"> 
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
        <div class="right_col" role="main" style="padding-bottom: 70px">
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

                      <form action="audit_ar.php" method="POST">
                        <div class="form-group">
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <div class='input-group date' id='myDatepicker2'>
                                    <input type='text' class="form-control" name="START_DATE" id="START_DATE" autocomplete="off" required="required" placeholder="Start Date">
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='input-group date' id='myDatepicker3'>
                                    <input type='text' class="form-control" name="END_DATE" id="END_DATE" autocomplete="off" required="required" placeholder="End Date">
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                          </div>
                        </div>
                      <div class="form-group" style="padding-top: 100px;">
                        <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                          <button class="btn btn-danger" type="reset">Reset</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>

                      </form>
                      <br>
                      <br><br>
                        <div class="card-box table-responsive">             
                          <table id="datatable" class="table table-striped">
                            <thead>
                              <tr>
                                <th>SO Number</th>
                                <th>DO Number</th>
                                <th>Do Date</th>
                                <th>SI Number</th>
                                <th>No Faktur Pajak</th>
                                <th>Customer</th>
                                <th>Uploaded File</th>
                                <th>View</th>
                              </tr>
                            </thead>
                            <tbody>

                            <?php

                            $sql = 
                            "SELECT DISTINCT
                                NVL(RCTA.TRX_NUMBER,'REQ STOCK KEBUN/MANUAL') INV_NUM,
                                NVL(rcta.attribute1,'Tidak Ada Faktur')  NO_FAKTUR,
                                NVL(TO_CHAR(wndv.NAME),'Tidak Ada DO')  DO_NUM,
                                TO_DATE(TO_CHAR(wndv.initial_pickup_date,'DD/Mon/RRRR')) DO_DATE,
                                NVL(TO_CHAR(OOHV.ORDER_NUMBER),'Tidak Ada SO')  SO_NUMBER,
                                trunc(oohv.creation_date)  SO_DATE,
                                NVL(TO_CHAR(WDD.CUST_PO_NUMBER),'Tidak Ada PO') PO_Number,
                                NVL(HP.PARTY_NAME,'Tidak Ada Customer') NAMA_CUSTOMER
                            FROM wsh_new_deliveries WNDV,
                               wsh_delivery_details wdd,
                                wsh_delivery_assignments wda,
                               AP_SUPPLIERS APS,
                               HZ_CUST_ACCOUNTS HCA,
                               HZ_PARTIES HP,
                               HZ_PARTY_SITES HPS,
                               HZ_LOCATIONS HL,
                               hz_cust_site_uses_all hcsua,
                               hz_cust_acct_sites_all hcasa,
                               MTL_SYSTEM_ITEMS_B MSIB,
                               xxcba_sp3b_trx SPH,
                               xxcba_sp3b_trx_lines SPL,
                               OE_ORDER_HEADERS_ALL OOHV,
                               OE_TRANSACTION_TYPES_VL OT,
                               OE_ORDER_LINES_ALL OOLV,
                               RA_CUSTOMER_TRX_ALL RCTA
                            WHERE 
                               WNDV.DELIVERY_ID(+) = WDA.DELIVERY_ID
                               AND HCA.CUST_ACCOUNT_ID = WDD.CUSTOMER_ID
                               AND HP.PARTY_ID = HCA.PARTY_ID
                               AND wda.delivery_detail_id = wdd.delivery_detail_id
                               AND WDD.SOURCE_HEADER_ID(+) = OOHV.HEADER_ID
                               AND MSIB.INVENTORY_ITEM_ID = WDD.INVENTORY_ITEM_ID
                               AND MSIB.ORGANIZATION_ID = WDD.ORGANIZATION_ID
                               AND OOLV.HEADER_ID = OOHV.HEADER_ID
                               AND OOLV.LINE_ID = WDD.SOURCE_LINE_ID
                               AND HP.PARTY_ID = HPS.PARTY_ID
                               AND HPS.location_id = HL.location_id
                               AND WNDV.ULTIMATE_DROPOFF_LOCATION_ID = HL.LOCATION_ID
                               AND hcsua.site_use_code = 'SHIP_TO'
                               AND hcsua.cust_acct_site_id = hcasa.cust_acct_site_id
                               AND hps.party_site_id = hcasa.party_site_id
                               AND hcasa.cust_account_id = hca.cust_account_id
                               AND APS.VENDOR_ID(+) = SPH.TRANS1_VENDOR_ID
                               AND SPH.SP3B_TRX_ID(+) = SPL.SP3B_TRX_ID
                               AND SPL.ORDER_LINE_ID(+) = OOLV.LINE_ID
                               AND OOHV.ORDER_TYPE_ID = OT.TRANSACTION_TYPE_ID
                               AND RCTA.INTERFACE_HEADER_ATTRIBUTE3(+) = WNDV.NAME
                               AND RCTA.INTERFACE_HEADER_ATTRIBUTE1(+) = TO_CHAR(OOHV.ORDER_NUMBER)
                               AND TO_date(wndv.initial_pickup_date) BETWEEN '".$START_DATE."' AND '".$END_DATE."' 
                            UNION ALL
                            SELECT DISTINCT 
                            NVL(RCTA.TRX_NUMBER,'REQ STOCK KEBUN/MANUAL')  INV_NUM,
                            NVL(rcta.attribute1,'Tidak Ada Faktur')  NO_FAKTUR,
                            NVL(TO_CHAR(MTRHV.ATTRIBUTE15),'Tidak Ada DO')  DO_NUM,
                            TRUNC(MTL.TRANSACTION_DATE) DO_DATE,
                            NVL(TO_CHAR(MTRHV.ATTRIBUTE1),'Tidak Ada SO')  SO_NUMBER,
                            trunc(sdd.creation_date)  SO_DATE,
                            NVL(TO_CHAR(mtrhv.attribute2),'Tidak Ada PO') PO_Number,
                            NVL(HP.PARTY_NAME,'Tidak Ada Customer') NAMA_CUSTOMER
                            FROM 
                              ORG_ORGANIZATION_DEFINITIONS OOD,
                                   hz_parties HP,
                                   HZ_CUST_ACCOUNTS HCA,
                                   MTL_SYSTEM_ITEMS_B MSIB,
                                   MTL_TXN_REQUEST_HEADERS MTRHV,
                                   MTL_TXN_REQUEST_LINES MTRLV,
                                   MTL_TRANSACTION_TYPES MTT,
                                   xxcba_sp3b_trx SPH,
                                   xxcba_sf_dplan SDP,
                                   xxcba_sf_dplan_dtl SDD,
                                   xxcba_sp3b_trx_lines SPL,
                                   AP_SUPPLIERS APS,
                                   RA_CUSTOMER_TRX_ALL RCTA,
                                   MTL_MATERIAL_TRANSACTIONS MTL
                             WHERE     MTT.TRANSACTION_TYPE_NAME = 'Sales Order Salesforce'
                                    AND MTT.TRANSACTION_TYPE_ID = MTRLV.TRANSACTION_TYPE_ID
                                   AND APS.VENDOR_ID = SPH.TRANS1_VENDOR_ID
                                   AND MTRLV.QUANTITY_DELIVERED IS NOT NULL
                                   AND MTRLV.LINE_STATUS IN ('5', '6')
                                   AND SPH.SP3B_TRX_ID = SPL.SP3B_TRX_ID
                                   AND SDD.DEL_PLAN_ID = SDP.DEL_PLAN_ID
                                   AND SPL.DEL_PLAN_ID = SDP.DEL_PLAN_ID
                                   AND SPL.DEL_PLAN_DTL_ID = SDD.DEL_PLAN_DTL_ID
                                   AND OOD.organization_id = SPH.TRANS1_FROM_ORG_ID
                                   AND SDP.DO_PLAN_NO = MTRHV.REQUEST_NUMBER
                                   AND SPH.TRANS1_FROM_ORG_ID = MTRHV.ORGANIZATION_ID
                                   AND OOD.organization_id = MSIB.organization_id
                                   AND MTRHV.HEADER_ID = MTRLV.HEADER_ID
                                   AND MTRHV.ORGANIZATION_ID = MSIB.ORGANIZATION_ID(+)
                                   AND MTRLV.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID(+)
                                   AND MTRHV.ATTRIBUTE3 = HCA.ACCOUNT_NUMBER(+)
                                   AND HCA.party_id = HP.party_id(+)
                                   AND SDD.SF_ID = MTRLV.ATTRIBUTE1
                                   AND MTRLV.UOM_CODE = SDD.UOM
                                   AND RCTA.INTERFACE_HEADER_ATTRIBUTE3(+) = MTRHV.ATTRIBUTE15
                                   AND RCTA.INTERFACE_HEADER_ATTRIBUTE1(+) = MTRHV.ATTRIBUTE15
                                   AND MTRLV.LINE_ID = MTL.MOVE_ORDER_LINE_ID
                                   AND TRUNC(MTL.TRANSACTION_DATE) BETWEEN '".$START_DATE."' AND '".$END_DATE."' 
                            ORDER BY 1 ASC";
                                                           
                              $result = oci_parse($conn,$sql);
                              oci_execute($result);

                              while($row = oci_fetch_array($result, OCI_ASSOC)) {                             
                            ?>

                            <tr>
                              <td><?php echo $row["SO_NUMBER"]; ?></td>
                              <td><?php echo $row["DO_NUM"]; ?></td>
                              <td><?php echo $row["DO_DATE"]; ?></td>
                              <td><?php echo $row["INV_NUM"]; ?></td>
                              <td><?php echo $row["NO_FAKTUR"]; ?></td>
                              <td><?php echo $row["NAMA_CUSTOMER"]; ?></td>
                              <td align="center">
                                <?php
                                $flag = 0;
                                  $SO_NUM = $row["SO_NUMBER"];
                                  $dir = "uploads/$employee_name/$SO_NUM";

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
                              <td><a href="form_upload_audit_AR.php?SO_NUMBER=<?php echo $row['SO_NUMBER'] ?>"><button class="btn btn-primary">Upload</button></a></td>
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
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.js"></script>

    <script type="text/javascript">
      $("#myDatepicker2").on("dp.keydown keypress keyup", false);

      $('#myDatepicker2').datetimepicker({
          format: 'YYYY/MM/DD'
      });

      $("#myDatepicker3").on("dp.keydown keypress keyup", false);

      $('#myDatepicker3').datetimepicker({
          format: 'YYYY/MM/DD'
      });

    </script>

  </body>
</html>