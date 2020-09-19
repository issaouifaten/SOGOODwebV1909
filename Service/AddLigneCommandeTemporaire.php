<?php
require "../connexion.php";
$CodeArticle=$_GET['CodeArticle'];
$NumeroBonCommandeVente=$_GET['NumeroBonCommandeVente'];
$Quantite=$_GET['Quantite'];
$observation=$_GET['observation'];
$sql="INSERT INTO  LigneBonCommandeTemporaire 
           (NumeroBonCommandeVente 
           ,CodeArticle 
           ,DesignationArticle 
           ,NumeroOrdre 
           ,PrixVenteHT 
           ,Quantite 
           ,MontantHT 
           ,TauxTVA 
           ,MontantTVA 
           ,MontantTTC 
           ,Observation 
           ,TauxRemise 
           ,MontantRemise 
           ,MontantFodec 
           ,NetHT 
           ,PrixAchatNet )
     VALUES
           ('$NumeroBonCommandeVente' 
           ,'$CodeArticle'
           ,(select Designation from Article where CodeArticle='$CodeArticle')
           , isnull((select max( NumeroOrdre)+1 from  LigneBonCommandeTemporaire where NumeroBonCommandeVente='$NumeroBonCommandeVente'),1)
           ,(select PrixVenteHT from Article where CodeArticle='$CodeArticle')
           ,$Quantite
           ,(select PrixVenteHT*$Quantite from Article where CodeArticle='$CodeArticle')
           ,( select TVA.TauxTVA from Article  INNER JOIN TVA ON TVA.CodeTVA=Article.CodeTVA where CodeArticle='$CodeArticle')
           ,( select TVA.TauxTVA/100 *PrixVenteHT* $Quantite from Article  INNER JOIN TVA ON TVA.CodeTVA=Article.CodeTVA where CodeArticle='$CodeArticle')
           ,( select (1+TVA.TauxTVA/100)*(PrixVenteHT* $Quantite) from Article  INNER JOIN TVA ON TVA.CodeTVA=Article.CodeTVA where CodeArticle='$CodeArticle')
         
           ,'$observation'
           ,0
           ,0
           ,0
           ,(select PrixVenteHT*$Quantite from Article where CodeArticle='$CodeArticle')
           ,(select PrixAchatHT from Article where CodeArticle='$CodeArticle'))
 
";

echo $sql;
$stmt2 = sqlsrv_prepare($conn, $sql, array());


if (!$stmt2) {
    echo '!sql <br>';
    die(print_r(sqlsrv_errors(), true));
}


if (sqlsrv_execute($stmt2) === false) {
    echo 'excute <br>';
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($stmt2)


?>
