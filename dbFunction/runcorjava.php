
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

$temp = explode('*',$r);
$args = '';

$msg = 'User : '.$user.'-'.$uname.' Number '.$temp[3].' Status Changed  '.$temp[4];  

for($i =0;$i < count($temp); $i++){
	$args = $args.$temp[$i].' ';
}



$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("file", "error-output1.txt", "a") // stderr is a file to write to
);

$cwd = ''; 

$env =  array('some_option' => 'aeiou');

//echo 'java -jar SLTIMSgui.jar '.$args;

$process = proc_open('java -jar Ebanline.jar '.$args, $descriptorspec, $pipes);


if (is_resource($process)) {
    // $pipes now looks like this:
    // 0 => writeable handle connected to child stdin
    // 1 => readable handle connected to child stdout
    // Any error output will be appended to /tmp/error-output.txt

    fwrite($pipes[0], '<?php print_r($_ENV); ?>');
    fclose($pipes[0]);

    $reply_data =  stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $return_value = proc_close($process);
	logToFile('corlog.txt',$msg);
	echo $reply_data;
}


?>
