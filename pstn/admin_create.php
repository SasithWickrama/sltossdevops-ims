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
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
	
	<script type="text/javascript">
var area_glob = "";
var setno = 0;

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function adduser(){
	
	document.getElementById('agcf').innerHTML = "CREATING USER IN AGCF....";
	document.getElementById('agcf').className = "label label-warning";
	var tp = document.getElementById("tpno").value;
	var ip = document.getElementById("mip").value;
	var tid = document.getElementById("mtid").value;
	
	tp = tp.slice( 1 );
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
	var repx = xmlhttp.responseText.split("#");	
	
		
		if(repx[0].trim() == "0"){
			document.getElementById('agcf').innerHTML = "USER CREATED IN AGCF";
			document.getElementById('agcf').className = "label label-success";			
			//adduserens(tp);
			adduserats(tp);
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('agcf').innerHTML = "USER CREATE ERROR IN AGCF";
			document.getElementById('agcf').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=ADDAGCF-4-tpno*"+tp+"-ip*"+ip+"-tid*"+tid+"-area*"+area_glob,true);
    xmlhttp.send();

}

function adduserens(tp){
	
	document.getElementById('ens').innerHTML = "CREATING USER IN ENS....";
	document.getElementById('ens').className = "label label-warning";
	
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0].trim() == "0"){
			document.getElementById('ens').innerHTML = "USER CREATED IN ENS";
			document.getElementById('ens').className = "label label-success";
			//adduserats(tp);
			adduser();
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('ens').innerHTML = "USER CREATE ERROR IN ENS";
			document.getElementById('ens').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=ADDENS-1-tpno*"+tp,true);
    xmlhttp.send();

}


function adduserhss(){
	var tp = document.getElementById("tpno").value;
	tp = tp.slice( 1 );
	document.getElementById('hss').innerHTML = "CREATING USER IN HSS....";
	document.getElementById('hss').className = "label label-warning";
	
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0].trim() == "0"){
			document.getElementById('hss').innerHTML = "USER CREATED IN HSS";
			document.getElementById('hss').className = "label label-success";
			adduserens(tp);
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('hss').innerHTML = "USER CREATE ERROR IN HSS";
			document.getElementById('hss').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=UDR_ADD_HSS||1||tpno*"+tp,true);
    xmlhttp.send();

}




function adduserats(tp){
	
	document.getElementById('ats').innerHTML = "CREATING USER IN ATS....";
	document.getElementById('ats').className = "label label-warning";
	var sou = tp.substring(0, 2);
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0].trim() == "0"){
			document.getElementById('ats').innerHTML = "USER CREATED IN ATS";
			document.getElementById('ats').className = "label label-success";
			setfeatures();
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('ats').innerHTML = "USER CREATE ERROR IN ATS";
			document.getElementById('ats').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=ADDATS-2-tpno*"+tp+"-source*"+sou,true);
    xmlhttp.send();

}


function setfeatures(){
	var tp = document.getElementById("tpno").value;
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
		var repx = xmlhttp.responseText.split("@");	
		var btns = "<table>"; 
			for(i=0; i<repx.length-1; i++){
				btns += " <tr><td style=\"padding-bottom:10px;\" ><button id=\""+repx[i]+"\" name=\"submit\"  onclick=\"actfeture(this)\" class=\"btn btn-primary\">Activate "+repx[i]+" Feature</button></td><td style=\"padding-right:10px\"><label class=\"label label-default\" for=\"selectbasic\" id=\""+repx[i]+"1\" ></label></td></tr>"
			}
			btns += "</table>";
			document.getElementById('fbutton').innerHTML = btns;
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+tp+"&r=feature",true);
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
    xmlhttp.open("GET","../dbFunction/runphptest.php?q="+fe.id+"-1-tpno*"+tp,true);
    xmlhttp.send();
}



function gettiddetails(){
	document.getElementById("submit2").style.display = "none";
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
	
	
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {

	         area_glob = "";
		   var repx = xmlhttp.responseText.split("#");	
		   
		   document.getElementById("mname").value = repx[0];
		   document.getElementById("mindex").value = repx[1];
		   document.getElementById("mmodel").value = repx[2];
		   document.getElementById("mip").value = repx[3];
		   document.getElementById("mtid").value = repx[4];
		   area_glob = repx[5];
		   	document.getElementById("submitcre1").style.display = "";
			  document.getElementById("submitcre2").style.display = "";   
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+tp+"&r=mod",true);
    xmlhttp.send();
	
	
	
}

function getmsandetails2(ip){
	
	var tp = document.getElementById("tpno").value;
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {

	         
		   var repx = xmlhttp.responseText.split("#");	
		   
		
		   document.getElementById("imsmindex").value = repx[1];
		   document.getElementById("imsmmodel").value = repx[2];
		   	   
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+ip+"&r=list",true);
    xmlhttp.send();
	displaybtn();
	document.getElementById("submit2").style.display = "";
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

	}
	else
	{
	document.getElementById("upbtn").style.display = "";
	

	}
}


</script>
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
                                        <h1>PSTN-Add User</h1>
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
                                                                    <label class="login2 pull-right pull-right-pro">Megaline NO</label>
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
                                                                           <!--  <button class="btn btn-white" type="submit">Cancel</button> -->
                                                                            <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submit2" onclick="gettiddetails()" name="submit">Get details</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        
                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                  
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <div class="col-lg-4">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro">Clarity</label>
                                                                            </div> 
                                                                        </div>
                                                                            <div class="col-lg-4">
                                                                          
                                                                          
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
                                                                        <div class="col-lg-4">
                                                                     <!--        <div class="form-select-list">
                                                                                <input type="text" class="form-control" placeholder=".col-md-6">
                                                                            </div> -->
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
                                                                        <div class="col-lg-4">
                                                                           <!--  <div class="form-select-list">
                                                                                <input type="text" class="form-control" placeholder=".col-md-6">
                                                                            </div> -->
                                                                            <input type="text" disabled class="form-control" id="mindex">
                                                                        </div>

                                                                        <div class="col-lg-2">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" id="agcf" style="color: blue;">AGCF</label>
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
                                                                        <div class="col-lg-4">
                                                                            <input type="text" disabled class="form-control" id="mmodel">
                                                                        </div>

                                                                        <div class="col-lg-2">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" id="ens" style="color: blue;">ENS</label>
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
                                                                        <div class="col-lg-4">
                                                                            <input type="text" disabled class="form-control" id="mip">
                                                                        </div>

                                                                        <div class="col-lg-2">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" id="hss" style="color: blue;">HSS</label>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">TID</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <input type="text" disabled class="form-control" id="mtid">
                                                                        </div>

                                                                        <div class="col-lg-2">
                                                                           <div class="form-select-list">
                                                                                <label class="login2 pull-right pull-right-pro" id="ats" style="color: blue;">ATS</label>
																				<label class="login2 pull-right pull-right-pro" style="color: blue;" id="wmsg"></label>
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
                                                                            <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submitcre1" name="submit" onclick="adduserhss()" style="display: none;">Create User</button>
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
    <?php include('../footer.html'); ?> 
    <!-- Footer End-->
   
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