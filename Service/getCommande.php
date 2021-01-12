<?php
require "../connexion.php";
$Num = $_GET['Num'];




$sql = " select * 
 ,(select URL from Article where Article.CodeArticle=LigneBonCommandeTemporaire.CodeArticle) as URL
 from LigneBonCommandeTemporaire where NumeroBonCommandeVente='$Num'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$btannule = "  
  <div class='container '>    
    <span class=\"input-group-btn\">
    <button class='btn btn-danger col-md-12 col-12'    onclick='showDiagAnnuleCommande()'>
      <i class='fa fa-close'></i>
      Annuler Commande </button> </span></div> 
                             
                         ";
$famille="";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $CodeArticle = $row["CodeArticle"];
    $Quantite = number_format( $row["Quantite"],0,'','');
    $PrixVenteTTC = $row["MontantTTC"];
    $Observation = utf8_encode($row["Observation"]);
    $URL = $row["URL"];
    $Libelle = str_replace("'", " ", utf8_encode($row["DesignationArticle"]));
    $u = getUrl($CodeArticle);
    $famille .= "		
		 
  
		
		
		
		   <div class=\"col-sm-6\">
                                <div class=\"card\">
                          
                                 <div class='col-md-12'>
                                  <button class='btn color-red  btn-sm right '   onclick='deleteArticle(\"$CodeArticle\")'><i class='fa fa-close'></i> Annuler Article </button>
                                   </div>
                                
                                   
                                    <div class=\"card-body\"> 
                                            <div class='col-md-12 row'>
                                          <img class='card-img col-4 '   style='  border-radius: 50%;' src='images/$URL'>
                                    
                                        <p class=\"card-title col-8\">$Libelle</p>
                                          </div>
                                          <br>
                                        <p class=\"card-text text-center col-12\">     
                           
                                           <button class='btn btn-outline-primary' onclick='ChangeQuantiteCommande(\"$CodeArticle\",-1)'> - </button>
                                           <input type='number' class='text-center    invoice-input'  readonly  id='$CodeArticle'  value='$Quantite'>   
                                          <button class='btn btn-outline-danger' onclick='ChangeQuantiteCommande(\"$CodeArticle\",1)'> + </button>
                                  
                                         <div class='col-md-12 col-12'>
                                        <input class='right text-center color-blue bg-bleu' readonly  type='number' id='prix$CodeArticle' value='$PrixVenteTTC'>
                                 </div>
                                    </div>
                                </div>
                                <p hidden   id='observation$CodeArticle'>$Observation</p>
                            </div>
		
		
		
		
		
		
		
		";
}


sqlsrv_free_stmt($stmt);


$sql = " select FraisLivraison,SeuilGratuite from ParametreDiver";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

$FraisLivraison=$row['FraisLivraison'];
$SeuilGratuite=$row['SeuilGratuite'];

}




$btvalide="  
 
 <div class='container  '> 
    <span class=\"input-group-btn\">	<button class=\"btn btn-success col-md-12 col-12 \"   type=\"button\" onclick=\"ValiderCommande()\">
									<span class=\"fa fa-check\" aria-hidden=\"true\"></span>
									Valider
								</button> </span>
								</div>
<div class='container  '> 
 <h6 class='container bg-white p-3 font_Lobster '>
 <span class='font-weight-bold' > Frais de Livraion</span> est <span class='color-green font-weight-bold'> $FraisLivraison DT</span>  , 
  <span class='font-weight-bold'> Gratuit  </span>pour Toute Commande Supèrieur à
   <span class='color-red font-weight-bold'> $SeuilGratuite DT</span>  </h6>
    </div>
 
 ";

if($famille!="")
{$famille=$btannule.$famille.$btvalide;

}
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
