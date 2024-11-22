<?php
include('../dbFunction/log.php');
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user = $_SESSION['$usrid'];
    $ulevel = $_SESSION['$p_level'];
    $centrix = $_SESSION['$centrix'];
    if ($centrix != 'Y') {
        echo '<script type="text/javascript"> document.location = "../main.php";</script>';
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

    <script type="text/javascript">
        function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }


        function getdata(){
            var reg = $("#tp").val();

            if ($("#tp").val().length != 10) {
                alert("Number must be 10 Digit long ");
                return;
            }
           
           $('#submit2').hide();

            $.get("../dbFunction/centrexDetails.php?q=" + reg + "&r=admindetails", {}, function(data, status) {
                console.log('return data ' + data);
                if (data.length !== 0) {
                   // if(data[0].CENTREX != "Y"){
                    $("#svtype").val(data[0].CIRT_SERT_ABBREVIATION);
                    $("#groupid").val(data[0].GROUP_ID);
                    $("#shortcode").val(data[0].SHORT_CODE);
                   // }else{
                  //      alert("SF_CENTREX value is Y");
                  //  }
                }else{
                    alert("There are No pending SOs for this number");
                }
            });
        }


        function deleteNo(){

            if ($("#tp").val().length != 10) {
                alert("Number must be 10 Digit long ");
                return;
            }

            $('#createbtn').hide();

            var reg = '94'+$("#tp").val().substring($("#tp").val().length - 9);

            $.post("../dbFunction/centrexPython.php?action=DELETE", {               
                tp: reg
            }, function(result) {
                var temp = result.split("#");
                if (temp[0] == "0") {
                    $("#msg1").text("SUCCESS");

                    if( $("#svtype").val() == "V-VOICE COPPER"){
                        $.post("../dbFunction/centrexPython.php?action=DELETECOPPER", {               
                            tp: reg
                        }, function(result) {
                            var temp = result.split("#");
                            if (temp[0] == "0") {
                                $("#msg2").text("SUCCESS");                              

                            } else {
                                $("#msg2").text("ERROR EXECUTING COMMAND :" + result);
                                
                            }
                        });

                    }

                } else {
                    $("#msg1").text("ERROR EXECUTING COMMAND :" + result);
                    
                }
            });

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
    <!-- Header top area start-->
    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
            <?php include('sidebar_centrex.php'); ?>
        </div>
        <?php include('header_bar.html'); ?>
        <!-- Breadcome start-->

        <!-- Breadcome End-->

        <!-- Basic Form Start -->
        <div class="basic-form-area mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sparkline12-list shadow-reset mg-t-30">
                            <div class="sparkline12-hd">
                                <div class="main-sparkline12-hd">
                                    <h1>CENTREX - Admin Delete Number</h1>
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
                                                            <label class="login2 pull-right pull-right-pro">Number</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">

                                                                <div class="col-lg-6">
                                                                    <div class="form-select-list">
                                                                        <input type="number" class="form-control" id="tp">
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
                                                                    <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="submit2" name="submit2" onclick="getdata()">Get details</button>
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
                                                            <label class="login2 pull-right pull-right-pro">SERVICE TYPE</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" disabled class="form-control" id="svtype">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">GROUP ID</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text"  class="form-control" id="groupid">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">SHORT CODE</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text"  class="form-control" id="shortcode">
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
                                                                    <button class="btn btn-sm btn-primary login-submit-cs" type="submit" id="createbtn" name="createbtn" onclick="deleteNo()">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro" id="msg1"></label>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro" id="msg2"></label>
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