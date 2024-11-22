function createZteCab() {
    var reg = "94" + $("#regid").val().substring($("#regid").val().length - 9);
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_ONT_SN':'" + $("#ontsn").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "','ZTE_NMS_REGID':'" + reg + "','ZTE_ONUTYPE':'" + $("#speed").val() + "'}";

    $("#addonu").text("CREATING ONU");

    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "FAB",
        COMMAND: "FTTH_ZTE_ADDONU",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#addonu").text("SUCCESS");

            $("#bid").text("CREATING PROFILE");

            var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "','FTTH_ZTE_PROFILE':'" + $("#profile").val() + "','ZTE_ONUTYPE':'" + $("#speed").val() + "'}";
            $.post("../dbFunction/runpython.php", {
                OLT: $("#olt").val(),
                SVTYPE: "FAB",
                COMMAND: "FTTH_ZTE_BID_PROFILE",
                ATT: att,
                REGID: $("#regid").val()
            }, function (result) {
        
                var temp = result.split("#");
                if (temp[0] == "0") {
                    $("#bid").text("SUCCESS");
                } else {
                    $("#bid").text("ERROR CREATING PROFILE :" + result);
                    
                }
            });

         } else {
             $("#addonu").text("ERROR CREATING ONU :" + result);
             
        }



    });
}




function createZteVoice() {
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "','FTH_ORDER_TYPE':'FTH_VOICE'}";
    $("#voicec").text("CREATING VOICE");
    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "VOICE",
        COMMAND: "FTTH_ZTE_ISERPOT",
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


function createZteBb(){
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "','FTH_ORDER_TYPE':'FTH_BB'}";
    $("#bbp").text("CREATING BB");
    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "BB",
        COMMAND: "FTTH_ZTE_ISERPOT",
        ATT: att,
        REGID: $("#regid").val()
    }, function(result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#bbp").text("SUCCESS");

            var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "','ADSL_ZTE_USERNAME':'" + $("#bb").val() + "'}";
            $("#bbuser").text("CREATING BB USER");
            $.post("../dbFunction/runpython.php", {
                OLT: $("#olt").val(),
                SVTYPE: "BB",
                COMMAND: "FTTH_INT_USRADD",
                ATT: att,
                REGID: $("#regid").val()
            }, function(result) {
                var temp = result.split("#");
                if (temp[0] == "0") {
                    $("#bbuser").text("SUCCESS");
                } else {
                    $("#bbuser").text("ERROR CREATING BB USER:" + result);
                }
            });
        } else {
            $("#bbp").text("ERROR CREATING BB :" + result);
        }

    });
}


function createZteIptv(){
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "','FTH_ORDER_TYPE':'FTH_IPTV'}";
    $("#iptvp").text("CREATING IPTV PORT");
    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "IPTV",
        COMMAND: "FTTH_ZTE_ISERPOT",
        ATT: att,
        REGID: $("#regid").val()
    }, function(result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#iptvp").text("CREATING IPTV PORT SUCCESS");

            var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
            $("#iptva").text("CREATING IPTVA");
            $.post("../dbFunction/runpython.php", {
                OLT: $("#olt").val(),
                SVTYPE: "IPTV",
                COMMAND: "FTTH_ZTE_IPTVSERA",
                ATT: att,
                REGID: $("#regid").val()
            }, function(result) {
                var temp = result.split("#");
                if (temp[0] == "0") {
                    $("#iptva").text("CREATING IPTVA SUCCESS");

                    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                    $("#iptvb").text("CREATING IPTVB");
                    $.post("../dbFunction/runpython.php", {
                        OLT: $("#olt").val(),
                        SVTYPE: "IPTV",
                        COMMAND: "FTTH_ZTE_IPTVSERB",
                        ATT: att,
                        REGID: $("#regid").val()
                    }, function(result) {
                        var temp = result.split("#");
                        if (temp[0] == "0") {
                            $("#iptvb").text("CREATING IPTVB SUCCESS");

                            var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                            $("#iptvc").text("CREATING IPTVC");
                            $.post("../dbFunction/runpython.php", {
                                OLT: $("#olt").val(),
                                SVTYPE: "IPTV",
                                COMMAND: "FTTH_ZTE_IPTVSERC",
                                ATT: att,
                                REGID: $("#regid").val()
                            }, function(result) {
                                var temp = result.split("#");
                                if (temp[0] == "0") {
                                    $("#iptvc").text("CREATING IPTVC SUCCESS");

                                    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                    $("#iptvd").text("CREATING IPTVD");
                                    $.post("../dbFunction/runpython.php", {
                                        OLT: $("#olt").val(),
                                        SVTYPE: "IPTV",
                                        COMMAND: "FTTH_ZTE_IPTVSERD",
                                        ATT: att,
                                        REGID: $("#regid").val()
                                    }, function(result) {
                                        var temp = result.split("#");
                                        if (temp[0] == "0") {
                                            $("#iptvd").text("CREATING IPTVD SUCCESS");

                                            if ($("#iptv").val() > 1) {

                                                var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                                $("#iptv2").text("CREATING IPTV2");
                                                $.post("../dbFunction/runpython.php", {
                                                    OLT: $("#olt").val(),
                                                    SVTYPE: "IPTV",
                                                    COMMAND: "FTTH_ZTE_IPTV2",
                                                    ATT: att,
                                                    REGID: $("#regid").val()
                                                }, function(result) {
                                                    var temp = result.split("#");
                                                    if (temp[0] == "0") {
                                                        $("#iptv2").text("CREATING IPTV2 SUCCESS");

                                                        if ($("#iptv").val() > 2) {

                                                            var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_HUW_VP':'" + $("#vport").val() + "'}";
                                                            $("#iptv3").text("CREATING IPTV3");
                                                            $.post("../dbFunction/runpython.php", {
                                                                OLT: $("#olt").val(),
                                                                SVTYPE: "IPTV",
                                                                COMMAND: "FTTH_ZTE_IPTV3",
                                                                ATT: att,
                                                                REGID: $("#regid").val()
                                                            }, function(result) {
                                                                var temp = result.split("#");
                                                                if (temp[0] == "0") {
                                                                    $("#iptv3").text("CREATING IPTV3 SUCCESS");
                                                                } else {
                                                                    $("#iptv3").text("ERROR CREATING IPTV3 :" + result);
                                                                }
                                                            });
                                                        }

                                                    } else {
                                                        $("#iptv2").text("ERROR CREATING IPTV2 :" + result);
                                                    }

                                                });
                                            }
                                        } else {
                                            $("#iptvd").text("ERROR CREATING IPTVD :" + result);
                                        }

                                    });
                                } else {
                                    $("#iptvc").text("ERROR CREATING IPTVC :" + result);
                                }

                            });

                        } else {
                            $("#iptvb").text("ERROR CREATING IPTVB :" + result);
                        }
                    });
                } else {
                    $("#iptva").text("ERROR CREATING IPTVA :" + result);
                }

            });
        } else {
            $("#iptvp").text("ERROR CREATING IPTV PORT :" + result);
        }


    });







}