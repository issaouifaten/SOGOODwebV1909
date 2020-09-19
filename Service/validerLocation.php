<?php


require "../connexion.php";

$NumeroBonCommandeVente = $_GET['Num'];

$latitude = $_GET['latitude'];
$longitude =str_replace("%20","" ,$_GET['longitude']);
//////
$sql = "update BonCommandeVente set Latitude='$latitude',Longitude='$longitude' 
where NumeroBonCommandeVente='$NumeroBonCommandeVente'";


$stmt = sqlsrv_prepare($conn, $sql, array());

if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}


if (sqlsrv_execute($stmt) === false) {
    die(print_r(sqlsrv_errors(), true));
}

