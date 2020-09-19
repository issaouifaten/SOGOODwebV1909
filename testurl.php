
<?php
header('X-Frame-Options: GOFORIT');
?>
<html>

<head>

</head>
<body>
<button onclick="openWin()">open   </button>
<button onclick="getURL()">get   </button>

</body>
<script>
   // window.location.href
var myWindow;
   function openWin() {
       myWindow = window.open("https://www.google.fr/maps/@34.3024799,10.023983,10.25z", "myWindow", "width=200,height=100");   // Opens a new window
   }

   function closeWin() {
       myWindow.close();   // Closes the new window
   }
   function getURL() {
       alert("The URL of this page is: " + myWindow.location.href);

   }




</script>
</html>
