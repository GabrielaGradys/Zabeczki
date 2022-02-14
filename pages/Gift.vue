<template>
  <div class="">
    <div v-if="visible" class="flex items-center justify-center w-full h-full">
      <button
        class="fixed p-4 bg-gradient-to-b from-pq-lightBlue to-green-500 rounded-xl text-white font-bold text-shadow shadow"
        @click="turnVisible"
      >
        Otwórz prezent!
      </button>
      <img
        v-if="visible"
        src="/Animation/Gift.svg"
        class="grid w-full h-full"
      />
    </div>
    <div v-if="!visible">
      <div class="fixed grid w-full h-full bg-transparent">
        <img
          src="/Animation/confetti.gif"
          class="'fixed grid w-full h-full bg-transparent"
        />
      </div>
      <img src="/Animation/zrzut.png" class="'grid w-full h-full'" />
    </div>
  </div>
</template>

<script>
export default {
  name: "index",
  data: () => ({ visible: true }),
  methods: {
    async turnVisible() {
      this.visible = !this.visible;
      setTimeout(
        () =>
          this.$router.push({
            path: "/",
          }),
        3000
      );
      console.log(this.visible);
    },
  },
};
</script>

<style scoped></style>
