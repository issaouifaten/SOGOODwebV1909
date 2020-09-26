<?php


require "../connexion.php";
//            xmlhttp.open("GET", "Service/ZoneBlocage.php?LongitudeCenter=" + LongitudeCenter
//                + "&LatitudeCenter=" + LatitudeCenter + "&Rayon=" + Rayon, true);
$LatitudeCenter = $_GET['LatitudeCenter'];

$LongitudeCenter = $_GET['LongitudeCenter'];
$Designation =utf8_encode(str_replace("'","''", $_GET['Designation']));
$Rayon = $_GET['Rayon'];

//////
$sql = "INSERT INTO   ZoneBlocageWeb 
           ( CodeZone 
           , LongitudeCenter 
           , LatitudeCenter 
           , Rayon,Designation )
     VALUES
           ( isnull((select max (CodeZone)+1 from ZoneBlocageWeb),'001')
           , $LongitudeCenter
           ,$LatitudeCenter
           ,$Rayon,'$Designation')
 ";


$stmt = sqlsrv_prepare($conn, $sql, array());

if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}


if (sqlsrv_execute($stmt) === false) {
    die(print_r(sqlsrv_errors(), true));
}

