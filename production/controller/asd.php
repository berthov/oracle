<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("doconnect.php");    


$sql = "SELECT INVOICE_NUM
        FROM AP_INVOICES ASA
        WHERE INVOICE_DATE BETWEEN '31/JAN/2018' AND '31/JAN/2018' ";
                                
                                $result = oci_parse($conn,$sql);
                                oci_execute($result);

                              while($row = oci_fetch_array($result, OCI_ASSOC)) {
                              ?>
                              <option value="<?php echo $row["INVOICE_NUM"] ?>"><?php echo $row["INVOICE_NUM"] ?></option>                              
                              
                              <?php
                              }
                              ?>
