<template>
  <div
    id="MainBox"
    class="fixed items-center justify-between top-10 left-10 p-4 grid w-4/16 gap-4 shadow h-max bg-gradient-to-b from-pq-lightBlue to-green-500 rounded-xl tracking-wide"
  >
    <OCDHome :class="mode === 'Home' ? 'flex' : 'hidden'" />
    <AddBase :class="mode === 'Base' ? 'flex' : 'hidden'" />
    <Deleter :class="mode === 'Dele' ? 'flex' : 'hidden'" />
    <PinForm :class="mode === 'Edit' ? 'grid' : 'hidden'" />
    <Preview :class="mode === 'Prev' ? 'flex' : 'hidden'" />
  </div>
</template>

<script>
export default {
  name: "Box",
  data: () => ({ map_vue: null, mode: "Home" }),
  methods: {
    Flip(modeName) {
      this.mode = modeName;
    },
  },
};
</script>

<style scoped></style>
