<?php
require "../connexion.php";
$sql = " select * from FamilleArticle where VueWeb=1";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$famille="";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $CodeFamille = $row["CodeFamille"];
    $Libelle = str_replace("'"," ",utf8_encode($row["Libelle"]));
$u=$row["Url"];
$famille.= "		<div class=\"col-md-4 col-6\" onclick='FillListFamille(\"$CodeFamille\")'>
			<div class=\"theme-block theme-block-hover\">
				<div class=\"theme-block-picture\">

					<img src=\"images/$u\" alt=\"$Libelle\" style='height: 100px' >
				</div>
				<div class=\"product-name\">
					<h4  style='font-size: 12px'>$Libelle</h4>
				</div>
				<input type='hidden' value='$CodeFamille' id='$CodeFamille' name='$CodeFamille'>
		 
			</div>
		</div>";
}


sqlsrv_free_stmt( $stmt);
ECHO $famille;
function getUrl( $code)
{$url="";
    switch ($code)
    {
        case 10:$url="pizza.jpg" ;break;
        case 11:$url="Margarita.jpg" ;break;
        case 18:$url="saladecesar.jpg" ;break;
        case 13:$url="pene.jpg" ;break;
        case 19:$url="soupe.jpg" ;break;
        case 14:$url="boisson.jpg" ;break;
        case 15:$url="tarte-citron.jpg" ;break;
        case 16:$url="filet.jpg" ;break;
        case 12:$url="pizza-thon.jpg" ;break;
        default : $url='pot.jpg';
    }
    return $url;
}
