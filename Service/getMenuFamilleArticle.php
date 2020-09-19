<?php

require "../connexion.php";
$sql = " select * from FamilleArticle where VueWeb=1";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$famille = "
<button  class='btn btn-lg btn-light  btn-hov' onclick=\"getLogo()\"><i class='fa fa-home'></i></button>
<button  class='btn btn-light btn-lg  btn-hov ' id='btn_tout'  onclick=\"FillListImageFamille()\">Tout</button>
";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $CodeFamille = $row["CodeFamille"];
    $Libelle = $row["Libelle"];

    $famille .= " 
				<button class='btn btn-light btn-lg  btn-hov '    onclick='FillListFamille(\"$CodeFamille\")'>$Libelle</button>
		 
		 ";
}


sqlsrv_free_stmt($stmt);
ECHO $famille;
