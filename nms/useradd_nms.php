<?php
include('../dbFunction/log.php');
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user = $_SESSION['$usrid'];
    $ulevel = $_SESSION['$p_level'];
    if ($ulevel != 25 && $ulevel != 50 && $ulevel != 100 && $ulevel != 70 && $ulevel != 40) {
        echo '<script type="text/javascript"> document.location = "main.php";</script>';
    }
} else {
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
    <script src="zte.js"></script>
    <script src="huawei.js"></script>
    <script src="nokia.js"></script>

    <script type="text/javascript">
        var area_glob = "";
        var setno = 0;

        var claritydata;

        function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }


        function gettiddetails() {
            document.getElementById("submit2").style.display = "none";
            var tp = document.getElementById("tpno").value;


            $.get("../dbFunction/nmsgetdetails.php?q=" + tp + "&r=fabcreate", {}, function(data, status) {
                console.log('return data ' + data.length === 0);
                if (data.length !== 0) {
                    claritydata = data;

                    $("#dname").val(data[0].DNAME);
                    $("#ip").val(data[0].EQUP_IPADDRESS);
                    $("#vport").val(data[0].V_PORT);
                    $("#olt").val(data[0].MSAN_TYPE);
                    $("#ontsn").val(data[0].ONT_SN);
                    $("#v1").val(data[0].VOICE_NO);
                    $("#v2").val(data[0].VOICE_NO2);
                    $("#bb").val(data[0].BB_CIRCUIT);
                    $("#regid").val(data[0].REGID);
                    $("#iptv").val(data[0].IPTV_COUNT);
                    $("#speed").val(data[0].SPEED);

                    if (data[0].ZTE_PROFILE == null) {
                        $("#profile").val('TRIPLEPLAY_BB');
                    } else {
                        $("#profile").val('TRIPLEPLAY_MULTYIIPTV');
                    }

                    if (data[0].MSAN_TYPE == 'HUAWEI') {
                        $("#port").val(data[0].PORT2);
                        $("#bid").hide();
                        $("#addonu").text("ADD ONT");
                        $("#bbuser").hide();                        
                        $('#voicebtn').show();
                    }
                    if (data[0].MSAN_TYPE == 'ZTE') {
                        $("#port").val(data[0].ZTE_PORT);                        
                        $('#voicebtn').show();
                    }
                    if (data[0].MSAN_TYPE == 'NOKIA') {
                        $("#port").val(data[0].PORT3);
                    }

                    $('#cabc').show();
                    /* if(data[0].VOICE_NO != "" || data[0].VOICE_NO2 != "" ){					   
						$('#voicec').show();
					   }*/
                    if (data[0].BB_CIRCUIT != "") {
                        if ($("#regid").val().substring($("#regid").val().length - 7) != $("#bb").val().substring($("#bb").val().length - 7)) {
                            $("#bb").css("border", "solid 2px #FF0000");
                        }
                        $('#bbc').show();
                        $('#bbp').show();
                        $('#bbuser').show();
                        if (data[0].MSAN_TYPE == 'NOKIA') {
                            $("#bbuser").hide();
                        }
						if (data[0].MSAN_TYPE == 'HUAWEI') {
                            $("#bbuser").hide();
                        }
                    }
                    if (claritydata[0].IPTV_COUNT > 0) {
                        $('#iptvcbtn').show();
                        $("#iptvp").show();
                        $("#iptva").show();
                        $("#iptvb").show();
                        $("#iptvc").show();
                        $("#iptvd").show();
                        if (data[0].MSAN_TYPE == 'HUAWEI') {
                            $("#iptvc").hide();
                            $("#iptvd").hide();
                        }
                        if (data[0].MSAN_TYPE == 'NOKIA') {
                            $("#iptva").hide();
                            $("#bid").hide();
                        $("#iptvb").hide();
                        $("#iptvc").hide();
                        $("#iptvd").hide();
                        $("#voicec").hide();
                        
                        }
                        if (claritydata[0].IPTV_COUNT > 1) {
                            $("#iptv2").show();
                        }
                        if (claritydata[0].IPTV_COUNT > 2) {
                            $("#iptv3").show();
                        }
                    }
                    if (data[0].BB_CIRCUIT != data[0].BBCCT) {
                        $("#bb").css("background-color", "#FF0000");
                    }


                } else {
                    alert('Please check the Circuit and try again');
                }
            });

        }



        function createcab() {
            $("#cabc").hide();
            if ($("#olt").val() == 'ZTE') {
                createZteCab();
            }
            if ($("#olt").val() == 'HUAWEI') {
                createHwCab();
            }
            if ($("#olt").val() == 'NOKIA') {
                createNkCab();
            }
        }


        function createvoice() {
            $('#voicebtn').hide();
            if ($("#olt").val() == 'ZTE') {
                createZteVoice();
            }
            if ($("#olt").val() == 'HUAWEI') {
                createHwVoice();
            } 
            
        }


        function createbb() {
            $('#bbc').hide();
            if ($("#olt").val() == 'ZTE') {
                createZteBb();
            }
            if ($("#olt").val() == 'HUAWEI') {
                createHwBb();
            }
            if ($("#olt").val() == 'NOKIA') {
                createNkBb();
            }
        }


        function createiptv() {
            $('#iptvcbtn').hide();
            
            if ($("#olt").val() == 'ZTE') {
                createZteIptv();
            }
            if ($("#olt").val() == 'HUAWEI') {
                createHwIptv();
            }
            if ($("#olt").val() == 'NOKIA') {
                createNkIptv();
            }

        }
    </script>
</head>

<body class="materialdesign">

    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
            <?php include('sidebar_nms.php'); ?>
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
                                    <h1>Add User</h1>
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
                                                            <label class="login2 pull-right pull-right-pro">FTTH BEARER</label>
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
                                                            <label class="login2 pull-right pull-right-pro">MSAN DNAME</label>
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

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">MSAN IP</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="ip">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="addonu">ADD ONU</label>
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

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="bid">BID_PROFILE</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">ONT_SN</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="ontsn">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="voicec"> VOICE</label>
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
                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="bbp" hidden> BROADBAND</label>
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
                                                                    <input type="text" disabled class="form-control" id="vport">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="bbuser" hidden> BROADBAND USER</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">ZTE Profile</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="profile">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="iptvp" hidden> IPTV PORT</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">BB ID</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="bb">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="iptva" hidden> IPTV A</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">Voice 1</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="v1">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="iptvb" hidden> IPTV B</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">Voice 2</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="v2">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="iptvc" hidden> IPTV C</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">IPTV Count</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="iptv">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="iptvd" hidden> IPTV D</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">REGISTRATION ID</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="regid">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="iptv2" hidden> IPTV 2</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">Service Speed</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="speed">
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <div class="form-select-list">
                                                                        <label class="login2 pull-right pull-right-pro" style="color: blue;" id="iptv3" hidden> IPTV 3</label>
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
                                                                    <button class="btn btn-sm btn-primary login-submit-cs" id="cabc" name="submit" onclick="createcab()" style="display:none;">Create FAB</button>

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

                                                                    <button class="btn btn-sm btn-primary login-submit-cs" id="voicebtn" name="submit" onclick="createvoice()" style="display:none;">Create Voice</button>
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

                                                                    <button class="btn btn-sm btn-primary login-submit-cs" id="bbc" name="submit" onclick="createbb()" style="display:none;">Create BB</button>
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
                                                                    <button class="btn btn-sm btn-primary login-submit-cs" id="iptvcbtn" name="submit" onclick="createiptv()" style="display:none;">Create IPTV</button>
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