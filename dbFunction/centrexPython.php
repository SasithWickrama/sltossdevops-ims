<?php
include('log.php');
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION['$usrid'];
	$uname = $_SESSION['$usrname'];
	$ulevel = $_SESSION['$p_level'];
}
else 
{     
    echo '<script type="text/javascript"> document.location = "login.html";</script>'; 
}



	$ACTION= $_GET['action'];

    if($ACTION == "CREATE"){
        $tp = $_POST['tp'];
        $group = $_POST['group'];
        $shortcode = $_POST['shortcode'];
        $cxsg = $_POST['cxsg'];
        $cxsbr = $_POST['cxsbr'];

        $msg = 'User : '.$user.'-'.$uname.' Create Number  '.$_POST["tp"].' in Centrex '; 
        logToFile('imslog.txt',$msg);
        $var = "ADD {'tpno':'$tp','group':'$group','subgrp':'$cxsg','shortcode':'$shortcode','cxsbr':'$cxsbr'}";

    }

    if($ACTION == "CREATECOPPER"){
        $tp = $_POST['tp'];
        $clen = $_POST['codelength'];

        $msg = 'User : '.$user.'-'.$uname.' Create Copper Number  '.$_POST["tp"].' in Centrex '; 
        logToFile('imslog.txt',$msg);
        $var = "DIGITMAP {'tpno':'$tp','digmap':'$clen'}";

    }

    if($ACTION == "DELETE"){
        $tp = $_POST['tp'];

        $msg = 'User : '.$user.'-'.$uname.' Delete Number  '.$_POST["tp"].' in Centrex '; 
        logToFile('imslog.txt',$msg);
        $var = "RMV {'tpno':'$tp'}";

    }

    if($ACTION == "DELETECOPPER"){
        $tp = $_POST['tp'];
        $clen = $_POST['codelength'];

        $msg = 'User : '.$user.'-'.$uname.' Delete Copper Number  '.$_POST["tp"].' in Centrex '; 
        logToFile('imslog.txt',$msg);
        $var = "DIGITMAP {'tpno':'$tp','digmap':'0'}";

    }


 


        $result=exec("F:\Python\Python39\python.exe F:\\xampp\\htdocs\\IMS\\dbFunction\\CentrexCon\\main.py ".$var);

    echo $result;
