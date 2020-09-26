<?php
require "connexion.php";
$sql = " select * from ZoneBlocageWeb  ";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$table = "";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $long_center = $row['LongitudeCenter'];
    $lat_center = $row['LatitudeCenter'];
    $Rayon = $row['Rayon'];
    $table .= "<tr>
<td>$long_center</td>
<td>$lat_center</td>
<td>$Rayon</td>
</tr>";

}


?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Places Search Box</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 85%;
            width: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;


        }

        #infowindow-content .title {
            font-weight: bold;
            font-size: 18px;


        }

        #infowindow-content {
            display: none;

        }

        #map #infowindow-content {
            display: inline;

        }

        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: red;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;

        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;

            padding: 15px;
            text-overflow: ellipsis;


        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        #target {
            width: 345px;
        }

    </style>
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

<?php //&latitude=" + latitude + "&longitude=" + longitude

//  ?>

<div class="row p-4 ">

    <div class="col-md-6 row  text-center ">


        <div class="col-md-12 row">
            <label class="alert-info col-md-3">Position Markeur</label>
            <input type="text" class="form-control col-md-4" readonly id="longitude">
            <input type="text" class="form-control col-md-4" readonly id="latitude">
        </div>
        <div class="col-md-12 row">
            <button class="btn btn-info btn-sm col-md-4" onclick="MarkerCenter()">Définir comme Point Center</button>

        </div>
        <div class="col-md-12 row">
            <button class="btn btn-success btn-sm col-md-4" onclick="MarkerExtreme()">Définir comme Point Extreme
            </button>
        </div>
        <div class="col-md-12 row">
            <button class="btn btn-dark btn-sm col-md-4" onclick="FillListBlocage()">
                <i class="fa fa-eye"></i>  Voir Liste zone bloquée</button>
        </div>
    </div>
    <div class="col-md-6 row  text-center">
        <div class="col-md-12 row">
            <label class=" col-md-3">Designation Zone</label>
            <input type="text" id="Designation" autocomplete="off" class="col-md-8 form-control " placeholder="donner une designation ">
        </div>
        <div class="col-md-12 row">
            <label class="alert-info col-md-3">Coordonnées Center</label>
            <input type="text" class="form-control col-md-4" readonly id="LongitudeCenter">
            <input type="text" readonly class="form-control col-md-4" id="LatitudeCenter">
        </div>
        <div class="col-md-12 row">
            <label class="alert-success col-md-3">Coordonnées Extreme</label>
            <input type="text" class="form-control col-md-4" readonly id="LongitudeExtreme">

            <input type="text" readonly class="form-control col-md-4" id="LatitudeExtreme">
        </div>
        <div class="col-md-12 text-center center row">
        <button class="btn btn-danger btn-sm col-md-4" onclick="validerLocation()">Valider Zone Blocage</button>
        </div>
    </div>


</div>


<div class="col-md-12 alert-danger text-center">
    <input id="pac-input" type="text" class="controls" placeholder="rechercher adresse">
</div>

<div id="map"></div>
<button id="bt_valider"></button>

<span id="erreurzone" class="alert-danger"></span>

<table id="table" hidden class="table">
    <tbody>
    <?php echo $table ?>
    </tbody>
</table>

<div class="modal fade" id="ModalErreurLocation" role="dialog">
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
                <h4><i class="fa fa-exclamation-triangle"></i> Vous devez taper sur le map pour prendre les deux points
                </h4>


            </div>
            <div class="modal-footer">


                <button class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="ModalListBlocage" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-red">

                <h4 class="modal-title"> ZOne bloquée </h4>
            </div>
            <div class="modal-body">

                <br>
                <table class="table">
                    <tbody id="dataListBlocage">


                    </tbody>
                </table>


            </div>
            <div class="modal-footer">


                <button class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>

    </div>
</div>
<script>
    function DeleteZone(CodeZone) {
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                getListBlocage();


            }

        };

        xmlhttp.open("GET", "Service/deleteZoneBlocage.php?CodeZone=" + CodeZone, true);
        xmlhttp.send();
    }

    function FillListBlocage() {
        getListBlocage();
        $('#ModalListBlocage').modal('show');
    }

    function getListBlocage() {

        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('dataListBlocage').innerHTML = this.responseText;
                //     console.info(this.responseText)

            }

        };

        xmlhttp.open("GET", "Service/getListZoneBlocage.php", true);
        xmlhttp.send();
    }


    function MarkerCenter() {
        document.getElementById("LongitudeCenter").value = document.getElementById("longitude").value;
        document.getElementById("LatitudeCenter").value = document.getElementById("latitude").value;
    }

    function MarkerExtreme() {
        document.getElementById("LongitudeExtreme").value = document.getElementById("longitude").value;
        document.getElementById("LatitudeExtreme").value = document.getElementById("latitude").value;
    }

    function initAutocomplete() {
        var mon_latitude = "33.88751526700937";
        var mon_longitude = "10.106127709150314";
        console.info("mon_latitude=" + mon_latitude + "mon_longitude" + mon_longitude);
//Le 52
//52 شارع الحبيب بورقيبة - Avenue Habib Bourguiba، Gabès 6000
//33.887613, 10.106148
        var le52 = new Object();
        le52.lng = parseFloat(mon_longitude);
        le52.lat = parseFloat(mon_latitude);
        var map = new google.maps.Map(document.getElementById('map'), {

            center: le52,
            zoom: 20,
            mapTypeId: google.maps.MapTypeId.HYBRID
        });
        //


        //zone interdite map

        var table, tr, td, i, txtValue;
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");

        var test = false;
        for (i = 0; i < tr.length; i++) {
            var td_long_center = tr[i].getElementsByTagName("td")[0];
            var td_lat_center = tr[i].getElementsByTagName("td")[1];
            var td_rayon = tr[i].getElementsByTagName("td")[2];
            if (td_long_center) {

                var Rayon = td_rayon.innerText;
                var LongitudeCenter = td_long_center.innerText;
                var LatitudeCenter = td_lat_center.innerText;


                var distance2 = Math.sqrt(Math.pow((mon_latitude - LatitudeCenter), 2) + Math.pow((mon_longitude - LongitudeCenter), 2));
                console.info(distance2 > Rayon);


                console.info("distance=" + distance2 + "****" + "Rayon=" + Rayon);
                if (distance2 < Rayon) {
                    test = true;

                }


            }
        }


        if (test) {
            alert("Vous etes hors zone limites , vous pouvez choisir une autre zone ");

            document.getElementById("erreurzone").innerHTML = "Vous etes hors zone limites , vous pouvez choisir une autre zone ";

        } else {

            document.getElementById("erreurzone").innerHTML = "";

        }


        //
        // // Create the initial InfoWindow.
        var infoWindow = new google.maps.InfoWindow(
            {content: 'Ma Position', position: le52});
        infoWindow.setContent("<div style='color:red;font-weight: bold'>le 52 </div>");
        infoWindow.open(map);

        map.addListener('click', function (mapsMouseEvent) {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({position: mapsMouseEvent.latLng});
            infoWindow.setContent("<div style='color:red;font-weight: bold'>Position </div>");

            var pos = mapsMouseEvent.latLng.toString();
            pos = pos.replace("(", "");
            pos = pos.replace(")", "");
            var l = pos.split(',')[0];
            var lon = pos.split(',')[1];
            lon = lon.replace("\n", "");
            lon = lon.replace("\r", "");
            lon = lon.replace("\n", "");
            lon = lon.replace("%20", "");
            lon = lon.replace("%\ds+=1", "");
            document.getElementById('latitude').value = l;
            document.getElementById('longitude').value = lon;
            console.info("longitude" + lon);
            console.info("latitude" + l);
            mon_latitude = l;
            mon_longitude = lon;
            console.info("mon_latitude=" + mon_latitude + "mon_longitude" + mon_longitude);
            var test = false;

            for (i = 0; i < tr.length; i++) {
                var td_long_center = tr[i].getElementsByTagName("td")[0];
                var td_lat_center = tr[i].getElementsByTagName("td")[1];
                var td_rayon = tr[i].getElementsByTagName("td")[2];


                var Rayon = td_rayon.innerText;
                var LongitudeCenter = td_long_center.innerText;
                var LatitudeCenter = td_lat_center.innerText;


                var distance2 = Math.sqrt(Math.pow((mon_latitude - LatitudeCenter), 2) + Math.pow((mon_longitude - LongitudeCenter), 2));


                console.info("i" + i + "distance=" + distance2 + "****" + "Rayon=" + Rayon);
                if (distance2 < Rayon) {
                    test = true;

                }


                console.info("test=" + i + "///" + test);


            }


            if (test) {
                alert("Vous etes hors zone limites , vous pouvez choisir une autre zone ");
                document.getElementById("bt_valider").disabled = true;
                document.getElementById("erreurzone").innerHTML = "Vous etes hors zone limites , vous pouvez choisir une autre zone ";

            } else {
                document.getElementById("bt_valider").disabled = false;
                document.getElementById("erreurzone").innerHTML = "";

            }


            infoWindow.open(map);
        });


        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function (marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    function validerLocation() {

        var LongitudeCenter = document.getElementById("LongitudeCenter").value;
        var LatitudeCenter = document.getElementById("LatitudeCenter").value;
        var LongitudeExtreme = document.getElementById("LongitudeExtreme").value;
        var LatitudeExtreme = document.getElementById("LatitudeExtreme").value;
        var Designation = document.getElementById("Designation").value;
        var Rayon = Math.sqrt(Math.pow((LatitudeExtreme - LatitudeCenter), 2) +
            Math.pow((LongitudeExtreme - LongitudeCenter), 2));


        if (LatitudeExtreme == "" || LongitudeCenter == "" || Rayon == 0) {
            $('#ModalErreurLocation').modal('show');
        } else {

            if (window.XMLHttpRequest) {

                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {


                    location.href = "blocageMap.php";

                }

            };

            xmlhttp.open("GET", "Service/ZoneBlocage.php?LongitudeCenter=" + LongitudeCenter
                + "&LatitudeCenter=" + LatitudeCenter + "&Rayon=" + Rayon + "&Designation=" + Designation, true);
            xmlhttp.send();

        }


    }


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUpACXQtN3tSUhtmYlvinkNlyUvv_IMM8&libraries=places&callback=initAutocomplete"
        async defer></script>
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

<!-- Scrolltofixed Plugin JavaScript-->
<script src="js/jquery-scrolltofixed.min.js"></script>
<!-- Magnific Popup Plugin JavaScript-->
<script src="js/jquery.magnific-popup.min.js"></script>


<!-- CounterUp Plugin JavaScript-->
<script src="js/jquery.counterup.js"></script>

<script src="js/custom.js"></script>
</body>
</html>
