<?php
require "../connexion.php";
$CodeArticle=$_GET['CodeArticle'];
$NumeroBonCommandeVente=$_GET['Num'];

$sql="delete from   LigneBonCommandeTemporaire 
          where NumeroBonCommandeVente ='$NumeroBonCommandeVente'and
            CodeArticle ='$CodeArticle'
           
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

sqlsrv_free_stmt($stmt2)


?>
