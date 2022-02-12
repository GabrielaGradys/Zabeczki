<template>
  <div class="grid gap-7 justify-center">
    <div
      v-if="
        !(
          map_vue &&
          map_vue.tempMarker.description &&
          map_vue.tempMarker.position &&
          map_vue.tempMarker.pinColor &&
          map_vue.tempMarker.title
        )
      "
      class="text-white text-center text-6 font-bold text-shadow --font-secondary"
    >
      <div>Twój Element nie zawiera:</div>
      <div v-if="map_vue && !map_vue.tempMarker.position">Pozycji</div>
      <div v-if="map_vue && !map_vue.tempMarker.title">Tytułu</div>
      <div v-if="map_vue && !map_vue.tempMarker.description">Opisu</div>
    </div>
    <div class="flex justify-center flex-row-reverse gap-4">
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="$parent.Flip('Edit')"
      >
        Edytuj
      </button>
      <button
        v-if="
          map_vue &&
          map_vue.tempMarker.position &&
          map_vue.tempMarker.pinColor &&
          map_vue.tempMarker.title
        "
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="map_vue.saveToDataBase('map')"
      >
        Wyślij na serwer
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Preview",
  data: () => ({ map_vue: null }),
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
  },
};
</script>

<style scoped></style>
