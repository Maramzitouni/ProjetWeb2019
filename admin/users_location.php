<?php 
session_start();

require_once '../connexionDB.php'; // Fichier PHP contenant la connexion à notre BDD
    require_once'../functions.php';
 ?>
<!DOCTYPE html >
<html>
  <body>
    <div id="map"></div>

    <h2 id="startLat"> </h2>
    <h2 id="startLon"> </h2>

    

















    <script>
     window.onload = function() {
  var startPos;
  var geoSuccess = function(position) {
    startPos = position;
    document.getElementById('startLat').innerHTML = startPos.coords.latitude;
    document.getElementById('startLon').innerHTML = startPos.coords.longitude;
  };
navigator.geolocation.getCurrentPosition(geoSuccess);
};
// check for Geolocation support
if (navigator.geolocation) {
  console.log('Geolocation is supported!');
}
else {
  console.log('Geolocation is not supported for this Browser/OS.');
}
window.onload = function() {
  var startPos;
  var geoOptions = {
    maximumAge: 5 * 60 * 1000,
  }

  var geoSuccess = function(position) {
    startPos = position;
    document.getElementById('startLat').innerHTML = startPos.coords.latitude;
    document.getElementById('startLon').innerHTML = startPos.coords.longitude;
     
      



  };
  var geoError = function(error) {
    console.log('Error occurred. Error code: ' + error.code);
    // error.code can be:
    //   0: unknown error
    //   1: permission denied
    //   2: position unavailable (error response from location provider)
    //   3: timed out
  };

  navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
};




 
 
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("firstname=" + startPos.coords.latitude + "&lastname=" + startPos.coords.longitude );












    </script>
   
  </body>
</html>