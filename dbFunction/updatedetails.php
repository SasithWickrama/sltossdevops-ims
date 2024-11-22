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


$q =  $_GET["q"];
$r =  $_GET["r"];
$r =  $_GET["r"];

function connecttooracle(){
	 $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )" ;
  
    if($c = oci_connect("ossprg", "prgoss456", $db))
    {
		return $c;
    }
    else
    {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}


$CON = connecttooracle();

date_default_timezone_set('Asia/colombo');
$nowmonth = date("m");

$temp = explode('|',$q);

if($r=='updateolt' ){

logToFile('imslog.txt','User :'.$user.' change '.$temp[0].' OLT to '.$temp[1]);
	
	$sql = "UPDATE   SERVICES_ATTRIBUTES SET SATT_DEFAULTVALUE = '".$temp[1]."'
WHERE SATT_ATTRIBUTE_NAME = 'OLT_MANUFACTURER' 
AND SATT_SERV_ID IN (
	SELECT DISTINCT A.CIRT_SERV_ID
	FROM CIRCUITS A ,CIRCUITS F, SERVICES_ATTRIBUTES g , services X ,services Y
	WHERE A.CIRT_CUSR_ABBREVIATION = f.CIRT_CUSR_ABBREVIATION
	AND A.CIRT_ACCT_NUMBER = F.CIRT_ACCT_NUMBER
	AND F.CIRT_DISPLAYNAME = '".$temp[0]."'
	AND A.CIRT_SERT_ABBREVIATION IN ('V-VOICE FTTH','E-IPTV FTTH','BB-INTERNET FTTH', 'AB-FTTH')
	and A.CIRT_SERV_ID = g.SATT_SERV_ID
	and G.SATT_ATTRIBUTE_NAME = 'REGISTRATION ID'
	and G.SATT_DEFAULTVALUE =  F.CIRT_DISPLAYNAME 
	and A.CIRT_SERV_ID = X.SERV_ID
	and F.CIRT_SERV_ID = Y.SERV_ID
	and X.SERV_AREA_CODE = Y.SERV_AREA_CODE 
	AND A.CIRT_STATUS in ('INSERVICE','SUSPENDED')
)";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result ="";
$result = oci_execute($stid);

	$sql1 = "SELECT SERO_ID FROM SERVICE_ORDERS X  WHERE X.SERO_OEID LIKE (
	SELECT SUBSTR(SERO_OEID ,0,INSTR(SERO_OEID , '_')-1)||'%' SERO_OEID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	and so.SERO_OEID is not null
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%')
	union
		SELECT SERO_ID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	and  so.SERO_SERT_ABBREVIATION ='UPD_CIRCUIT'
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'";

	$stid1 = oci_parse($CON, $sql1);
	oci_execute($stid1);
	$result ="";

	while(oci_fetch($stid1)){
	
			$sql = "UPDATE SERVICE_ORDER_ATTRIBUTES SOA    SET SOA.SEOA_DEFAULTVALUE = '".$temp[1]."' 
		WHERE  SOA.SEOA_NAME ='OLT_MANUFACTURER'
		and SOA.SEOA_SERO_ID = '".oci_result($stid1,oci_field_name($stid1, 1))."' ";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result = oci_execute($stid);
	}
	
	
	/*$sql = "UPDATE SERVICE_ORDER_ATTRIBUTES SOA    SET SOA.SEOA_DEFAULTVALUE = '".$temp[1]."' 
WHERE  SOA.SEOA_NAME ='OLT_MANUFACTURER'
and SOA.SEOA_SERO_ID in (SELECT SERO_ID FROM SERVICE_ORDERS X  WHERE X.SERO_OEID LIKE (
	SELECT SUBSTR(SERO_OEID ,0,INSTR(SERO_OEID , '_')-1)||'%' SERO_OEID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'))";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result ="";
$result = oci_execute($stid);*/

			 
oci_free_statement($stid);
}

/*

if($r=='updatesig' ){

logToFile('imslog.txt','User :'.$user.' change '.$temp[0].' LTE SIGNAL AVAILABILITY to '.$temp[1]);
	
	$sql = "UPDATE   SERVICES_ATTRIBUTES SET SATT_DEFAULTVALUE = '".$temp[1]."'
WHERE SATT_ATTRIBUTE_NAME = 'OLT_MANUFACTURER' 
AND SATT_SERV_ID IN (
	SELECT DISTINCT A.CIRT_SERV_ID
	FROM CIRCUITS A ,CIRCUITS F, SERVICES_ATTRIBUTES g , services X ,services Y
	WHERE A.CIRT_CUSR_ABBREVIATION = f.CIRT_CUSR_ABBREVIATION
	AND A.CIRT_ACCT_NUMBER = F.CIRT_ACCT_NUMBER
	AND F.CIRT_DISPLAYNAME = '".$temp[0]."'
	AND A.CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET', 'AB-WIRELESS ACCESS')
	and A.CIRT_SERV_ID = g.SATT_SERV_ID
	and G.SATT_ATTRIBUTE_NAME = 'LTE SIGNAL AVAILABILITY'
	and G.SATT_DEFAULTVALUE =  F.CIRT_DISPLAYNAME 
	and A.CIRT_SERV_ID = X.SERV_ID
	and F.CIRT_SERV_ID = Y.SERV_ID
	and X.SERV_AREA_CODE = Y.SERV_AREA_CODE 
	AND A.CIRT_STATUS in ('INSERVICE','SUSPENDED')
)";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result ="";
$result = oci_execute($stid);

	$sql1 = "SELECT SERO_ID FROM SERVICE_ORDERS X  WHERE X.SERO_OEID LIKE (
	SELECT SUBSTR(SERO_OEID ,0,INSTR(SERO_OEID , '_')-1)||'%' SERO_OEID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	and so.SERO_OEID is not null
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%')
	union
		SELECT SERO_ID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	and  so.SERO_SERT_ABBREVIATION ='UPD_CIRCUIT'
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'";

	$stid1 = oci_parse($CON, $sql1);
	oci_execute($stid1);
	$result ="";

	while(oci_fetch($stid1)){
	
			$sql = "UPDATE SERVICE_ORDER_ATTRIBUTES SOA    SET SOA.SEOA_DEFAULTVALUE = '".$temp[1]."' 
		WHERE  SOA.SEOA_NAME ='LTE SIGNAL AVAILABILITY'
		and SOA.SEOA_SERO_ID = '".oci_result($stid1,oci_field_name($stid1, 1))."' ";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result = oci_execute($stid);
	}
	


			 
oci_free_statement($stid);
}

*/

if($r=='portchage' ){
$q =  $_GET["q"];


 
$sql = 'BEGIN CHANGE_IMS_FTTH_PORT(:name, :message); END;';

 $stmt = oci_parse($CON,$sql);
oci_bind_by_name($stmt,':name',$name,32);
oci_bind_by_name($stmt,':message',$message,100);
 $name = $q;
 oci_execute($stmt);
$result = $message;
}



if($r=='updateport' ){

logToFile('imslog.txt','User :'.$user.' change '.$temp[0].' port to '.$temp[1]);
	
	$sql = "UPDATE   SERVICES_ATTRIBUTES SET SATT_DEFAULTVALUE = '".$temp[1]."'
WHERE SATT_ATTRIBUTE_NAME = 'OLT_MANUFACTURER' 
AND SATT_SERV_ID IN (
	SELECT DISTINCT A.CIRT_SERV_ID
	FROM CIRCUITS A ,CIRCUITS F, SERVICES_ATTRIBUTES g , services X ,services Y
	WHERE A.CIRT_CUSR_ABBREVIATION = f.CIRT_CUSR_ABBREVIATION
	AND A.CIRT_ACCT_NUMBER = F.CIRT_ACCT_NUMBER
	AND F.CIRT_DISPLAYNAME = '".$temp[0]."'
	AND A.CIRT_SERT_ABBREVIATION IN ('V-VOICE FTTH','E-IPTV FTTH','BB-INTERNET FTTH', 'AB-FTTH')
	and A.CIRT_SERV_ID = g.SATT_SERV_ID
	and G.SATT_ATTRIBUTE_NAME = 'REGISTRATION ID'
	and G.SATT_DEFAULTVALUE =  F.CIRT_DISPLAYNAME 
	and A.CIRT_SERV_ID = X.SERV_ID
	and F.CIRT_SERV_ID = Y.SERV_ID
	and X.SERV_AREA_CODE = Y.SERV_AREA_CODE 
	AND A.CIRT_STATUS in ('INSERVICE','SUSPENDED')
)";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result ="";
$result = oci_execute($stid);

	$sql1 = "SELECT SERO_ID FROM SERVICE_ORDERS X  WHERE X.SERO_OEID LIKE (
	SELECT SUBSTR(SERO_OEID ,0,INSTR(SERO_OEID , '_')-1)||'%' SERO_OEID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	and so.SERO_OEID is not null
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%')
	union
		SELECT SERO_ID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	and  so.SERO_SERT_ABBREVIATION ='UPD_CIRCUIT'
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'";

	$stid1 = oci_parse($CON, $sql1);
	oci_execute($stid1);
	$result ="";

	while(oci_fetch($stid1)){
	
			$sql = "UPDATE SERVICE_ORDER_ATTRIBUTES SOA    SET SOA.SEOA_DEFAULTVALUE = '".$temp[1]."' 
		WHERE  SOA.SEOA_NAME ='OLT_MANUFACTURER'
		and SOA.SEOA_SERO_ID = '".oci_result($stid1,oci_field_name($stid1, 1))."' ";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result = oci_execute($stid);
	}
	
	
	/*$sql = "UPDATE SERVICE_ORDER_ATTRIBUTES SOA    SET SOA.SEOA_DEFAULTVALUE = '".$temp[1]."' 
WHERE  SOA.SEOA_NAME ='OLT_MANUFACTURER'
and SOA.SEOA_SERO_ID in (SELECT SERO_ID FROM SERVICE_ORDERS X  WHERE X.SERO_OEID LIKE (
	SELECT SUBSTR(SERO_OEID ,0,INSTR(SERO_OEID , '_')-1)||'%' SERO_OEID  FROM SERVICE_ORDERS SO , CIRCUITS A
	WHERE SO.SERO_CIRT_NAME = A.CIRT_NAME
	AND A.CIRT_DISPLAYNAME like '".$temp[0]."%'
	AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'))";

//logToFile('imslog.txt',$sql);
	
$stid = oci_parse($CON, $sql);
$result ="";
$result = oci_execute($stid);*/

			 
oci_free_statement($stid);
}
echo $result;

?>
