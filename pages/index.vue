<template>
  <main class="grid grid-cols-1 min-h-screen">
    <div id="Map_Show" class="flex w-full tracking-wide">
      <div id="map" class="w-full h-full"></div>
    </div>
    <div
      id="Pin_Adder"
      class="fixed grid justify-center items-center gap-4 px-15 py-15"
    >
      <div
        id="New_pin_box"
        class="p-7 grid w-4/16 shadow bg-gradient-to-b from-pq-lightBlue to-green-500 rounded-xl tracking-wide"
      >
        <p
          class="text-white text-center text-10 font-bold text-shadow --font-secondary"
        >
          Witaj przygodo! :) <br />
          Chcemy Cię zamapiętać <br />
          Dodajmy punkt na mapie
        </p>
        <div id="PinForm" class="grid gap-4 rounded-xl">
          <p class="text-white text-bold tracking-wide">
            Podaj współrzędne punktu
          </p>
          <input
            type="number"
            placeholder="Lang"
            class="bg-white rounded-xl text-center"
          />
          <input
            type="number"
            placeholder="lat"
            class="bg-white rounded-xl text-center"
          />
        </div>
        <!--        TODO Dodać form (Tytul, opis, colorpicker, moze obraz) -->
        <!--        <div class="" @click="mylocation = getLocation()">TUTAJ</div>-->
        <!--        <div class="" v-html="mylocation"></div>-->
        <ColorPicker />
        <!--        <div-->
        <!--          class="p-7 grid rounded-full h-full bg-blue-400"-->
        <!--          @click="PinColor()"-->
        <!--        ></div>-->
      </div>
      <!--      TODO zmienić layoyt strony - mapy na full screan i form w boxie-->
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
    mapboxgl.accessToken =
      "pk.eyJ1IjoiZ2FicmllbGEtZ3JhZHlzIiwiYSI6ImNremFqMW42eTFmcWEyb245OXAzZTl5MmsifQ.dCPrRvsSH78RNhTBPP74cQ";
    const map = new mapboxgl.Map({
      container: "map", // <div id="map"></div>
      style: "mapbox://styles/gabriela-gradys/ckzazx9hk001914qijhpvarnb",
      center: [19.90595, 50.02439], // starting position as [lng, lat]
      bearing: 180,
      duration: 10000,
      pitch: 0,
      zoom: 14,
    });

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
        color: "orange",
      },
      mapboxgl: mapboxgl,
    });
    map.addControl(geocoder);
    map.addControl(geolocate);

    //Geolocation.getCurrentPosition()
    // TODO Dodać plik GeoJSON zawierający bibliotekę lokazliacji/dataset
    // TODO opracować sposób dopisywania do pliku na podstawie informacji wprowadzonych przez użytkownika
    // Library of pins
    // map.addSource("map", {
    //   type: "geojson",
    //   data: "https://github.com/GabrielaGradys/Zabeczki/blob/c36fd0caaa2291aef60d137820ecaf435680a6cb/data/map.geojson",
    // });
    map.on("load", () => {
      map.addLayer({
        id: "rpd_parks",
        type: "fill",
        source: {
          type: "vector",
          url: "gabriela-gradys.ckzbbp9bz1fy422oflop827rp-0cch2",
        },
      });
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
    // const PinLiblary = map.getSource("map").features;
    // // Add markers to the map
    // for (const marker of PinLiblary) {
    //   ///For Creating Img Pins
    //   // const el = document.createElement("div");
    //   // // const width = marker.properties.iconSize[0];
    //   // // const height = marker.properties.iconSize[1];
    //   // el.className = "marker";
    //   // el.style.backgroundImage = `url(https://placekitten.com/g/${width}/${height}/)`;
    //   // el.style.width = `${width}px`;
    //   // el.style.height = `${height}px`;
    //   // el.style.backgroundSize = "100%";
    //
    //   /// For creating alert-window
    //
    //   // el.addEventListener('click', () => {
    //   //   window.alert(marker.properties.message);
    //   // });
    //
    //   // Add markers to the map
    //   new mapboxgl.Marker({ color: "black" })
    //     .setLngLat(marker.geometry.coordinates)
    //     .addTo(map);
    // }
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

<style lang="scss">
#map {
  .mapboxgl-popup-content {
    text-align: center;
    font-family: var(--font-primary);
    color: white;
    background: rgb(56, 182, 255);
    background: linear-gradient(
      0deg,
      rgba(56, 182, 255, 1) 0%,
      rgba(16, 185, 129, 1) 100%
    );
  }
  .mapboxgl-popup-tip {
    border-top-color: #38b6ff;
  }
  .mapboxgl-ctrl-top-right {
    display: flex;
    flex-direction: row-reverse;
    align-items: flex-start;
  }
  .mapboxgl-ctrl-geocoder {
    width: calc(300rem / 16);
    input {
      width: 100%;
      padding: calc(8rem / 16) calc(16rem / 16);
      border-radius: 999px;
      box-shadow: 4px 4px 4px #7c7c7cb3;
      font-family: var(--font-primary);
    }
    ul.suggestions {
      position: relative;
      top: calc(2rem / 16);
      z-index: 10;
      background: white;
      display: block;
      padding: calc(4rem / 16);
      border-radius: calc(8rem / 16);
      li {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding: calc(4rem / 16) calc(8rem / 16);
        &.active {
          color: #38b6ff;
        }
      }
    }
  }
  .mapboxgl-ctrl-group {
    box-shadow: 4px 4px 4px #7c7c7cb3;
  }
  .mapboxgl-ctrl-attrib-button {
    display: none;
  }
}
</style>
