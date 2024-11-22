<?php
/*error_reporting(E_ERROR | E_PARSE);
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
	 ini_set('max_execution_time', 36000);
*/	 


$q =  $_GET["q"];
$r =  $_GET["r"];

function connecttooracle(){
	 $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )" ;
  
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


$CON = connecttooracle();

date_default_timezone_set('Asia/colombo');
$nowmonth = date("m");


if($r=='list' ){
	$sql = "select EQUP_LOCN_TTNAME,EQUP_INDEX,EQUP_EQUT_ABBREVIATION  from EQUIPMENT eq
where EQ.EQUP_IPADDRESS ='".$q."'";
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";
oci_fetch($stid);
  $result =  oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))."#".
  oci_result($stid,oci_field_name($stid, 3));					 
oci_free_statement($stid);
}

else if ($r=='mod' ){
	$sql = "SELECT E.EQUP_LOCN_TTNAME, E.EQUP_INDEX, E.EQUP_EQUT_ABBREVIATION, E.EQUP_IPADDRESS, SUBSTR(REPLACE(P.PORT_CARD_SLOT,'-',''),2,5)||SUBSTR(P.PORT_NAME,-2,2) AS TID
    , (SELECT NETINFO FROM OSSPRG.PSTN_SOURCE_CODE  WHERE PSTN_CODE =SUBSTR(C.CIRT_DISPLAYNAME,2,2)) AS AREA
FROM CIRCUITS C,PORT_LINKS PL,PORTS P ,PORT_LINK_PORTS PLP, EQUIPMENT E
WHERE   PL.PORL_ID = PLP.POLP_PORL_ID
AND PLP.POLP_PORT_ID = P.PORT_ID
  AND P.PORT_EQUP_ID = E.EQUP_ID
AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
AND PL.PORL_CIRT_NAME = PL.PORL_CIRT_NAME
AND PL.PORL_CIRT_NAME =  C.CIRT_NAME
AND C.CIRT_NAME = ( SELECT MAX( EC.CIRT_NAME)   FROM CIRCUITS EC WHERE 
EC.CIRT_STATUS IN ('INSERVICE','COMMISSIONED','SUSPENDED','PROPOSED')
and EC.CIRT_DISPLAYNAME like '".$q."%')";

/*
$sql = "            SELECT E.EQUP_LOCN_TTNAME, E.EQUP_INDEX, E.EQUP_EQUT_ABBREVIATION, E.EQUP_IPADDRESS, SUBSTR(REPLACE(P.PORT_CARD_SLOT,'-',''),2,5)||SUBSTR(P.PORT_NAME,-2,2) AS TID
    , (SELECT NETINFO FROM OSSPRG.PSTN_SOURCE_CODE  WHERE PSTN_CODE =SUBSTR(C.CIRT_DISPLAYNAME,2,2)) AS AREA
FROM CIRCUITS C,PORTS P ,EQUIPMENT E
WHERE   P.PORT_CIRT_NAME=  C.CIRT_NAME
  AND P.PORT_EQUP_ID = E.EQUP_ID
AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
AND C.CIRT_NAME = ( SELECT MAX( EC.CIRT_NAME)   FROM CIRCUITS EC WHERE 
EC.CIRT_STATUS IN ('INSERVICE','COMMISSIONED','SUSPENDED','PROPOSED')
and EC.CIRT_DISPLAYNAME like '".$q."%')";
 */

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";
oci_fetch($stid);
  $result =  oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))."#".
  oci_result($stid,oci_field_name($stid, 3))."#".oci_result($stid,oci_field_name($stid, 4))."#".oci_result($stid,oci_field_name($stid, 5))."#".oci_result($stid,oci_field_name($stid, 6));					 
oci_free_statement($stid);
}



else if ($r=='modlte' ){
	$sql = "SELECT C.CIRT_SERT_ABBREVIATION, SA.SATT_DEFAULTVALUE  ,SA1.SATT_DEFAULTVALUE XX
FROM SERVICES_ATTRIBUTES SA , CIRCUITS C,SERVICES_ATTRIBUTES SA1
WHERE  SA.SATT_ATTRIBUTE_NAME = 'IMSI NO'
AND SA.SATT_SERV_ID = C.CIRT_SERV_ID
AND C.CIRT_DISPLAYNAME LIKE   '".$q."%'
AND C.CIRT_STATUS IN ('INSERVICE','SUSPENDED')
AND  SA1.SATT_ATTRIBUTE_NAME = 'SA_IMS_PACKAGE'
AND SA1.SATT_SERV_ID = C.CIRT_SERV_ID";

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";
oci_fetch($stid);
  $result =  oci_result($stid,oci_field_name($stid, 1))."@".oci_result($stid,oci_field_name($stid, 2))."@".oci_result($stid,oci_field_name($stid, 3))."@1";					 
oci_free_statement($stid);
}


else if ($r=='crlte' ){
	$sql = "select case 
when SERO_SERT_ABBREVIATION = 'UPD_CIRCUIT'
then 'PSTN'
else SERO_SERT_ABBREVIATION
end as s_type , SO1.SEOA_DEFAULTVALUE  x, so2.SEOA_DEFAULTVALUE y
 from service_orders so , circuits c , SERVICE_ORDER_ATTRIBUTES so1 , SERVICE_ORDER_ATTRIBUTES so2
where SO.SERO_ORDT_TYPE LIKE 'CREATE%'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like '".$q."%'
and SO1.SEOA_SERO_ID = SO.SERO_ID
and SO1.SEOA_NAME = 'IMSI NO'
and SO2.SEOA_SERO_ID = SO.SERO_ID
and SO2.SEOA_NAME = 'MSISDN NO'";

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";
oci_fetch($stid);
  $result =  oci_result($stid,oci_field_name($stid, 1))."@".oci_result($stid,oci_field_name($stid, 2))."@".oci_result($stid,oci_field_name($stid, 3))."@1";					 
oci_free_statement($stid);
}


else if ($r=='feature' ){


$sql = "select CASE SOFE_FEATURE_NAME
WHEN 'SF_CLI_EXT'  THEN 'SF_CLI' ELSE SOFE_FEATURE_NAME  END SOFE_FEATURE_NAME
from SERVICE_ORDER_FEATURES a, service_orders b , circuits c
where A.SOFE_DEFAULTVALUE = 'Y'
AND    A.SOFE_SERO_ID = B.SERO_ID
and B.SERO_CIRT_NAME = C.CIRT_NAME
and B.SERO_ORDT_TYPE like 'CREATE%'
and B.SERO_STAS_ABBREVIATION not like 'C%'
and C.CIRT_DISPLAYNAME like '".$q."%'
AND  SOFE_FEATURE_NAME NOT IN ('SF_1314 SC ACCESS','SF_ANONYMOUS_CALL_BARRING',
'SF_BAR_INCOMING_CALL',
'SF_BAR_OUTGOING_CALL',
'SF_CENTREX',
'SF_GLOBAL_LINK',
'SF_INMARSAT',
'SF_MCT',
'SF_MCT_ALL_INCOMING',
'SF_SISU CONNECT',
'SF_SISU CONNECT SMS',
'SF_VOICE_MAIL')";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);
}

else if ($r=='nowfeature' ){


$sql = "select CASE SFEA_FEATURE_NAME
WHEN 'SF_CLI_EXT'  THEN 'SF_CLI' ELSE SFEA_FEATURE_NAME  END SFEA_FEATURE_NAME from SERVICES_FEATURES sf, circuits c
where C.CIRT_SERV_ID = SF.SFEA_SERV_ID
and C.CIRT_DISPLAYNAME = '".$q."'
and SF.SFEA_VALUE = 'Y'
and SF.SFEA_FEATURE_NAME not in ('SF_1314 SC ACCESS','SF_ANONYMOUS_CALL_BARRING',
'SF_BAR_INCOMING_CALL',
'SF_BAR_OUTGOING_CALL',
'SF_CENTREX',
'SF_GLOBAL_LINK',
'SF_INMARSAT',
'SF_MCT',
'SF_MCT_ALL_INCOMING',
'SF_SISU CONNECT',
'SF_SISU CONNECT SMS',
'SF_VOICE_MAIL')";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);
}


else if ($r=='delcheck' ){


$sql = "select SERO_ID from service_orders so , circuits c
where SO.SERO_ORDT_TYPE = 'DELETE'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like '".$q."%'";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@1";	
}
				 
oci_free_statement($stid);
}

else if ($r=='createcheck' ){

/*  -- edited on 19-01-2016---
$sql = "select SERO_SERT_ABBREVIATION from service_orders so , circuits c
where SO.SERO_ORDT_TYPE LIKE 'CREATE%'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and so.SERO_SERT_ABBREVIATION <>'UPD_CIRCUIT'
and C.CIRT_DISPLAYNAME like '".$q."%'";
*/

$sql = "select case 
when SERO_SERT_ABBREVIATION = 'UPD_CIRCUIT'
then 'PSTN'
else SERO_SERT_ABBREVIATION
end as s_type from service_orders so , circuits c
where SO.SERO_ORDT_TYPE LIKE 'CREATE%'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like '".$q."%'";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
// $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@1";	
 $result =  oci_result($stid,oci_field_name($stid, 1))."@1";	
}
				 
oci_free_statement($stid);
}


else if ($r=='createchecklte' ){

/*$sql = "select SERO_SERT_ABBREVIATION,SOA.SEOA_DEFAULTVALUE ,SOA1.SEOA_DEFAULTVALUE MSI
from service_orders so , circuits c, SERVICE_ORDER_ATTRIBUTES  soa, SERVICE_ORDER_ATTRIBUTES  soa1
where SO.SERO_ORDT_TYPE LIKE 'CREATE%'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like   '".$q."%'
and SOA.SEOA_SERO_ID = SO.SERO_ID
and SOA.SEOA_NAME = 'IMSI NO'
and SOA1.SEOA_SERO_ID = SO.SERO_ID
and SOA1.SEOA_NAME ='SA_IMS_PACKAGE'";*/
 
$sql= "select SERO_SERT_ABBREVIATION,SOA.SEOA_DEFAULTVALUE ,SOA1.SEOA_DEFAULTVALUE MSI,SOA2.SEOA_DEFAULTVALUE SIGNAL
from service_orders so , circuits c, SERVICE_ORDER_ATTRIBUTES  soa, SERVICE_ORDER_ATTRIBUTES  soa1, SERVICE_ORDER_ATTRIBUTES  soa2
where  (SO.SERO_ORDT_TYPE LIKE 'CREATE%' OR SO.SERO_ORDT_TYPE LIKE 'MODIFY%')
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like  '".$q."%'
and SOA.SEOA_SERO_ID = SO.SERO_ID
and SOA.SEOA_NAME = 'IMSI NO'
and SOA1.SEOA_SERO_ID = SO.SERO_ID
and SOA1.SEOA_NAME ='SA_IMS_PACKAGE'
and SOA2.SEOA_SERO_ID = SO.SERO_ID
and SOA2.SEOA_NAME ='LTE SIGNAL AVAILABILITY'";

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
// $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@1";	
  $result =  oci_result($stid,oci_field_name($stid, 1))."@".oci_result($stid,oci_field_name($stid, 2))."@".oci_result($stid,oci_field_name($stid, 3))."@".oci_result($stid,oci_field_name($stid, 4))."@1";		
}
				 
oci_free_statement($stid);
}


else if ($r=='delchecklte' ){

$sql = "select SERO_SERT_ABBREVIATION,SOA.SEOA_DEFAULTVALUE ,SOA1.SEOA_DEFAULTVALUE MSI
from service_orders so , circuits c, SERVICE_ORDER_ATTRIBUTES  soa, SERVICE_ORDER_ATTRIBUTES  soa1
where SO.SERO_ORDT_TYPE LIKE 'DELETE%'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like   '".$q."%'
and SOA.SEOA_SERO_ID = SO.SERO_ID
and SOA.SEOA_NAME = 'IMSI NO'
and SOA1.SEOA_SERO_ID = SO.SERO_ID
and SOA1.SEOA_NAME ='SA_IMS_PACKAGE'";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
// $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@1";	
  $result =  oci_result($stid,oci_field_name($stid, 1))."@".oci_result($stid,oci_field_name($stid, 2))."@".oci_result($stid,oci_field_name($stid, 3))."@1";		
}
				 
oci_free_statement($stid);
}

else if ($r=='modchecklte' ){

$sql = "select SERO_SERT_ABBREVIATION,SOA.SEOA_DEFAULTVALUE ,SOA1.SEOA_DEFAULTVALUE as XX
from service_orders so , circuits c, SERVICE_ORDER_ATTRIBUTES  soa, SERVICE_ORDER_ATTRIBUTES  soa1
where SO.SERO_ORDT_TYPE = 'MODIFY-FEATURE'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like   '".$q."%'
and SOA.SEOA_SERO_ID = SO.SERO_ID
and SOA.SEOA_NAME = 'IMSI NO'
and SOA1.SEOA_SERO_ID = SO.SERO_ID
and SOA1.SEOA_NAME ='SA_IMS_PACKAGE'";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
// $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@1";	
 $result =  oci_result($stid,oci_field_name($stid, 1))."@".oci_result($stid,oci_field_name($stid, 2))."@".oci_result($stid,oci_field_name($stid, 3))."@1";	
}
				 
oci_free_statement($stid);
}




else if ($r=='modfeature' ){


$sql = "select  CASE SOFE_FEATURE_NAME
WHEN 'SF_CLI_EXT'  THEN 'SF_CLI' ELSE SOFE_FEATURE_NAME  END SOFE_FEATURE_NAME , A.SOFE_DEFAULTVALUE , A.SOFE_PREV_VALUE
from SERVICE_ORDER_FEATURES a, service_orders b , circuits c
where   A.SOFE_SERO_ID = B.SERO_ID
and B.SERO_CIRT_NAME = C.CIRT_NAME
and B.SERO_ORDT_TYPE like 'MODIFY%'
and A.SOFE_DEFAULTVALUE <> nvl(A.SOFE_PREV_VALUE,'N')
and B.SERO_STAS_ABBREVIATION not like 'C%'
and C.CIRT_DISPLAYNAME like '".$q."%'
AND  SOFE_FEATURE_NAME NOT IN ('SF_1314 SC ACCESS','SF_ANONYMOUS_CALL_BARRING',
'SF_BAR_INCOMING_CALL',
'SF_BAR_OUTGOING_CALL',
'SF_CENTREX',
'SF_GLOBAL_LINK',
'SF_INMARSAT',
'SF_MCT',
'SF_MCT_ALL_INCOMING',
'SF_SISU CONNECT',
'SF_SISU CONNECT SMS',
'SF_VOICE_MAIL')";
 
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))
 ."#".oci_result($stid,oci_field_name($stid, 3))."@";	
}
				 
oci_free_statement($stid);
}



else if ($r=='listall' ){


$sql = "select distinct  EQ.EQUP_LOCN_TTNAME , EQ.EQUP_INDEX, PO.PORT_CARD_SLOT , c.CARD_NAME 
from PORTS po,  Equipment eq , cards c
where   PO.PORT_EQUP_ID = EQ.EQUP_ID
AND EQ.EQUP_EQUT_ABBREVIATION like '%MSAN%'
and C.CARD_EQUP_ID = EQ.EQUP_ID
and EQ.EQUP_IPADDRESS = '".$q."'
and PO.PORT_CARD_SLOT = C.CARD_SLOT
and (c.CARD_NAME like '%LINE%' or c.CARD_NAME like '%ASTGC+ATLDI%' or c.CARD_NAME    = 'APTGC')
order by c.CARD_NAME ";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))
 ."#".oci_result($stid,oci_field_name($stid, 3))."#".oci_result($stid,oci_field_name($stid, 4))."@";	
}
				 
oci_free_statement($stid);
}

else if ($r=='ippwd'){

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION['$usrid'];
	$ulevel = $_SESSION['$p_level'];
	if($user == '012585' || $user == '012583' || $user == '011681' || $user == '010563'|| $user == '004642'
	|| $user == '007820' || $user == '008124' || $user == '010021' || $user == '009944' || $user == '011283' 
	|| $user == '011287' || $user == '073049' 
|| $user == '007361' || $user == '007789' || $user == '007808' || $user == '008582' || $user == '010414'
|| $user == '010991' || $user == '011324' || $user == '011350' || $user == '011417' || $user == '012038'
|| $user == '012192' || $user == '012216' || $user == '014447'
|| $user == '010354' || $user == '011496' || $user == '011688' || $user == '007760'  	){
	
	}else {
	echo '<script type="text/javascript"> document.location = "main.php";</script>';
	}
}
else 
{     
    echo '<script type="text/javascript"> document.location = "login.html";</script>'; 
}

$msg = "user ".$user ." requested password for ".$q;
logToFile('pwdlog.txt',$msg);

$result = "";

$sql = "SELECT PWD  FROM IMS_VOICE_PASS
WHERE SERV_ID = (
SELECT B.CIRT_SERV_ID
FROM CIRCUITS  B
WHERE  B.CIRT_DISPLAYNAME = '".$q."'
AND B.CIRT_STATUS IN ('INSERVICE','COMMISSIONED','SUSPENDED','PROPOSED'))";


$stid = oci_parse($CON, $sql);
oci_execute($stid);
while(oci_fetch($stid)){
	$result = oci_result($stid,oci_field_name($stid, 1));
}

if($result == ""){

$sql = "SELECT A.SATT_DEFAULTVALUE
FROM SERVICES_ATTRIBUTES A,CIRCUITS  B
WHERE A.SATT_SERV_ID = B.CIRT_SERV_ID
AND B.CIRT_DISPLAYNAME = '".$q."'
AND B.CIRT_STATUS IN ('INSERVICE','COMMISSIONED','SUSPENDED','PROPOSED')
AND A.SATT_ATTRIBUTE_NAME = 'IP ENDPOINT ID'
UNION
SELECT SEOA_DEFAULTVALUE
FROM SERVICE_ORDER_ATTRIBUTES A ,SERVICE_ORDERS B , CIRCUITS C
WHERE SEOA_SERO_ID = SERO_ID 
AND B.SERO_CIRT_NAME = C.CIRT_NAME
AND C.CIRT_DISPLAYNAME LIKE '".$q."%'
AND B.SERO_SERT_ABBREVIATION = 'D-IP ENDPOINT'
AND B.SERO_ORDT_TYPE = 'CREATE'
AND B.SERO_STAS_ABBREVIATION NOT LIKE 'C%'
AND SEOA_NAME = 'IP ENDPOINT ID'
union
SELECT A.SATT_DEFAULTVALUE
FROM SERVICES_ATTRIBUTES A,CIRCUITS  B
WHERE A.SATT_SERV_ID = B.CIRT_SERV_ID
AND B.CIRT_DISPLAYNAME = '".$q."'
AND B.CIRT_SERT_ABBREVIATION = 'V-VOICE FTTH'
AND B.CIRT_STATUS IN ('INSERVICE','COMMISSIONED','SUSPENDED','PROPOSED')
AND A.SATT_ATTRIBUTE_NAME = 'REGISTRATION ID'
UNION
SELECT SEOA_DEFAULTVALUE
FROM SERVICE_ORDER_ATTRIBUTES A ,SERVICE_ORDERS B , CIRCUITS C
WHERE SEOA_SERO_ID = SERO_ID 
AND B.SERO_CIRT_NAME = C.CIRT_NAME
AND C.CIRT_DISPLAYNAME LIKE '".$q."%'
AND B.SERO_SERT_ABBREVIATION = 'V-VOICE FTTH'
AND B.SERO_ORDT_TYPE like 'CREATE%'
AND B.SERO_STAS_ABBREVIATION NOT LIKE 'C%'
AND SEOA_NAME = 'REGISTRATION ID'";

$result ="";
$stid = oci_parse($CON, $sql);
oci_execute($stid);
while(oci_fetch($stid)){
$result = oci_result($stid,oci_field_name($stid, 1));
}



$sql ="SELECT TRIM(TO_CHAR(SUBSTR('".$result ."',6,1)+1))
|| TO_CHAR(SUBSTR('".$result ."',8,1)+1)
|| TRIM(TO_CHAR(SUBSTR('".$result ."',-2,2)+9,'XXXXXXXX'))
|| TO_CHAR(NVL(SUBSTR('".$result ."',11,1),'0')+1)
|| TO_CHAR(SUBSTR('".$result ."',5,1)+1)
|| TO_CHAR(SUBSTR('".$result ."',9,1)+1)
|| TO_CHAR(SUBSTR('".$result ."',7,1)+1)
|| TO_CHAR(SUBSTR('".$result ."',4,1)+1)
|| TO_CHAR(SUBSTR('".$result ."',10,1)+1) 
FROM DUAL";


 $stid = oci_parse($CON, $sql);
oci_execute($stid);
while(oci_fetch($stid)){
$result = oci_result($stid,oci_field_name($stid, 1));
}

}

oci_free_statement($stid);

}



else if ($r=='getallpstn' ){

$s =  $_GET["s"];

$sql = "select distinct substr(replace(p.PORT_CARD_SLOT,'-',''),2,5)||substr(p.PORT_NAME,-2,2) as tid , C.CIRT_DISPLAYNAME , C.CIRT_STATUS
from circuits c,ports p , equipment e
where   P.PORT_CIRT_NAME = C.CIRT_NAME(+)
  and P.PORT_EQUP_ID = E.EQUP_ID
and e.EQUP_IPADDRESS = '".$q."'
and (C.CIRT_SERT_ABBREVIATION = 'V-VOICE COPPER'  or C.CIRT_SERT_ABBREVIATION like 'D%' or C.CIRT_SERT_ABBREVIATION = 'CCB')
and C.CIRT_STATUS IN ('INSERVICE','COMMISSIONED','SUSPENDED','PROPOSED')
and p.PORT_CARD_SLOT = '".$s."'
union
select distinct substr(replace(p.PORT_CARD_SLOT,'-',''),2,5)||substr(p.PORT_NAME,-2,2) as tid ,'',''
from ports p , equipment e
where  P.PORT_CIRT_NAME is null
  and P.PORT_EQUP_ID = E.EQUP_ID
and e.EQUP_IPADDRESS = '".$q."'
and p.PORT_CARD_SLOT = '".$s."'
and P.PORT_NAME like 'POTS-OUT%'
order by tid";
 

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))
 ."#".oci_result($stid,oci_field_name($stid, 3))."@";	
}
				 
oci_free_statement($stid);
}

else if($r=='ftthcreateso' ){

$s =  $_GET["q"];
	
	$sql = "SELECT  E.EQUP_LOCN_TTNAME, E.EQUP_INDEX, E.EQUP_EQUT_ABBREVIATION, E.EQUP_IPADDRESS, SUBSTR(REPLACE(P.PORT_CARD_SLOT,'-',''),2,5)||SUBSTR(P.PORT_NAME,-2,2) AS TID
    , (SELECT NETINFO FROM OSSPRG.PSTN_SOURCE_CODE  WHERE PSTN_CODE =SUBSTR(C.CIRT_DISPLAYNAME,2,2)) AS AREA,
(SELECT SOA.SEOA_DEFAULTVALUE OLT_MANUFACTURER 
FROM SERVICE_ORDER_ATTRIBUTES SOA   WHERE SOA.SEOA_SERO_ID = SO.SERO_ID AND SOA.SEOA_NAME ='OLT_MANUFACTURER') MSAN_TYPE ,
'1-1-'||to_number(replace(replace(substr(p.PORT_CARD_SLOT,-2,2),'-',''),'.',''))||'-'||to_number(replace(substr(p.PORT_NAME,1,instr(p.PORT_NAME,'-')-1),'-0','')) PORT,
to_number(replace(replace(substr(p.PORT_CARD_SLOT,-5,2),'-',''),'.',''))||'-'||to_number(replace(replace(substr(p.PORT_CARD_SLOT,-2,2),'-',''),'.',''))||'-'||to_number(substr(p.PORT_NAME,1,instr(p.PORT_NAME,'-')-1)) PORT2,
SUBSTR(P.PORT_CARD_SLOT,5,1)||'-'||SUBSTR(P.PORT_CARD_SLOT,3,1)||'-'||TO_NUMBER(SUBSTR(P.PORT_CARD_SLOT,7,2))||'-'||
TO_NUMBER(SUBSTR(P.PORT_NAME,1,instr(P.PORT_NAME,'-')-1 ) )||'-'||TO_NUMBER(SUBSTR(P.PORT_NAME,instr(P.PORT_NAME,'-')+1,3 ) ) PORT3,
TO_NUMBER(substr(p.PORT_NAME,instr(p.PORT_NAME,'-')+1,3)) V_PORT,
TRIM(REPLACE(EQUP_LOCN_TTNAME,'-NODE',' '))||'_'||TRIM(REPLACE(REPLACE(EQUP_EQUM_MODEL,'-ISL',' '),'(IPMB)',''))||'_'||SUBSTR(EQUP_INDEX,-2) DNAME
        FROM PORT_LINKS PL,PORTS P ,PORT_LINK_PORTS PLP, EQUIPMENT E ,SERVICE_ORDERS SO , CIRCUITS C
        WHERE  PL.PORL_CIRT_NAME = SO.SERO_CIRT_NAME
        AND PL.PORL_ID = PLP.POLP_PORL_ID
        AND PLP.POLP_PORT_ID = P.PORT_ID
        AND P.PORT_EQUP_ID = E.EQUP_ID
        AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
        AND  C.CIRT_DISPLAYNAME LIKE '$s%'
        AND SO.SERO_ORDT_TYPE LIKE 'CREATE%'
		AND SO.SERO_SERT_ABBREVIATION = 'V-VOICE FTTH'
        AND SO.SERO_CIRT_NAME = C.CIRT_NAME
        AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'";
		
	 $stid = oci_parse($CON, $sql);
	oci_execute($stid);
	$result ="";

	while(oci_fetch($stid)){
	 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))
	 ."#".oci_result($stid,oci_field_name($stid, 3))."#".oci_result($stid,oci_field_name($stid, 4))."#".oci_result($stid,oci_field_name($stid, 5))
	 ."#".oci_result($stid,oci_field_name($stid, 6))."#".oci_result($stid,oci_field_name($stid, 7))."#".oci_result($stid,oci_field_name($stid, 8))
	 ."#".oci_result($stid,oci_field_name($stid, 9))."#".oci_result($stid,oci_field_name($stid, 10))."#".oci_result($stid,oci_field_name($stid, 11))
	 ."#".oci_result($stid,oci_field_name($stid, 12));	
}
				 
oci_free_statement($stid);
}

else if($r=='ftthdeleteeso' ){

$s =  $_GET["q"];
	
	$sql = "SELECT  E.EQUP_LOCN_TTNAME, E.EQUP_INDEX, E.EQUP_EQUT_ABBREVIATION, E.EQUP_IPADDRESS, SUBSTR(REPLACE(P.PORT_CARD_SLOT,'-',''),2,5)||SUBSTR(P.PORT_NAME,-2,2) AS TID
    , (SELECT NETINFO FROM OSSPRG.PSTN_SOURCE_CODE  WHERE PSTN_CODE =SUBSTR(C.CIRT_DISPLAYNAME,2,2)) AS AREA
        FROM PORT_LINKS PL,PORTS P ,PORT_LINK_PORTS PLP, EQUIPMENT E ,SERVICE_ORDERS SO , CIRCUITS C
        WHERE  PL.PORL_CIRT_NAME = SO.SERO_CIRT_NAME
        AND PL.PORL_ID = PLP.POLP_PORL_ID
        AND PLP.POLP_PORT_ID = P.PORT_ID
        AND P.PORT_EQUP_ID = E.EQUP_ID
        AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
        AND  C.CIRT_DISPLAYNAME LIKE '$s%'
        AND SO.SERO_ORDT_TYPE LIKE 'DELETE%'
        AND SO.SERO_SERT_ABBREVIATION = 'V-VOICE FTTH'
        AND SO.SERO_CIRT_NAME = C.CIRT_NAME
        AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'";
		
	 $stid = oci_parse($CON, $sql);
	oci_execute($stid);
	$result ="";

	while(oci_fetch($stid)){
	 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))
	 ."#".oci_result($stid,oci_field_name($stid, 3))."#".oci_result($stid,oci_field_name($stid, 4))."#".oci_result($stid,oci_field_name($stid, 5))
	 ."#".oci_result($stid,oci_field_name($stid, 6));	
}
				 
oci_free_statement($stid);
}

else if($r=='ftthcreateadmin' ){

$s =  $_GET["q"];
	
	$sql = "SELECT  E.EQUP_LOCN_TTNAME, E.EQUP_INDEX, E.EQUP_EQUT_ABBREVIATION, E.EQUP_IPADDRESS, SUBSTR(REPLACE(P.PORT_CARD_SLOT,'-',''),2,5)||SUBSTR(P.PORT_NAME,-2,2) AS TID
    , (SELECT NETINFO FROM OSSPRG.PSTN_SOURCE_CODE  WHERE PSTN_CODE =SUBSTR(C.CIRT_DISPLAYNAME,2,2)) AS AREA,
(SELECT SOA.SEOA_DEFAULTVALUE OLT_MANUFACTURER 
FROM SERVICE_ORDER_ATTRIBUTES SOA   WHERE SOA.SEOA_SERO_ID = SO.SERO_ID AND SOA.SEOA_NAME ='OLT_MANUFACTURER') MSAN_TYPE ,
'1-1-'||to_number(replace(replace(substr(p.PORT_CARD_SLOT,-2,2),'-',''),'.',''))||'-'||to_number(replace(substr(p.PORT_NAME,1,instr(p.PORT_NAME,'-')-1),'-0','')) PORT,
to_number(replace(replace(substr(p.PORT_CARD_SLOT,-5,2),'-',''),'.',''))||'-'||to_number(replace(replace(substr(p.PORT_CARD_SLOT,-2,2),'-',''),'.',''))||'-'||to_number(substr(p.PORT_NAME,1,instr(p.PORT_NAME,'-')-1)) PORT2,
SUBSTR(P.PORT_CARD_SLOT,5,1)||'-'||SUBSTR(P.PORT_CARD_SLOT,3,1)||'-'||TO_NUMBER(SUBSTR(P.PORT_CARD_SLOT,7,2))||'-'||
TO_NUMBER(SUBSTR(P.PORT_NAME,1,instr(P.PORT_NAME,'-')-1 ) )||'-'||TO_NUMBER(SUBSTR(P.PORT_NAME,instr(P.PORT_NAME,'-')+1,3 ) ) PORT3,
TO_NUMBER(substr(p.PORT_NAME,instr(p.PORT_NAME,'-')+1,3)) V_PORT,
TRIM(REPLACE(EQUP_LOCN_TTNAME,'-NODE',' '))||'_'||TRIM(REPLACE(REPLACE(EQUP_EQUM_MODEL,'-ISL',' '),'(IPMB)',''))||'_'||SUBSTR(EQUP_INDEX,-2) DNAME
        FROM PORT_LINKS PL,PORTS P ,PORT_LINK_PORTS PLP, EQUIPMENT E ,SERVICE_ORDERS SO , CIRCUITS C
        WHERE  PL.PORL_CIRT_NAME = SO.SERO_CIRT_NAME
        AND PL.PORL_ID = PLP.POLP_PORL_ID
        AND PLP.POLP_PORT_ID = P.PORT_ID
        AND P.PORT_EQUP_ID = E.EQUP_ID
        AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
        AND  C.CIRT_DISPLAYNAME LIKE '$s%'
        AND (SO.SERO_ORDT_TYPE LIKE 'CREATE%' OR SO.SERO_ORDT_TYPE LIKE 'MODIFY%')
		AND SO.SERO_SERT_ABBREVIATION = 'V-VOICE FTTH'
        AND SO.SERO_CIRT_NAME = C.CIRT_NAME
        AND SO.SERO_STAS_ABBREVIATION NOT LIKE 'C%'
		UNION
		SELECT  E.EQUP_LOCN_TTNAME, E.EQUP_INDEX, E.EQUP_EQUT_ABBREVIATION, E.EQUP_IPADDRESS, SUBSTR(REPLACE(P.PORT_CARD_SLOT,'-',''),2,5)||SUBSTR(P.PORT_NAME,-2,2) AS TID
    , (SELECT NETINFO FROM OSSPRG.PSTN_SOURCE_CODE  WHERE PSTN_CODE =SUBSTR(C.CIRT_DISPLAYNAME,2,2)) AS AREA,
(SELECT SOA.SATT_DEFAULTVALUE OLT_MANUFACTURER 
FROM SERVICES_ATTRIBUTES SOA   WHERE SOA.SATT_SERV_ID = c.CIRT_SERV_ID AND SOA.SATT_ATTRIBUTE_NAME ='OLT_MANUFACTURER') MSAN_TYPE ,
'1-1-'||to_number(replace(replace(substr(p.PORT_CARD_SLOT,-2,2),'-',''),'.',''))||'-'||to_number(replace(substr(p.PORT_NAME,1,instr(p.PORT_NAME,'-')-1),'-0','')) PORT,
to_number(replace(replace(substr(p.PORT_CARD_SLOT,-5,2),'-',''),'.',''))||'-'||to_number(replace(replace(substr(p.PORT_CARD_SLOT,-2,2),'-',''),'.',''))||'-'||to_number(substr(p.PORT_NAME,1,instr(p.PORT_NAME,'-')-1)) PORT2,
SUBSTR(P.PORT_CARD_SLOT,5,1)||'-'||SUBSTR(P.PORT_CARD_SLOT,3,1)||'-'||TO_NUMBER(SUBSTR(P.PORT_CARD_SLOT,7,2))||'-'||
TO_NUMBER(SUBSTR(P.PORT_NAME,1,instr(P.PORT_NAME,'-')-1 ) )||'-'||TO_NUMBER(SUBSTR(P.PORT_NAME,instr(P.PORT_NAME,'-')+1,3 ) ) PORT3,
TO_NUMBER(substr(p.PORT_NAME,instr(p.PORT_NAME,'-')+1,3)) V_PORT,
TRIM(REPLACE(EQUP_LOCN_TTNAME,'-NODE',' '))||'_'||TRIM(REPLACE(REPLACE(EQUP_EQUM_MODEL,'-ISL',' '),'(IPMB)',''))||'_'||SUBSTR(EQUP_INDEX,-2) DNAME
        FROM PORT_LINKS PL,PORTS P ,PORT_LINK_PORTS PLP, EQUIPMENT E , CIRCUITS C
        WHERE  PL.PORL_CIRT_NAME = C.CIRT_NAME
        AND PL.PORL_ID = PLP.POLP_PORL_ID
        AND PLP.POLP_PORT_ID = P.PORT_ID
        AND P.PORT_EQUP_ID = E.EQUP_ID
        AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
        AND  C.CIRT_DISPLAYNAME LIKE '$s%'
		AND C.CIRT_STATUS = 'INSERVICE'
		AND C.CIRT_SERT_ABBREVIATION = 'V-VOICE FTTH'";
		
	 $stid = oci_parse($CON, $sql);
	oci_execute($stid);
	$result ="";

	while(oci_fetch($stid)){
	 $result =  $result.oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))
	 ."#".oci_result($stid,oci_field_name($stid, 3))."#".oci_result($stid,oci_field_name($stid, 4))."#".oci_result($stid,oci_field_name($stid, 5))
	 ."#".oci_result($stid,oci_field_name($stid, 6))."#".oci_result($stid,oci_field_name($stid, 7))."#".oci_result($stid,oci_field_name($stid, 8))
	 ."#".oci_result($stid,oci_field_name($stid, 9))."#".oci_result($stid,oci_field_name($stid, 10))."#".oci_result($stid,oci_field_name($stid, 11))
	 ."#".oci_result($stid,oci_field_name($stid, 12));	
}
				 
oci_free_statement($stid);
}



else if ($r=='ltecheckadmin' ){


$sql= "select SERO_SERT_ABBREVIATION,SOA.SEOA_DEFAULTVALUE ,SOA1.SEOA_DEFAULTVALUE MSI,SOA2.SEOA_DEFAULTVALUE SIGNAL
from service_orders so , circuits c, SERVICE_ORDER_ATTRIBUTES  soa, SERVICE_ORDER_ATTRIBUTES  soa1, SERVICE_ORDER_ATTRIBUTES  soa2
where SO.SERO_ORDT_TYPE LIKE 'CREATE%'
and SO.SERO_STAS_ABBREVIATION not like 'C%'
and SO.SERO_CIRT_NAME = C.CIRT_NAME
and C.CIRT_DISPLAYNAME like  '".$q."%'
and SOA.SEOA_SERO_ID = SO.SERO_ID
and SOA.SEOA_NAME = 'IMSI NO'
and SOA1.SEOA_SERO_ID = SO.SERO_ID
and SOA1.SEOA_NAME ='SA_IMS_PACKAGE'
and SOA2.SEOA_SERO_ID = SO.SERO_ID
and SOA2.SEOA_NAME ='LTE SIGNAL AVAILABILITY'
UNION
select CIRT_SERT_ABBREVIATION ,SOA.SATT_DEFAULTVALUE ,SOA1.SATT_DEFAULTVALUE MSI,SOA2.SATT_DEFAULTVALUE SIGNAL
from  circuits c, SERVICES_ATTRIBUTES  soa, SERVICES_ATTRIBUTES  soa1, SERVICES_ATTRIBUTES  soa2
where  C.CIRT_DISPLAYNAME like  '".$q."%'
and SOA.SATT_SERV_ID = CIRT_SERV_ID
and SOA.SATT_ATTRIBUTE_NAME = 'IMSI NO'
and SOA1.SATT_SERV_ID = CIRT_SERV_ID
and SOA1.SATT_ATTRIBUTE_NAME ='SA_IMS_PACKAGE'
and SOA2.SATT_SERV_ID = CIRT_SERV_ID
and SOA2.SATT_ATTRIBUTE_NAME ='LTE SIGNAL AVAILABILITY'";

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result ="";

while(oci_fetch($stid)){
// $result =  $result.oci_result($stid,oci_field_name($stid, 1))."@1";	
  $result =  oci_result($stid,oci_field_name($stid, 1))."@".oci_result($stid,oci_field_name($stid, 2))."@".oci_result($stid,oci_field_name($stid, 3))."@".oci_result($stid,oci_field_name($stid, 4))."@1";		
}
				 
oci_free_statement($stid);
}

echo $result;

?>
