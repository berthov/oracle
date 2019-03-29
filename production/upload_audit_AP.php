<?php
session_start();
include("controller/doconnect_php.php");
include("controller/session.php");
include("controller/doconnect.php");   
include("query/cek_employee.php");   

$PR_ID = $_REQUEST['PR_ID']; 
$PR_NUM = $_REQUEST['PR_NUM'];

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
                  <div class="x_content">
                  <div class="col-xs-12 col-md-12">
                    <!-- <embed src="uploads/ben/7543/BI PUBLISHER.pdf" width="100%" height="750"> -->
                      <!-- <iframe src="uploads/ben/7543/BI PUBLISHER.pdf" style="width:718px; height:700px;" frameborder="0"></iframe> -->
                                        <?php
// $dir = "uploads/ben/7543/";

// // Open a directory, and read its contents
// if (is_dir($dir)){
//   if ($dh = opendir($dir)){
//     while (($file = readdir($dh)) !== false){
//       echo "filename:" . $file . "<br>";
//     }
//     closedir($dh);
//   }
// }

echo "<br>";

if ($handle = opendir('uploads/ben/<?php echo $PR_NUM ?>/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo "$entry\n";
            ?>
            <!-- <embed src="uploads/ben/<?php echo $PR_NUM ?>/<?php echo $entry ?>" width="100%" height="750"> -->
              <iframe src="uploads/ben/<?php echo $PR_NUM ?>/<?php echo $entry ?>" style="width:100%; height:700px;" frameborder="0"></iframe>
              <br>
            <?php
        }
    }
    closedir($handle);
}

                      ?>

                  </div>                       
                    <div class="col-xs-6 col-md-6">


                      <div class="form-group">
                        <form enctype="multipart/form-data" action="controller/upload_audit_P.php" method="post">
                          <input type="file" name="uploaded_file">
                          <br>
                          <input type="hidden" name="PR_NUM" value="<?php echo $PR_NUM; ?>">
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