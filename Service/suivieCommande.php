<?php
require "../connexion.php";
$Num = $_GET['tel'];
$sql = "
select Etat.Libelle, TotalTTC,
   ( (select distinct (isnull( stuff ((select distinct (', '+   ((FamilleArticle.Libelle+' :  '+ DesignationArticle +' (' +convert (nvarchar ,convert(numeric(18,0),Quantite) )+')' )) ) 
 from  LigneBonCommandeVente
inner join Article on Article.CodeArticle=LigneBonCommandeVente.CodeArticle
INNER JOIN FamilleArticle on FamilleArticle.CodeFamille=Article.CodeFamille
  where LigneBonCommandeVente.NumeroBonCommandeVente = BonCommandeVente.NumeroBonCommandeVente for XML Path(''),type).value('.','NVARCHAR(MAx)'),1,1,'  '),'')) ) )as cmd 
  from  BonCommandeVente
 inner join Etat on Etat.NumeroEtat=BonCommandeVente.NumeroEtat
  where TelClient='$Num' and CONVERT(date,DateCreation,103)=CONVERT(date,GETDATE(),103) ";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$famille = " 
<div class=\"col-sm-6\">
       <div class=\"card\" >
<span class='btn btn-danger    ' onclick='  getLogo()'>&nbsp;<i class='fa fa-arrow-left  '></i> Retour </span> 
 
       </div>
</div>
 ";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $cmd = $row["cmd"];
    $Libelle = $row["Libelle"];
    $TotalTTC = $row["TotalTTC"];

    $famille .= "		
		 
  
		
		
		
		   <div class=\"col-sm-6\">
                                <div class=\"card\">
                             
                       
                                    <div class=\"card-body\">     
                                        <label class='alert-blue col-md-12 text-left ' style='padding: 5px'> Total commande : &nbsp; 
                                       <span class='right'> $TotalTTC  &nbsp;</span>
                                        </label>
                             
                               
                              
                                    
                                        <h4 class=\"card-title color-red\"> <br>  $Libelle</h4>
                                        <p class=\"card-text text-center\">     
                           
                                        $cmd</p>
                                      
                                    </div>
                                </div>
                        
                            </div>
		
		
		
		
		
		
		
		";
}


sqlsrv_free_stmt($stmt);
ECHO $famille;
