<?php

require "../connexion.php";

$NumeroBonCommandeVente = $_GET['NumeroBonCommandeVente'];
$client= $_GET['client'];
$telclient= $_GET['telclient'];
$latitude= $_GET['latitude'];
$longitude= $_GET['longitude'];
$adresse= str_replace("'","''", utf8_encode($_GET['adresse']));

///////
$sql = " select * from CompteurPiece  where NomPiecer='BonCommandeVente'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}


$ltab = 0;
$t = 0;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $compteur = $row['Compteur'];
    $prefixe = $row['PrefixPiece'];
    $annee = $row['Annee'];

}

$code = $prefixe . $annee . $compteur;
$cod = $code;

$c = $compteur + 1;
$qty = sprintf("%05d", $c);

//////
$sql = "update CompteurPiece set Compteur='$qty'
where NomPiecer='BonCommandeVente'";


$stmt = sqlsrv_prepare($conn, $sql, array());

if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}


if (sqlsrv_execute($stmt) === false) {
    die(print_r(sqlsrv_errors(), true));
}

///..
//if ( sqlsrv_begin_transaction( $conn ) === false )
//{
//    echo "Could not begin transaction.\n";
//    die( print_r( sqlsrv_errors(), true ));
//}

$sql = "insert into LigneBonCommandeVente  
select  '$code' ,CodeArticle ,DesignationArticle ,NumeroOrdre ,PrixVenteHT ,Quantite ,MontantHT ,TauxTVA ,MontantTVA ,MontantTTC ,Observation ,TauxRemise ,MontantRemise ,MontantFodec
 ,NetHT ,PrixAchatNet,0  from LigneBonCommandeTemporaire where  NumeroBonCommandeVente='$NumeroBonCommandeVente'";


$stmt1 = sqlsrv_prepare($conn, $sql, array());
if (sqlsrv_execute($stmt1) === false) {
   // echo 'excute <br>';
    die(print_r(sqlsrv_errors(), true));
}
sqlsrv_free_stmt( $stmt1);


$sql="INSERT INTO  BonCommandeVente
           ( NumeroBonCommandeVente
           , DateBonCommandeVente
           , NumeroDevisVente
           , CodeClient
           , ReferenceClient
           , DateReferenceClient
           , DelaiLivraison
           , TotalHT
           , TotalTVA
           , TotalTTC
           , NumeroEtat
           , NomUtilisateur
           , DateCreation
           , HeureCreation
           , Observation
           , TotalRemise
           , TotalFodec
           , TotalNetHT
           ,NomClient
           ,TelClient
           ,Adresse
           ,Latitude
           ,Longitude
           ,CommandeEnLigne)
     VALUES
           ('$code'
           ,GETDATE()
           ,''
           ,'418'
           ,''
           ,GETDATE()
           ,0
           ,(select sum(LigneBonCommandeVente.MontantHT)from LigneBonCommandeVente where NumeroBonCommandeVente ='$code')
                ,(select sum(LigneBonCommandeVente.MontantTVA)from LigneBonCommandeVente where NumeroBonCommandeVente ='$code')
                ,(select sum(LigneBonCommandeVente.MontantTTC)from LigneBonCommandeVente where NumeroBonCommandeVente ='$code')
           ,'E01'
           ,''
           ,GETDATE()
           ,GETDATE()
   , ''
     
             ,(select sum(LigneBonCommandeVente.MontantRemise)from LigneBonCommandeVente where NumeroBonCommandeVente ='$code')
        ,(select sum(LigneBonCommandeVente.MontantFodec)from LigneBonCommandeVente where NumeroBonCommandeVente ='$code')
      ,(select sum(LigneBonCommandeVente.NetHT)from LigneBonCommandeVente where NumeroBonCommandeVente ='$code')
     ,'$client'
        ,'$telclient'
         , ? 
          ,'','',1 )
 ";




$stmt2 = sqlsrv_prepare($conn, $sql, array(&$adresse));



//if( $stmt1 && $stmt2 )
//{
//    sqlsrv_commit( $conn );
//    echo "Transaction was committed.\n";
//}
//else
//{
//    sqlsrv_rollback( $conn );
//    echo "Transaction was rolled back.\n";
//    die(print_r(sqlsrv_errors(), true));
//}

if (sqlsrv_execute($stmt2) === false) {

    die(print_r(sqlsrv_errors(), true));
}


sqlsrv_free_stmt( $stmt2);
echo $code;
