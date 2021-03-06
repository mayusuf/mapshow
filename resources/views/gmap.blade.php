<!DOCTYPE html>
<html>
  <head>
    <title>G Map</title>
    <link rel="stylesheet" href="{{asset('css/gmap.css')}}">

    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>

    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>

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

      var input1 = document.getElementById('autocompleteA');
      var input2 = document.getElementById('autocompleteB');

      const autocomplete1 = new google.maps.places.Autocomplete(input1,{origin:{ lat: 140.749933, lng: -140.98633 },types: ['(cities)']});

      const autocomplete2 = new google.maps.places.Autocomplete(input2,{origin:{ lat: 140.749933, lng: -140.98633 },types: ['(cities)']});

      autocomplete1.bindTo("bounds", map);
      autocomplete2.bindTo("bounds", map);

      google.maps.event.addListener(autocomplete1, 'place_changed', function(){
         var place = autocomplete1.getPlace();
         console.log(place);
      });

      google.maps.event.addListener(autocomplete2, 'place_changed', function(){
         var place = autocomplete2.getPlace();
         
      });
    }

    function getAddress() {

      let strA = document.getElementById("autocompleteA").value;
      let strB = document.getElementById("autocompleteB").value;
      console.log(strA);
      console.log(strB);

      if(strA==""){
        alert("Address From is not selected");
      }
      if(strB==""){
        alert("Address To is not selected");
      }
      
      getRoute(strA,strB);

      

      return;
  }

  async function getRoute(strA,strB) {

      const geostrA = await fetch(
          "https://api.mapbox.com/geocoding/v5/mapbox.places/strA.json?access_token=pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA",
          { method: 'GET' }
        );

      const geostrB = await fetch(
          "https://api.mapbox.com/geocoding/v5/mapbox.places/strB.json?access_token=pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA",
          { method: 'GET' }
        );

    

      const geoJsonstrA = await geostrA.json();

          console.log(geoJsonstrA);

          getoCodeA0 = geoJsonstrA.features[0].center[0];
          getoCodeA1 = geoJsonstrA.features[0].center[1];


          console.log(geoJsonstrA.features[0].center[0]);
          console.log(geoJsonstrA.features[0].center[1]);   

      const geoJsonstrB = await geostrB.json();  

          console.log(geoJsonstrB);

          getoCodeB0 = geoJsonstrB.features[0].center[0];
          getoCodeB1 = geoJsonstrB.features[0].center[1];

           console.log(geoJsonstrB.features[0].center[0]);
          console.log(geoJsonstrB.features[0].center[1]);  

        getInfo(getoCodeA0,getoCodeA1,getoCodeB0,getoCodeB1);  

      }

      

      async function getInfo(getoCodeA0,getoCodeA1,getoCodeB0,getoCodeB1) {

       const distance = await fetch(
          `https://api.mapbox.com/directions/v5/mapbox/driving/${getoCodeA0},${getoCodeA1};${getoCodeB0},${getoCodeB1}?annotations=distance&overview=full&geometries=geojson&access_token=pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA`,
          { method: 'GET' }
        );

       const duration = await fetch(
          `https://api.mapbox.com/directions/v5/mapbox/driving/${getoCodeA0},${getoCodeA1};${getoCodeB0},${getoCodeB1}?annotations=duration&overview=full&geometries=geojson&access_token=pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA`,
          { method: 'GET' }
        );

       const distanceJson = await distance.json();
       console.log(distanceJson);
       const distanceJsonData = distanceJson.routes[0];
       const distanceData = distanceJsonData.distance;

       const durationJson = await duration.json();
       console.log(durationJson);
       const durationJsonData = durationJson.routes[0];
       const durationData = durationJsonData.duration;
      
      document.getElementById("textAreaA").value = distanceData;
      document.getElementById("textAreaB").value = durationData;

     }

    </script>

  </head>

  <body>

    

     
    <form>
    
    From : <input type="text" id="autocompleteA"/>
    To : <input type="text" id="autocompleteB"/>
    <button type="button" onclick="getAddress()">sumbit</button>

    </form>
    Distance: <textarea id="textAreaA"/></textarea>
    Duration: <textarea id="textAreaB"/></textarea>

     <div id="map"></div>   

    <script
      src="https://maps.googleapis.com/maps/api/js?key=<API_KEY>&libraries=places&v=weekly"
      async
    ></script>


  </body>
</html>
