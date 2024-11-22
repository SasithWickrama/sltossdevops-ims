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


function isIp(IPvalue){

errorString = "";
theName = "IPaddress";

var ipPattern = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
var ipArray = IPvalue.match(ipPattern);

if (IPvalue == "0.0.0.0")
errorString = errorString + theName + ': '+IPvalue+' is a special IP address and cannot be used here.';
else if (IPvalue == "255.255.255.255")
errorString = errorString + theName + ': '+IPvalue+' is a special IP address and cannot be used here.';
if (ipArray == null)
errorString = errorString + theName + ': '+IPvalue+' is not a valid IP address.';
else {
for (i = 0; i < 4; i++) {
thisSegment = ipArray[i];
if (thisSegment > 255) {
errorString = errorString + theName + ': '+IPvalue+' is not a valid IP address.';
i = 4;
}
if ((i == 0) && (thisSegment > 255)) {
errorString = errorString + theName + ': '+IPvalue+' is a special IP address and cannot be used here.';
i = 4;
      }
   }
}
extensionLength = 3;
if (errorString == "")
return true;
else
return false;

}


function gettiddetails(){
	document.getElementById("submit").style.display = "none";	
	var ip = document.getElementById("mip").value;	
	
	if(!isIp(ip)){
		alert("Invalid IP Address");
		return;
	}
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	//alert(xmlhttp.responseText);
		var repxy = xmlhttp.responseText.split("@");	
		var x = document.getElementById("cards");			

			var le = x.options.length;
			for (var t=0; t<le; t++) {
    		x.options[0] = null;
			}
			var option = document.createElement("option");
		//	option.text = "";
    	//	x.add(option);
		
			for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
				
				var option = document.createElement("option");
				option.text = repx[2];
				option.value =  repx[2];
				x.add(option);	
				document.getElementById("upbtn").style.visibility = 'visible';
			}
			
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+ip+"&r=listall",true);
    xmlhttp.send();
}



function getnumbers(){
	//document.getElementById("upbtn").style.display = "none";	
	var ip = document.getElementById("mip").value;
	var cards = document.getElementById("cards").value;	
	
	
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	//alert(xmlhttp.responseText);
		var repxy = xmlhttp.responseText.split("@");	
		var x = document.getElementById("cards");			

			var tbl = "<table  class=\"table table-striped\"><thead><tr><td>TID</td><td> Clarity User</td><td> Clarity Status</td><td>IMS User</td></tr></thead><tbody>";
		
			for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
				tbl += "<tr><td>"+repx[0]+"</td><td>"+repx[1]+"</td><td>"+repx[2]+"</td><td><label class=\"control-label\" for=\"selectbasic\" id=\""+repx[0]+"\"> </label></td></tr>";
				
			
				
			}
			
			tbl += "</tbody></table>";
			document.getElementById("table1").innerHTML = tbl;
			
			var repxy = xmlhttp.responseText.split("@");
			for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
				 gtimsno(repx[0]);
			}
			
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+ip+"&s="+cards+"&r=getallpstn",true);
    xmlhttp.send();
}

function gtimsno(xx){
	var ip = document.getElementById("mip").value;
	
	var xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() {
    			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		
	         
			   var rep = xmlhttp.responseText.split("#");	
			   
			   
			   document.getElementById(xx).innerHTML = rep[2];
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=LISTAGCFPORT-2-ip*"+ip+"-tid*"+xx,true);
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
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
     <div class="wrapper-pro">
        <div class="left-sidebar-pro">
        <?php include('sidebar_pstn.php'); ?>
        </div>
    <?php include('header_bar.html'); ?> 
            <!-- Breadcome start-->

            <!-- Breadcome End-->
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
                                        <h1>PSTN-List Users</h1>
                                 <!--        <div class="sparkline12-outline-icon">
                                            <span class="sparkline12-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span><i class="fa fa-wrench"></i></span>
                                            <span class="sparkline12-collapse-close"><i class="fa fa-times"></i></span>
                                        </div> -->
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
                                                                    <label class="login2 pull-right pull-right-pro">IP address</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                  
                                                                        <div class="col-lg-6">
                                                                            <div class="form-select-list">
                                                                                <input type="text" class="form-control" id="mip">
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
                                                                           <!--  <button class="btn btn-white" type="submit">Cancel</button> -->
                                                                            <button class="btn btn-sm btn-primary login-submit-cs" id="submit"   onclick="gettiddetails()">Get cards details</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Card</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                    <div class="col-lg-6">
                                                                    <div class="form-select-list">
                                                                        <select class="form-control custom-select-value" id="cards" name="cards">                                                                            
                                                                        </select>
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
                                                                           <!--  <button class="btn btn-white" type="submit">Cancel</button> -->
                                                                            <button class="btn btn-sm btn-primary login-submit-cs" id="upbtn" style="visibility:hidden;" name="submit1"  onclick="getnumbers()">Get Port Details</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														
														<div id="table1"></div>
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