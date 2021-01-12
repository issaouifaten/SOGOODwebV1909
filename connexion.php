<?php



$serverName = "faten\MSSQLSERVER,5252"; //serverName\instanceName
$connectionInfo = array( "Database"=>"I2S_RestaurentSogood1010", "UID"=>"sa", "PWD"=>"ideal2s");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    /*     echo "Connexion établie.<br />"; */
}else{
    header("Location:ErreurConnexion.html");


}











?>
