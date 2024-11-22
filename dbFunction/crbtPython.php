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



	$no= $_POST['REGID'];
	$stat= $_POST['STATUS'] ; 


    $msg = 'User : '.$user.'-'.$uname.' sent CRBT Command  '.$_POST["STATUS"].' for '.$_POST["REGID"]; 
logToFile('imslog.txt',$msg);

        $result=exec("F:\Python\Python39\python.exe F:\\xampp\\htdocs\\IMS\\dbFunction\\crbt\\main.py ".$no." ".$stat);
        
        logToFile('imslog.txt',$result);
    echo $result;
