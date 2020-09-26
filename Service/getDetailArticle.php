<?php
require "../connexion.php";
$code = $_GET['CodeArticle'];
$sql = " select * from Article where CodeArticle='$code'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$famille = "";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $CodeArticle = $row["CodeArticle"];
    $Decription = $row["DetailCompositonArticle"];
    $CodeFamille = $row["CodeFamille"];
    $Designation =str_replace("'"," ", $row["Designation"]);
    $PrixVenteTTC = number_format($row["PrixVenteTTC"], 3, ".", '');
    $u=$row["URL"];
    $famille .= "  
 
     <div class=\"container theme-block row \">
                 <div class=\"product-name text-center col-12\">
                    <h4 class='text-center'><a>$Designation</a></h4>
                </div>
     	    	<div class=\"theme-block-picture center align-content-center col-6\">
                      <center>
					<img src=\"images/$u\"  class='center text-center align-content-center'  >
					</center>
				</div>
            <div class=\"col-6\">
            
           
                  <div class=\"doctor-details\">
             
                           <input type='hidden'  value='$CodeArticle'>
                           <input id='prixarticle' class='text-center' readonly value='$PrixVenteTTC'>
               
                    <!-- Input Group -->
                    <div class=\"input-group\">
                    <button class='btn btn-outline-danger' onclick='ChangeQuantite(\"$CodeArticle\",-1,\"$PrixVenteTTC\")'>-</button>
                        <input type=\"number\" readonly class=\"form-control\" min='0' id='$CodeArticle'   value=\"0\">
                      <button class='btn btn-outline-dark' onclick='ChangeQuantite(\"$CodeArticle\",1,\"$PrixVenteTTC\")'>+</button>
                    </div>

                </div>
            </div>
            
            <div class='col-md-12'>
              <p class='text-left color-green font_Lobster '> $Decription</p>
            </div>
        </div>
       
        
      ";
}


sqlsrv_free_stmt($stmt);

$sql = "select * from LibellePredefini where CodeFamille='$CodeFamille' and   VueWeb=1";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$observation="<div class='container  '>";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $Numero = $row["Numero"];
    $Libelle =utf8_encode(str_replace("'"," ", $row["Libelle"]));
    $observation.="<label class='col-md-12 container-checkbox'>
<input id='$Numero' type='checkbox' onchange='addObservation(\"$Libelle\",\"$Numero\")' value='$Libelle'>$Libelle
  <span class=\"checkmark\"></span>

</label>
 


";

}

$observation.="</div>";

echo "<div hidden id='observation'></div>";

$bt="  <div class='container center '>    
 
                               <center>
								<button class=\"btn btn-danger \" type=\"button\"  onclick='addArticle(\"$CodeArticle\",\"$PrixVenteTTC\",\"$Designation\")'>
									<span class=\"fa fa-plus\" aria-hidden=\"true\"></span>
									Ajouter
								</button>
								<button class='btn btn-dark '  onclick='FillListImageFamille()'><i class='fa fa-arrow-circle-left'></i> Retour</button>
							</center>
							
							</span></div> ";


ECHO $famille."<br> <div class='container bg-white p-3' style='border-radius: 10px'>".$observation."<br>".$bt."</div>";

function getUrl( $code)
{$url="";
    switch ($code)
    {
        case 10:$url="pizza.jpg" ;break;
        case 11:$url="pizzaxl.jpg" ;break;
        case 18:$url="salade.jpg" ;break;
        case 13:$url="pasta.jpg" ;break;
        case 19:$url="soupe.jpg" ;break;
        case 14:$url="boisson.jpg" ;break;
        case 15:$url="dessert.jpg" ;break;
        case 16:$url="plat.jpg" ;break;
        case 12:$url="pizzalarge.jpg" ;break;
        default : $url='pot.jpg';
    }
    return $url;
}
