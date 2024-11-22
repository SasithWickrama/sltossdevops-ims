<?php
include('../dbFunction/log.php');
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION['$usrid'];
	$ulevel = $_SESSION['$p_level'];
	if($ulevel != 25 && $ulevel != 50 && $ulevel != 100 && $ulevel != 70 && $ulevel != 40)
	{
	echo '<script type="text/javascript"> document.location = "main.php";</script>';
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



function setfeatures(){
	var tp = document.getElementById("tpno").value;
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	//alert(xmlhttp.responseText);
	
	if(xmlhttp.responseText == ""){
	alert('There are no Modify SO in clarity');
	}
		var repxy = xmlhttp.responseText.split("@");	
		var btns = "<table>"; 
		
		
			for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
				
				if(repx[1]== 'Y' )	{
				btns += " <tr><td style=\"padding-bottom:10px;\" ><button id=\""+repx[0]+"\" name=\"submit\"  onclick=\"actfeture(this)\" class=\"btn btn-primary\">Activate "+repx[0]+" Feature</button></td><td style=\"padding-right:10px\"><label class=\"label label-default\" for=\"selectbasic\" id=\""+repx[0]+"1\" ></label></td>"
				
				
				if(i+1 < repxy.length-1){
					i++;
					btns += " <td style=\"padding-bottom:10px;\" ><button id=\""+repx[0]+"\" name=\"submit\"  onclick=\"actfeture(this)\" class=\"btn btn-primary\">Activate "+repx[0]+" Feature</button></td><td style=\"padding-right:10px\"><label class=\"label label-default\" for=\"selectbasic\" id=\""+repx[0]+"1\" ></label></td></tr>"
				}else{
					btns += "<td></td></tr>";
				}
				}else if(repx[1]== 'N' ){
					
					btns += " <tr><td style=\"padding-bottom:10px;\" ><button id=\"D_"+repx[0]+"\" name=\"submit\"  onclick=\"actfeture(this)\" class=\"btn btn-primary\">Deactivate "+repx[0]+" Feature</button></td><td style=\"padding-right:10px\"><label class=\"label label-default\" for=\"selectbasic\" id=\""+repx[0]+"1\" ></label></td>"
				
				
				if(i+1 < repxy.length-1){
					i++;
					btns += " <td style=\"padding-bottom:10px;\" ><button id=\"D_"+repx[0]+"\" name=\"submit\"  onclick=\"actfeture(this)\" class=\"btn btn-primary\">Deactivate "+repx[0]+" Feature</button></td><td style=\"padding-right:10px\"><label class=\"label label-default\" for=\"selectbasic\" id=\""+repx[0]+"1\" ></label></td></tr>"
				}else{
					btns += "<td></td></tr>";
				}
				}
			}
			btns += "</table>";
			document.getElementById('fbutton').innerHTML = btns;
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+tp+"&r=modfeature",true);
    xmlhttp.send();
}

function actfeture(fe){
	
	var tp = document.getElementById("tpno").value;
	document.getElementById(fe.id).innerHTML = fe.id+" Feature Activating....";
	document.getElementById(fe.id).className = "btn btn-warning";
	tp = tp.slice( 1 );
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById(fe.id).innerHTML = fe.id+" Feature Activated";
			document.getElementById(fe.id).className = "btn btn-success";
			
		}else{
			document.getElementById(fe.id+"1").innerHTML = repx[1] ;
			document.getElementById(fe.id+"1").className = "label label-danger";
			document.getElementById(fe.id).innerHTML = fe.id+" Feature Activation Failed";
			document.getElementById(fe.id).className = "btn btn-danger";
		}
		
		document.getElementById(fe.id).disabled = "true";
		
        }
    }
    xmlhttp.open("GET","../dbFunction/imsportal/runphptest.php?q="+fe.id+"-1-tpno*"+tp,true);
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

    <!-- Header top area start-->
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
                                        <h1>Add Clarity Features</h1>
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
                                                                    <label class="login2 pull-right pull-right-pro">FTTH NO</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
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
                                                                    <div class="col-lg-3"></div>
                                                                    <div class="col-lg-9">
                                                                        <div class="login-horizental cancel-wp pull-left">
                                                                        
                                                                        <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submit2" name="submit2" onclick="setfeatures()">Get details</button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
														<div id="fbutton"></div>
                                                    
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