            
               <!-- Mobile Menu start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul class="mobile-menu-nav">
                                        <li><a data-toggle="collapse" data-target="#Charts" href="#">Home <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                    <!--         <ul class="collapse dropdown-header-top">
                                                <li><a href="dashboard.html">Dashboard v.1</a>
                                                </li>
                                                <li><a href="dashboard-2.html">Dashboard v.2</a>
                                                </li>
                                                <li><a href="analytics.html">Analytics</a>
                                                </li>
                                                <li><a href="widgets.html">Widgets</a>
                                                </li>
                                            </ul> -->
                                        </li>
										
										
										<?php 
										if($ulevel >= 40)
										{
										?>	
										
                                        <li><a data-toggle="collapse" data-target="#demo" href="#">List <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="demo" class="collapse dropdown-header-top">

                                                <li><a href="getdetails_ftth">List Details</a>
                                                </li>
                                     
                                            </ul>
                                        </li>
										
										<?php 
										}
										if($ulevel >= 25)
										{
										?>	
                                        <li><a data-toggle="collapse" data-target="#others" href="#">Operations <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        	<?php 
											}
											if($ulevel >= 40)
											{
											?>
										
										<ul id="others" class="collapse dropdown-header-top">
									
																	
                                                <li><a href="useradd_socheck_ftthv2">Create User with Task</a>
                                                </li>
                                                <li><a href="useradd_socheck_ftth">Create User</a>
                                                </li>
                                                <li><a href="deluser_delcheck_ftth">Delete User</a>
                                                </li>
                                                <li><a href="act_mod_feature_ftth">Add Feature</a>
                                                </li>
                                        
                                            </ul>
											<?php } ?>
											</li>

											<?php 
											if($ulevel >= 40)
											{
											?>	

                                        <li><a data-toggle="collapse" data-target="#Miscellaneousmob" href="res_sus_ftth">Suspend/Resume<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        </li>
										
										<?php 
										}	
										?>


										<?php 
										if($ulevel == 100)
										{
										?>										

                                        <li><a data-toggle="collapse" data-target="#Chartsmob" href="#">Admin<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Chartsmob" class="collapse dropdown-header-top">
                                                <li><a href="useradd_ftthv2">Create User with Task</a>
                                                </li>
                                                <li><a href="useradd_ftth">Create User</a>
                                                </li>
                                                <li><a href="deluser_ftth">Delete User</a>
                                                </li>
                                                <li><a href="deluser_ftth_admin">Admin Delete User</a>
                                                </li>
                                                <li><a href="deluser_withmsan_ftth">Delete User with MSAN</a>
                                                </li>
                                                <li><a href="deluser_withmsan_ftth_admin">Admin Delete User with MSAN</a>
                                                </li>
                                                <li><a href="deluser_udr_ftth">Delete Voic</a>
                                                </li>
												<li><a href="act_feature_ftth">Add Feature</a>
                                                </li>
												<li><a href="userdel_msan_ftth">Delete MSAN User</a>
                                                </li>
												<li><a href="userdel_msan_ftth_admin">Admin Delete MSAN User</a>
                                                </li>
												<li><a href="../dbFunction/logread">LOG</a>
                                                </li>
                                            </ul>
                                        </li>
										
										
										<li><a data-toggle="collapse" data-target="#Chartsmob" href="#">Change<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Chartsmob" class="collapse dropdown-header-top">
                                                <li><a href="portchage_ftth">Change Voice Port</a>
                                                </li>
                                                <li><a href="change_olt">Change OLT in Clarity</a>
                                                </li>
                                            </ul>
                                        </li>
                                    	<?php 
										}
										if($ulevel == 70)
										{
										?> 

										<li><a data-toggle="collapse" data-target="#Chartsmob" href="#">Change<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Chartsmob" class="collapse dropdown-header-top">
                                                <li><a href="portchage_ftth">Change Voice Port</a>
                                                </li>
                                                <li><a href="change_olt">Change OLT in Clarity</a>
                                                </li>
                                            </ul>
                                        </li>

										<?php 
										}
										?>	

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu end -->