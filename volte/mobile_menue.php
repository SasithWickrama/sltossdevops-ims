            
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
										
										
                                        <li><a data-toggle="collapse" data-target="#demo" href="#">List <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="demo" class="collapse dropdown-header-top">

												<?php 
												if($ulevel >= 40)
												{
												?>
											
                                                <li><a href="list_details">List Details</a>
                                                </li>
												<?php }?>
                                     
                                            </ul>
                                        </li>
										
							
                                        <li><a data-toggle="collapse" data-target="#others" href="#">Operations <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                    
										<ul id="others" class="collapse dropdown-header-top">
											
												<?php 
												if($ulevel >= 30)
												{
												?>
												
                                                <li><a href="create_user">Create User</a>
                                                </li>
                                                <li><a href="delete_user">Delete User</a>
                                                </li>
                                                <li><a href="modify_user">Modify User</a>
                                                </li>
												<?php }?>
										
                                            </ul>
										
											</li>

										<?php 
										if($ulevel >= 25)
										{
										?>	

                                        <li><a data-toggle="collapse" data-target="#Miscellaneousmob" href="res_sus">Suspend/Resume<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        </li>
										
										<?php 
										}	
										?>								

                                        <li><a data-toggle="collapse" data-target="#Chartsmob" href="#">Admin<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Chartsmob" class="collapse dropdown-header-top">
                                            
											<?php 
				
											if($ulevel == 100)
											{
											?>
																		
											
                                                <li><a href="admin_create">Create User</a>
                                                </li>
                                                <li><a href="admin_delete">Delete User</a>
                                                </li>
                                                <li><a href="admin_delete_udr">Delete User USR HSS</a>
                                                </li>
                                                <li><a href="mob_anc">Modify Anchoring</a>
                                                </li>
                                                <li><a href="../dbFunction/logread">LOG</a>
                                                </li>
												<?php 
												}
												?>
									   
                                            </ul>
                                        </li>
										
								

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu end -->