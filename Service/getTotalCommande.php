<?php
require "../connexion.php";
$Num = $_GET['Num'];
$sql = " select * from LigneBonCommandeTemporaire where NumeroBonCommandeVente='$Num'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$total = 0;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $total+=$row['MontantTTC'];

}
echo $total;
