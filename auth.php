<?php
session_start();
include('dbFunction/log.php');
function connecttooracle(){
	 $db = "  (DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
" ;
  
    if($c = oci_connect("OSSRPT", "ossrpt123", $db))
    {
		return $c;
    }
    else
    {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}

$uname = $_POST['txtUsername']."@intranet.slt.com.lk";
$pwd = $_POST['txtPassword'];
$user_name =$_POST['txtUsername'];


$_SESSION['$usrid']= $_POST['txtUsername'];

$link = ldap_connect( 'intranet.slt.com.lk' );
if( ! $link )
{
	echo"Cant Connect to Server";
}
ldap_set_option($link, LDAP_OPT_REFERRALS, 0); 
ldap_set_option( $link, LDAP_OPT_PROTOCOL_VERSION, 3 ); 
if (  ldap_bind( $link, $uname, $pwd ) )
{
	    $ldap_base_dn = 'DC=intranet,DC=slt,DC=com,DC=lk';
	$filter = '(sAMAccountName='.$user_name.')';
    $attributes = array("name", "telephonenumber", "mail", "samaccountname","thumbnailphoto","sn");
    $result = ldap_search($link, $ldap_base_dn, $filter, $attributes);
	
	if (FALSE !== $result){
		
		
		
		$entries = ldap_get_entries($link, $result);
		 for ($x=0; $x<$entries['count']; $x++){
			 
			  //img
			$ldap_img = "";
  
 if (!empty($entries[$x]['thumbnailphoto'][0])) {
	$ldap_img = $entries[$x]["thumbnailphoto"][0];
 
	
 } 
			 
	$_SESSION['ldap_img']= $ldap_img;
		
		}
		 	 
	}
	
	
	
	$CON = connecttooracle();
	$sql = "select USER_ID,NAME,GRANT_LEVEL,AREA ,IPEND ,SRS ,COR ,CALL_CENTER ,CRBT , NMS ,ONEG ,CENTRIX from IMS_LOGIN  where USER_ID ='".$_POST['txtUsername']."'";
	//echo $sql;
	$userid = oci_parse($CON, $sql);
	oci_execute($userid);
	$row= oci_fetch_array($userid);
   	 if($row[0] == $_POST['txtUsername'] && !empty($_POST['txtPassword']))
	 {
	 $_SESSION['$usrname']= $row[1];
	 $_SESSION['$p_level']= $row[2];
	 $_SESSION['$area']= $row[3];
	 $_SESSION['$ipend']= $row[4];
	 $_SESSION['$srs']= $row[5];
	 $_SESSION['$cor']= $row[6];
	 $_SESSION['$cc']= $row[7];
	 $_SESSION['$crbt']= $row[8];
	 $_SESSION['$nms']= $row[9];
	 $_SESSION['$oneg']= $row[10];
	 $_SESSION['$centrix']= $row[11];
	 $_SESSION['loggedin'] = true;
	// logToFile('imslog.txt','Logged User : '.$_POST['txtUsername'].'-'.$row[1]);

	if($row[2] != "100"){
		if($row[7] == "Y"){
			echo '<script type="text/javascript"> document.location = "cc/act_feature.php";</script>';
		}else{
		  echo '<script type="text/javascript"> document.location = "main";</script>';
		 }
	 }else{
		echo '<script type="text/javascript"> document.location = "main";</script>';
	 }
	  
	  }
	  else
	  {
		echo "<script type='text/javascript'>alert('Not Authorize for this Site')</script>";
		echo '<script type="text/javascript"> document.location = "login.html";</script>';
	  }
}else{
		echo "<script type='text/javascript'>alert('Invalid User Name or Password')</script>";
		echo '<script type="text/javascript"> document.location = "login.html";</script>';
}


?>