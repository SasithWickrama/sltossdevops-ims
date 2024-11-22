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
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-table"></i> <span class="mini-dn">Operation</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">				
                                <a href="no_create" class="dropdown-item">Create</a>		
                                <a href="no_delete" class="dropdown-item">Delete</a>							
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-files-o"></i> <span class="mini-dn">Admin</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">				
                                <a href="adminno_create" class="dropdown-item">Create</a>		
                                <a href="adminno_delete" class="dropdown-item">Delete</a>							
                            </div>
                        </li>
						
						

                    </ul>
                </div>
            </nav>