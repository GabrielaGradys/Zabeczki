<template>
  <div id="ocdBox" class="justify-center items-center gap-4 w-full h-full">
    <div
      id="startBase"
      v-if="visible === 'nothing'"
      class="flex justify-between gap-4"
    >
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="$parent.Flip('Base')"
      >
        Zmień bazę
      </button>
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="numberOFPin > 0 ? turnVisible('edit') : turnVisible('Add')"
      >
        Edytuj
      </button>
    </div>
    <div id="editHow" v-if="visible === 'edit'" class="">
      <div>
        <button
          class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
          @click="$parent.Flip('Dele')"
        >
          Usuń Element
        </button>
        <button
          class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
          @click="turnVisible('Add')"
        >
          Dodaj Element
        </button>
      </div>
    </div>
    <div id="start" v-if="visible === 'Add'">
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="
          turnVisible('trasa');
          $parent.Flip('Edit');
        "
      >
        Dodaj Trasę
      </button>
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="
          turnVisible('pin');
          $parent.Flip('Edit');
        "
      >
        Dodaj Pin
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "OCDHome",
  data: () => ({ visible: "nothing", numberOFPin: 0 }),
  methods: {
    turnVisible(what) {
      this.visible = what;
      console.log(this.visible);
      document.querySelector("#Editor").__vue__.visible = what;
    },
  },
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
    if (!this.$route.query["database"]) {
      window.location.href = "/?database=klodki";
    }
  },
};
</script>

<style scoped></style>
