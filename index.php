<?php
require "connexion.php";
$longitude = "";
$latitude = "";
if (isset($_GET['longitude']) && isset($_GET['latitude'])) {
    $longitude = $_GET['longitude'];
    $latitude = $_GET['latitude'];
}

$sql = "select * from  BlocageApplicationWeb where ActifBlocage=1
 and convert(date,GETDATE())>= DateDebutBlocage and  convert(date,GETDATE())<= DateFinBlocage ";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$Blocage = false;
$MotifBlocage = "";
$DateDebutBlocage = "";
$DateFinBlocage = "";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $DateDebutBlocage = $row["DateDebutBlocage"];
    $DateFinBlocage = $row["DateFinBlocage"];
    $MotifBlocage = utf8_encode($row["MotifBlocage"]);
    $Blocage = true;
}
$sql = " select FraisLivraison,SeuilGratuite from ParametreDiver";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $FraisLivraison = $row['FraisLivraison'];
    $SeuilGratuite = $row['SeuilGratuite'];

}

$sql=" select SUM(Inclu)   as Ouvert from (
select 
  case  
when  getdate ()  between 
 ( select cONVERT(DATETIME, CONVERT(NVARCHAR, DateJour ,103)+' '+  HeureEntre  )) 
 and 
 ( select cONVERT(DATETIME, CONVERT(NVARCHAR, DateJour ,103)+' '+  HeureSortie  ))
 then 1
 else 0
 end  as Inclu
from EmploieTemp where DateJour=CONVERT(date,getdate())  
 
 )as tt";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $Ouvert = $row['Ouvert'];


}


$sql="select   HeureEntre   ,  HeureSortie,Jour  from EmploieTemp where DateJour=CONVERT(date,getdate())  ";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$horraire="Horaire de Livraison : <br>";
$et="";

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $HeureEntre = $row['HeureEntre'];
    $HeureSortie = $row['HeureSortie'];
    $Jour= $row['Jour'];
if($Jour=='Dimanche') {

    $horraire="Le restaurant est fermé le dimanche " ;

}else{
    if( $HeureEntre!='')
    { $horraire .= $et . " De  " . $HeureEntre . " à " . $HeureSortie . "<br>";
    $et = " et ";}
}


}





?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>SOGOOD</title>

    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"/>
    <!-- Google web Font -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:400,500">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Material Design Lite Stylesheet CSS -->
    <link rel="stylesheet" href="css/material.min.css"/>
    <!-- Material Design Select Field Stylesheet CSS -->
    <link rel="stylesheet" href="css/mdl-selectfield.min.css">
    <!-- Owl Carousel Stylesheet CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <!-- Owl Carousel theme Stylesheet CSS -->
    <link rel="stylesheet" href="css/owl.theme.default.css"/>
    <!-- Animate Stylesheet CSS -->
    <link rel="stylesheet" href="css/animate.min.css"/>
    <!-- Magnific Popup Stylesheet CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css"/>
    <!-- Full Calendar Stylesheet CSS -->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <!-- Flex Slider Stylesheet CSS -->
    <link rel="stylesheet" href="css/flexslider.css"/>
    <!-- Custom Main Stylesheet CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        @font-face {
            font-family: "Ma Super Fonte";
            src: url('fonts/MinionPro-Regular.otf');
        }

        @font-face {
            font-family: "TitreLobster";
            src: url('fonts/Lobster 1.4.otf');
        }
    </style>
</head>

<body style='font-family: "Ma Super Fonte", Helvetica, Arial, sans-serif;background-image: url("images/bg_black.png")'>

<!-- Navigation -->
<!-- Featured Products -->
<div class="container">


    <div class="scrollmenu fixed-top " style="margin-top:40px;background-color: transparent"
         id="menu_horisontale"></div>
    <br>
    <br>


    <div class="row">
        <input type="hidden" value="<?php echo $longitude ?>" id="longitude">
        <input type="hidden" value="<?php echo $latitude ?>" id="latitude">
        <input type="hidden" id="numbc" value="<?php echo str_replace(" ", "", date('d/m/Y h:i:s')) ?>">
    </div>
<br>
    <div id="dataArticle" class="row p-1" style="margin-top: 25px">

        <div class="col-md-12 ">


            <div class="col-sm-6 ">
                <center>

                    <div class=" ">
                        <?php if ($Blocage == false) {

                            if($Ouvert>=1)

                            {


                            ?>
                            <!--                        actif-->
                            <div class="sub-ttl font_Lobster  color-white">Restaurant Le 52</div>
                            <br>
                            <br>
                            <div class="text-center">
                                <div class="col-md-12">
                                    <img class="img-responsive" style="width: 250px; " src="images/bg_52_logo.png"
                                         alt="">
                                    <h4 class="font-16"></h4>
                                    <br>
                                    <br>
                                    <p class="btn btn-danger btn-lg" id="bt_menu" hidden onclick="getMenu()"><i
                                                class="fa fa-play-circle"></i>
                                        Voir Menu </p>


                                </div>


                            </div>

                            <label class="color-white font-weight-bold font-16  animated  pulse infinite    ">

                                <input type="checkbox" id="checkrobot" class="" onclick="RobetTest()">
                                Je ne suis pas un robot</label><br>
                                <label class="color-white font-16">

                                    <?php echo $horraire  ?>

                                </label>
                            <!--              fin actif         -->
                        <?php }
                        else{?>


                            <div class="sub-ttl font_Lobster  color-white">Restaurant Le 52</div>
                            <br>
                            <br>
                            <div class="text-center">
                                <div class="col-md-12">
                                    <img class="img-responsive" style="width: 250px;250px" src="images/bg_52_logo.png"
                                         alt="">
                                    <h4 class="font-16"></h4>
                                    <br>

                                   <label class="color-white font-20">

                                       <?php echo $horraire  ?>

                                   </label>

                                </div>


                            </div>







                            <?php




                        }



                        } ELSE { ?>
                            <!--                          DEACTIF-->
                            <div class="sub-ttl font_Lobster  color-white">Restaurant Le 52</div>
                            <div>
                                <h5 class="color-white text-uppercase">FERMé DU
                                    <span class="font-weight-bold color-red"><?php echo date_format($DateDebutBlocage, 'd/m/Y') ?></span>
                                    AU
                                    <span class="font-weight-bold color-red">
                                      <?php echo date_format($DateFinBlocage, 'd/m/Y') ?></span>
                                </h5>
                                <hr>
                                <p  class="color-white"><?php echo $MotifBlocage ?></p>
                            </div>


                            <!--             FIN DESCATIF-->
                        <?php } ?>
                        <div id="dataInfoRestaurant">

                            <input type='hidden' class="" readonly id='tel' name='tel' value='46 525 252'/>
                            <div class="col-md-12  ">
                                <h4 class="color-white font-weight-bold">
                                    <i class="fa fa-phone"></i> (+216) 46 52 52 52</h4>
                            </div>

                            <div class="btn-group row ">

                                 <a href='https://www.facebook.com/RestoLe52' class='btn btn-info'>
                                            <i class='fa fa-facebook-square'></i> facebook &nbsp;</a>


                                        <a href='https://www.instagram.com/restaurant_le52/' style="background-color: #b30047"
                                           class='btn btn-danger'>
                                            <i class='fa fa-instagram'></i> Instagram </a>
                            </div>

                            <!--                            <a class="btn btn-info" href="https://www.facebook.com/RestoLe52/"><i-->
                            <!--                                        class="fa fa-facebook-square"></i></a>-->

                        </div>
                    </div>


                    <script>
                        function call() {
                            var num = document.getElementById('tel').value;
                            window.open('tel:' + num);
                        }
                    </script>

                </center>
            </div>


        </div>


    </div>  <!-- fin col-md-6 -!-->


</div>


</div>
</div>
<!--    FIN ARTICLE-->
<br><br>
<br><br>

<div id="appointment-button" class="animated fadeInUp">
    <button hidden id="bt_pannier" type="button" onclick="FillCommande()"
            class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-button--raised">
        <i id="nbcommande" class="fa fa-shopping-cart"> </i></button>


    <div class="mdl-tooltip mdl-tooltip--top" data-mdl-for="appointment-now">Votre commande</div>

</div><!-- End Fixed Appointment Button at Bottom -->
<footer id="footer" class="fixed-bottom">

    <div class="row  ">


        <div class="row  ">


            <div class="input-group btn-group  col-md-6 ">


                  <button class="btn  alert-blue   " style="font-size: 11px;margin-left: 30px" data-toggle="modal"
                        data-target="#ModalSuivie"><i
                            class="fa fa-eye"></i> Suivi de la commande
                </button>
                <button hidden id="bt_pannier_down" class="btn  btn-danger " style="font-size: 11px" type="button"
                        onclick="FillCommande()">
                    <i class="fa fa-shopping-cart"></i>
                    &nbsp;&nbsp; Votre  Panier &nbsp;&nbsp;
                </button>
            </div>
        </div>
    </div>

    <div class="row  ">

        <div class="col-md-12 col-12 ">

            <div class="input-group">
                <input type="number" id="fraislivraison" hidden style="font-size: 11px" class="form-control text-right"
                       value="<?php echo $FraisLivraison ?>" readonly>
                <input type="number" id="seuillivraison" hidden style="font-size: 11px" class="form-control text-right"
                       value="<?php echo $SeuilGratuite ?>" readonly>

                <label class="color-white" style="font-size: 9px">&nbsp; Total CMD: &nbsp;</label>
                <input type="number" id="total" style="font-size: 11px" class="form-control text-right" value="0"
                       readonly>
                <label class="color-white" style="font-size: 9px">&nbsp;+ Frais de  Livraison : &nbsp;</label>
                <input type="number" id="totalfrais" style="font-size: 11px" class="form-control text-right" value="0"
                       readonly>
                <label class="color-white" style="font-size: 9px">&nbsp;Total à payer : &nbsp;</label>
                <input type="number" id="totalpayer" style="font-size: 11px" class="form-control text-right" value="0"
                       readonly>

            </div>
        </div>


    </div>
</footer>



<div class="modal fade" id="ModalValidation" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-red">

                <h4 class="modal-title text-center "> Confirmation Commande </h4>
            </div>
            <div class="modal-body">
                <center>
                    <img src="images/logo_52.jpg" style="width: 50px;height: 50px">

                </center>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">

                    <input class="mdl-textfield__input" type="text" required id="client">
                    <label class="mdl-textfield__label" for="client">Nom et Prénom  <span class="color-red">*</span>   </label>
                    <span class="mdl-textfield__error"></span>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">

                    <input class="mdl-textfield__input" type="text" Pattern="[0-9]{8}" size="8" minlength="8"
                           maxlength="8" required id="telclient">
                    <label class="mdl-textfield__label" for="telclient">Téléphone <span class="color-red">*</span>    </label>
                    <span class="mdl-textfield__error"> </span>

                </div>
                <br>

                 <label class="color-red"> * Champs obligatoires </label>


                <input class=" " hidden type="text" required id="adresseclient">


            </div>
            <div class="modal-footer">

                <button class="btn btn-default" onclick="EnregistrerCommande()">Valider</button>
                <button class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalSuivie" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-blue">

                <h4 class="modal-title"> Suivie Commande </h4>
            </div>
            <div class="modal-body">
                <center>
                    <img src="images/logo_52.jpg" style="width: 50px;height: 50px">

                </center>
                <br>
                <label> Tapez votre numéro : </label>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">

                    <input class="mdl-textfield__input" type="text" pattern="[0-9]{8}" required id="telclientsuivie">
                    <label class="mdl-textfield__label" for="telclientsuivie">Téléphone <span class="color-red">*</span>   </label>
                    <span class="mdl-textfield__error"></span>
                </div>
                <label class="color-red"> * Champ obligatoire </label>

            </div>
            <div class="modal-footer">

                <button class="btn btn-default" onclick="SuiviCommande()" data-dismiss="modal">Valider</button>
                <button class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalERREUR" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-red">

                <h4 class="modal-title"> ERREUR </h4>
            </div>
            <div class="modal-body">
                <center>
                    <img src="images/logo_52.jpg" style="width: 50px;height: 50px">

                </center>
                <br>
                <h4><i class="fa fa-exclamation-triangle"></i> Ajoutez au moin un article </h4>


            </div>
            <div class="modal-footer">


                <button class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalAnnuleCommande" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-red">

                <h4 class="modal-title"> Annuler Commande </h4>
            </div>
            <div class="modal-body">
                <center>
                    <img src="images/logo_52.jpg" style="width: 50px;height: 50px">

                </center>
                <br>
                <h4><i class="fa fa-exclamation-triangle"></i> Voulez vous vraiment Annuler votre commande </h4>


            </div>
            <div class="modal-footer">


                <button class="btn btn-default" data-dismiss="modal" onclick="deleteAllArticle()">Valider</button>
                <button class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalErreurQTArticle" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-red">

                <h4 class="modal-title"> Erreur </h4>
            </div>
            <div class="modal-body">
                <center>
                    <img src="images/logo_52.jpg" style="width: 50px;height: 50px">

                </center>
                <br>
                <h4><i class="fa fa-exclamation-triangle"></i> Vous devez entrer une quantité </h4>


            </div>
            <div class="modal-footer">


                <button class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>

    </div>
</div>


<script>


    function RobetTest() {

        var check = document.getElementById("checkrobot").checked;

        if (check) {
            document.getElementById("bt_menu").hidden = false;

        } else {

            document.getElementById("bt_menu").hidden = true;
        }


    }

    function getMenu() {
        getMenuFamille();
        FillListImageFamille();
    }

    function SuiviCommande() {
        var telclientsuivie = document.getElementById('telclientsuivie').value;

        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('dataArticle').innerHTML = this.responseText;
                //     console.info(this.responseText)

            }

        }

        xmlhttp.open("GET", "Service/suivieCommande.php?tel=" + telclientsuivie, true);
        xmlhttp.send();


    }


    //dataArticle
    function FillListImageFamille() {
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('dataArticle').innerHTML = this.responseText;
                //document.getElementById('btn_tout').focus();
                // document.getElementById('btn_tout').focus=true;

                //     console.info(this.responseText)

            }

        };

        xmlhttp.open("GET", "Service/getAllFamilleArticle.php", true);
        xmlhttp.send();
    }

    // FillListImageFamille();

    function FillListFamille(CodeFamille) {

        var numbc = document.getElementById('numbc').value;
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('dataArticle').innerHTML = this.responseText;
                //  console.info(this.responseText)

            }

        }

        xmlhttp.open("GET", "Service/getAllArticleParFamille.php?CodeFamille=" + CodeFamille + "&numbc=" + numbc, true);
        xmlhttp.send();
    }

    function addArticle(CodeArticle, PrixVenteTTC, Designation) {
        var numbc = document.getElementById('numbc').value;
        var qt = document.getElementById(CodeArticle).value;
        var fraislivraison = document.getElementById("fraislivraison").value;
        var seuillivraison = document.getElementById("seuillivraison").value;
        var totalfrais = document.getElementById("totalfrais");
        var totalpayer = document.getElementById("totalpayer");
        var observation = document.getElementById('observation').innerHTML;


        //  var listcmd = document.getElementById("listcmd");
        var total = document.getElementById("total");
        if (qt > 0) {
            if (window.XMLHttpRequest) {

                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {


                    //     listcmd.innerHTML += Designation + "(" + qt + ") , ";
                    var t = total.value;
                    t = t * 1 + PrixVenteTTC * qt;
                    total.value = t.toFixed(3);
                    if (t == 0) {
                        totalfrais.value = 0;
                    } else if (t > seuillivraison) {
                        totalfrais.value = 0;
                    } else {
                        totalfrais.value = fraislivraison;
                    }
                    var totpayer=t*1+fraislivraison*1;
                    totalpayer.value=totpayer.toFixed(3);
                    document.getElementById("bt_pannier").hidden = false;
                    document.getElementById("bt_pannier_down").hidden = false;
                    TotalCommande();
                    TotalNbCommande();
                    FillListImageFamille();
                }

            };
            var url = "Service/AddLigneCommandeTemporaire.php?" + "CodeArticle=" + CodeArticle + "&Quantite=" + qt + "&NumeroBonCommandeVente=" + numbc + "&observation=" + observation;
            console.info(url);
            xmlhttp.open("GET", url, true);
            xmlhttp.send();

        } else {

            $('#ModalErreurQTArticle').modal('show');

        }
    }

    function showDiagAnnuleCommande() {
        $('#ModalAnnuleCommande').modal('show');
    }

    function ValiderCommande() {

        var numbc = document.getElementById('numbc').value;
        var total = document.getElementById("total").value;
        if (total == 0) {
            // alert('Passer un article');
            $('#ModalERREUR').modal('show');
        } else {
            //location.href = "ValidationCommande.php?Num=" + numbc

            $('#ModalValidation').modal('show');
        }

    }

    //dataArticle
    function FillCommande() {
        var numbc = document.getElementById('numbc').value;
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('dataArticle').innerHTML = this.responseText;
                //     console.info(this.responseText)

            }

        }

        xmlhttp.open("GET", "Service/getCommande.php?Num=" + numbc, true);
        xmlhttp.send();
    }

    function getMenuFamille() {

        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('menu_horisontale').innerHTML = this.responseText;
                //     console.info(this.responseText)

            }

        };

        xmlhttp.open("GET", "Service/getMenuFamilleArticle.php", true);
        xmlhttp.send();
    }

    function getLogo() {
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('dataArticle').innerHTML = this.responseText;
                //  console.info(this.responseText)

            }

        };

        xmlhttp.open("GET", "Service/getLogo.php", true);
        xmlhttp.send();
    }


    function ViewArticle(CodeArticle) {
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('dataArticle').innerHTML = this.responseText;
                //  console.info(this.responseText)

            }

        };

        xmlhttp.open("GET", "Service/getDetailArticle.php?CodeArticle=" + CodeArticle, true);
        xmlhttp.send();
    }

    function ChangeQuantite(code, quantite, prixuntaire) {
        var qt = document.getElementById(code).value;


        var nv_qt = qt * 1 + quantite * 1;
        var prixtot = prixuntaire * 1 * nv_qt;
        if (nv_qt <= 0) {
            nv_qt = 1;
            prixtot = prixuntaire;
        }







        document.getElementById(code).value = nv_qt;
        document.getElementById('prixarticle').value = prixtot.toFixed(3);
    }

    function ChangeQuantiteCommande(code, quantite) {
        var qt = document.getElementById(code).value;
        var prixtot = document.getElementById('prix' + code).value;
        var prixunitaire = prixtot / qt;
        var nv_qt = qt * 1 + quantite * 1;
        if (nv_qt <= 0) {
            nv_qt = 1;
        }
        document.getElementById(code).value = nv_qt;
        var t = nv_qt * prixunitaire;
        document.getElementById('prix' + code).value = t.toFixed(3);
        ModifArticle(code, prixunitaire, "");
    }

    function deleteArticle(CodeArticle) {
        var numbc = document.getElementById('numbc').value;
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                console.info(this.responseText);
                FillCommande();
                TotalCommande();
                TotalNbCommande();
            }

        };

        xmlhttp.open("GET", "Service/deleteArticle.php?Num=" + numbc + "&CodeArticle=" + CodeArticle, true);
        xmlhttp.send();
    }

    function ModifArticle(CodeArticle, PrixVenteTTC, Designation) {

        var numbc = document.getElementById('numbc').value;
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                console.info(this.responseText);
                addArticleModif(CodeArticle, PrixVenteTTC, Designation);

                TotalCommande();
                TotalNbCommande();
            }

        };

        xmlhttp.open("GET", "Service/deleteArticle.php?Num=" + numbc + "&CodeArticle=" + CodeArticle, true);
        xmlhttp.send();
        //addArticle(CodeArticle, PrixVenteTTC, Designation)

    }

    //nbcommande
    function TotalNbCommande() {

        var numbc = document.getElementById('numbc').value;
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var t = this.responseText;
                document.getElementById("nbcommande").innerHTML = " (" + t + ")";

            }

        };

        xmlhttp.open("GET", "Service/getTotalNbArticle.php?Num=" + numbc, true);
        xmlhttp.send();
        //addArticle(CodeArticle, PrixVenteTTC, Designation)

    }


    function TotalCommande() {

        var numbc = document.getElementById('numbc').value;
        var fraislivraison = document.getElementById("fraislivraison").value;
        var seuillivraison = document.getElementById("seuillivraison").value;
        var totalfrais = document.getElementById("totalfrais");
        var totalpayer = document.getElementById("totalpayer");
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var t = this.responseText;

                var total = document.getElementById("total");
                var tot = t * 1;
                total.value = tot.toFixed(3);
                if (t == 0) {
                    totalfrais.value = 0;
                } else if (t > seuillivraison) {
                    totalfrais.value = 0;
                } else {
                    totalfrais.value = fraislivraison;
                }
                var totpayer=t*1+fraislivraison*1;
                totalpayer.value=totpayer.toFixed(3) ;

            }

        };

        xmlhttp.open("GET", "Service/getTotalCommande.php?Num=" + numbc, true);
        xmlhttp.send();
        //addArticle(CodeArticle, PrixVenteTTC, Designation)

    }

    function addArticleModif(CodeArticle, PrixVenteTTC, Designation) {
        var numbc = document.getElementById('numbc').value;
        var qt = document.getElementById(CodeArticle).value;
        var observation = document.getElementById("observation" + CodeArticle).innerHTML;

        //  var listcmd = document.getElementById("listcmd");
        var total = document.getElementById("total");
        if (qt > 0) {
            if (window.XMLHttpRequest) {

                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {


                    TotalCommande();
                    TotalNbCommande();
                }

            };
            var url = "Service/AddLigneCommandeTemporaire.php?" + "CodeArticle=" + CodeArticle + "&Quantite=" + qt + "&NumeroBonCommandeVente=" + numbc + "&observation=" + observation;
            console.info(url);
            xmlhttp.open("GET", url, true);
            xmlhttp.send();

        } else {
            alert('Entrez une quantite')
        }
    }

    function addObservation(observation, code) {
        var text = document.getElementById('observation').innerHTML;
        var ob = document.getElementById(code).checked;
        if (ob) {
            document.getElementById('observation').innerHTML += observation + ",";
        } else {
            var nv = text.replace(observation, '');
            document.getElementById('observation').innerHTML = nv;
        }


    }

    function EnregistrerCommande() {

        var numbc = document.getElementById('numbc').value;
        var client = document.getElementById('client').value;
        var telclient = document.getElementById('telclient').value;
        var adresse = document.getElementById('adresseclient').value;
        var latitude = document.getElementById('latitude').value;
        var longitude = document.getElementById('longitude').value;

        if (isNaN(telclient) && telclient.length > 8) {
            alert("donner un numero valide");
        } else if (client == "") {
            alert("Saisir votre nom ");

        } else {

            if (window.XMLHttpRequest) {

                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var t = this.responseText;
                    console.info(t);
                    //  location.reload();
                    location.href = "googlemap.php?latitude=" + latitude + "&longitude=" + longitude + "&telclient=" + telclient + "&numero=" + t;

                }

            };
            var url = "Service/ValideBonCommande.php?" + "client=" + client + "&telclient=" + telclient + "&NumeroBonCommandeVente=" + numbc + "&adresse=" + adresse + "&latitude=" + latitude + "&longitude=" + longitude;
            console.info(url);
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
    }


    function deleteAllArticle() {
        var numbc = document.getElementById('numbc').value;
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                console.info(this.responseText);
                document.getElementById("bt_pannier").hidden = true;
                document.getElementById("bt_pannier_down").hidden = true;
                FillCommande();
                TotalCommande();
                TotalNbCommande();
            }

        };

        xmlhttp.open("GET", "Service/deleteAllArticle.php?Num=" + numbc, true);
        xmlhttp.send();
    }


</script>

<!-- Moment Plugin JavaScript-->
<script src="js/moment.min.js"></script>
<!-- Jquery Library 2.1 JavaScript-->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- Popper JavaScript-->
<script src="js/popper.min.js"></script>
<!-- Bootstrap Core JavaScript-->
<script src="js/bootstrap.min.js"></script>
<!-- Material Design Lite JavaScript-->+
<script src="js/material.min.js"></script>
<!-- Material Select Field Script -->
<script src="js/mdl-selectfield.min.js"></script>
<!-- Flexslider Plugin JavaScript-->
<script src="js/jquery.flexslider.min.js"></script>
<!-- Owl Carousel Plugin JavaScript-->
<script src="js/owl.carousel.min.js"></script>
<!-- Scrolltofixed Plugin JavaScript-->
<script src="js/jquery-scrolltofixed.min.js"></script>
<!-- Magnific Popup Plugin JavaScript-->
<script src="js/jquery.magnific-popup.min.js"></script>
<!-- FullCalendar Plugin JavaScript-->
<script src="js/fullcalendar.min.js"></script>
<!-- WayPoint Plugin JavaScript-->
<script src="js/jquery.waypoints.min.js"></script>
<!-- CounterUp Plugin JavaScript-->
<script src="js/jquery.counterup.js"></script>
<!-- SmoothScroll Plugin JavaScript-->
<script src="js/smoothscroll.min.js"></script>
<!--Custom JavaScript for Klinik Template-->
<script src="js/custom.js"></script>

</body>

</html>
