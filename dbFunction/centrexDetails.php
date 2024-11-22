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


if ($r == 'createso') {
    $sql = "SELECT SERO_SERT_ABBREVIATION ,
    (SELECT SOFE_DEFAULTVALUE  FROM SERVICE_ORDER_FEATURES WHERE SOFE_FEATURE_NAME ='SF_CENTREX' and SOFE_SERO_ID = SERO_ID) CENTREX,
    (SELECT distinct ltrim(replace(SEOA_DEFAULTVALUE,'CX',''),'0')  FROM SERVICE_ORDER_ATTRIBUTES WHERE SEOA_NAME ='CENTREX GROUP ID' and SEOA_SOFE_ID is null and SEOA_SERO_ID = SERO_ID )  group_id ,
    (SELECT distinct SEOA_DEFAULTVALUE  FROM SERVICE_ORDER_ATTRIBUTES WHERE SEOA_NAME ='SHORT CODE'  and SEOA_SOFE_ID is null and SEOA_SERO_ID = SERO_ID )  short_code,
    (SELECT CASE  WHEN SEOA_DEFAULTVALUE = 'YES' THEN 0 ELSE 1 END AS  CXSBR FROM SERVICE_ORDER_ATTRIBUTES WHERE SEOA_NAME = 'OGB WITH EXT DIALING ENABLED' AND SEOA_SERO_ID = SERO_ID )CXSBR
    FROM SERVICE_ORDERS SO , CIRCUITS C
    WHERE SO.SERO_CIRT_NAME = C.CIRT_NAME
    AND (SO.SERO_ORDT_TYPE LIKE 'CREATE%' OR SO.SERO_ORDT_TYPE = 'MODIFY-FEATURE')
    AND so.SERO_STAS_ABBREVIATION NOT LIKE 'C%'
    AND C.CIRT_DISPLAYNAME LIKE  '$q'||'%' ";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();

}



if ($r == 'deleteso') {
    $sql = "SELECT SERO_SERT_ABBREVIATION ,SERO_ORDT_TYPE,
    (SELECT SOFE_DEFAULTVALUE  FROM SERVICE_ORDER_FEATURES WHERE SOFE_FEATURE_NAME ='SF_CENTREX' and SOFE_SERO_ID = SERO_ID)  CENTREX,
    (SELECT distinct ltrim(replace(SEOA_DEFAULTVALUE,'CX',''),'0')  FROM SERVICE_ORDER_ATTRIBUTES WHERE SEOA_NAME ='CENTREX GROUP ID' and SEOA_SOFE_ID is null and SEOA_SERO_ID = SERO_ID )  group_id ,
    (SELECT distinct SEOA_DEFAULTVALUE  FROM SERVICE_ORDER_ATTRIBUTES WHERE SEOA_NAME ='SHORT CODE'  and SEOA_SOFE_ID is null and SEOA_SERO_ID = SERO_ID )  short_code
    FROM SERVICE_ORDERS SO , CIRCUITS C
    WHERE SO.SERO_CIRT_NAME = C.CIRT_NAME
    AND (SO.SERO_ORDT_TYPE LIKE 'DELETE%' OR SO.SERO_ORDT_TYPE = 'MODIFY-FEATURE')
    AND so.SERO_STAS_ABBREVIATION NOT LIKE 'C%'
    AND C.CIRT_DISPLAYNAME LIKE  '$q'||'%' ";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();

}



if ($r == 'admindetails') {
    $sql = "SELECT C.CIRT_SERT_ABBREVIATION ,
    (SELECT SFEA_VALUE  FROM SERVICES_FEATURES WHERE SFEA_FEATURE_NAME ='SF_CENTREX' and SFEA_SERV_ID = CIRT_SERV_ID)CENTREX,
    (SELECT distinct ltrim(replace(SATT_DEFAULTVALUE,'CX',''),'0')  FROM SERVICES_ATTRIBUTES WHERE SATT_ATTRIBUTE_NAME ='CENTREX GROUP ID' and  SATT_SERV_ID = CIRT_SERV_ID )  group_id ,
    (SELECT distinct SATT_DEFAULTVALUE  FROM SERVICES_ATTRIBUTES WHERE SATT_ATTRIBUTE_NAME ='SHORT CODE'  and SATT_SERV_ID = CIRT_SERV_ID )  short_code,
    (SELECT distinct CASE  WHEN SATT_DEFAULTVALUE = 'YES' THEN 0 ELSE 1 END AS  CXSBR   FROM SERVICES_ATTRIBUTES WHERE SATT_ATTRIBUTE_NAME = 'OGB WITH EXT DIALING ENABLED' and SATT_SERV_ID = CIRT_SERV_ID )  CXSBR
    FROM  CIRCUITS C
    WHERE  C.CIRT_DISPLAYNAME LIKE '$q'||'%'
    AND C.CIRT_STATUS IN ('INSERVICE')  ";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $results = $statment->fetchAll();
    $statment->closeCursor();

}







header('Content-Type: application/json; charset=utf-8');
echo json_encode($results);