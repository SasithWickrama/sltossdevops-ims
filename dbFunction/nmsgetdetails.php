<?php


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

try{
    $conn = new PDO("oci:dbname=" . $connstring, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}catch (PDOException $e){
    $error = "Database Error: ".$e->getMessage();
    echo $error;
}

date_default_timezone_set('Asia/colombo');
$nowmonth = date("m");


if ($r=='fabcreate' ){

$sql = "/* Formatted on 2/8/2022 9:08:26 AM (QP5 v5.336) */
SELECT (SELECT    REPLACE (SUBSTR (SATT_DEFAULTVALUE, 1, 8),
                           '48575443',
                           'HWTC')
               || SUBSTR (SATT_DEFAULTVALUE, 9)
          FROM SERVICES_ATTRIBUTES SOA
         WHERE     SOA.SATT_SERV_ID = C.CIRT_SERV_ID
               AND SOA.SATT_ATTRIBUTE_NAME = 'ONT SERIAL NUMBER'
               AND SATT_DEFAULTVALUE IS NOT NULL
               AND ROWNUM = 1)
           AS ONT_SN,
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
           PORT2,
          SUBSTR (P.PORT_CARD_SLOT, 5, 1)
       || '-'
       || SUBSTR (P.PORT_CARD_SLOT, 3, 1)
       || '-'
       || TO_NUMBER (SUBSTR (P.PORT_CARD_SLOT, 7, 2))
       || '-'
       || TO_NUMBER (SUBSTR (P.PORT_NAME, 1, INSTR (P.PORT_NAME, '-') - 1))
       || '-'
       || TO_NUMBER (SUBSTR (P.PORT_NAME, INSTR (P.PORT_NAME, '-') + 1, 3))
           PORT3,
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
       (SELECT distinct SATT_DEFAULTVALUE
          FROM CIRCUITS X, CIRCUIT_HIERARCHY, SERVICES_ATTRIBUTES SOA
         WHERE     CIRH_CHILD = X.CIRT_NAME
               AND SOA.SATT_SERV_ID = X.CIRT_SERV_ID
               AND CIRT_SERT_ABBREVIATION = 'BB-INTERNET FTTH'
               AND SOA.SATT_ATTRIBUTE_NAME in ( 'BB CIRCUIT ID' , 'ADSL_CIRCUIT_ID')
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
       AND C.CIRT_DISPLAYNAME LIKE '$q%'
       AND C.CIRT_STATUS IN ('INSERVICE', 'SUSPENDED')
       AND C.CIRT_SERT_ABBREVIATION = 'AB-FTTH'";    
	   

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();
   //var_dump( $results);
	}
	
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($results);