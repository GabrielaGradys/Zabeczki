<template>
  <main class="grid grid-cols-1 pt-15">
    <div id="Pin_Adder" class="flex justify-between gap-50 px-15">
      <div
        id="New_pin_box"
        class="p-7 grid w-4/16 shadow bg-gradient-to-b from-pq-lightBlue to-green-500 rounded-xl tracking-wide"
      >
        <p
          class="text-white text-center text-15 font-bold text-shadow --font-secondary"
        >
          Witaj przygodo! :) <br />
          Chcemy Cię zamapiętać <br />
          Dodajmy punkt na mapie
        </p>
        <div class="" @click="mylocation = getLocation()">TUTAJ</div>
        <div class="" v-html="mylocation"></div>
      </div>
      <div
        id="Map_Show"
        class="p-7 flex w-full shadow bg-gradient-to-b from-pq-lightBlue to-green-400 rounded-xl tracking-wide"
      >
        <div id="map" class="w-full h-full"></div>
        <!--          <iframe src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSjxa5WEY7PGK-3g_65wMZmSy-7WkI2Kk&callback=initMap" class="w-full"></iframe>-->
        <!--          <iframe src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=%C4%B0zmir+(My%20Business%20Name)&ie=UTF8&t=&z=14&iwloc=B&output=embed" class="w-full"></iframe>-->
        <!--          <img src="https://ocdn.eu/pulscms-transforms/1/Y4mktkpTURBXy9iNzcwNmIwYmIzYzQyMGUxMDIzM2NmYWVlNTQ4MzQzNC5qcGeRlQMAAM0IAM0EgA" />-->
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "index",
  data: () => ({
    mylocation: null,
  }),
  mounted() {
    const mapboxgl = require("mapbox-gl");
    const map = new mapboxgl.Map({
      accessToken:
        "pk.eyJ1IjoiZ2FicmllbGEtZ3JhZHlzIiwiYSI6ImNremFqMW42eTFmcWEyb245OXAzZTl5MmsifQ.dCPrRvsSH78RNhTBPP74cQ",
      container: "map", // <div id="map"></div>
      style: "mapbox://styles/mapbox/streets-v9", // default style
      center: [-21.9270884, 64.1436456], // starting position as [lng, lat]
      zoom: 13,
    });
    let yourMarkersArray = [
      { location: [-21.9270884, 64.1436456], description: "test" },
    ];
    yourMarkersArray.map((marker) => {
      const LngLat = marker.location;
      const popup = new mapboxgl.Popup({ offset: 25 }).setText(
        marker.description
      );
      new mapboxgl.Marker().setLngLat(LngLat).setPopup(popup).addTo(map); // Initialized above
    });
    map.addControl(
      new mapboxgl.GeolocateControl({
        positionOptions: {
          enableHighAccuracy: true,
        },
        // When active the map will receive updates to the device's location as it changes.
        trackUserLocation: true,
        // Draw an arrow next to the location dot to indicate which direction the device is heading.
        showUserHeading: true,
      })
    );
  },
  methods: {
    getLocation() {
      let position = "no gps";
      function save(pos) {
        position = pos;
      }
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(save);
      }
      return position;
    },
  },
};
</script>

<style scoped></style>
