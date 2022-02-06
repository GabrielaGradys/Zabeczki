<template>
  <div id="ColorPicker-Box">
    <p class="text-white text-bold tracking-wide">Wybierz kolor</p>
    <div id="Colors" class="flex justify-between pt-6">
      <div
        class="p-7 grid rounded-full h-full bg-blue-400"
        @click="Choosen()"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ColorPicker",
  data: () => ({ ChoosedColor: "black" }),
  methods: {
    Choosen() {
      this.ChoosedColor = "black";
      this.$emit("PinColor");
    },
  },
};
</script>

<style scoped></style>
