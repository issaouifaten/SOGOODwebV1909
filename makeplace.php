<!---->
<!---->
<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <meta charset="utf-8" />-->
<!--    <title>Add a default marker</title>-->
<!--    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />-->
<!--    <script src="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js"></script>-->
<!--    <link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />-->
<!--    <style>-->
<!--        body { margin: 0; padding: 0; }-->
<!--        #map { position: absolute; top: 0; bottom: 0; width: 100%; }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<!--<div id="map"></div>-->
<!---->
<script>

</script>
<!---->
<!--</body>-->
<!--</html>-->


<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />
</head>
<body>
<DIV id="position"></DIV>
<div id='map' style='width: 100%; height: 100%;'></div>

<script>

    mapboxgl.accessToken = 'pk.eyJ1IjoiZmF0ZW5pc3Nhb3VpIiwiYSI6ImNrYTg5cDQwMDA2ZzczMnM5NXlzb3p2bDgifQ.zpQwQbBXcovbCGgBin8P9w';
    mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.1.0/mapbox-gl-rtl-text.js');

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [10.100520651888388, 33.88476235226318],
        zoom: 8
    });

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
<script>

</script>

</body>
</html>
<html>
<!--<head>-->
<!--    <meta charset="utf-8" />-->
<!--    <title>Add a GeoJSON line</title>-->
<!--    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />-->
<!--    <script src="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js"></script>-->
<!--    <link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />-->
<!--    <style>-->
<!--        body { margin: 0; padding: 0; }-->
<!--        #map { position: absolute; top: 0; bottom: 0; width: 100%; }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<!--<div id="map"></div>-->
<!--<script>-->
<!--    mapboxgl.accessToken = 'pk.eyJ1IjoiZmF0ZW5pc3Nhb3VpIiwiYSI6ImNrYTg5cDQwMDA2ZzczMnM5NXlzb3p2bDgifQ.zpQwQbBXcovbCGgBin8P9w';-->
<!--    var map = new mapboxgl.Map({-->
<!--        container: 'map',-->
<!--        style: 'mapbox://styles/mapbox/streets-v11',-->
<!--        center: [-122.486052, 37.830348],-->
<!--        zoom: 15-->
<!--    });-->
<!---->
<!--    map.on('load', function() {-->
<!--        map.addSource('route', {-->
<!--            'type': 'geojson',-->
<!--            'data': {-->
<!--                'type': 'Feature',-->
<!--                'properties': {},-->
<!--                'geometry': {-->
<!--                    'type': 'LineString',-->
<!--                    'coordinates': [-->
<!--                        [-122.48369693756104, 37.83381888486939],-->
<!--                        [-122.48348236083984, 37.83317489144141],-->
<!--                        [-122.48339653015138, 37.83270036637107],-->
<!--                        [-122.48356819152832, 37.832056363179625],-->
<!--                        [-122.48404026031496, 37.83114119107971],-->
<!--                        [-122.48404026031496, 37.83049717427869],-->
<!--                        [-122.48348236083984, 37.829920943955045],-->
<!--                        [-122.48356819152832, 37.82954808664175],-->
<!--                        [-122.48507022857666, 37.82944639795659],-->
<!--                        [-122.48610019683838, 37.82880236636284],-->
<!--                        [-122.48695850372314, 37.82931081282506],-->
<!--                        [-122.48700141906738, 37.83080223556934],-->
<!--                        [-122.48751640319824, 37.83168351665737],-->
<!--                        [-122.48803138732912, 37.832158048267786],-->
<!--                        [-122.48888969421387, 37.83297152392784],-->
<!--                        [-122.48987674713133, 37.83263257682617],-->
<!--                        [-122.49043464660643, 37.832937629287755],-->
<!--                        [-122.49125003814696, 37.832429207817725],-->
<!--                        [-122.49163627624512, 37.832564787218985],-->
<!--                        [-122.49223709106445, 37.83337825839438],-->
<!--                        [-122.49378204345702, 37.83368330777276]-->
<!--                    ]-->
<!--                }-->
<!--            }-->
<!--        });-->
<!--        map.addLayer({-->
<!--            'id': 'route',-->
<!--            'type': 'line',-->
<!--            'source': 'route',-->
<!--            'layout': {-->
<!--                'line-join': 'round',-->
<!--                'line-cap': 'round'-->
<!--            },-->
<!--            'paint': {-->
<!--                'line-color': '#888',-->
<!--                'line-width': 8-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->

</body>
</html>