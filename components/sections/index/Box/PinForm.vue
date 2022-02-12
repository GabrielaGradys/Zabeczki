<template>
  <div id="PinLayout-Box" class="justify-center items-center p-4 gap-6 h-full">
    <p
      class="text-white text-center text-10 font-bold text-shadow --font-secondary"
    >
      Witaj przygodo! :) <br />
      Chcemy Cię zamapiętać <br />
    </p>
    <div id="colors" class="flex items-center justify-between">
      <p
        class="text-white text-center text-6 font-bold text-shadow --font-secondary"
      >
        Wybierz <br />
        Kolor:
      </p>
      <img
        id="padlocks"
        v-for="i in 6"
        :key="i"
        :src="`/Markers/${i}.svg`"
        class="w-15 h-15"
        :class="
          map_vue && i == map_vue.tempMarker.pinColor
            ? 'opacity-100'
            : 'opacity-40'
        "
        @click="pinUpdate('pinColor', i)"
        data-not-lazy
      />
    </div>
    <div id="Title-description" class="grid gap-4 w-full">
      <input
        placeholder="Dodaj Tytuł"
        class="rounded-xl p-2 w-full"
        @input="
          (event) => {
            pinUpdate('title', event.target.value);
          }
        "
      />
      <textarea
        placeholder="Opis..."
        class="rounded-xl p-2 w-full h-30"
        @input="
          (event) => {
            pinUpdate('description', event.target.value);
          }
        "
      >
      </textarea>
    </div>
    <div class="flex justify-between">
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        onclick="location.reload()"
      >
        Anuluj
      </button>
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="$parent.Flip('Prev')"
      >
        Zatwierdź
      </button>
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
  },
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
  },
};
</script>

<style>
.make_bright {
  filter: brightness(2);
}
.make_dark {
  filter: brightness(0.4);
}
</style>
