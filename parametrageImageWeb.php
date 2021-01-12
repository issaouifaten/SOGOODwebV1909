<?php
IF (isset($_POST["bt_uplpad_img"])) {
    require "connexion.php";
    $CodeFamille = $_POST['spinFamilleArticle'];

    $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    $folder = "images/";

    // new file size in KB
    $new_size = $file_size / 1024;
    // new file size in KB

    // make file name in lower case
    $new_file_name = strtolower($file);
    // make file name in lower case

    $final_file = str_replace(' ', '-', $new_file_name);

    if (move_uploaded_file($file_loc, $folder . $final_file)) {


        $sql = "update FamilleArticle set Url='$file' where CodeFamille=?";


        $stmt = sqlsrv_prepare($conn, $sql, array(&$CodeFamille));

        if (!$stmt) {
            echo '!sql <br>';
            die(print_r(sqlsrv_errors(), true));
        }


        if (sqlsrv_execute($stmt) === false) {
            echo 'excute <br>';
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_free_stmt($stmt);

    }
    header("location:parametrageImageWeb.php");
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

<body class="bg-dark"  style='font-family: "Ma Super Fonte", Helvetica, Arial, sans-serif; '>

<!-- Navigation -->
<!-- Featured Products -->
<div class="container p-5">


    <form action=" " method="POST" autocomplete="off" enctype="multipart/form-data">


        <div class="row bg-white p-1">
            <div class="col-md-12">
                <label class="text-primary font-20">Choissir une famille d'article </label><br>

                <select class="form-input color-dark-light font-20" name="spinFamilleArticle" id="spinFamilleArticle"
                        onchange="getImageActuel()">


                </select>
            </div>

            <div class="col-md-6">
                <h2>Image Actuelle</h2>

                <img id="imageactuelle" style="width: 300px;height: 300px">
            </div>
            <div class="col-md-6">
                <h2>Image Upload</h2>
                <input type="file" id="files" name="file"/>
                <img id="image" style="width: 300px;height: 300px"/>
            </div>
            <div class="right">
            <button type="submit" name="bt_uplpad_img" class="btn btn-sm right   btn-primary"><i class="fa fa-check"></i> Valider
            </button>
            </div>



        </div>




    </form>


</div>


</body>
</html>
<script>
    document.getElementById("files").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("image").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };


    function getSpin() {

        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {


                document.getElementById("spinFamilleArticle").innerHTML = this.responseText;
            }

        };

        xmlhttp.open("GET", "Service/getSpinFamilleArticle.php", true);
        xmlhttp.send();
    }


    getSpin();

    function getImageActuel() {
        var CodeFamille = document.getElementById("spinFamilleArticle").value;

        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {


                document.getElementById("imageactuelle").src = this.responseText;

                console.error(this.responseText);

            }

        };

        xmlhttp.open("GET", "Service/getImageFamilleArticle.php?CodeFamille=" + CodeFamille, true);
        xmlhttp.send();
    }


</script>
