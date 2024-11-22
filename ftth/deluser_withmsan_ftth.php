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
    <!-- vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvfavicon
		============================================ -->
    <link rel="shortcut icon" type="../image/x-icon" href="../img/favicon.ico">
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


function delusermsan(){
	
	document.getElementById('msandel').innerHTML = "DELETEING USER....";
	document.getElementById('msandel').className = "label label-warning";
	var tp = document.getElementById("tpno").value;
	var olt = document.getElementById("olt").value;
	var port = document.getElementById("port").value;
	var vport = document.getElementById("vport").value;
	var dname = document.getElementById("dname").value;
	
	if(olt == null){
		alert("OLT_MANUFACTURER cannot be null");
	}else{
		
	tp = tp.slice( 1 );
	
	if(olt == 'ZTE'){
		var url = "MSAN_SCR_DEL|5|MSAN_TYPE*ZTE|ONT_PORT*1|FTTH_ZTE_PID*"+port+"|FTTH_HUW_VP*"+vport+"|ADSL_ZTE_DNAME*"+dname;
	}
	if(olt == 'NOKIA'){
		var url = "MSAN_SCR_DEL|5|MSAN_TYPE*NOKIA|ONT_PORT*1|FTTH_ZTE_PID*"+port+'-'+vport+"|FTTH_HUW_VP*"+vport+"|ADSL_ZTE_DNAME*"+dname;
	}
	if(olt == 'HUAWEI'){
		var p = port.split("-")
		var url = "MSAN_SCR_DEL|7|MSAN_TYPE*HUAWEI|ONT_PORT*1|FTTH_HUW_FN*"+p[0]+"|FTTH_HUW_SN*"+p[2]+"|FTTH_HUW_PN*"+p[3]+"|FTTH_HUW_VP*"+vport+"|ADSL_ZTE_DNAME*"+dname;
	}
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0].trim() == "0"){
			document.getElementById('msandel').innerHTML = "USER DELETED";
			document.getElementById('msandel').className = "label label-success";
		
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('msandel').innerHTML = "USER DELETE ERROR";
			document.getElementById('msandel').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q="+url,true);
    xmlhttp.send();
	}

}

function deluseragcf(tp){
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('agcf').innerHTML = "USER DELETED IN AGCF";
			document.getElementById('agcf').className = "label label-success";			
			deluserats(tp);
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('agcf').innerHTML = "USER DELETE ERROR IN AGCF";
			document.getElementById('agcf').className = "label label-danger";
			deluserats(tp);
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=DELAGCF-1-tpno*"+tp,true);
    xmlhttp.send();

}
function deluser(){
	
	
	var tp = document.getElementById("tpno").value;
	var ip = document.getElementById("mip").value;
	var tid = document.getElementById("mtid").value;
	
	tp = tp.slice( 1 );
	

	
	document.getElementById('ens').innerHTML = "DELETING USER IN ENS....";
	document.getElementById('ens').className = "label label-warning";
	
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('ens').innerHTML = "USER DELETED IN ENS";
			document.getElementById('ens').className = "label label-success";
			//deluserhss(tp);
			delusermsan(tp)
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('ens').innerHTML = "USER DELETE ERROR IN ENS";
			document.getElementById('ens').className = "label label-danger";
			//deluserhss(tp);
			delusermsan(tp)
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=DELENS-1-tpno*"+tp,true);
    xmlhttp.send();

}


function deluserhss(){
	var tp = document.getElementById("tpno").value;
	tp = tp.slice( 1 );
	document.getElementById('hss').innerHTML = "DELETING USER IN HSS....";
	document.getElementById('hss').className = "label label-warning";
	
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('hss').innerHTML = "USER DELETED IN HSS";
			document.getElementById('hss').className = "label label-success";
			deluser();
			
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('hss').innerHTML = "USER DELETE ERROR IN HSS";
			document.getElementById('hss').className = "label label-danger";
			deluser();
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=UDR_DEL_HSS|1|tpno*"+tp,true);
    xmlhttp.send();

}


function deluserats(){
	var tp = document.getElementById("tpno").value;
	tp = tp.slice( 1 );
	document.getElementById('ats').innerHTML = "DELETING USER IN ATS....";
	document.getElementById('ats').className = "label label-warning";
	var sou = tp.substring(0, 2);
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0] == 0){
			document.getElementById('ats').innerHTML = "USER DELETED IN ATS";
			document.getElementById('ats').className = "label label-success";
			deluserhss();
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('ats').innerHTML = "USER DELETE ERROR IN ATS";
			document.getElementById('ats').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=DELATS-2-tpno*"+tp+"-source*"+sou,true);
    xmlhttp.send();

}


function gettiddetails(){
	document.getElementById("submit2").style.display = "none";
	var tp = document.getElementById("tpno").value;
	
	if(tp.length == 10){
	   			if(!isNumeric(tp)){
					alert("Please Enter a valid FTTH 10 digit NO");
	   				return ;
	   			}
	}else{
		alert("Please Enter a valid FTTH 10 digit NO");
	   				return ;
	}
	
	
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	//alert(xmlhttp.responseText);
	         area_glob = "";
		   var repx = xmlhttp.responseText.split("#");	
		   
		   document.getElementById("mname").value = repx[0];
		   document.getElementById("mindex").value = repx[1];
		   document.getElementById("mmodel").value = repx[2];
		   document.getElementById("mip").value = repx[3];
		   document.getElementById("mtid").value = repx[4];
		   area_glob = repx[5];
		   
		   document.getElementById("olt").value = repx[6];
		   if(repx[6] == 'HUAWEI'){
		   document.getElementById("port").value = repx[8];
		   }if(repx[6] == 'ZTE'){
		   document.getElementById("port").value = repx[7];
		   }if(repx[6] == 'NOKIA'){
		   document.getElementById("port").value = repx[9];
		   }
		    document.getElementById("vport").value = repx[10];
		   document.getElementById("dname").value = repx[11];
		   
		   document.getElementById("submit2").style.display = "none";  
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+tp+"&r=ftthcreateadmin",true);
    xmlhttp.send();
	
	
	
}

function getmsandetails2(ip){
	
	var tp = document.getElementById("tpno").value;
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	//alert(xmlhttp.responseText);
	         
		   var repx = xmlhttp.responseText.split("#");	
		   
		 //  document.getElementById("imsmname").value = repx[0];
		   document.getElementById("imsmindex").value = repx[1];
		   document.getElementById("imsmmodel").value = repx[2];
		   	   
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+ip+"&r=list",true);
    xmlhttp.send();
	displaybtn();
	document.getElementById("submit1").style.display = "";
}

function displaybtn()
{

	var ip = document.getElementById("mip").value;
	var tid = document.getElementById("mtid").value;
	var imsip = document.getElementById("imsmip").value;
	var imstid = document.getElementById("imsmtid").value;
	
	
if( ip == imsip && tid == imstid)
	{
	document.getElementById("upbtn").style.display = "none";
	document.getElementById("msg").style.display = "";
	//alert(imsip);
	}
	else
	{
	document.getElementById("upbtn").style.display = "";
	
	//alert("Hello");
	}
}


</script>
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
                                        <h1>Delete User</h1>
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

                                                                        <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submit2" name="submit2" onclick="gettiddetails()">Get details</button>

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
                                                                        <lable>Clarity</lable>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">MSAN Location</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text" disabled class="form-control" id="mname">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">MSAN Index</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text" disabled class="form-control" id="mindex">
                                                                        </div>

                                                                        <div class="col-lg-3">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" style="color: blue;" id="ens">ENS</label>
                                                                            </div> 
                                                                        </div>

                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>


                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">MSAN Type</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text" disabled class="form-control" id="mmodel">
                                                                        </div>

                                                                        <div class="col-lg-2">

                                                                        <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submit1" name="submit1" onclick="deluserats()">Delete User</button>

                                                                        </div>

                                                                        <div class="col-lg-1">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" style="color: blue;" id="hss">HSS</label>
                                                                            </div> 
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">MSAN IP</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text" disabled class="form-control" id="mip">
                                                                        </div>
																		<div class="col-lg-3">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" style="color: blue;" id="msandel">MSAN</label>
                                                                            </div> 
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Voice Port</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text" disabled class="form-control" id="mtid">
                                                                        </div>
																		<div class="col-lg-1">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" style="color: blue;" id="ats">ATS</label>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														
														<div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
																<label class="login2 pull-right pull-right-pro">OLT</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
																		<input type="text" disabled class="form-control" id="olt">
                                                                        </div>
																		<div class="col-lg-3">
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
                                                                <div class="col-lg-3">
																<label class="login2 pull-right pull-right-pro">Port</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
																		<input type="text" disabled class="form-control" id="port">
                                                                        </div>
																		<div class="col-lg-3">
                                                                           <div class="form-select-list">
                                                                            </div> 
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														
														<div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">V_Port</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text"  disabled class="form-control" id="vport">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														
														<div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">DNAME</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text" disabled class="form-control" id="dname">
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
    <?php include('../footer.html'); ?> 
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