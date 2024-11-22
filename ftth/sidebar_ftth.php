           <nav id="sidebar" class="scrollbar-element">
                <div class="sidebar-header">
                    <?php
					$img = $_SESSION['ldap_img'];
					echo '<img src="data:image/png;base64,'. base64_encode($img) . '" style="border-radius: 50%; width:70px; height:70px"/>';  ?>
                    </a>
                    <!-- <h3>Andrar Son</h3>
                    <strong>AP+</strong> -->
                </div>
                <div class="left-custom-menu-adp-wrap">
                    <ul class="nav navbar-nav left-sidebar-menu-pro">	

				<?php 
				if($ulevel >= 40)
				{
				?>					
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-edit"></i> <span class="mini-dn">List</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                <a href="getdetails_ftth" class="dropdown-item">List Details</a>
                            </div>
                        </li>
				<?php 
				}
				if($ulevel >= 25)
				{
				?>		
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-table"></i> <span class="mini-dn">Operations</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
				<?php 
				}
				if($ulevel >= 40)
				{
				?>
								<a href="useradd_socheck_ftthv2" class="dropdown-item">Create User with Task</a>
                                <a href="useradd_socheck_ftth" class="dropdown-item">Create User</a>
                                <a href="deluser_delcheck_ftth" class="dropdown-item">Delete User</a>
                                <a href="act_mod_feature_ftth" class="dropdown-item">Add Feature</a>								
				<?php 
				}
				
				?>
							
				
                            </div>
                        </li>
						
				<?php 
				if($ulevel >= 40)
				{
				?>					
						<li class="nav-item">
                            <a href="res_sus_ftth"   class="nav-link "><i class="fa big-icon fa-edit"></i> <span class="mini-dn">Suspend/Resume</span> </a>
                        </li>
				<?php 
				}	
?>				
				<?php 
				
				if($ulevel == 100)
				{
				?>
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-files-o"></i> <span class="mini-dn">Admin</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
								<a href="useradd_ftthv2" class="dropdown-item">Create User with Task</a>
                                <a href="useradd_ftth" class="dropdown-item">Create User</a>
								<a href="deluser_ftth" class="dropdown-item">Delete User</a>
								<a href="deluser_ftth_admin" class="dropdown-item">Admin Delete User</a>
								<a href="deluser_withmsan_ftth" class="dropdown-item">Delete User with MSAN</a>
								<a href="deluser_withmsan_ftth_admin" class="dropdown-item">Admin Delete User with MSAN</a>
								<a href="deluser_udr_ftth" class="dropdown-item">Delete Voice</a>
                                <a href="act_feature_ftth" class="dropdown-item">Add Feature</a>
								<a href="userdel_msan_ftth" class="dropdown-item">Delete MSAN User</a>
								<a href="userdel_msan_ftth_admin" class="dropdown-item">Admin Delete MSAN User</a>
								<a href="../dbFunction/logread" class="dropdown-item">LOG</a>
                            </div>
                        </li>
						
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-files-o"></i> <span class="mini-dn">Change</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
								<a href="portchage_ftth" class="dropdown-item">Change Voice Port</a>    
								<a href="change_olt" class="dropdown-item">Change OLT in Clarity</a> 								
                            </div>
                        </li>
						
				<?php 
				}
				if($ulevel == 70)
				{
				?>

						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-files-o"></i> <span class="mini-dn">Change</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
								<a href="portchage_ftth" class="dropdown-item">Change Voice Port</a>    
								<a href="change_olt" class="dropdown-item">Change OLT in Clarity</a> 								
                            </div>
                        </li>
						
				<?php 
				}
				?>		
                        



                    </ul>
                </div>
            </nav>