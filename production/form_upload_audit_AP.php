<?php
session_start();
include("controller/doconnect_php.php");
include("controller/session.php");
include("controller/doconnect.php");   
include("query/cek_employee.php");   

$NOMOR_PR = $_REQUEST['NOMOR_PR'];

$dir = "uploads/AP/$NOMOR_PR";

		if (isset($_POST['remove_file']))
		{
				$file_name = $_POST['dir1'];
				
				if (file_exists($file_name))
				{
					unlink($file_name);
				}
		}


/*function delete_directory($dir) {
         if (is_dir($dir))
           $handle = opendir($dir);
     if (!$handle)
          return false;
     while($file = readdir($handle)) {
           if ($file != "." && $file != "..") {
                if (!is_dir($dir."/".$file))
                     unlink($dir."/".$file);
                else
                     delete_directory($dir.'/'.$file);
           }
     }
     closedir($handle);
     rmdir($dir);
     return true;
	 
	 
}*/

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
    <link href="../vendors/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
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
                  <div class="x_content">
                  <div class="col-xs-12 col-md-12">
                  <?php
                    if (is_dir($dir)) {
                      if ($handle = opendir($dir)) {
                          while (false !== ($entry = readdir($handle))) {
                              if ($entry != "." && $entry != "..") {
                                  echo "$entry\n";
                  ?>
                    <iframe src="uploads/AP/<?php echo $NOMOR_PR ?>/<?php echo $entry ?>" style="width:100%; height:700px;" frameborder="0"></iframe>
                    <br><br>
					
					
					
					    <form enctype="multipart/form-data" action="form_upload_audit_AP.php" method="post">
                          <input type="hidden" name="dir1" value="uploads/AP/<?php echo $NOMOR_PR ?>/<?php echo $entry ?>">
						  <input type="hidden" name="NOMOR_PR" value= <?php echo $NOMOR_PR ?>>
                          <input type = "submit" name = "remove_file" value = "Delete File">
						  
                        </form>
					
                  <?php
                        }
                      }
                    }
                    closedir($handle);
                  }

                  ?>

                  </div>                       
                    <div class="col-xs-6 col-md-6">
                      <div class="form-group">
                        <form enctype="multipart/form-data" action="controller/upload_audit_AP.php" method="post">
                          <input type="file" name="uploaded_file">
                          <br>
                          <input type="hidden" name="NOMOR_PR" value="<?php echo $NOMOR_PR; ?>">
                          <input type="hidden" name="PR_ID" value="<?php echo $PR_ID; ?>">
                          <button type="submit" class="btn btn-default"><i class="fa fa-upload"> Upload </i></button>
						  
                        </form>
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
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <script src="../production/common/error.js"></script>

  </body>
</html>