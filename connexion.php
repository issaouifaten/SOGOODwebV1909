<?php



$serverName = "faten\MSSQLSERVER,5252"; //serverName\instanceName
$connectionInfo = array( "Database"=>"Sogood2908", "UID"=>"sa", "PWD"=>"ideal2s");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    /*     echo "Connexion établie.<br />"; */
}else{
    header("Location:ErreurConnexion.html");
    echo "La connexion n'a pu être établie.<br />";
    die( print_r( sqlsrv_errors(), true));

}











?>
