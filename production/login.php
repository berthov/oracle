<?php
session_start();
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

    <?php include("view/title.php"); ?>
    <!-- Toastr -->
    <link rel="stylesheet" href="../vendors/toastr/toastr.min.css">
    <script src="../vendors/toastr/jquery-1.9.1.min.js"></script>
    <script src="../vendors/toastr/toastr.min.js"></script>
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome-2/css/all.css" rel="stylesheet"> 
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="formLogin" action="controller/dologin.php" method="post" >
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" id="username" placeholder="Username" name="username" required="" autocomplete="off"/>
              </div>
              <div>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required="" />
              </div>
              <div>
               <input class="btn btn-default" type = "submit" value = " Log in "/>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form id="formRegister" action="controller/doregister.php" method="post">
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" id="usernameregister" placeholder="Username" name="username" required="" autocomplete="off" />
              </div>
              <div>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required="" autocomplete="off" />
              </div>
              <div>
                <input type="password" class="form-control" id="passwordregister" placeholder="Password" name="password" required="" autocomplete="off" />
              </div>
              <div>
                <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" required="" autocomplete="off" />
              </div>
             <!--  <div>
                <input type="text" class="form-control" placeholder="Role" name="role" required="" />
              </div> -->
              <div>
                <select class="form-control" name="divisi" id="divisi" required="required">
                  <option value="" disabled selected>Select Divisi</option>
                  <?php
                    $sql = "  SELECT FLEX_VALUE,
                              FLEX_VALUE_MEANING,
                              DESCRIPTION
                              FROM FND_FLEX_VALUES_VL
                              WHERE ( ('' IS NULL)
                                OR (structured_hierarchy_level IN
                                       (SELECT hierarchy_id
                                          FROM fnd_flex_hierarchies_vl h
                                         WHERE h.flex_value_set_id = 1016490
                                               AND h.hierarchy_name LIKE '')))
                               AND (FLEX_VALUE_SET_ID = 1016490)
                               AND ENABLED_FLAG = 'Y'
                      ORDER BY flex_value";
                    $result = oci_parse($conn,$sql);
                    oci_execute($result);

                  while($row = oci_fetch_array($result, OCI_ASSOC)) {
                  ?>

                  <option value="<?php echo $row["FLEX_VALUE"] ?>"><?php echo $row["DESCRIPTION"] ?></option>                              
                  
                  <?php
                  }
                  ?>

                </select> 

              </div>
              <br>
              <div>
                <button type="submit" class="btn btn-default" name="reg_user">Register</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>

    <script src="../production/common/error.js"></script>
    
  </body>

  <?php
    if(isset($_SESSION["logout"]) && !empty($_SESSION["logout"])){
      if($_SESSION['logout'] == true){
      ?>
      <script>
        toastr.success('You are logged out');
      </script>
      <?php
        $_SESSION['logout'] = false;
      }
    }
  ?>

</html>
