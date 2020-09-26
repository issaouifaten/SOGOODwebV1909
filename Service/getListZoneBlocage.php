<?php

require "../connexion.php";

$sql="select  CodeZone,LongitudeCenter,LatitudeCenter,Rayon ,Designation from ZoneBlocageWeb ";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$table="";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $CodeZone = $row["CodeZone"];
    $LongitudeCenter = $row["LongitudeCenter"];
    $LatitudeCenter = $row["LatitudeCenter"];
    $Rayon = $row["Rayon"];
    $Designation = $row["Designation"];

$table.="<tr>
<td>$CodeZone</td>
<td>$LongitudeCenter</td>
<td>$LatitudeCenter</td>
<td>$Rayon</td>
<td>$Designation</td>
<td onclick='DeleteZone(\"$CodeZone\")'>Supprimer</td>
</tr>";

}
echo $table;
