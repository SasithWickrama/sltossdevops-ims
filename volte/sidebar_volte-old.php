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
				<?php 
				if($ulevel >= 40)
				{
				?>
                                <a href="list_details" class="dropdown-item">List Details</a>
				<?php }?>
                            </div>
                        </li>
						
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-table"></i> <span class="mini-dn">Operations</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
				<?php 
				if($ulevel >= 30)
				{
				?>
                                <a href="create_user" class="dropdown-item">Create User</a>
                                <a href="delete_user" class="dropdown-item">Delete User</a>
                                <a href="modify_user" class="dropdown-item">Modify User</a>
				<?php 
				}
				if($ulevel >= 20)
				{
				?>
								<a href="res_sus" class="dropdown-item">Suspend/Resume</a>
				<?php }?>
                            </div>
                        </li>
						
						<li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-files-o"></i> <span class="mini-dn">Admin</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
				<?php 
				
				if($ulevel == 100)
				{
				?>
                                <a href="admin_create" class="dropdown-item">Create User</a>
                                <a href="admin_delete" class="dropdown-item">Delete User</a>
								<a href="mob_anc" class="dropdown-item">Modify Anchoring</a>
								<a href="../dbFunction/logread" class="dropdown-item">LOG</a>
				<?php 
				}
				?>
                            </div>
                        </li>
						
						
                        



                    </ul>
                </div>
            </nav>