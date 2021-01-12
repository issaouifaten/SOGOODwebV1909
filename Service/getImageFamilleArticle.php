<?php
require "../connexion.php";
$CodeFamille=$_GET['CodeFamille'];
$sql = " select * from FamilleArticle where CodeFamille='$CodeFamille'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$Url="";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {


    $Url = $row["Url"];

}
echo "images/".$Url;

