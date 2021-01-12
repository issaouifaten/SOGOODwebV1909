<?php
require "../connexion.php";
$sql = " select * from FamilleArticle where VueWeb=1";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$famille="<option disabled selected> choisir une famille </option>";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $CodeFamille = $row["CodeFamille"];
    $Url = $row["Url"];
    $Libelle = str_replace("'"," ",utf8_encode($row["Libelle"]));

    $famille.= " <option value='$CodeFamille'>$Libelle</option>";
}
echo $famille;

