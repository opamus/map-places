var modal = document.getElementById('modal');
var btn = document.getElementById('btn');
var span = document.getElementById('close');

btn.onclick = function() {
    modal.style.display = 'block';
}
span.onclick = function() {
    modal.style.display = 'none';
}
window.onclick = function(event) {
    if(event.target == modal) {
        modal.style.display = 'none';
    }
}

setTimeout(initMap, 100);
        function initMap() {
            
            
        // Create a map
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: 11,
          fullscreenControl: true,
          streetViewControl: false
        });
        var infoWindow = new google.maps.InfoWindow;

          // Open the markers.xml file and get data from it by attribute name
          downloadUrl('markers.xml', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            // Loop through the xml file and get necessary attributes
            Array.prototype.forEach.call(markers, function(markerElem) {
              // var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var hours = markerElem.getAttribute('hours');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('latitude')),
                  parseFloat(markerElem.getAttribute('longitude')));

              // Create infowindow with div, strong for name and text for address and type
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              infowincontent.appendChild(document.createElement('br'));
              
              var text2 = document.createElement('p');
              text2.textContent = type
              infowincontent.appendChild(text2);
              
              // set if the place is open, no hours provided or closed
              var today = new Date();
              var hour = today.getHours();
              console.log(hour);
              
              var first = hours.split('-')[0];
              var second = hours.split('-')[1];
              // Change infowindow text if place is closed or open or no hours provided
              if (hour >= second || hour < first) {
                  var text3 = document.createElement('p');
                  text3.style="color:red; margin-bottom:0;";
                  text3.textContent = "Closed. Opening hours: " + hours;
                  infowincontent.appendChild(text3);
              } else if (hours === ""){
                  var text3 = document.createElement('p');
                  text3.style="color:#2d7caf; margin-bottom:0;";
                  text3.textContent = "No opening hours provided.";
                  infowincontent.appendChild(text3);
              } else {
                  var text3 = document.createElement('p');
                  text3.style="color:#2d7caf; margin-bottom:0;";
                  text3.textContent = hours;
                  infowincontent.appendChild(text3);
              }
              // Create custom label from the type (restaurant, bar, shop, home, test)
              var marker = new google.maps.Marker({
                map: map,
                position: point,
              });
              
              // Finally, add a listener to open infoWindow and show content
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
              
              var button = document.getElementById("open");
              button.addEventListener('click', getOpenLocations);
              
              function getOpenLocations() {
                  if(text3.textContent === "Closed. Opening hours: " + hours) {
                      marker.setVisible(false);
                      button.innerHTML = "Show closed locations";
                      button.removeEventListener('click', getOpenLocations);
                      button.addEventListener('click', showClosedLocations);
                  } else  {
                      doNothing();
                  }
              }
              
              function showClosedLocations () {
                  marker.setVisible(true);
                  button.innerHTML = "Hide closed locations";
                  button.removeEventListener('click', showClosedLocations);
                  button.addEventListener('click', getOpenLocations);
              }
              
              
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
      