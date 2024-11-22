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
         
						
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-edit"></i> <span class="mini-dn">List</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                <a href="list_tid" class="dropdown-item">List TID</a>
                                <a href="list_user" class="dropdown-item">List User</a>
                                <a href="list_details" class="dropdown-item">List Details</a>
				<?php 
				if($ulevel >= 80)
				{
				?>
                                <a href="list_users" class="dropdown-item">List All Users</a>
				<?php 
				}
				?>
                            </div>
                        </li>
						
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-table"></i> <span class="mini-dn">Operations</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
				<?php 
				if($ulevel >= 40)
				{
				?>
								 <a href="create_userv2" class="dropdown-item">Create User with Task</a>
                                <a href="create_user" class="dropdown-item">Create User</a>
                                <a href="delete_user" class="dropdown-item">Delete User</a>
                                <a href="add_features" class="dropdown-item">Add Feature</a>
				
				<?php 
				}
				if($ulevel >= 20)
				{
				?>
								<a href="tid_change" class="dropdown-item">TID Change</a>
				<?php } ?>
                            </div>
                        </li>
						
				<?php 
				if($ulevel >= 25)
				{
				?>					
						<li class="nav-item">
                            <a href="suspend_resume"   class="nav-link "><i class="fa big-icon fa-edit"></i> <span class="mini-dn">Suspend/Resume</span> </a>
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
								<a href="admin_createv2" class="dropdown-item">Create User with Task</a>
                                <a href="admin_create" class="dropdown-item">Create User</a>
                                <a href="admin_delete" class="dropdown-item">Delete User</a>
								<a href="admin_delete_udr" class="dropdown-item">Delete User UDR HSS</a>
                                <a href="admin_deleteV2" class="dropdown-item">Delete V2</a>
				
                                <a href="admin_feature" class="dropdown-item">Add Feature</a>
								<a href="../dbFunction/logread" class="dropdown-item">LOG</a>
                            </div>
                        </li>
				<?php 
				}
				?>		
						
                        



                    </ul>
                </div>
            </nav>