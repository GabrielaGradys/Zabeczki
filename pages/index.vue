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
        <!--        TODO Dodać form (Tytul, opis, colorpicker, moze obraz) -->
        <!--        <div class="" @click="mylocation = getLocation()">TUTAJ</div>-->
        <!--        <div class="" v-html="mylocation"></div>-->
        <ColorPicker />
        <div
          class="p-7 grid rounded-full h-full bg-blue-400"
          @click="PinColor()"
        ></div>
      </div>
      <!--      TODO zmienić layoyt strony - mapy na full screan i form w boxie-->
      <div
        id="Map_Show"
        class="p-7 flex w-full shadow bg-gradient-to-b from-pq-lightBlue to-green-400 rounded-xl tracking-wide"
      >
        <div id="map" class="w-full h-full"></div>
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
    // Creating a map
    const mapboxgl = require("mapbox-gl");
    const map = new mapboxgl.Map({
      accessToken:
        "pk.eyJ1IjoiZ2FicmllbGEtZ3JhZHlzIiwiYSI6ImNremFqMW42eTFmcWEyb245OXAzZTl5MmsifQ.dCPrRvsSH78RNhTBPP74cQ",
      container: "map", // <div id="map"></div>
      style: "mapbox://styles/gabriela-gradys/ckzazx9hk001914qijhpvarnb",
      center: [19.90595, 50.02439], // starting position as [lng, lat]
      zoom: 13,
    });
    // Creating First Pin (Marker)
    let yourMarkersArray = [
      {
        location: [19.90595, 50.02439],
        title: "Domek",
        description: "Nasze mieszkanko",
      },
    ];
    yourMarkersArray.map((marker) => {
      const LngLat = marker.location;
      const pin = "pink";
      const popup = new mapboxgl.Popup({ offset: 25 })
        .setText(marker.description)
        .setHTML(`<h3>${marker.title}</h3><p>${marker.description}</p>`);
      new mapboxgl.Marker({ color: pin, rotation: 45 })
        .setLngLat(LngLat)
        .setPopup(popup)
        .addTo(map); // Initialized above
    });
    //Adding User Locator
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
    // TODO Dodać plik GeoJSON zawierający bibliotekę lokazliacji/dataset
    // TODO opracować sposób dopisywania do pliku na podstawie informacji wprowadzonych przez użytkownika
    // Library of pins
    const PinLiblary = {
      type: "FeatureCollection",
      features: [
        {
          type: "Feature",
          properties: {
            message: "Foo",
            iconSize: [60, 60],
          },
          geometry: {
            type: "Point",
            coordinates: [-66.324462, -16.024695],
          },
        },
        {
          type: "Feature",
          properties: {
            message: "Bar",
            iconSize: [50, 50],
          },
          geometry: {
            type: "Point",
            coordinates: [-61.21582, -15.971891],
          },
        },
        {
          type: "Feature",
          properties: {
            message: "Baz",
            iconSize: [40, 40],
          },
          geometry: {
            type: "Point",
            coordinates: [-63.292236, -18.281518],
          },
        },
      ],
    };
    // Add markers to the map
    for (const marker of PinLiblary.features) {
      /// For Creating Img Pins

      // const el = document.createElement("div");
      // // const width = marker.properties.iconSize[0];
      // // const height = marker.properties.iconSize[1];
      // el.className = "marker";
      // el.style.backgroundImage = `url(https://placekitten.com/g/${width}/${height}/)`;
      // el.style.width = `${width}px`;
      // el.style.height = `${height}px`;
      // el.style.backgroundSize = "100%";

      /// For creating alert-window

      // el.addEventListener('click', () => {
      //   window.alert(marker.properties.message);
      // });

      // Add markers to the map
      new mapboxgl.Marker({ color: "black" })
        .setLngLat(marker.geometry.coordinates)
        .addTo(map);
    }
  },
  methods: {
    // getLocation() {
    //   let position = "no gps";
    //   function save(pos) {
    //     position = pos;
    //   }
    //   if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(save);
    //   }
    //   return position;
    // },
  },
};
</script>

<style scoped>
.mapboxgl-popup-content {
  text-align: center;
  font-family: --font-primar;
  text-color: --darkBlue;
  background: rgb(56, 182, 255);
  background: linear-gradient(
    0deg,
    rgba(56, 182, 255, 1) 0%,
    rgba(16, 185, 129, 1) 100%
  );
}
</style>
