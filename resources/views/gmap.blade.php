<!DOCTYPE html>
<html>
  <head>
    <title>G Map</title>
    <link rel="stylesheet" href="{{asset('css/gmap.css')}}">

     <script>

      function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: 40.749933, lng: -73.98633 },
          zoom: 13
      });

      // The marker, positioned at Uluru
      const marker = new google.maps.Marker({
        position: { lat: 40.749933, lng: -73.98633 },
        map: map,
      });

      var input = document.getElementById('autocomplete');

      const autocomplete = new google.maps.places.Autocomplete(input,{origin:{ lat: 40.749933, lng: -73.98633 },radius:100,types: ['(cities)']});

      autocomplete.bindTo("bounds", map);

      google.maps.event.addListener(autocomplete, 'place_changed', function(){
         var place = autocomplete.getPlace();
         console.log(place);
      });
    }
    </script>

  </head>

  <body>

    <!--  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGKenOfSm3Xwm9gMyvic7nHX31DnLB18o&callback=initMap&libraries=places"></script> -->

     

    <input type="text" id="autocomplete"/>

     <div id="map"></div>   

    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGKenOfSm3Xwm9gMyvic7nHX31DnLB18o&callback=initMap&libraries=places&v=weekly"
      async
    ></script>

  </body>
</html>