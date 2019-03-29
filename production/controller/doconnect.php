<?php
	date_default_timezone_set('Asia/Jakarta');
	
	$username	= "apps";
	$password	= "apps";
	
	// $conn	= oci_connect($username, $password,'  (DESCRIPTION=
 //    (ADDRESS=
 //      (PROTOCOL=TCP)
 //      (HOST=192.168.222.106)
 //      (PORT=1531)
 //    )
 //    (CONNECT_DATA=
 //      (SERVER=default)
 //      (SERVICE_NAME=KING)
 //    )
 //  )');

	$conn	= oci_connect($username, $password,'  (DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=192.168.222.104)
      (PORT=1521)
    )
    (CONNECT_DATA=
      (SERVER=default)
      (SERVICE_NAME=PROD)
    )
  )');


	if (!$conn) {
	    $e = oci_error();
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
                              
	$sql = "BEGIN
	        MO_GLOBAL.SET_POLICY_CONTEXT('S',81);
			END;";

	$result = oci_parse($conn,$sql);
	oci_execute($result);



?>