<template>
  <div id="PinLayout-Box">
    <div id="Title-description" class="grid gap-4 w-full">
      <input placeholder="Title of your pin" class="rounded-xl p-2 w-full" />
      <textarea
        placeholder="Description of your pin"
        class="rounded-xl p-2 w-full"
        @input=""
      >
      </textarea>
      <!--        TODO Tu skonczylismy-->
    </div>
    <div id="Colors" class="grid justify-between pt-6">
      <p class="text-white font-bold tracking-wide text-6 pb-6 text-shadow-lg">
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
          @click="PinUpdate('pinColor', i)"
          data-not-lazy
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PinForm",
  data: () => ({ map_vue: null }),
  methods: {
    PinUpdate(properties, value) {
      this.map_vue.tempMarker[properties] = value;
    },
  },
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
  },
};
</script>

<style scoped></style>
