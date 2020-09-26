<?php
require "../connexion.php";
$CodeZone=$_GET['CodeZone'];

$sql="delete from   ZoneBlocageWeb 
          where  
            CodeZone ='$CodeZone'
           
";

echo $sql;
$stmt2 = sqlsrv_prepare($conn, $sql, array());


if (!$stmt2) {
    echo '!sql <br>';
    die(print_r(sqlsrv_errors(), true));
}


if (sqlsrv_execute($stmt2) === false) {
    echo 'excute <br>';
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($stmt2);
