
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

$r =  $_GET["q"];


if (strpos($r, 'UDR_') !== false || strpos($r, 'MSAN_SCR_DEL') !== false ){
	$temp = explode('|',$r);
	logToFile('imslog.txt','$temp'.$temp[0]);
	logToFile('imslog.txt','$temp'.count($temp));
}else{
	$temp = explode('-',$r);
}
$args = '';


if($temp[0] == 'ADDAGCF'){

	$x = str_replace('_','-',$temp[5]);
	$temp[5] = $x;
}

if($temp[0] == 'MODAGCF'){

	$x = str_replace('_','-',$temp[5]);
	$temp[5] = $x;
}

if($temp[0] == 'LISTAGCF')
{
	$msg = 'User : '.$user.'-'.$uname.' Request TID of  '.$temp[2]; 
}
else if($temp[0] == 'MODAGCF')
{
	$msg = 'User : '.$user.'-'.$uname.' Changed TID of  '.$temp[2]; 
}
else if($temp[0] == 'LISTAGCFPORT')
{
	$msg = 'User : '.$user.'-'.$uname.' Request User for TID '.$temp[2].' and '.$temp[3]; 
}
else if($temp[0] == 'BAR_OUTGOING_CALL')
{
	$msg = 'User : '.$user.'-'.$uname.' BAR_OUTGOING_CALL '.$temp[2]; 
}
else if($temp[0] == 'BAR_INCOMING_CALL')
{
	$msg = 'User : '.$user.'-'.$uname.' BAR_INCOMING_CALL '.$temp[2]; 
}
else if($temp[0] == 'REMOVE_OGB')
{
	$msg = 'User : '.$user.'-'.$uname.' REMOVE_OGB '.$temp[2]; 
}
else if($temp[0] == 'REMOVE_ICB')
{
	$msg = 'User : '.$user.'-'.$uname.' REMOVE_ICB '.$temp[2]; 
}
else if($temp[0] == 'REMOVE_OGBX')
{
	$msg = 'Call Center User : '.$user.'-'.$uname.' REMOVE_OGB '.$temp[2]; 
}
else if($temp[0] == 'REMOVE_ICBX')
{
	$msg = 'Call Center User : '.$user.'-'.$uname.' REMOVE_ICB '.$temp[2]; 
}
else if($temp[0] == 'ADDAGCF' || $temp[0] == 'ADDENS'|| $temp[0] == 'ADDHSS'|| $temp[0] == 'ADDATS'|| $temp[0] == 'ADDHSSFTTH')
{
	$msg = 'User : '.$user.'-'.$uname.' User Created for TP '.$temp[2].$temp[0]; 
}
else if($temp[0] == 'UDR_ADDFTTH_HSS' || $temp[0] == 'UDR_ADD_HSS' || $temp[0] == 'UDR_ADDLTEANC_HSS' || $temp[0] == 'UDR_ADDLTEIMS_HSS' || $temp[0] =='UDR_ADD_ANC' || $temp[0] =='UDR_ADDIPEND_HSS')
{
	$msg = 'User : '.$user.'-'.$uname.' User Created in UDRHSS for TP '.$temp[2].$temp[0]; 
}
else if($temp[0] == 'MSAN_SCR_DEL' )
{
	$msg = 'User : '.$user.'-'.$uname.' User Delete in MSAN for TP '.$temp[2].$temp[0]; 
}
else if($temp[0] == 'UDR_DEL_HSS' )
{
	$msg = 'User : '.$user.'-'.$uname.' User Delete in UDR HSS for TP '.$temp[2].$temp[0]; 
}
else if($temp[0] == 'DELAGCF' || $temp[0] == 'DELENS'|| $temp[0] == 'DELHSS'|| $temp[0] == 'DELATS')
{
	$msg = 'User : '.$user.'-'.$uname.' User Deleted for TP '.$temp[2].$temp[0]; 
}
else if($temp[0] == 'UDR_NCR_DEL')
{
	$msg = 'User : '.$user.'-'.$uname.' User Port Changed for TP '.$temp[2].$temp[0]; 
}
else if($temp[0] == 'UDR_ADDVOBB_HSS')
{
	$msg = 'User : '.$user.'-'.$uname.' User VOBB Created for TP '.$temp[2].$temp[0]; 
}
else if($temp[0] == 'UDR_IPEND_CPWD')
{
	$msg = 'User : '.$user.'-'.$uname.' User Changed Password for TP '.$temp[2].$temp[0]; 
}
else
{
	$msg = 'User : '.$user.'-'.$uname.' Feature activated for TP '.$temp[2].$temp[0]; 
}

for($i =0;$i < count($temp); $i++){
	$args = $args.$temp[$i].' ';
}

$args = str_replace('*','#',$args);


$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("file", "error-output1.txt", "a") // stderr is a file to write to
);

$cwd = ''; 

$env =  array('some_option' => 'aeiou');

//echo 'java -jar SLTIMSgui.jar '.$args;

//$process = proc_open('java -jar SLTIMSgui.jar '.$args, $descriptorspec, $pipes);
	if($temp[0] == 'ADDENS' || $temp[0] == 'DELENS' ||$temp[0] == 'UDR_ADDFTTH_HSS'|| $temp[0] == 'UDR_DEL_HSS'||$temp[0] == 'MSAN_SCR_DEL'|| $temp[0] =='UDR_ADDVOBB_HSS'
	||$temp[0] == 'UDR_ADD_HSS'||$temp[0] == 'UDR_ADDLTEANC_HSS'||$temp[0] == 'UDR_ADDLTEIMS_HSS' || $temp[0] =='UDR_ADD_ANC' || $temp[0] =='UDR_NCR_DEL' || $temp[0] =='UDR_ADDIPEND_HSS'
	|| $temp[0] == 'UDR_IPEND_CPWD'){
		$process = proc_open('java -jar SLTUdrGui.jar '.$args, $descriptorspec, $pipes);
	//logToFile('imslog.txt','java -jar SLTUdrGui.jar '.$args);
	}
	else{
		$process = proc_open('java -jar SLTIMSgui.jar '.$args, $descriptorspec, $pipes);	
	}

if (is_resource($process)) {
    // $pipes now looks like this:
    // 0 => writeable handle connected to child stdin
    // 1 => readable handle connected to child stdout
    // Any error output will be appended to /tmp/error-output.txt

    fwrite($pipes[0], '<?php print_r($_ENV); ?>');
    fclose($pipes[0]);

    $reply_data =  stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    // It is important that you close any pipes before calling
    // proc_close in order to avoid a deadlock
    $return_value = proc_close($process);
	logToFile('imslog.txt',$msg);
	echo $reply_data;
   // echo "command returned $return_value\n";
}


?>
