window.addEventListener("DOMContentLoaded", async () => {



    const myApiUrl = 'http://127.0.0.1:8000/api/benne-a-verre/1234';
    async function getApi(url) {
      return await fetch(url).then(response => response.json());
    }
  
    bennes = [];
  
    try {
      bennes = await getApi(myApiUrl);
    } catch (e) {
      console.log(e);
    }
  
  
  
  
  
    mapboxgl.accessToken =
      "pk.eyJ1IjoibTAyeGltZSIsImEiOiJja3VnbmI5bmkyM2xyMzFtdjZrYnd3eGx1In0.o3IMLfIbIFXCGNjMvEaQkg"
  
    navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {
      enableHighAccuracy: true
    })
  
    function successLocation(position) {
      setupMap([position.coords.longitude,position.coords.latitude ])
      document.querySelector('.mapchange').style.filter="blur(0)" 
      document.querySelector('#map').style.filter="blur(0)" 
    }
  
    // TODO: Mettre l élément sur la flou
    function errorLocation() {
      document.querySelector('.locate').innerHTML = "Autoriser la localisation pour voir la carte"
      setupMap([1.44151, 43.59875])
    }
  
  
    function setupMap(center) {
      const map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/satellite-streets-v11",
        center: center,
        zoom: 11
      })
  
      var geocoder = new MapboxGeocoder({ accessToken: mapboxgl.accessToken, countries: 'fr', });
      map.addControl(geocoder);
  
      mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js');
      map.addControl(new MapboxLanguage({ defaultLanguage: 'fr' }));
  
      document.querySelectorAll('.mapboxgl-ctrl-bottom-right').forEach(function (a) {
        a.remove()
      })
  
      document.querySelectorAll('.mapboxgl-ctrl-bottom-left').forEach(function (a) {
        a.remove()
      })
  
  
      geocoder.on('result', function (e) {
        // console.log(e.result.center)
        // console.log(e.result.center[0])
        // console.log(e.result.center[1])
  
        function distance(lat1, lat2, lon1, lon2) {
  
          // The math module contains a function
          // named toRadians which converts from
          // degrees to radians.
          lon1 = lon1 * Math.PI / 180;
          lon2 = lon2 * Math.PI / 180;
          lat1 = lat1 * Math.PI / 180;
          lat2 = lat2 * Math.PI / 180;
  
          // Haversine formula
          let dlon = lon2 - lon1;
          let dlat = lat2 - lat1;
          let a = Math.pow(Math.sin(dlat / 2), 2)
            + Math.cos(lat1) * Math.cos(lat2)
            * Math.pow(Math.sin(dlon / 2), 2);
  
          let c = 2 * Math.asin(Math.sqrt(a));
  
          // Radius of earth in kilometers. Use 3956
          // for miles
          let r = 6371;
  
          // calculate the result
          return (c * r);
        }
  
  
        map.on('zoom', () => {
          var zoom = map.getZoom();
          // console.log(zoom);
          if (zoom == 16) {
            for (let i = 0; i < bennes.length; i++) {
  
              var lat = bennes[i].latitude;
              var lon = bennes[i].longitude;
              var point = 'marker' + i;
              var dist = distance(e.result.center[1], lat, e.result.center[0], lon);
  
              if (dist <= 1) {
                // create the popup
                const popup = new mapboxgl.Popup({ offset: 25 }).setText(bennes[i].address + " ce point ce situe à " + Math.round(dist*100)/100 + " km de votre recherche");
  
                // create DOM element for the marker
                const el = document.createElement('div');
                el.id = 'marker';
  
                  point = new mapboxgl.Marker({ color: "#00AA00" }).setLngLat([lon, lat]).setPopup(popup).addTo(map);
  
              }
  
            }
          } else if (zoom <= 13) {
  
            var mark = document.getElementsByClassName("mapboxgl-marker");
            // console.log(mark);
            for (let index = 0; index < mark.length; index++) {
              mark[0].parentNode.removeChild(mark[0]);
  
            }
  
  
  
          }
        });
      })
  
  
  
      document.getElementById("checkfield").onchange = function () { doalert(document.getElementById("checkfield")) };
  
  
      function doalert(checkboxElem) {
        if (checkboxElem.checked) {
          map.setStyle('mapbox://styles/mapbox/streets-v11')
          document.querySelector('.mapchange').style.backgroundImage = "url('../assets/images/satellite.png')";
  
        } else {
          map.setStyle('mapbox://styles/mapbox/satellite-v9')
          document.querySelector('.mapchange').style.backgroundImage = "url('../assets/images/maping.png')";
        }
      }
  
  
  
      document.querySelector('.mapboxgl-ctrl-geocoder--icon-search').style.marginLeft = "190px";
      const nav = new mapboxgl.NavigationControl()
      map.addControl(
        new mapboxgl.GeolocateControl({
        positionOptions: {
        enableHighAccuracy: true
        },
        // When active the map will receive updates to the device's location as it changes.
        trackUserLocation: true,
        // Draw an arrow next to the location dot to indicate which direction the device is heading.
        showUserHeading: true
        })
        );
      map.addControl(nav)
  
  

  
  
  
    }
  
  
  
  });