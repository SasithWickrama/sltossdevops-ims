function createNkCab() {

    var reg = "94" + $("#regid").val().substring($("#regid").val().length - 9);
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "','FTTH_ONT_SN':'" + $("#ontsn").val() + "','REGID':'" + reg + "'}";

    $("#addonu").text("CREATING ONU");

    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "FAB",
        COMMAND: "ADD_ONT_NOKIA",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#addonu").text("SUCCESS");            

        } else {
            $("#addonu").text("ERROR CREATING ONU :" + result);
            ``
        }
    });
}


function createNkVoice() {

}


function createNkBb(){
    var reg = "94" + $("#regid").val().substring($("#regid").val().length - 9);
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "'}";

    $("#bbp").text("CREATING BB");

    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "BB",
        COMMAND: "ADD_NK_INTERNET",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#bbp").text("SUCCESS");            

        } else {
            $("#bbp").text("ERROR CREATING BB :" + result);
            ``
        }
    });
}


function createNkIptv(){
    var reg = "94" + $("#regid").val().substring($("#regid").val().length - 9);
    var att = "{'ADSL_ZTE_DNAME':'" + $("#dname").val() + "','FTTH_ZTE_PID':'" + $("#port").val() + "'}";

    $("#iptvp").text("CREATING IPTV");

    $.post("../dbFunction/runpython.php", {
        OLT: $("#olt").val(),
        SVTYPE: "IPTV",
        COMMAND: "ADD_NK_IPTV",
        ATT: att,
        REGID: $("#regid").val()
    }, function (result) {
        var temp = result.split("#");
        if (temp[0] == "0") {
            $("#iptvp").text("SUCCESS");            

        } else {
            $("#iptvp").text("ERROR CREATING IPTV :" + result);
            ``
        }
    });


}