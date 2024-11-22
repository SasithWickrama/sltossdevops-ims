<?php
include('../dbFunction/log.php');
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION['$usrid'];
	$ulevel = $_SESSION['$p_level'];
	if($ulevel != 25 && $ulevel != 50 && $ulevel != 100 && $ulevel != 70 && $ulevel != 40)
	{
	echo '<script type="text/javascript"> document.location = "../main.php";</script>';
	}
}
else 
{     
    echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ribe</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <!-- adminpro icon CSS
		============================================ -->
    <link rel="stylesheet" href="../css/adminpro-custon-icon.css">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="../css/meanmenu.min.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="../css/animate.css">
    <!-- modals CSS
		============================================ -->
    <link rel="stylesheet" href="../css/modals.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="../css/normalize.css">
    <!-- forms CSS
		============================================ -->
    <link rel="stylesheet" href="../css/form/all-type-forms.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="../style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="../css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="../js/vendor/modernizr-2.8.3.min.js"></script>
	
	<script type="text/javascript">
var area_glob = "";
var setno = 0;

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}


function ogb(){
	
	
	var tp = document.getElementById("tpno").value;
	
	if(tp.length == 10){
	   			if(!isNumeric(tp)){
					alert("Please Enter a valid Megaline 10 digit NO");
	   				return ;
	   			}
	}else{
		alert("Please Enter a valid Megaline 10 digit NO");
	   				return ;
	}
	
	tp = tp.slice( 1 );
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('wmsg').innerHTML = "User Suspended" ;
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=BAR_OUTGOING_CALL-1-tpno*"+tp,true);
    xmlhttp.send();

}


function icb(){


	
	
	var tp = document.getElementById("tpno").value;
	
	if(tp.length == 10){
	   			if(!isNumeric(tp)){
					alert("Please Enter a valid Megaline 10 digit NO");
	   				return ;
	   			}
	}else{
		alert("Please Enter a valid Megaline 10 digit NO");
	   				return ;
	}
	
	tp = tp.slice( 1 );
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('wmsg').innerHTML = "User Suspended" ;
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=BAR_INCOMING_CALL-1-tpno*"+tp,true);
    xmlhttp.send();

}




function removeogb(){
		
	var tp = document.getElementById("tpno").value;
	
	if(tp.length == 10){
	   			if(!isNumeric(tp)){
					alert("Please Enter a valid Megaline 10 digit NO");
	   				return ;
	   			}
	}else{
		alert("Please Enter a valid Megaline 10 digit NO");
	   				return ;
	}
	
	tp = tp.slice( 1 );
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('wmsg').innerHTML = "Call Outgoing Activated" ;
			removeicb();
		}else{
		if( repx[1]= 'ATS-The required data does not exist in the specified path.'){
		document.getElementById('wmsg').innerHTML = "Call Outgoing Already Activated" ;
			removeicb();
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			removeicb();
			}
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=REMOVE_OGB-1-tpno*"+tp,true);
    xmlhttp.send();
}

function removeicb(){
		
	var tp = document.getElementById("tpno").value;
	
	tp = tp.slice( 1 );
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('wmsg2').innerHTML = "Call Incoming Activated" ;
		}else{
			if( repx[1]= 'ATS-The required data does not exist in the specified path.'){
		document.getElementById('wmsg2').innerHTML = "Call Incoming Already Activated" ;
		
		}else{
			document.getElementById('wmsg2').innerHTML = repx[1] ;
			}
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=REMOVE_ICB-1-tpno*"+tp,true);
    xmlhttp.send();
}


</script>

<style type="text/css">
   
   .footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
  /* color: #ffffff;*/
   text-align: center;
   
}
</style>

</head>

<body class="materialdesign">

    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
        <?php include('sidebar_ftth.php'); ?>
        </div>
        <?php include('header_bar.html'); ?> 

		<!-- Mobile Menu start -->
        <?php include('mobile_menue.php'); ?>
        <!-- Mobile Menu end -->
		
            <!-- Basic Form Start -->
            <div class="basic-form-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sparkline12-list shadow-reset mg-t-30">
                                <div class="sparkline12-hd">
                                    <div class="main-sparkline12-hd">
                                        <h1>SUSPEND/RESUME</h1>
                                    </div>
                                </div>
                                <div class="sparkline12-graph">
                                    <div class="basic-login-form-ad">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="all-form-element-inner">
                                                    

                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Megaline NO</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <div class="form-select-list">
                                                                                <input type="text" class="form-control" id="tpno">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group-inner">
                                                            <div class="login-btn-inner">
                                                                <div class="row">
                                                                    <div class="col-lg-3"><label class="login2 pull-right pull-right-pro">OutGoing BAR</label></div>
                                                                    <div class="col-lg-9">
                                                                       
                                                                    <button class="btn btn-sm btn-primary col-lg-3 login-submit-cs" type="submit" id="submit2" name="submit2" onclick="ogb()">OutGoing BAR</button>
                                                                     
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group-inner">
                                                            <div class="login-btn-inner">
                                                                <div class="row">
                                                                    <div class="col-lg-3"><label class="login2 pull-right pull-right-pro">Incomming BAR</label></div>
                                                                    <div class="col-lg-9">
                                                                       
                                                                     <button class="btn btn-sm btn-primary col-lg-3 login-submit-cs" type="submit" id="submit2" name="submit2" onclick="icb()">Incomming BAR</button>
                                                                     
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="form-group-inner">
                                                            <div class="login-btn-inner">
                                                                <div class="row">
                                                                    <div class="col-lg-3"><label class="login2 pull-right pull-right-pro">RESUME</label></div>
                                                                    <div class="col-lg-9">
                                                                       
                                                                     <button class="btn btn-sm btn-primary col-lg-3 login-submit-cs" type="submit" id="submit2" name="submit2" onclick="removeogb()">RESUME</button>

                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <div class="form-group-inner">
                                                            <div class="row">
                                                                
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        
																		<div class="col-lg-2">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" style="color: blue;" id="wmsg"></label>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														
														<div class="form-group-inner">
                                                            <div class="row">
                                                                
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        
																		<div class="col-lg-2">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" style="color: blue;" id="wmsg2"></label>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic Form End-->

        </div>
    </div>
    <!-- Footer Start-->
    <!--<?php include('../footer.html'); ?>-->
	<div class="footer-copyright-area footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-copy-right">
                        <p>Copyright &#169; 2016-2020 All rights reserved. <span style="color: #FF0000">IT Solution & DevOps</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
    <!-- Chat Box Start-->
    <!-- Chat Box End-->
    <!-- jquery
		============================================ -->
    <script src="../js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="../js/jquery.meanmenu.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="../js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="../js/jquery.scrollUp.min.js"></script>
    <!-- counterup JS
		============================================ -->
    <script src="../js/counterup/jquery.counterup.min.js"></script>
    <script src="../js/counterup/waypoints.min.js"></script>
    <!-- modal JS
		============================================ -->
    <script src="../js/modal-active.js"></script>
    <!-- icheck JS
		============================================ -->
    <script src="../js/icheck/icheck.min.js"></script>
    <script src="../js/icheck/icheck-active.js"></script>
    <!-- main JS
		============================================ -->
    <script src="../js/main.js"></script>
</body>

</html>