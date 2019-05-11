setTimeout(initMap, 100);
function initMap() {
    var mapOptions =
       {
            zoom: 12,
            center:new google.maps.LatLng(-33.879917,151.210449) //center over sydney
       };

   map = new google.maps.Map(document.getElementById('map'), mapOptions);

}
