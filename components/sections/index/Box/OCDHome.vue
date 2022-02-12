<template>
  <div id="ocdBox" class="justify-center items-center gap-4 w-full h-full">
    <div class="flex gap-4 justify-between items-center">
      <p
        class="text-white text-center text-6 font-bold text-shadow --font-secondary"
      >
        Wybierz Bazę Pinów
      </p>
      <select
        id="selectBase"
        @change="setDatabase"
        class="bg-blue rounded-xl font-bold text-center text-blue-200 w-full"
      >
        <option
          v-for="i in pinDatabases"
          :key="i"
          :value="i"
          class="p-4 bg-blue rounded-xl"
        >
          {{ i }}
        </option>
      </select>
    </div>
    <div class="flex justify-between gap-4">
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="$parent.Flip('Base')"
      >
        Dodaj nową bazę danych
      </button>
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="$parent.Flip('Edit')"
      >
        Dodaj Pin
      </button>
      <button
        v-if="numberOFPin > 0"
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="$parent.Flip('Dele')"
      >
        Usuń Pin
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "OCDHome",
  data: () => ({ pinDatabases: null, numberOFPin: 0 }),
  methods: {
    setDatabase(event) {
      console.log(event);
      window.location.href = `/?database=${event.target.value}`;
    },
  },
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
    if (!this.$route.query["database"]) {
      window.location.href = "/?database=map";
      return;
    }
    fetch("/databases_list.php")
      .then((x) => x.json())
      .then((x) => (this.pinDatabases = x))
      .then(
        setTimeout(() => {
          this.$el.querySelector("#selectBase").value =
            this.$route.query["database"];
        }, 500)
      );
  },
};
</script>

<style scoped></style>
