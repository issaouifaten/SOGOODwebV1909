<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Add a geocoder</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.10.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.10.1/mapbox-gl.css" rel="stylesheet" />
    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>
</head>
<body>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<link
    rel="stylesheet"
    href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css"
    type="text/css"
/>
<!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<DIV id="position"></DIV>
<div id='map' style='width: 90%; height: 90%;'></div>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiZmF0ZW5pc3Nhb3VpIiwiYSI6ImNrYTg5cDQwMDA2ZzczMnM5NXlzb3p2bDgifQ.zpQwQbBXcovbCGgBin8P9w';
    // mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.1.0/mapbox-gl-rtl-text.js');

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-v9',
      // style: 'mapbox://styles/mapbox/satellite-streets-v11',
        //style: 'mapbox://styles/mapbox/navigation-guidance-day-v4',
        center: [10.103935,33.8875153],
        zoom: 11
    });

    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        })
    );




    var marker = new mapboxgl.Marker()
        .setLngLat([10.100520651888388,33.88476235226318])
        .addTo(map);
    map.on('click', function(e) {
        // The event object (e) contains information like the
        // coordinates of the point on the map that was clicked.
        console.error('A click event has occurred at ' + e.lngLat);
        document.getElementById("position" ).innerHTML= e.lngLat;
        var marker = new mapboxgl.Marker()
            .setLngLat(e.lngLat)
            .addTo(map);
    });






    var geolocate = new mapboxgl.GeolocateControl({
        positionOptions: {
            enableHighAccuracy: true
        },
        trackUserLocation: true
    });
    // Add the control to the map.
    map.addControl(geolocate);
    // Set an event listener that fires
    // when a geolocate event occurs.
    geolocate.on('geolocate', function() {
        console.error('A geolocate event has occurred.')
    });
















</script>

</body>
</html>
