           <nav id="sidebar" class="scrollbar-element">
                <div class="sidebar-header">
                    <?php
					$img = $_SESSION['ldap_img'];
					echo '<img src="data:image/png;base64,'. base64_encode($img) . '" style="border-radius: 50%; width:70px; height:70px"/>';  ?>
                    </a>
                </div>
                <div class="left-custom-menu-adp-wrap">
                    <ul class="nav navbar-nav left-sidebar-menu-pro">
                        <li class="nav-item">     
						   <a href="act_feature" class="nav-link"><i class="fa big-icon fa-edit"></i> <span class="mini-dn">Add Feature</span></a>
						</li>
														
						<li class="nav-item">
                            <a href="res_sus"   class="nav-link "><i class="fa big-icon fa-edit"></i> <span class="mini-dn">Suspend/Resume</span> </a>
                        </li>
				
				
                        



                    </ul>
                </div>
            </nav>