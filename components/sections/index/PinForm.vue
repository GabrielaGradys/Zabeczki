<template>
  <div
    id="PinLayout-Box"
    class="justify-center items-center gap-4 px-15 h-full"
  >
    <div id="Hello">
      <p
        class="text-white text-center text-10 font-bold text-shadow --font-secondary"
      >
        Witaj przygodo! :) <br />
        Chcemy Cię zamapiętać <br />
        Dodajmy punkt na mapie
      </p>
      <div id="Colors" class="grid justify-between pt-6">
        <p
          class="text-white font-bold tracking-wide text-6 pb-6 text-shadow-lg"
        >
          Wybierz kolor:
        </p>
        <div class="flex justify-between">
          <img
            id="padlocks"
            v-for="i in 6"
            :key="i"
            :src="`/Markers/${i}.svg`"
            class="w-20 h-20"
            :class="
              map_vue && i == map_vue.tempMarker.pinColor
                ? 'opacity-100'
                : 'opacity-60'
            "
            @click="pinUpdate('pinColor', i)"
            data-not-lazy
          />
        </div>
      </div>
      <div id="Title-description" class="grid gap-4 w-full">
        <input
          placeholder="Title of your pin"
          class="rounded-xl p-2 w-full"
          @input="
            (event) => {
              pinUpdate('title', event.target.value);
            }
          "
        />
        <textarea
          placeholder="Description of your pin"
          class="rounded-xl p-2 w-full"
          @input="
            (event) => {
              pinUpdate('description', event.target.value);
            }
          "
        >
        </textarea>
      </div>
      <div class="flex">
        <button
          class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
          @click="changeMode()"
        >
          Zatwierdź
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PinForm",
  data: () => ({ map_vue: null }),
  methods: {
    pinUpdate(properties, value) {
      this.map_vue.tempMarker[properties] = value;
      this.map_vue.updateTempMarker();
    },
    changeMode() {
      this.map_vue = document.querySelector("#Map_Show").__vue__;
      this.map_vue.editMode = false;
    },
  },
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
  },
};
</script>

<style scoped></style>
