<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <title>Getting started with the Mapbox Directions API</title>
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
    <style>
      body {
        margin: 0;
        padding: 0;
      }

      #map {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
      }
    </style>

    <script type="text/javascript">
      
      

    </script>

  </head>
  <body>
    <div id="map"></div>
    <div id="instructions"></div>

    <script>
      
      mapboxgl.accessToken = 'pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA';

      const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-84.518641,39.134270], // starting position
        zoom: 12
      });
      // set the bounds of the map
      const bounds = [
        [-123.069003, 45.395273],
        [-122.303707, 45.612333]
      ];
      map.setMaxBounds(bounds);


      // an arbitrary start will always be the same
      // only the end or destination will change
      const start = [-84.518641,39.134270];
      const end = [-84.512023,39.102779];


      // this is where the code for the next step will go

      // create a function to make a directions request
      async function getRoute(end) {
        // make a directions request using cycling profile
        // an arbitrary start will always be the same
        // only the end or destination will change
        const query = await fetch(
          `https://api.mapbox.com/directions/v5/mapbox/walking/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken}`,
          { method: 'GET' }
        );

        const geo = await fetch(
          "https://api.mapbox.com/geocoding/v5/mapbox.places/Los%20Angeles.json?access_token=pk.eyJ1IjoibWF5dXN1ZiIsImEiOiJja3oxamlramcweWNhMm5vMTFyd2ljejZhIn0.mKmYvJvETodNbos-jGeluA",
          { method: 'GET' }
        );

        const gjson = await geo.json();

        console.log(gjson);

        const json = await query.json();
        const data = json.routes[0];
        const route = data.geometry.coordinates;
        const geojson = {
          type: 'Feature',
          properties: {},
          geometry: {
            type: 'LineString',
            coordinates: route
          }
        };
        // if the route already exists on the map, we'll reset it using setData
        if (map.getSource('route')) {
          map.getSource('route').setData(geojson);
        }
        // otherwise, we'll make a new request
        else {
          map.addLayer({
            id: 'route',
            type: 'line',
            source: {
              type: 'geojson',
              data: geojson
            },
            layout: {
              'line-join': 'round',
              'line-cap': 'round'
            },
            paint: {
              'line-color': '#3887be',
              'line-width': 5,
              'line-opacity': 0.75
            }
          });
        }
        // add turn instructions here at the end
      }

      map.on('load', () => {
        // make an initial directions request that
        // starts and ends at the same location
        getRoute(start);

        // Add starting point to the map
        map.addLayer({
          id: 'point',
          type: 'circle',
          source: {
            type: 'geojson',
            data: {
              type: 'FeatureCollection',
              features: [
                {
                  type: 'Feature',
                  properties: {},
                  geometry: {
                    type: 'Point',
                    coordinates: start
                  }
                }
              ]
            }
          },
          paint: {
            'circle-radius': 10,
            'circle-color': '#3887be'
          }
        });
        // this is where the code from the next step will go
      });

    </script>
  </body>
</html>