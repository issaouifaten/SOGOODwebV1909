<?php ?>

<html>


<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUpACXQtN3tSUhtmYlvinkNlyUvv_IMM8&libraries=places&callback=initAutocomplete"
            async defer></script>
</head>
<body>
<div id="map"></div>
</body>
<style>
    #map {
        border: 1px solid black;
        margin: 0 auto;
        width: 500px;
        height: 300px;
    }
</style>
<script>



    var map;
    var mapProp;
    var url;
    var marker;
    var markers = [];
    var infoWindow;
    var wellCircle;

    function initMap() {
        var mon_latitude = "33.88751526700937";
        var mon_longitude = "10.106127709150314";
        console.info("mon_latitude=" + mon_latitude + "mon_longitude" + mon_longitude);
//Le 52
//52 شارع الحبيب بورقيبة - Avenue Habib Bourguiba، Gabès 6000
//33.887613, 10.106148
        var le52 = new Object();
        le52.lng = parseFloat(mon_longitude);
        le52.lat = parseFloat(mon_latitude);
        mapProp = {
            center: le52,
            zoom: 60,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        map = new google.maps.Map(document.getElementById("map"), mapProp);
        infoWindow = new google.maps.InfoWindow({
            content: "hello world"
        });
    };



    function addMarker(lat, lng) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map
        });
        markers.push(marker);
        //console.log(markers);
    };
    $(document).ready(function() {
        url = 'https://data.colorado.gov/resource/hfwh-wsgi.json?&$limit=500';
        initMap();




            addMarker(33.88751526700937,10.106127709150314);
            var wellCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: new google.maps.LatLng(33.88751526700937, 10.106127709150314),
                radius: 	0.023395082604626916*1000
            });


    });



</script>
</html>
