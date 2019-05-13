<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="styles/styles.css">
  </head>
  <body>
      <div class="btn-markers">
        <a href="index.php"> Markers </a>
      </div>
      
      <div class="open-places">
          <button id="open">Hide closed locations</button>
      </div>
      
     <div id="map-container">
        <div id="map"></div>
    </div>
      
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script>

    <script type="text/javascript" src="script.js"></script> 
  </body>
</html>