<template>
  <div id="Map_Show" class="flex w-full tracking-wide">
    <div id="map" class="w-full h-full"></div>
  </div>
</template>

<script>
import * as mapboxgl from "mapbox-gl";
import mapboxGlGeocoder from "mapbox-gl-geocoder";
export default {
  name: "Map",
  data: () => ({
    token:
      "pk.eyJ1IjoiZ2FicmllbGEtZ3JhZHlzIiwiYSI6ImNremFqMW42eTFmcWEyb245OXAzZTl5MmsifQ.dCPrRvsSH78RNhTBPP74cQ",
    map: null,
    geolocate: null,
    geocoder: null,
    tempMarker: {
      obj: null,
      pinColor: null,
      title: null,
      description: null,
      position: null,
    },
    editMode: false,
  }),
  methods: {
    // Generate map
    createMap() {
      this.map = new mapboxgl.Map({
        accessToken: this.token,
        container: "map", // <div id="map"></div>
        style: "mapbox://styles/gabriela-gradys/ckzazx9hk001914qijhpvarnb",
        center: [19.90595, 50.02439], // starting position as [lng, lat]
        bearing: 90,
        duration: 10000,
        pitch: 0,
        zoom: 14,
      });
    },
    //Adding User Locator and geolocator
    initControls() {
      this.geolocate = new mapboxgl.GeolocateControl({
        positionOptions: {
          enableHighAccuracy: true,
        },
        // When active the map will receive updates to the device's location as it changes.
        trackUserLocation: true,
        // Draw an arrow next to the location dot to indicate which direction the device is heading.
        showUserHeading: true,
      });
      this.geocoder = new mapboxGlGeocoder({
        accessToken: this.token,
        marker: {
          //TODO Poprawić marker wyszukiwania pozycji
          color: "orange",
        },
        mapboxgl: mapboxgl,
      });
      this.map.addControl(this.geocoder);
      this.map.addControl(this.geolocate);
    },
    // Creating function to make a new pin
    addMarker(title, description, pinColor, position) {
      const popup = new mapboxgl.Popup({ offset: [0, -15] })
        .setLngLat(position)
        .setHTML(`<h3>${title}</h3><p>${description}</p>`);

      // Creating padlock as a pin
      function CreateImgEl(url) {
        let el = document.createElement("div");
        const width = 40;
        const height = 40;
        el.className = "marker";
        el.style.backgroundImage = `url(${url})`;
        el.style.width = `calc(${width}rem / 16)`;
        el.style.height = `calc(${height}rem / 16)`;
        el.style.backgroundSize = "100%";
        return el;
      }
      return new mapboxgl.Marker(CreateImgEl(`/Markers/${pinColor || "2"}.svg`))
        .setLngLat(position)
        .setPopup(popup)
        .addTo(this.map);
    },
    //Create a function to lad existing padlocks
    async readLibrary() {
      let data = await fetch("/map.geojson");
      data = await data.json();
      return data;
    },
    // Creating a function to make and update temporary marker after click
    updateTempMarker() {
      if (this.tempMarker.obj && this.tempMarker.obj.remove)
        this.tempMarker.obj.remove();
      // Create button design from form

      this.tempMarker.obj = this.addMarker(
        this.tempMarker.title,
        this.tempMarker.description,
        this.tempMarker.pinColor,
        this.tempMarker.position
      );
    },
    // Saving new marker to server
    saveToServer() {},
  },
  // Loading Map, Geocoder and geolocator and existing Markers
  mounted() {
    this.createMap();
    this.initControls();
    // In editMode: If click -> create TempMarker
    this.map.on("click", (e) => {
      if (this.editMode) {
        let position = e.lngLat.wrap();
        this.tempMarker.position = [position.lng, position.lat];
        this.updateTempMarker();
      }
    });
    // Taking properties form dictionary
    this.readLibrary().then((markers) => {
      markers.features.map((marker) => {
        console.log(marker);
        this.addMarker(
          marker.properties.title,
          marker.properties.description,
          marker.properties.pinColor,
          marker.geometry.coordinates
        );
      });
    });
  },
};
</script>

<style lang="scss"></style>
