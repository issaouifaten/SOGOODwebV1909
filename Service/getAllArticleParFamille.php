<?php
require "../connexion.php";
$code = $_GET['CodeFamille'];
$numbc = $_GET['numbc'];
$sql = " select * from Article where CodeFamille='$code' and Actif=1 and VueWeb=1
 and CodeArticle not in(select CodeArticle from LigneBonCommandeTemporaire where  NumeroBonCommandeVente='$numbc' )";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$famille = "";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $CodeArticle = $row["CodeArticle"];
    $Designation = utf8_encode($row["Designation"]);
    $Decription = utf8_encode($row["DetailCompositonArticle"]);
    $PrixVenteTTC = number_format($row["PrixVenteTTC"], 3, ".", '');
    $u = $row["URL"];
    $famille .= "     
     <div class=\"col-md-6 col-12\" onclick='ViewArticle(\"$CodeArticle\" )' >
     	
            <div class=\"theme-block theme-block-hover\">
            
                <div class=\"product-name row\">
               <!-- Input Group -->
                            <input type='hidden'  value='$CodeArticle'>
                           <p class='col-md-7 col-7' style='height: 50px'>$Designation  </p>
                  
							<p class='col-md-2 col-2 font-weight-bold'>$PrixVenteTTC </p>
						<div class=' col-md-3 col-3'>
							<button class=\"btn btn-success  \"  type=\"button\"  onclick='ViewArticle(\"$CodeArticle\" )'>
									<span class=\"fa fa-shopping-cart\" aria-hidden=\"true\"></span>
							</button>
							</div>
			    </div>
            </div>
        </div>";
}


sqlsrv_free_stmt($stmt);
ECHO $famille;

function getUrl($code)
{
    $url = "";
    switch ($code) {
        case 10:
            $url = "pizza.jpg";
            break;
        case 11:
            $url = "pizzaxl.jpg";
            break;
        case 18:
            $url = "salade.jpg";
            break;
        case 13:
            $url = "pasta.jpg";
            break;
        case 19:
            $url = "soupe.jpg";
            break;
        case 14:
            $url = "boisson.jpg";
            break;
        case 15:
            $url = "dessert.jpg";
            break;
        case 16:
            $url = "plat.jpg";
            break;
        case 12:
            $url = "pizzalarge.jpg";
            break;
        default :
            $url = 'pot.jpg';
    }
    return $url;
}
