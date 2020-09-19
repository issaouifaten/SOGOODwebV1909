
<br><br>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Change a map's language</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />

    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>
</head>
<body>
<style>
    #buttons {
        width: 90%;
        margin: 0 auto;
    }
    .button {
        display: inline-block;
        position: relative;
        cursor: pointer;
        width: 20%;
        padding: 8px;
        border-radius: 3px;
        margin-top: 10px;
        font-size: 12px;
        text-align: center;
        color: #fff;
        background: #ee8a65;
        font-family: sans-serif;
        font-weight: bold;
    }

</style>
<br><br><br><br><br><br>
<div id="map" style=" width: 500px"></div>
<ul id="buttons">
    <li id="button-fr" class="button">French</li>
    <li id="button-ru" class="button">Russian</li>
    <li id="button-de" class="button">German</li>
    <li id="button-es" class="button">Spanish</li>

</ul>
<script>
    // Add right to left text support to support Arabic labels
    mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.1.0/mapbox-gl-rtl-text.js');


    mapboxgl.accessToken = 'pk.eyJ1IjoiZmF0ZW5pc3Nhb3VpIiwiYSI6ImNrYTg5cDQwMDA2ZzczMnM5NXlzb3p2bDgifQ.zpQwQbBXcovbCGgBin8P9w';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v10',
        center: [16.05, 48],
        zoom: 2.9
    });
    map.addControl(new MapboxBrowserLanguage({  defaultLanguage: 'ar'}));
    document
        .getElementById('buttons')
        .addEventListener('click', function(event) {
            var language = event.target.id.substr('button-'.length);
            // Use setLayoutProperty to set the value of a layout property in a style layer.
            // The three arguments are the id of the layer, the name of the layout property,
            // and the new property value.
            map.setLayoutProperty('country-label', 'text-field', [
                'get',
                'name_' + language
            ]);
        });
</script>

</body>
</html>
