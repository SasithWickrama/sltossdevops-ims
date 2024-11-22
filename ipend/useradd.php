<?php
include('../dbFunction/log.php');
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION['$usrid'];
	$ulevel = $_SESSION['$p_level'];
	$ipend = $_SESSION['$ipend'];
	if($ipend != 'Y')
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
    <script src="../js/vendor/modernizr-2.8.3.min.js"></script>
	
	<script type="text/javascript">
var area_glob = "";
var setno = 0;

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

if(typeof String.prototype.trim !== 'function') {
  String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, ''); 
  }
}

function isValid(str){
 return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}

function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   document.getElementById("pwd").value =  result;
}


function adduserlte(){
	
	
	
	var tp = document.getElementById("tpno").value;
	
	var pwd = document.getElementById("pwd").value;
	
	if(!isValid(pwd) || pwd.length != 15){
		alert("Please enter a valid Authentication");
		return;
	}
	document.getElementById('hss').innerHTML = "CREATING USER IN HSS....";
	document.getElementById('hss').className = "label label-warning";
	
	tp = tp.slice( 1 );
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0].trim() == "0"){
			document.getElementById('hss').innerHTML = "USER CREATED IN HSS";
			document.getElementById('hss').className = "label label-success";
			adduserats(tp);
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('hss').innerHTML = "USER CREATE ERROR IN HSS";
			document.getElementById('hss').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET","../dbFunction/runphptest.php?q=UDR_ADDIPEND_HSS|2|tpno*"+tp+"|PWD*"+pwd,true);
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






function adduserats(tp){
	
	document.getElementById('ats').innerHTML = "CREATING USER IN ATS....";
	document.getElementById('ats').className = "label label-warning";
	var pack = document.getElementById("mindex").value;
	var link;
	var souse = tp.substring(0, 2);
	var vas;
	if(pack != ''){
	if(pack == 'TRIPLE_VAS') { vas = 'IMS_VAS3' }
	if(pack == 'DOUBLE_VAS') { vas = 'IMS_VAS2' }
	if(pack == 'SINGLE_VAS') { vas = 'IMS_VAS1' }
	//link = "../dbFunction/runphptest.php?q=IMS_LTEVOBB_ADD_ATS-3-tpno*"+tp+"-IMS_SORCE_CODE*"+souse+"-IMS_PACKAGE*vas";
	link = "../dbFunction/runphptest.php?q=IMS_LTEVOBB_ADD_ATS-3-tpno*"+tp+"-IMS_SORCE_CODE*"+souse+"-IMS_PACKAGE*IMS_BRONZE";
	}else{
	//link = "../dbFunction/runphptest.php?q=IMS_LTEVOBB_ADD_ATS2-2-tpno*"+tp+"-IMS_SORCE_CODE*"+souse;
	link = "../dbFunction/runphptest.php?q=IMS_LTEVOBB_ADD_ATS-3-tpno*"+tp+"-IMS_SORCE_CODE*"+souse+"-IMS_PACKAGE*IMS_BRONZE";
	}
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var repx = xmlhttp.responseText.split("#");	
		if(repx[0].trim() == "0"){
			document.getElementById('ats').innerHTML = "USER CREATED IN ATS";
			document.getElementById('ats').className = "label label-success";
			adduserens(tp);
		}else{
			document.getElementById('wmsg').innerHTML = repx[1] ;
			document.getElementById('wmsg').className = "label label-danger";
			document.getElementById('ats').innerHTML = "USER CREATE ERROR IN ATS";
			document.getElementById('ats').className = "label label-danger";
		}
		
        }
    }
    xmlhttp.open("GET",link,true);
    xmlhttp.send();

}





function checkcre(){
	var tp = document.getElementById("tpno").value;
	
	var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
console.log(xmlhttp.responseText);
	       
		   var repx = xmlhttp.responseText.split("#");	
		   console.log(repx.length);
		   if(repx.length > 1){
		     document.getElementById("submit2").style.display = "none";
			 document.getElementById("submitcre1").style.display = "";
			 document.getElementById("submitcre2").style.display = "";

		  
		   document.getElementById("mindex").value = repx[1];
		   document.getElementById("submitcre2").style.display = "";
		   document.getElementById("submitcre1").style.display = "";
		   }
		   else{
		   alert("There is no Create D-IPENDPOINT SOs");
		   }
		   
		   
		 
		   
        }
    }
    xmlhttp.open("GET","../dbFunction/getdetails.php?q="+tp+"&r=ipendcreateadmin",true);
    xmlhttp.send();
}


</script>
</head>

<body class="materialdesign">

    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
        <?php include('sidebar_ipend.php'); ?>
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
                                        <h1>Add IP-Endpoint User</h1>
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
                                                                    <label class="login2 pull-right pull-right-pro">Circuit NO</label>
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
                                                                        
                                                                        <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submit2" name="submit"  onclick="checkcre()">Get details</button>
                                                                        
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
                                                                    <label class="login2 pull-right pull-right-pro">VAS Package</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                          
                                                                            <input type="text" disabled class="form-control" id="mindex">
                                                                        </div>

                                                                        <div class="col-lg-2">
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
																<label class="login2 pull-right pull-right-pro">Authentication</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">   
																		<input type="text" class="form-control" id="pwd" placeholder="15 characters with out special characters">
                                                                        </div>
                                                                        <div class="col-lg-2">
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
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">   
                                                                        </div>
                                                                        <div class="col-lg-2">
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
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">   
                                                                        </div>
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
                                                            <div class="login-btn-inner">
                                                                <div class="row">
                                                                    <div class="col-lg-3"></div>
                                                                    <div class="col-lg-9">
                                                                        <div class="login-horizental cancel-wp pull-left">
                                                                            <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submit" name="submit"  onclick="modagcf()" style="display: none;">Update IMS</button>
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
                                                                            <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submitcre1" name="submit" onclick="makeid(15)" style="display: none;">Genarate Random Authentication</button>
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
                                                                            <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submitcre2" name="submit"  onclick="adduserlte()" style="display: none;">Create User</button>
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