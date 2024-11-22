<?php
include('../dbFunction/log.php');
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user = $_SESSION['$usrid'];
    $ulevel = $_SESSION['$p_level'];
    $oneg = $_SESSION['$oneg'];
    if ($oneg != 'Y') {
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
    <link rel="stylesheet" href="../css/select2.min.css">


    <link rel="stylesheet" href="../css/jquery-ui.css">
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/buttons.dataTables.min.css">
    <!-- modernizr JS
		============================================ -->
    <script src="../js/vendor/modernizr-2.8.3.min.js"></script>


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
                                    <h1>1GB Planned Event User Transfer Process</h1>
                                </div>
                            </div>
                            <div class="sparkline12-graph">
                                <div class="basic-login-form-ad">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="all-form-element-inner">

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-2"></div>
                                                        <div class="col-lg-3">
                                                            <label class="login2 pull-right pull-right-pro">PE Number</label>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-select-list">
                                                                <select id='pelist' class="form-control custom-select-value">
                                                                    <option value=""></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <button class="btn btn-sm btn-primary " id="submit2" name="submit2" onclick="gettiddetails()">Get details</button>
                                                        </div>
                                                        <div class="col-lg-2"></div>
                                                    </div>
                                                </div>
                                                <br />
                                                <div class="row">
                                                    <div class="col-lg-1"></div>
                                                    <div class="col-lg-10">
                                                        <table class="table  table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>PE NO</th>
                                                                    <th>STATUS</th>
                                                                    <th>OLD IP</th>
                                                                    <th>OLD CARD</th>
                                                                    <th>OLD PORT</th>
                                                                    <th>NEW IP</th>
                                                                    <th>NEW CARD</th>
                                                                    <th>NEW PORT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="petbody"></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-1"></div>
                                                </div>
                                                <br />
                                                <div class="row">
                                                    <div class="form-check" id="deletecheckdiv">
                                                        <input class="form-check-input" type="checkbox" value="" id="delcheckbx">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            I have checked and confirm Data to delete
                                                        </label>
                                                        <button class="btn btn-sm btn-danger " id="delcheckbtn" name="delcheckbtn" onclick="delconfirm()">Submit</button>
                                                    </div>
                                                    <!-- <div class="form-check" id="deletedatadiv"> 
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                            Delete Data
                                                        </label>
                                                         <button class="btn btn-sm btn-danger " id="delbtn" name="delbtn" onclick="del()">Submit</button>
                                                    </div> -->
                                                    <div class="form-check" id="createcheckdiv">
                                                        <input class="form-check-input" type="checkbox" value="" id="createcheckbx">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            I have checked and confirm Data to create
                                                        </label>
                                                        <button class="btn btn-sm btn-danger " id="createcheckbtn" name="createcheckbtn" onclick="createconfirm()">Submit</button>
                                                    </div>
                                                    <div class="form-check" id="transferdatadiv">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Transfer Data
                                                        </label>
                                                        <button class="btn btn-sm btn-danger " id="trbtn" name="trbtn" onclick="transfer()">Submit</button>
                                                    </div>
                                                    <div class="form-check" id="confirmlastdiv">
                                                        <input class="form-check-input" type="checkbox" value="" id="transfercheckbx">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Data has Transferred Successfully
                                                        </label>
                                                        <button class="btn btn-sm btn-danger " id="crbtn" name="crbtn" onclick="compleate()">Submit</button>
                                                    </div>
                                                </div>
                                                <hr />


                                                <div id="tabs">
                                                    <ul>
                                                        <li><a href="#tabs-1">Old Data</a></li>
                                                        <li><a href="#tabs-2">New Data</a></li>
                                                        <li><a href="#tabs-3">Comparison Summary</a></li>
                                                    </ul>
                                                    <div id="tabs-1">
                                                        <div class="row">
                                                            <table class="table  table-bordered" id="oldtable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>PORT</th>
                                                                        <th>VPORT</th>
                                                                        <th>VOICE1</th>
                                                                        <th>VOICE2</th>
                                                                        <th>OLT</th>
                                                                        <th>ONT_SN</th>
                                                                        <th>PROFILE</th>
                                                                        <th>BB ID</th>
                                                                        <th>IPTV COUNT</th>
                                                                        <th>REGISTRATION ID</th>
                                                                        <th>SPEED</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="numdetailsbody"></tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <div id="tabs-2">
                                                        <div class="row">
                                                            <table class="table  table-bordered" id="newtable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>PORT</th>
                                                                        <th>VPORT</th>
                                                                        <th>VOICE1</th>
                                                                        <th>VOICE2</th>
                                                                        <th>OLT</th>
                                                                        <th>ONT_SN</th>
                                                                        <th>PROFILE</th>
                                                                        <th>BB ID</th>
                                                                        <th>IPTV COUNT</th>
                                                                        <th>REGISTRATION ID</th>
                                                                        <th>SPEED</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="newnumdetailsbody"></tbody>
                                                            </table>
                                                        </div>

                                                    </div>

                                                    <div id="tabs-3">
                                                        <div class="row">
                                                            <table class="table  table-bordered" id="summarytable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>REGISTRATION ID</th>
                                                                        <th>OLD PORT</th>
                                                                        <th>OLD VPORT</th>
                                                                        <th>NEW PORT</th>
                                                                        <th>NEW VPORT</th>
                                                                        <th>STATUS</th>
                                                                        <th>COMMENT</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="summarybody"></tbody>
                                                            </table>
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
    <script src="../js/jquery-ui.js"></script>
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
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/select2.min.js"></script>

    <script type="text/javascript" src="../js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../js/jszip.min.js"></script>
    <script type="text/javascript" src="../js/buttons.html5.min.js"></script>

    <script type="text/javascript">
        var pelist = [];
        var nolist;
        var newnolist;
        var oldtable;
        var newtable;
        var planedevent;
        var summarytable;
        var x;



        $(document).ready(function() {
            $("#deletecheckdiv").hide();
            $("#delcheckbx").prop("checked", false);

            // $("#deletedatadiv").hide();

            $("#createcheckdiv").hide();
            $("#createcheckbx").prop("checked", false);

            $("#transferdatadiv").hide();
            $("#confirmlastdiv").hide();

            $("#tabs").tabs();

            $.get("../dbFunction/onegDetails.php?q=&r=getpe", {}, function(data, status) {
                if (data.length !== 0) {
                    pelist = data;
                    $.each(data, function(i, item) {
                        $('#pelist').append($('<option>', {
                            value: i,
                            text: item.PE_NO
                        }));
                    });

                    $("#pelist").select2();
                }
            });

            $('#pelist').on('change', function() {
                var crid = $('#pelist').val();
            });


        });

        function gettiddetails() {
            $("#deletecheckdiv").hide();
            $("#delcheckbx").prop("checked", false);

            $("#deletedatadiv").hide();

            $("#createcheckdiv").hide();
            $("#createcheckbx").prop("checked", false);

            $("#createdatadiv").hide();

            $("#confirmlastdiv").hide();


            x = $('#pelist').val();
            var stat = "";
            var r = "";
            planedevent = pelist[x];

            if (oldtable) {
                oldtable.destroy();
            }
            if (newtable) {
                newtable.destroy();
            }
            if (summarytable) {
                summarytable.destroy();
            }

            if (pelist[x].PE_STATUS == 0) {
                stat = "Data Ready for Delete Approval";
                $("#deletecheckdiv").show();
                r = "getolddata";
            }
            if (pelist[x].PE_STATUS == 1) {
                stat = "Waiting for Create Data";
                r = "getolddata";
            }
            // if (pelist[x].PE_STATUS == 3) {
            //     stat = "Await Data Delete Confirmation";
            //     r = "getolddata";
            // }
            if (pelist[x].PE_STATUS == 5) {
                stat = "Data Ready for Create Approval";
                $("#createcheckdiv").show();
                r = "getnewdata";
            }
            if (pelist[x].PE_STATUS == 6) {
                stat = "Waiting for Transfer Approval";
                $("#transferdatadiv").show();
                r = "getnewdata";
            }
            if (pelist[x].PE_STATUS == 7) {
                stat = "Transferring Data";
                r = "getnewdata";
            }
            if (pelist[x].PE_STATUS == 8) {
                stat = "Transfer Complete";
                $("#confirmlastdiv").show();
                r = "getnewdata";
            }
            if (pelist[x].PE_STATUS == 9) {
                stat = "Complete";
                r = "getnewdata";
            }

            $('#petbody').empty()
            tbody = "<tr><td> <a href=\"../dbFunction/oneGLog/" + pelist[x].PE_NO + "_log.txt\" target=\"_blank\">" + pelist[x].PE_NO + "</a></td><td>" + stat + "</td><td>" + pelist[x].OLD_IP +
                "</td><td>" + pelist[x].OLD_CARD + "</td><td>" + pelist[x].OLD_PORT + "</td><td>" + pelist[x].NEW_IP + "</td><td>" + pelist[x].NEW_CARD + "</td><td>" + pelist[x].NEW_PORT + "</td></tr>";
            $(tbody).appendTo($("#petbody"));


            $.get("../dbFunction/onegDetails.php?q=" + pelist[x].PE_NO + "&r=getolddata", {}, function(data, status) {
                if (data.length !== 0) {
                    nolist = data;
                    // console.log(nolist);
                    $('#numdetailsbody').empty()
                    $.each(data, function(i, item) {
                        tbody = "<tr>"
                        if (data[i].MSAN_TYPE == "ZTE") {
                            tbody += "<td>" + data[i].ZTE_PORT + "</td>";
                        }
                        if (data[i].MSAN_TYPE == "HUAWEI") {
                            tbody += "<td>" + data[i].HUAWEI_PORT + "</td>";
                        }
                        if (data[i].MSAN_TYPE == "NOKIA") {
                            tbody += "<td>" + data[i].NOKIA_PORT + "</td>";
                        }
                        if (data[i].MSAN_TYPE == null) {
                            tbody += "<td></td>";
                        }


                        tbody += "<td>" + data[i].V_PORT + "</td>" +
                            "<td>" + data[i].VOICE_NO + "</td>" +
                            "<td>" + data[i].VOICE_NO2 + "</td>" +
                            "<td>" + data[i].MSAN_TYPE + "</td>" +
                            "<td>" + data[i].ONT_SN + "</td>" +
                            "<td>" + data[i].ZTE_PROFILE + "</td>";
                        //"<td>" + data[i].BB_CIRCUIT + "</td>" +
                        if (data[i].BB_CIRCUIT) {
                            if (data[i].REGID.substring(data[i].REGID.length - 7) !== data[i].BB_CIRCUIT.substring(data[i].BB_CIRCUIT.length - 7)) {
                                tbody += "<td bgcolor=\"#F5B041\" >" + data[i].BB_CIRCUIT + "</td>";
                            } else {
                                if (data[i].BBCCT !== data[i].BB_CIRCUIT) {
                                    tbody += "<td bgcolor=\"#EC7063\" >" + data[i].BB_CIRCUIT + "</td>";
                                } else {
                                    tbody += "<td>" + data[i].BB_CIRCUIT + "</td>";
                                }
                            }
                        } else {
                            tbody += "<td>" + data[i].BB_CIRCUIT + "</td>";
                        }

                        tbody += "<td>" + data[i].IPTV_COUNT + "</td>" +
                            "<td>" + data[i].REGID + "</td>" +
                            "<td>" + data[i].SPEED + "</td>";

                        if (pelist[x].PE_STATUS == 0) {
                            tbody += "<td><button class=\"btn btn-sm btn-primary \" id=\"requery_" + data[i].REC_ID + "\"  onclick=\"requeary(" + data[i].REC_ID + ")\">Refresh</button></td>";
                        } else {
                            tbody += "<td></td>";
                        }

                        // if (pelist[x].PE_STATUS > 5) {
                        //     tbody += "<td>" + data[i].ZTE_PROFILE + "</td>";
                        // }

                        tbody += "</tr>";
                        $(tbody).appendTo($("#numdetailsbody"));
                    });

                    oldtable = $('#oldtable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel'
                        ]
                    });
                }
            });



            if (r == "getnewdata") {


                $.get("../dbFunction/onegDetails.php?q=" + pelist[x].PE_NO + "&r=getnewdata", {}, function(data, status) {
                    if (data.length !== 0) {
                        newnolist = data;
                        //console.log(newnolist);
                        $('#newnumdetailsbody').empty()
                        $.each(data, function(i, item) {
                            tbody = "<tr>"
                            if (data[i].MSAN_TYPE == "ZTE") {
                                tbody += "<td>" + data[i].ZTE_PORT + "</td>";
                            }
                            if (data[i].MSAN_TYPE == "HUAWEI") {
                                tbody += "<td>" + data[i].HUAWEI_PORT + "</td>";
                            }
                            if (data[i].MSAN_TYPE == "NOKIA") {
                                tbody += "<td>" + data[i].NOKIA_PORT + "</td>";
                            }
                            if (data[i].MSAN_TYPE == null) {
                                tbody += "<td></td>";
                            }


                            tbody += "<td>" + data[i].V_PORT + "</td>" +
                                "<td>" + data[i].VOICE_NO + "</td>" +
                                "<td>" + data[i].VOICE_NO2 + "</td>" +
                                "<td>" + data[i].MSAN_TYPE + "</td>" +
                                "<td>" + data[i].ONT_SN + "</td>" +
                                "<td>" + data[i].ZTE_PROFILE + "</td>";
                            //"<td>" + data[i].BB_CIRCUIT + "</td>" +
                            if (data[i].BB_CIRCUIT) {
                                if (data[i].REGID.substring(data[i].REGID.length - 7) !== data[i].BB_CIRCUIT.substring(data[i].BB_CIRCUIT.length - 7)) {
                                    tbody += "<td bgcolor=\"#F5B041\" >" + data[i].BB_CIRCUIT + "</td>";
                                } else {
                                    if (data[i].BBCCT !== data[i].BB_CIRCUIT) {
                                        tbody += "<td bgcolor=\"#EC7063\" >" + data[i].BB_CIRCUIT + "</td>";
                                    } else {
                                        tbody += "<td>" + data[i].BB_CIRCUIT + "</td>";
                                    }
                                }
                            } else {
                                tbody += "<td>" + data[i].BB_CIRCUIT + "</td>";
                            }

                            tbody += "<td>" + data[i].IPTV_COUNT + "</td>" +
                                "<td>" + data[i].REGID + "</td>" +
                                "<td>" + data[i].SPEED + "</td>";

                            if (pelist[x].PE_STATUS == 5) {
                                tbody += "<td><button class=\"btn btn-sm btn-primary \" id=\"requery_" + data[i].REC_ID + "\"  onclick=\"requearynew(" + data[i].REC_ID + ")\">Refresh</button></td>";
                            } else {
                                tbody += "<td></td>";
                            }

                            tbody += "</tr>";
                            $(tbody).appendTo($("#newnumdetailsbody"));
                        });

                        newtable = $('#newtable').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel'
                            ]
                        });
                    }
                });



                $.get("../dbFunction/onegDetails.php?q=" + pelist[x].PE_NO + "&r=getsummary", {}, function(data, status) {
                    if (data.length !== 0) {

                        console.log(data);
                        $('#summarybody').empty()
                        $.each(data, function(i, item) {
                            tbody = "<tr><td>" + data[i].REGID + "</td>";
                            if (data[i].MSAN_TYPE == "ZTE") {
                                tbody += "<td>" + data[i].ZTE_PORT + "</td>";
                            }
                            if (data[i].MSAN_TYPE == "HUAWEI") {
                                tbody += "<td>" + data[i].HUAWEI_PORT + "</td>";
                            }
                            if (data[i].MSAN_TYPE == "NOKIA") {
                                tbody += "<td>" + data[i].NOKIA_PORT + "</td>";
                            }
                            if (data[i].MSAN_TYPE == null) {
                                tbody += "<td></td>";
                            }


                            tbody += "<td>" + data[i].V_PORT + "</td>";

                            if (data[i].MSAN_TYPE_1 == "ZTE") {
                                tbody += "<td>" + data[i].ZTE_PORT_1 + "</td>";
                            }
                            if (data[i].MSAN_TYPE_1 == "HUAWEI") {
                                tbody += "<td>" + data[i].HUAWEI_PORT_1 + "</td>";
                            }
                            if (data[i].MSAN_TYPE_1 == "NOKIA") {
                                tbody += "<td>" + data[i].NOKIA_PORT_1 + "</td>";
                            }
                            if (data[i].MSAN_TYPE_1 == null) {
                                tbody += "<td></td>";
                            }

                            tbody += "<td>" + data[i].V_PORT_1 + "</td>" +
                                "<td>" + data[i].CCT_STATUS + "</td>" +
                                "<td>" + data[i].CCT_MESSAGE + "</td>";


                            tbody += "</tr>";
                            $(tbody).appendTo($("#summarybody"));
                        });

                        summarytable = $('#summarytable').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel'
                            ]
                        });
                    }
                });

            }
        }

        function requeary(rowid) {
            // $('#requery_' + rowid).hide();
            $('[id^=requery]').hide();
            $.get("../dbFunction/onegDetails.php?q=" + rowid + "&r=refreshnumber", {}, function(data, status) {
                console.log(data);
                if (data) {

                    alert("Success");
                    gettiddetails();
                } else {
                    alert("Error");
                }
            });
        }


        function requearynew(rowid) {
            // $('#requery_' + rowid).hide();
            $('[id^=requery]').hide();
            $.get("../dbFunction/onegDetails.php?q=" + rowid + "&r=refreshnumbernew", {}, function(data, status) {
                console.log(data);
                if (data) {

                    alert("Success");
                    gettiddetails();
                } else {
                    alert("Error");
                }
            });
        }


        function delconfirm() {
            $("#trbtn").hide();
            if (!$('#delcheckbx').is(':checked')) {
                alert("Please check Old Table data and confirm to Delete by checking the box");
                return;
            }

            $.get("../dbFunction/onegDetails.php?q=" + planedevent.PE_NO + "&r=deldataconfirm", {}, function(data, status) {
                console.log(data);
                if (data) {
                    pelist[x].PE_STATUS = 1;
                    alert("Success");
                    gettiddetails();
                } else {
                    alert("Error");
                }
            });

        }

        // function del(){
        //     $.get("../dbFunction/onegDetails.php?q=" + planedevent.PE_NO + "&r=deletego", {}, function(data, status) {
        //         console.log(data);
        //         if (data) {
        //             pelist[x].PE_STATUS = 2;
        //             alert("Success");
        //             gettiddetails();
        //         } else {
        //             alert("Error");
        //         }
        //     });
        // }


        function createconfirm() {
            $("#trbtn").hide();
            if (!$('#createcheckbx').is(':checked')) {
                alert("Please check New Table data and confirm to Create by checking the box");
                return;
            }

            $.get("../dbFunction/onegDetails.php?q=" + planedevent.PE_NO + "&r=crdataconfirm", {}, function(data, status) {
                console.log(data);
                if (data) {
                    pelist[x].PE_STATUS = 6;
                    alert("Success");
                    gettiddetails();
                } else {
                    alert("Error");
                }
            });

        }


        function compleate() {
            $("#trbtn").hide();
            if (!$('#transfercheckbx').is(':checked')) {
                alert("Please check Transfer result and confirm by checking the box");
                return;
            }

            $.get("../dbFunction/onegDetails.php?q=" + planedevent.PE_NO + "&r=compleate", {}, function(data, status) {
                console.log(data);
                if (data) {
                    pelist[x].PE_STATUS = 9;
                    alert("Success");
                    gettiddetails();
                } else {
                    alert("Error");
                }
            });

        }


        // function cr(){
        //     $.get("../dbFunction/onegDetails.php?q=" + planedevent.PE_NO + "&r=creatego", {}, function(data, status) {
        //         console.log(data);
        //         if (data) {
        //             pelist[x].PE_STATUS = 7;
        //             alert("Success");
        //             gettiddetails();
        //         } else {
        //             alert("Error");
        //         }
        //     });
        // }


        function transfer() {
            $("#trbtn").hide();
            $.get("../dbFunction/onegDetails.php?q=" + planedevent.PE_NO + "&r=transfer", {}, function(data, status) {
                console.log(data);
                if (data) {
                    pelist[x].PE_STATUS = 6;
                    $("#submit2").hide();
                    alert("Success");
                    refreshpg();
                } else {
                    alert("Error");
                }
            });
        }


        function refreshpg() {
            $.get("../dbFunction/onegDetails.php?q=" + planedevent.PE_NO + "&r=getpewithid", {}, function(data, status) {
                console.log(data);
                if (data) {
                    pelist[x] = data[0];
                    gettiddetails();
                    if (data[0].PE_STATUS == 7) {
                        $("#submit2").show();
                    } else {
                        function timeFunction() {
                            setTimeout(function() {
                                refreshpg();
                            }, 30000);
                        }
                    }

                } else {
                    alert("Error");
                }
            });
        }
    </script>
</body>

</html>