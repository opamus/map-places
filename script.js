/* setTimeout(initMap, 100);
function initMap() {
    var mapOptions =
       {
            zoom: 12,
            center:new google.maps.LatLng(-33.879917,151.210449) //center over sydney
       };

   map = new google.maps.Map(document.getElementById('map'), mapOptions);

}

*/
setTimeout(initMap, 100);
var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        },
        shop: {
            label: 'S'
        },
        home: {
            label: 'H'
        },
        test: {
            label: 'T'
        },
      };

        function initMap() {
            
        // Create a map
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: 12,
          fullscreenControl: true
        });
        var infoWindow = new google.maps.InfoWindow;

          // Open the markers.xml file and get data from it by attribute name
          downloadUrl('markers.xml', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            // Loop through the xml file and get necessary attributes
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
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
              
              var text2 = document.createElement('text');
              text2.textContent = type
              infowincontent.appendChild(text2);
              
              
              // Create custom label from the type (restaurant, bar, shop, home, test)
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              // Finally, add a listener to open infoWindow and show content
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
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