        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/user.png" alt=""><?php echo $user_check ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
<!--                     <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right"></span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li> -->
                    <li><a href="controller/dologout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?php echo $count; ?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    
                    <?php
                      if ($_SESSION['userRole'] == "Staff"){
                      $sql = 
                      "SELECT creation_date,so_number, file_name,last_update_date
                       FROM approval_list_ar ala
                       WHERE 
                       created_by = '".$employee_id."' 
                       and status = 'P'
					   UNION
					   SELECT creation_date,pr_number, file_name,last_update_date
					   FROM approval_list_ap
					   WHERE created_by = '".$employee_id."' 
                       and status = 'P'
					   order by last_update_date desc
                       limit 5";
                     } else if ($_SESSION['userRole'] == "Admin") {
                      $sql = 
                      "SELECT creation_date,so_number, file_name,last_update_date
                       FROM approval_list_ar ala
                       WHERE 
                       status = 'P'
					   UNION
					   SELECT creation_date,pr_number, file_name,last_update_date
					   FROM approval_list_ap
					   WHERE status = 'P'
					   order by last_update_date desc
                       limit 5";
                     }
                  
                        $result = $conn_php->query($sql);
                        while($row = $result->fetch_assoc()) {
                        $creation_date = strtotime($row["creation_date"]);
                    ?>

                    <li>
                      <a>
                        <span class="image"><img src="images/user.png" alt="Profile Image" /></span>
                        <span>
                          <span><?php echo $user_check ?></span>
                          <span class="time"> <?php echo round(abs($today - $creation_date) / 60/60,1); ?> Hours ago</span>
                        </span>
                        <span class="message">
                          <?php 
  
                           if ($_SESSION['userRole'] == "Staff"){
                            echo "Approval Pending : ";
                            echo $row["so_number"]; echo "<br>";
                            echo "File Name : ";
                            echo $row["file_name"];
                          } else if ($_SESSION['userRole'] == "Admin") {
                            echo "Need Approval Untuk Doc : ";
                            echo $row["so_number"]; echo "<br>";
                            echo "File Name : ";
                            echo $row["file_name"];
                          }

                          ?>
                        </span>
                      </a>
                    </li>
                    
                    <?php
                    
                    }
                    
                    ?>
                    
                    <li>
                      <div class="text-center">
                        <?php 
                        if ($_SESSION['userRole'] == "Staff"){
                        
                        ?>
                        
                        <a href="approval_pending_staff.php">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                        
                        <?php
                        
                        }
                        else if ($_SESSION['userRole'] == "Admin") {

                        ?>
                        
                        <a href="approval_pending_admin.php">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a> 

                        <?php
                        }
                        ?>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>