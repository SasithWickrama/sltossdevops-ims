<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $userid = $_SESSION['$usrid'];
	$uname = $_SESSION['$usrname'];
	$ulevel = $_SESSION['$p_level'];
}
else 
{     
    echo '<script type="text/javascript"> document.location = "login.html";</script>'; 
}

function logToFile($filename, $msg)
{
    // open file
    $fd = fopen("oneGLog/".$filename, "a");
    // append date/time to message
    date_default_timezone_set("Asia/Colombo");
    $str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $msg;
    // write string
    fwrite($fd, $str . "\n");
    // close file
    fclose($fd);
}




$q =  $_GET["q"];
$r =  $_GET["r"];

$connstring = '(DESCRIPTION =
(ADDRESS_LIST =
(ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
)
(CONNECT_DATA = (SID=clty))
)';
$user = 'OSSRPT';
$pass = 'ossrpt123';

try {
    $conn = new PDO("oci:dbname=" . $connstring, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
    echo $error;
}

date_default_timezone_set('Asia/colombo');
$nowmonth = date("m");


if ($r == 'getpe') {
    $sql = "SELECT * FROM ONEG_PE_DETAILS";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();
}

if ($r == 'getpewithid') {
    $sql = "SELECT * FROM ONEG_PE_DETAILS WHERE PE_NO = '$q' ";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();
}

if ($r == 'getolddata') {
    $sql = "SELECT * FROM ONEG_OLDCCT_DETAILS WHERE PE_NO = '$q' AND ONT_SN IS NOT NULL  ORDER BY HUAWEI_PORT , V_PORT";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();
}

if ($r == 'getnewdata') {
    $sql = "SELECT * FROM ONEG_NEWCCT_DETAILS WHERE PE_NO = '$q' AND ONT_SN IS NOT NULL  ORDER BY HUAWEI_PORT , V_PORT";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();
}

if ($r == 'getsummary') {
    $sql = "SELECT  b.REGID , b.MSAN_TYPE , b.ZTE_PORT , b.HUAWEI_PORT , b.NOKIA_PORT , b.V_PORT,
    a.MSAN_TYPE MSAN_TYPE_1 , a.ZTE_PORT  ZTE_PORT_1, a.HUAWEI_PORT HUAWEI_PORT_1 , a.NOKIA_PORT NOKIA_PORT_1 
    , a.V_PORT V_PORT_1, a.CCT_STATUS , a.CCT_MESSAGE 
      FROM ONEG_OLDCCT_DETAILS B,ONEG_NEWCCT_DETAILS A WHERE B.REGID = A.REGID AND B.PE_NO = '$q' ORDER BY B.HUAWEI_PORT , B.V_PORT ";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();
}


if ($r == 'deldataconfirm') {
    $sql = "UPDATE ONEG_PE_DETAILS SET PE_STATUS = 1  WHERE PE_NO = '$q' ";

    $statment = $conn->prepare($sql);
    $results = $statment->execute();
    $statment->closeCursor();

    $file = $q."_log.txt";
    logToFile($file,"$userid - $uname CONFIRM DATA FOR DELETE ");
}

// if ($r == 'deletego') {
//     $sql = "UPDATE ONEG_PE_DETAILS SET PE_STATUS = 2  WHERE PE_NO = '$q' ";

//     $statment = $conn->prepare($sql);
//     $results = $statment->execute();
//     $statment->closeCursor();

//     $file = $q."_log.txt";
//     logToFile($file,"$userid - $uname PROCEED FOR DELETE ");
// }


// if ($r == 'deletefinish') {
//     $sql = "UPDATE ONEG_PE_DETAILS SET PE_STATUS = 5  WHERE PE_NO = '$q' ";

//     $statment = $conn->prepare($sql);
//     $statment->execute();
//     $results = $statment->fetchAll();
//     $statment->closeCursor();

//     $file = $q."_log.txt";
//     logToFile($file,"$userid - $uname CONFIRM DATA DELETETION ");
// }


if ($r == 'crdataconfirm') {
    $sql = "UPDATE ONEG_PE_DETAILS SET PE_STATUS = 6  WHERE PE_NO = '$q' ";

    $statment = $conn->prepare($sql);
    $results = $statment->execute();
    $statment->closeCursor();

    $file = $q."_log.txt";
    logToFile($file,"$userid - $uname CONFIRM DATA FOR CREATE ");
}


if ($r == 'compleate') {
    $sql = "UPDATE ONEG_PE_DETAILS SET PE_STATUS = 9  WHERE PE_NO = '$q' ";

    $statment = $conn->prepare($sql);
    $results = $statment->execute();
    $statment->closeCursor();

    $file = $q."_log.txt";
    logToFile($file,"$userid - $uname CONFIRM DATA TRANSFER IS OK ");
}

// if ($r == 'creatego') {
//     $sql = "UPDATE ONEG_PE_DETAILS SET PE_STATUS = 7  WHERE PE_NO = '$q' ";

//     $statment = $conn->prepare($sql);
//     $results = $statment->execute();
//     $statment->closeCursor();

//     $file = $q."_log.txt";
//     logToFile($file,"$userid - $uname PROCEED FOR CREATE ");
// }


if ($r == 'transfer') {
    $sql = "UPDATE ONEG_PE_DETAILS SET PE_STATUS = 7  WHERE PE_NO = '$q' ";

    $statment = $conn->prepare($sql);
    $results = $statment->execute();
    $statment->closeCursor();

    $file = $q."_log.txt";
    logToFile($file,"$userid - $uname PROCEED FOR TRANSFER");
}



if ($r == 'refreshnumber') {
    $sql = "SELECT * FROM ONEG_OLDCCT_DETAILS WHERE REC_ID = $q";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();

    $file = $results[0]['PE_NO']."_log.txt";
    logToFile($file,"$userid - $uname Refresh Old Details for ".$results[0]['VOICE_NO']);

    $sql = "SELECT (SELECT     REPLACE (SUBSTR (SATT_DEFAULTVALUE, 1, 8),
    '48575443',
    'HWTC')
|| SUBSTR (SATT_DEFAULTVALUE, 9)
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'ONT SERIAL NUMBER'
AND SATT_DEFAULTVALUE IS NOT NULL
AND ROWNUM = 1) AS ONT_SN,
(SELECT SATT_DEFAULTVALUE
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'FTTH_IPTV_2')
AS ZTE_PROFILE,
(SELECT SOA.SATT_DEFAULTVALUE     OLT_MANUFACTURER
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'OLT_MANUFACTURER')
MSAN_TYPE,
'1-1-'
|| TO_NUMBER (
REPLACE (REPLACE (SUBSTR (P.PORT_CARD_SLOT, -2, 2), '-', ''),
'.',
''))
|| '-'
|| TO_NUMBER (
REPLACE (SUBSTR (P.PORT_NAME, 1, INSTR (P.PORT_NAME, '-') - 1),
'-0',
''))
ZTE_PORT,
TO_NUMBER (
REPLACE (REPLACE (SUBSTR (P.PORT_CARD_SLOT, -5, 2), '-', ''),
'.',
''))
|| '-'
|| TO_NUMBER (
REPLACE (REPLACE (SUBSTR (P.PORT_CARD_SLOT, -2, 2), '-', ''),
'.',
''))
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_NAME, 1, INSTR (P.PORT_NAME, '-') - 1))
HUAWEI_PORT,
SUBSTR (P.PORT_CARD_SLOT, 5, 1)
|| '-'
|| SUBSTR (P.PORT_CARD_SLOT, 3, 1)
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_CARD_SLOT, 7, 2))
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_NAME, 1, INSTR (P.PORT_NAME, '-') - 1))
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_NAME, INSTR (P.PORT_NAME, '-') + 1, 3))
NOKIA_PORT,
TO_NUMBER (SUBSTR (P.PORT_NAME, INSTR (P.PORT_NAME, '-') + 1, 3))
V_PORT,
TRIM (REPLACE (EQUP_LOCN_TTNAME, '-NODE', ' '))
|| '_'
|| TRIM (
REPLACE (REPLACE (EQUP_EQUM_MODEL, '-ISL', ' '), '(IPMB)', ''))
|| '_'
|| SUBSTR (EQUP_INDEX, -2)
DNAME,
E.EQUP_IPADDRESS,
(SELECT SATT_DEFAULTVALUE
FROM CIRCUITS X, CIRCUIT_HIERARCHY, SERVICES_ATTRIBUTES SOA
WHERE     CIRH_CHILD = X.CIRT_NAME
AND SOA.SATT_SERV_ID = X.CIRT_SERV_ID
AND CIRT_SERT_ABBREVIATION = 'BB-INTERNET FTTH'
AND SOA.SATT_ATTRIBUTE_NAME = 'BB CIRCUIT ID'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 1)
BB_CIRCUIT,
(SELECT COUNT (DISTINCT REPLACE (X.CIRT_DISPLAYNAME, '(N)', ''))
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'E-IPTV FTTH'
AND CIRH_PARENT = C.CIRT_NAME)
IPTV_COUNT,
(SELECT DISTINCT CIRT_DISPLAYNAME
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'V-VOICE FTTH'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 1)
VOICE_NO,
(SELECT DISTINCT CIRT_DISPLAYNAME
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'V-VOICE FTTH'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 2)
VOICE_NO2,
(SELECT SATT_DEFAULTVALUE
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'REGISTRATION ID')
AS REGID,
(SELECT REPLACE (SATT_DEFAULTVALUE, ' ', '_')
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'SERVICE_SPEED')
AS SPEED,
(SELECT DISTINCT CIRT_DISPLAYNAME
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'BB-INTERNET FTTH'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 1)
BBCCT
FROM PORT_LINKS       PL,
PORTS            P,
PORT_LINK_PORTS  PLP,
EQUIPMENT        E,
CIRCUITS         C
WHERE     PL.PORL_CIRT_NAME = C.CIRT_NAME
AND PL.PORL_ID = PLP.POLP_PORL_ID
AND PLP.POLP_PORT_ID = P.PORT_ID
AND P.PORT_EQUP_ID = E.EQUP_ID
AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
AND C.CIRT_STATUS IN ('INSERVICE', 'SUSPENDED')
AND C.CIRT_SERT_ABBREVIATION = 'AB-FTTH'
AND CIRT_NAME = '" . $results[0]['BEARER'] . "'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results1 = $statment->fetchAll();
    $statment->closeCursor();


    $sql = "UPDATE ONEG_OLDCCT_DETAILS SET
       ONT_SN         = '" . $results1[0]['ONT_SN'] . "',
       ZTE_PROFILE    = '" . $results1[0]['ZTE_PROFILE'] . "',
       MSAN_TYPE      = '" . $results1[0]['MSAN_TYPE'] . "',
       ZTE_PORT       = '" . $results1[0]['ZTE_PORT'] . "',
       HUAWEI_PORT    = '" . $results1[0]['HUAWEI_PORT'] . "',
       NOKIA_PORT     = '" . $results1[0]['NOKIA_PORT'] . "',
       V_PORT         = '" . $results1[0]['V_PORT'] . "',
       DNAME          = '" . $results1[0]['DNAME'] . "',
       EQUP_IPADDRESS = '" . $results1[0]['EQUP_IPADDRESS'] . "',
       BB_CIRCUIT     = '" . $results1[0]['BB_CIRCUIT'] . "',
       IPTV_COUNT     = '" . $results1[0]['IPTV_COUNT'] . "',
       VOICE_NO       = '" . $results1[0]['VOICE_NO'] . "',
       VOICE_NO2      = '" . $results1[0]['VOICE_NO2'] . "',
       REGID          = '" . $results1[0]['REGID'] . "',
       SPEED          = '" . $results1[0]['SPEED'] . "',
       BBCCT          = '" . $results1[0]['BBCCT'] . "'
    WHERE REC_ID  = '$q'";

    $statment = $conn->prepare($sql);
    $results = $statment->execute();
    $statment->closeCursor();
}




if ($r == 'refreshnumbernew') {
    $sql = "SELECT * FROM ONEG_NEWCCT_DETAILS WHERE REC_ID = $q";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();

    $file = $results[0]['PE_NO']."_log.txt";
    logToFile($file,"$userid - $uname Refresh New Details for ".$results[0]['VOICE_NO']);

    $sql = "SELECT (SELECT     REPLACE (SUBSTR (SATT_DEFAULTVALUE, 1, 8),
    '48575443',
    'HWTC')
|| SUBSTR (SATT_DEFAULTVALUE, 9)
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'ONT SERIAL NUMBER'
AND SATT_DEFAULTVALUE IS NOT NULL
AND ROWNUM = 1) AS ONT_SN,
(SELECT SATT_DEFAULTVALUE
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'FTTH_IPTV_2')
AS ZTE_PROFILE,
(SELECT SOA.SATT_DEFAULTVALUE     OLT_MANUFACTURER
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'OLT_MANUFACTURER')
MSAN_TYPE,
'1-1-'
|| TO_NUMBER (
REPLACE (REPLACE (SUBSTR (P.PORT_CARD_SLOT, -2, 2), '-', ''),
'.',
''))
|| '-'
|| TO_NUMBER (
REPLACE (SUBSTR (P.PORT_NAME, 1, INSTR (P.PORT_NAME, '-') - 1),
'-0',
''))
ZTE_PORT,
TO_NUMBER (
REPLACE (REPLACE (SUBSTR (P.PORT_CARD_SLOT, -5, 2), '-', ''),
'.',
''))
|| '-'
|| TO_NUMBER (
REPLACE (REPLACE (SUBSTR (P.PORT_CARD_SLOT, -2, 2), '-', ''),
'.',
''))
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_NAME, 1, INSTR (P.PORT_NAME, '-') - 1))
HUAWEI_PORT,
SUBSTR (P.PORT_CARD_SLOT, 5, 1)
|| '-'
|| SUBSTR (P.PORT_CARD_SLOT, 3, 1)
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_CARD_SLOT, 7, 2))
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_NAME, 1, INSTR (P.PORT_NAME, '-') - 1))
|| '-'
|| TO_NUMBER (SUBSTR (P.PORT_NAME, INSTR (P.PORT_NAME, '-') + 1, 3))
NOKIA_PORT,
TO_NUMBER (SUBSTR (P.PORT_NAME, INSTR (P.PORT_NAME, '-') + 1, 3))
V_PORT,
TRIM (REPLACE (EQUP_LOCN_TTNAME, '-NODE', ' '))
|| '_'
|| TRIM (
REPLACE (REPLACE (EQUP_EQUM_MODEL, '-ISL', ' '), '(IPMB)', ''))
|| '_'
|| SUBSTR (EQUP_INDEX, -2)
DNAME,
E.EQUP_IPADDRESS,
(SELECT SATT_DEFAULTVALUE
FROM CIRCUITS X, CIRCUIT_HIERARCHY, SERVICES_ATTRIBUTES SOA
WHERE     CIRH_CHILD = X.CIRT_NAME
AND SOA.SATT_SERV_ID = X.CIRT_SERV_ID
AND CIRT_SERT_ABBREVIATION = 'BB-INTERNET FTTH'
AND SOA.SATT_ATTRIBUTE_NAME = 'BB CIRCUIT ID'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 1)
BB_CIRCUIT,
(SELECT COUNT (DISTINCT REPLACE (X.CIRT_DISPLAYNAME, '(N)', ''))
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'E-IPTV FTTH'
AND CIRH_PARENT = C.CIRT_NAME)
IPTV_COUNT,
(SELECT DISTINCT CIRT_DISPLAYNAME
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'V-VOICE FTTH'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 1)
VOICE_NO,
(SELECT DISTINCT CIRT_DISPLAYNAME
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'V-VOICE FTTH'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 2)
VOICE_NO2,
(SELECT SATT_DEFAULTVALUE
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'REGISTRATION ID')
AS REGID,
(SELECT REPLACE (SATT_DEFAULTVALUE, ' ', '_')
FROM SERVICES_ATTRIBUTES SOA
WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
AND SOA.SATT_ATTRIBUTE_NAME = 'SERVICE_SPEED')
AS SPEED,
(SELECT DISTINCT CIRT_DISPLAYNAME
FROM CIRCUITS X, CIRCUIT_HIERARCHY
WHERE     CIRH_CHILD = X.CIRT_NAME
AND CIRT_SERT_ABBREVIATION = 'BB-INTERNET FTTH'
AND CIRH_PARENT = C.CIRT_NAME
AND ROWNUM = 1)
BBCCT
FROM PORT_LINKS       PL,
PORTS            P,
PORT_LINK_PORTS  PLP,
EQUIPMENT        E,
CIRCUITS         C
WHERE     PL.PORL_CIRT_NAME = C.CIRT_NAME
AND PL.PORL_ID = PLP.POLP_PORL_ID
AND PLP.POLP_PORT_ID = P.PORT_ID
AND P.PORT_EQUP_ID = E.EQUP_ID
AND EQUP_EQUT_ABBREVIATION LIKE '%MSAN%'
AND C.CIRT_STATUS IN ('INSERVICE', 'SUSPENDED')
AND C.CIRT_SERT_ABBREVIATION = 'AB-FTTH'
AND CIRT_NAME = '" . $results[0]['BEARER'] . "'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results1 = $statment->fetchAll();
    $statment->closeCursor();


    $sql = "UPDATE ONEG_NEWCCT_DETAILS SET
       ONT_SN         = '" . $results1[0]['ONT_SN'] . "',
       ZTE_PROFILE    = '" . $results1[0]['ZTE_PROFILE'] . "',
       MSAN_TYPE      = '" . $results1[0]['MSAN_TYPE'] . "',
       ZTE_PORT       = '" . $results1[0]['ZTE_PORT'] . "',
       HUAWEI_PORT    = '" . $results1[0]['HUAWEI_PORT'] . "',
       NOKIA_PORT     = '" . $results1[0]['NOKIA_PORT'] . "',
       V_PORT         = '" . $results1[0]['V_PORT'] . "',
       DNAME          = '" . $results1[0]['DNAME'] . "',
       EQUP_IPADDRESS = '" . $results1[0]['EQUP_IPADDRESS'] . "',
       BB_CIRCUIT     = '" . $results1[0]['BB_CIRCUIT'] . "',
       IPTV_COUNT     = '" . $results1[0]['IPTV_COUNT'] . "',
       VOICE_NO       = '" . $results1[0]['VOICE_NO'] . "',
       VOICE_NO2      = '" . $results1[0]['VOICE_NO2'] . "',
       REGID          = '" . $results1[0]['REGID'] . "',
       SPEED          = '" . $results1[0]['SPEED'] . "',
       BBCCT          = '" . $results1[0]['BBCCT'] . "'
    WHERE REC_ID  = '$q'";

    $statment = $conn->prepare($sql);
    $results = $statment->execute();
    $statment->closeCursor();
}


header('Content-Type: application/json; charset=utf-8');
echo json_encode($results);
