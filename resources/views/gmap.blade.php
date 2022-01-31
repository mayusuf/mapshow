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

    function myFunction() {

      let strA = document.getElementById("autocompleteA").value;
      let strB = document.getElementById("autocompleteB").value;
      console.log(strA);
      console.log(strB);

      if(strA==""){
        alert("Address From is not seltedted")
      }
      if(strB==""){
        alert("Address To is not seltedted")
      }
      
      getRoute(strA,strB);

      

      return // whatever you want to do with it
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

          getoCodeA0 = geoJsonstrA.features[4].center[0];
          getoCodeA1 = geoJsonstrA.features[4].center[1];


          console.log(geoJsonstrA.features[4].center[0]);
          console.log(geoJsonstrA.features[4].center[1]);   

      const geoJsonstrB = await geostrB.json();  

          console.log(geoJsonstrB);

          getoCodeB0 = geoJsonstrB.features[4].center[0];
          getoCodeB1 = geoJsonstrB.features[4].center[1];

           console.log(geoJsonstrB.features[4].center[0]);
          console.log(geoJsonstrB.features[4].center[1]);  

       getRoute(getoCodeA0,getoCodeA1,getoCodeB0,getoCodeB1);  

      }

      

      async function getRoute(getoCodeA0,getoCodeA1,getoCodeB0,getoCodeB1) {

       const distance = await fetch(
          "https://api.mapbox.com/directions/v5/mapbox/driving/getoCodeA0,getoCodeA1;getoCodeB0,getoCodeB1?annotations=distance&overview=full&geometries=geojson&access_token=pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA",
          { method: 'GET' }
        );

       const duration = await fetch(
          "https://api.mapbox.com/directions/v5/mapbox/driving/getoCodeA0,getoCodeA1;getoCodeB0,getoCodeB1?annotations=duration&overview=full&geometries=geojson&access_token=pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA",
          { method: 'GET' }
        );

       const distanceJson = await distance.json();
       console.log(distanceJson);
       // const data = json.routes[0];
       // const route = data.geometry.coordinates;

       const durationJson = await duration.json();
       console.log(durationJson);
      
      document.getElementById("textAreaA").value = distanceJson;
      document.getElementById("textAreaB").value = durationJson;

     }

    </script>

  </head>

  <body>

    

     
    <form>
    
    From : <input type="text" id="autocompleteA"/>
    To : <input type="text" id="autocompleteB"/>
    <button type="button" onclick="myFunction()">sumbit</button>

    </form>
    <textarea id="textAreaA"/></textarea>
    <textarea id="textAreaB"/></textarea>

     <div id="map"></div>   

    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGKenOfSm3Xwm9gMyvic7nHX31DnLB18o&callback=initMap&libraries=places&v=weekly"
      async
    ></script>


  </body>
</html>
