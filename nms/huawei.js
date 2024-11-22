function createHwCab() {
    var p = $("#port").val().split("-");
    var reg = "94" + $("#regid").val().substring($("#regid").val().length - 9);
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_HUW_FN':'" + p[0] + "','FTTH_HUW_SN':'" + p[1] + "','FTTH_HUW_PN':'" + p[2] + "','FTTH_ONT_SN':'" + $("#ontsn").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "','FTTH_ZTE_PROFILE':'" + $("#profile").val() + "','ADSL_ZTE_USERID':'" + reg + "','FTTH_INTERNET_PKG':'100M'}";

    $("#addonu").text("ADDING ONT");

    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "FAB",
        COMMAND: "FTTH_HUW_ADDONT",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#addonu").text("ADDING ONT SUCCESS");
        } else {
            $("#addonu").text("ERROR ADDING ONT :" + result);
            ``
        }



    });
}


function createHwVoice() {
    var p = $("#port").val().split("-");
    var att = "{'FTH_ORDER_TYPE':'FTH_VOICE','ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_HUW_FN':'" + p[0] + "','FTTH_HUW_SN':'" + p[1] + "','FTTH_HUW_PN':'" + p[2] + "','FTTH_HUW_VP':'" + $("#vport").val() +
        "','FTTH_HUW_TRPOF_TX':'50_Mbps','FTTH_HUW_TRPOF_RX':'100M'}";

    $("#voicec").text("CREATING VOICE");
    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "VOICE",
        COMMAND: "FTH_CREATE_SER_PORT_VOICE",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#voicec").text("SUCCESS");
        } else {
            $("#voicec").text("ERROR CREATING VOICE :" + result);
        }

    });
}


function createHwBb() {
    var p = $("#port").val().split("-");
    var att = "{'FTH_ORDER_TYPE':'FTH_BB','ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_HUW_FN':'" + p[0] + "','FTTH_HUW_SN':'" + p[1] + "','FTTH_HUW_PN':'" + p[2] + "','FTTH_HUW_VP':'" + $("#vport").val() +
        "','FTTH_HUW_TRPOF_TX':'50_Mbps','FTTH_HUW_TRPOF_RX':'100_Mbps'}";

    $("#bbp").text("CREATING BB");
    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "BB",
        COMMAND: "FTH_CREATE_SER_PORT_BB",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#bbp").text("SUCCESS");

        } else {
            $("#bbp").text("ERROR CREATING BB :" + result);
        }

    });
}


function createHwIptv() {
    var p = $("#port").val().split("-");
    var att = "{'FTH_ORDER_TYPE':'FTH_IPTV','ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_HUW_FN':'" + p[0] + "','FTTH_HUW_SN':'" + p[1] + "','FTTH_HUW_PN':'" + p[2] + "','FTTH_HUW_VP':'" + $("#vport").val() +
        "','FTTH_HUW_TRPOF_TX':'50_Mbps','FTTH_HUW_TRPOF_RX':'100_Mbps'}";

    $("#iptvp").text("CREATING IPTV PORT");
    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "IPTV",
        COMMAND: "FTH_CREATE_SER_PORT_IPTV",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#iptvp").text("CREATING IPTV PORT SUCCESS");

            var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_HUW_FN':'" + p[0] + "','FTTH_HUW_SN':'" + p[1] + "','FTTH_HUW_PN':'" + p[2] + "','FTTH_HUW_VP':'" + $("#vport").val() +"','FTTH_HUW_TRPOF_TX':'50_Mbps','FTTH_HUW_TRPOF_RX':'100_Mbps'}";
            $("#iptva").text("CREATING IPTVA");
            $.post("../dbFunction/runpython.php", {
                OLT: $("#olt").val(),
                SVTYPE: "IPTV",
                COMMAND: "FTTH_HUW_JOINT_NTV",
                ATT: att,
                REGID: $("#regid").val()
            }, function (result) {
                var temp = result.split("#");
                if (temp[0] == "0") {
                    $("#iptva").text("CREATING NTV SUCCESS");

                    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_HUW_FN':'" + p[0] + "','FTTH_HUW_SN':'" + p[1] + "','FTTH_HUW_PN':'" + p[2] + "','FTTH_HUW_VP':'" + $("#vport").val()+ "','FTTH_HUW_TRPOF_TX':'50_Mbps','FTTH_HUW_TRPOF_RX':'100_Mbps'}";
                    $("#iptvb").text("RUNNING MOD_NTV");
                    $.post("../dbFunction/runpython.php", {
                        OLT: $("#olt").val(),
                        SVTYPE: "IPTV",
                        COMMAND: "FTTH_HUW_MOD_NTV",
                        ATT: att,
                        REGID: $("#regid").val()
                    }, function (result) {
                        var temp = result.split("#");
                        if (temp[0] == "0") {
                            $("#iptvb").text("RUNNING MOD_NTV SUCCESS");



                            if ($("#iptv").val() > 1) {

                                var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                $("#iptv2").text("CREATING IPTV21");
                                $.post("../dbFunction/runpython.php", {
                                    OLT: $("#olt").val(),
                                    SVTYPE: "IPTV",
                                    COMMAND: "FTTH_IPTV_ADD_21",
                                    ATT: att,
                                    REGID: $("#regid").val()
                                }, function (result) {
                                    var temp = result.split("#");
                                    if (temp[0] == "0") {
                                        $("#iptv2").text("CREATING IPTV21 SUCCESS");


                                        var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                        $("#iptv2").text("CREATING IPTV22");
                                        $.post("../dbFunction/runpython.php", {
                                            OLT: $("#olt").val(),
                                            SVTYPE: "IPTV",
                                            COMMAND: "FTTH_IPTV_ADD_22",
                                            ATT: att,
                                            REGID: $("#regid").val()
                                        }, function (result) {
                                            var temp = result.split("#");
                                            if (temp[0] == "0") {
                                                $("#iptv2").text("CREATING IPTV22 SUCCESS");

                                                var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                                $("#iptv2").text("CREATING IPTV23");
                                                $.post("../dbFunction/runpython.php", {
                                                    OLT: $("#olt").val(),
                                                    SVTYPE: "IPTV",
                                                    COMMAND: "FTTH_IPTV_ADD_23",
                                                    ATT: att,
                                                    REGID: $("#regid").val()
                                                }, function (result) {
                                                    var temp = result.split("#");
                                                    if (temp[0] == "0") {
                                                        $("#iptv2").text("CREATING IPTV23 SUCCESS");

                                                        if ($("#iptv").val() > 2) {

                                                            var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                                            $("#iptv3").text("CREATING IPTV31");
                                                            $.post("../dbFunction/runpython.php", {
                                                                OLT: $("#olt").val(),
                                                                SVTYPE: "IPTV",
                                                                COMMAND: "FTTH_IPTV_ADD_31",
                                                                ATT: att,
                                                                REGID: $("#regid").val()
                                                            }, function (result) {
                                                                var temp = result.split("#");
                                                                if (temp[0] == "0") {
                                                                    $("#iptv3").text("CREATING IPTV31 SUCCESS");

                                                                    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                                                    $("#iptv3").text("CREATING IPTV32");
                                                                    $.post("../dbFunction/runpython.php", {
                                                                        OLT: $("#olt").val(),
                                                                        SVTYPE: "IPTV",
                                                                        COMMAND: "FTTH_IPTV_ADD_32",
                                                                        ATT: att,
                                                                        REGID: $("#regid").val()
                                                                    }, function (result) {
                                                                        var temp = result.split("#");
                                                                        if (temp[0] == "0") {
                                                                            $("#iptv3").text("CREATING IPTV32 SUCCESS");



                                                                        } else {
                                                                            $("#iptv3").text("ERROR CREATING IPTV32 :" + result);
                                                                        }
                                                                    });


                                                                } else {
                                                                    $("#iptv3").text("ERROR CREATING IPTV31 :" + result);
                                                                }
                                                            });
                                                        }

                                                    } else {
                                                        $("#iptv2").text("ERROR CREATING IPTV23 :" + result);
                                                    }

                                                });

                                            } else {
                                                $("#iptv2").text("ERROR CREATING IPTV22 :" + result);
                                            }

                                        });


                                    } else {
                                        $("#iptv2").text("ERROR CREATING IPTV21 :" + result);
                                    }

                                });
                            }



                        } else {
                            $("#iptvb").text("ERROR RUNNING MOD_NTV :" + result);
                        }
                    });
                } else {
                    $("#iptva").text("ERROR CREATING NTV :" + result);
                }

            });
        } else {
            $("#iptvp").text("ERROR CREATING IPTV PORTeee :" + result);
        }


    });







}