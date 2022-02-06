<template>
  <div id="Map_Show" class="flex w-full tracking-wide">
    <div id="map" class="w-full h-full"></div>
  </div>
</template>

<script>
export default {
  name: "Map",
  data: () => ({
    mylocation: null,
  }),
  mounted() {
    // Creating a map
    const mapboxgl = require("mapbox-gl");
    mapboxgl.accessToken =
      "pk.eyJ1IjoiZ2FicmllbGEtZ3JhZHlzIiwiYSI6ImNremFqMW42eTFmcWEyb245OXAzZTl5MmsifQ.dCPrRvsSH78RNhTBPP74cQ";
    const map = new mapboxgl.Map({
      container: "map", // <div id="map"></div>
      style: "mapbox://styles/gabriela-gradys/ckzazx9hk001914qijhpvarnb",
      center: [19.90595, 50.02439], // starting position as [lng, lat]
      bearing: 90,
      duration: 10000,
      pitch: 0,
      zoom: 14,
    });

    //Adding User Locator and geolocator
    const MapboxGeocoder = require("mapbox-gl-geocoder");
    const geolocate = new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true,
      },
      // When active the map will receive updates to the device's location as it changes.
      trackUserLocation: true,
      // Draw an arrow next to the location dot to indicate which direction the device is heading.
      showUserHeading: true,
    });
    const geocoder = new MapboxGeocoder({
      accessToken: mapboxgl.accessToken,
      marker: {
        //TODO Poprawić marker wyszukiwania pozycji
        color: "orange",
      },
      mapboxgl: mapboxgl,
    });
    map.addControl(geocoder);
    map.addControl(geolocate);

    // Library of pins
    // TODO opracować sposób dopisywania do pliku na podstawie informacji wprowadzonych przez użytkownika
    map.on("load", () => {
      // Add an image to use as a custom marker
      map.loadImage(
        "https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png",
        (error, image) => {
          if (error) throw error;
          map.addImage("custom-marker", image);
          // Add a GeoJSON source with 2 points
          map.addSource("points", {
            type: "geojson",
            data: "/map.geojson",
          });

          // Add a symbol layer
          map.addLayer({
            id: "points",
            type: "symbol",
            source: "points",
            layout: {
              "icon-image": "custom-marker",
              // get the title name from the source's "title" property
              "text-field": ["get", "title"],
              "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
              "text-offset": [0, 1.25],
              "text-anchor": "top",
            },
          });
        }
      );
    });

    //Pop-up to Zabeczki layer??
    map.on("load", () => {
      map.on("click", (event) => {
        const features = map.queryRenderedFeatures(event.point, {
          layers: ["zabeczki"],
        });
        if (!features.length) {
          return;
        }
        const feature = features[0];

        const popup = new mapboxgl.Popup({ offset: [0, -15] })
          .setLngLat(feature.geometry.coordinates)
          .setHTML(
            `<h3>${feature.properties.title}</h3><p>${feature.properties.description}</p>`
          )
          .addTo(map);
      });
    });
  },
};
</script>

<style lang="scss"></style>
