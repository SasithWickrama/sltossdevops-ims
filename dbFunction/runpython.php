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

   
$zte='ZTE';
$msan='FAB';
$com='FTTH_DEL_ONU';
$stat = '{"item":"item1","item":"item2","item":"item3"}';
//$stat= 'hekko';
$msg = 'User : '.$user.'-'.$uname.' sent NMS Command  '.$_POST["COMMAND"].' for '.$_POST["REGID"]." ".$_POST["OLT"]." ".$_POST["SVTYPE"]." ".$_POST["ATT"]; 
logToFile('imslog.txt',$msg);

$result= exec("F:\Python\Python39\python.exe F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\main.py ".$_POST["OLT"]." ".$_POST["SVTYPE"]." ".$_POST["COMMAND"]." ".json_encode($_POST["ATT"]));

//$result= exec("F:\Python\Python39\python.exe F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\main.py ".$zte." ".$msan." ".$com." ".json_encode($stat));

  
echo $result;

?>
