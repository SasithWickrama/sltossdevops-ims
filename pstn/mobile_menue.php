            
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
                                                <li><a href="list_tid">List TID</a>
                                                </li>
                                                <li><a href="list_user">List User</a>
                                                </li>
                                                <li><a href="list_details">List Details</a>
                                                </li>
                                                <?php 
                                                if($ulevel >= 80)
                                                {
                                                ?>

                                                <li><a href="list_users">List All Users</a>
                                                </li>

                                                <?php 
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a data-toggle="collapse" data-target="#others" href="#">Operations <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="others" class="collapse dropdown-header-top">

                                                <?php 
                                                if($ulevel >= 40)
                                                {
                                                ?>    
                                                <li><a href="create_userv2">Create User with Task</a>
                                                </li>
                                                <li><a href="create_user">Create User</a>
                                                </li>
                                                <li><a href="delete_user">Delete User</a>
                                                </li>
                                                <li><a href="add_features">Add Feature</a>
                                                </li>
                                                <?php 
                                                }
                                                if($ulevel >= 20)
                                                {
                                                ?>
                                                <li><a href="tid_change">TID Change</a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <?php 
                                        if($ulevel >= 25)
                                        {
                                        ?>  

                                        <li><a data-toggle="collapse" data-target="#Miscellaneousmob" href="suspend_resume">Suspend/Resume<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        </li>

                                        <?php } ?>

                                        <?php 
                                        if($ulevel == 100)
                                        {
                                        ?>  

                                        <li><a data-toggle="collapse" data-target="#Chartsmob" href="#">Admin<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Chartsmob" class="collapse dropdown-header-top">
                                                <li><a href="admin_createv2">Create User with Task</a>
                                                </li>
                                                <li><a href="admin_create">Create User</a>
                                                </li>
                                                <li><a href="admin_delete">Delete User</a>
                                                </li>
                                                <li><a href="admin_delete_udr">Delete User UDR HSS</a>
                                                </li>
                                                <li><a href="admin_deleteV2">Delete V2</a>
                                                </li>
                                                <li><a href="admin_feature">Add Feature</a>
                                                </li>
                                                <li><a href="../dbFunction/logread">LOG</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>      

                    <!--                     <li><a data-toggle="collapse" data-target="#Tablesmob" href="#">Tables <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Tablesmob" class="collapse dropdown-header-top">
                                                <li><a href="static-table.html">Static Table</a>
                                                </li>
                                                <li><a href="data-table.html">Data Table</a>
                                                </li>
                                            </ul>
                                        </li> -->
     <!--                                    <li><a data-toggle="collapse" data-target="#formsmob" href="#">Forms <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="formsmob" class="collapse dropdown-header-top">
                                                <li><a href="basic-form-element.html">Basic Form Elements</a>
                                                </li>
                                                <li><a href="advance-form-element.html">Advanced Form Elements</a>
                                                </li>
                                                <li><a href="password-meter.html">Password Meter</a>
                                                </li>
                                                <li><a href="multi-upload.html">Multi Upload</a>
                                                </li>
                                                <li><a href="tinymc.html">Text Editor</a>
                                                </li>
                                                <li><a href="dual-list-box.html">Dual List Box</a>
                                                </li>
                                            </ul>
                                        </li> -->
                    <!--                     <li><a data-toggle="collapse" data-target="#Appviewsmob" href="#">App views <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Appviewsmob" class="collapse dropdown-header-top">
                                                <li><a href="basic-form-element.html">Basic Form Elements</a>
                                                </li>
                                                <li><a href="advance-form-element.html">Advanced Form Elements</a>
                                                </li>
                                                <li><a href="password-meter.html">Password Meter</a>
                                                </li>
                                                <li><a href="multi-upload.html">Multi Upload</a>
                                                </li>
                                                <li><a href="tinymc.html">Text Editor</a>
                                                </li>
                                                <li><a href="dual-list-box.html">Dual List Box</a>
                                                </li>
                                            </ul>
                                        </li> -->
                    <!--                     <li><a data-toggle="collapse" data-target="#Pagemob" href="#">Pages <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul id="Pagemob" class="collapse dropdown-header-top">
                                                <li><a href="login.html">Login</a>
                                                </li>
                                                <li><a href="register.html">Register</a>
                                                </li>
                                                <li><a href="captcha.html">Captcha</a>
                                                </li>
                                                <li><a href="checkout.html">Checkout</a>
                                                </li>
                                                <li><a href="contact.html">Contacts</a>
                                                </li>
                                                <li><a href="review.html">Review</a>
                                                </li>
                                                <li><a href="order.html">Order</a>
                                                </li>
                                                <li><a href="comment.html">Comment</a>
                                                </li>
                                            </ul>
                                        </li> -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu end -->