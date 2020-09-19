<!DOCTYPE html>
<!-- Template by Quackit.com -->
<!-- Images by various sources under the Creative Commons CC0 license and/or the Creative Commons Zero license.
Although you can use them, for a more unique website, replace these images with your own. -->
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>SOGOOD</title>


    <!-- Custom CSS: You can use this stylesheet to override any Bootstrap styles and/or apply your own styles -->
    <!-- Favicon Icon -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png"/>
    <!-- Font Awesoeme Stylesheet CSS -->
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

</head>

<body>
<header id="header">

    <!-- Start Main Header Section -->
    <div id="hdr-wrapper">
        <!-- Start Header Top Section -->
        <div id="hdr-top-wrapper">
            <div class="layer-stretch hdr-top">
                <div class="hdr-top-block ">
                    <div id="hdr-social hidden-xs">
                        Restaurant
                        SOGOOD
                    </div>
                </div>

                <div class="hdr-top-block hdr-number">
                    <div class="font-13">
                        <i class="fa fa-mobile font-20 tbl-cell"> </i> <span
                            class="hidden-xs tbl-cell">  Number : </span> <span class="tbl-cell">1800000000</span>
                    </div>
                </div>
                <div class="hdr-top-line"><a href="index.php"><i class="fa fa-home"></i></a></div>
                <div class="hdr-top-block">

                </div>
            </div>
        </div><!-- End Header Top Section -->
    </div><!-- End Main Header Section -->
</header><!-- End Header -->
<!-- Navigation -->
<!-- Featured Products -->
<div class="container">


      <div class="row">
        <!--        --><?php //require "Service/getMenuFamilleArticle.php" ?>
        <input type="text" id="numbc" value="<?php echo $_GET['Num'] ?>">
    </div>
    <div id="dataArticle" class="row">


    </div>
    <br><br>
    <br><br>


    <footer id="footer" class="fixed-bottom">

        <div class="row  ">
            <div class="col-md-8  ">


            </div>
            <div class="col-md-4  ">

                <!-- Input Group -->
                <div class="input-group">
                    <label class="label-footer"> Totale commande : &nbsp;</label>
                    <input type="number" id="total" class="form-control text-right" value="0" readonly>
                    <span class="input-group-btn">
								<button class="btn btn-danger" type="button" onclick="ValiderCommande()">
									<span class="fa fa-check" aria-hidden="true"></span>
									Valider
								</button>
							</span>
                </div>
            </div>
        </div>
    </footer>
</div><!-- /.container -->
<script>

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
                //     console.error(this.responseText)

            }

        }

        xmlhttp.open("GET", "Service/getCommande.php?Num="+numbc, true);
        xmlhttp.send();
    }

    FillCommande();



    function addArticle(CodeArticle, PrixVenteTTC, Designation) {
        var numbc = document.getElementById('numbc').value;
        var qt = document.getElementById(CodeArticle).value;
        var listcmd = document.getElementById("listcmd");
        var total = document.getElementById("total");


        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {


                listcmd.innerHTML += Designation + "("+qt+") , ";
                var t = total.value;
                t = t * 1 + PrixVenteTTC * qt;
                total.value = t.toFixed(3);
                console.info(this.responseText)
            }

        };
        var url = "Service/AddLigneCommandeTemporaire.php?" + "CodeArticle=" + CodeArticle + "&Quantite=" + qt + "&NumeroBonCommandeVente=" + numbc;
        console.error(url);
        xmlhttp.open("GET", url, true);
        xmlhttp.send();


    }
    function ValiderCommande() {
        var numbc = document.getElementById('numbc').value;
        var total = document.getElementById("total").value;
        if(total==0)
        {
            alert('Passer un article');
        }else{
            location.href="ValidationCommande.php?Num="+numbc
        }

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
<!-- Material Design Lite JavaScript-->
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
