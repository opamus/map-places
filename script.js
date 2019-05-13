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
        park: {
            label: 'P'
        }
      };

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
              
              if (hour >= second || hour <= first) {
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
              
              var button = document.getElementById("open");
              button.addEventListener('click', getOpenLocations);
              
              function getOpenLocations() {
                  if(text3.textContent == "Closed. Opening hours: " + hours) {
                      marker.setVisible(false);
                      button.innerHTML = "Show closed locations";
                  } else {
                      doNothing();
                  }
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
      