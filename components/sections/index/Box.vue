<template>
  <div
    id="Pin_Adder"
    class="fixed top-1/2 -translate-y-1/2 left-10 p-4 grid w-4/16 gap-4 shadow h-max bg-gradient-to-b from-pq-lightBlue to-green-500 rounded-xl tracking-wide"
  >
    <div v-if="(!map_vue || !map_vue.editMode) && !createVis">
      <h3>Wybierz Bazę Pinów</h3>
      <select id="selectBase" @change="setDatabase">
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
    <div class="flex p-7 justify-beetwen">
      <button
        v-if="map_vue && !map_vue.editMode"
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="
          Flip();
          createVis = false;
        "
      >
        {{ map_vue && !map_vue.tempMarker.position ? "Dodaj Pin" : "Edytuj" }}
      </button>
      <button
        v-if="map_vue && !map_vue.editMode"
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="createVis = true"
      >
        Dodaj nową bazę danych
      </button>
      <div class="grid p-3">
        <div v-if="createVis" class="flex justify-between gap-4">
          <input
            id="newDatabaseName"
            placeholder="Nazwa bazy danych"
            class="rounded-xl p-2 w-full"
          />
          <button
            v-if="map_vue && !map_vue.editMode"
            class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
            @click="createDatabase()"
          >
            Stwórz
          </button>
        </div>
      </div>
    </div>

    <button
      v-if="
        map_vue &&
        !map_vue.editMode &&
        map_vue.tempMarker.position &&
        map_vue.tempMarker.pinColor &&
        map_vue.tempMarker.title &&
        map_vue.tempMarker.description
      "
      class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
      @click="map_vue.saveToDataBase('map')"
    >
      Wyślij na serwer
    </button>
    <PinForm :class="map_vue && !map_vue.editMode ? 'hidden' : 'grid'" />
  </div>
</template>

<script>
export default {
  name: "Box",
  data: () => ({ map_vue: null, pinDatabases: null, createVis: false }),
  methods: {
    Flip() {
      this.map_vue.editMode = true;
    },
    setDatabase(event) {
      console.log(event);
      window.location.href = `/?database=${event.target.value}`;
    },
    createDatabase() {
      let name = this.$el.querySelector("#newDatabaseName").value;
      let db = {
        type: "FeatureCollection",
        features: [],
      };
      async function postData(url = "", data = {}) {
        const response = await fetch(url, {
          method: "POST",
          cache: "no-cache",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });
        return response.json();
      }
      postData(`/save_to_json.php?database=${name}`, db).then(
        () => (window.location.href = `/?database=${name}`)
      );
    },
  },
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
    if (!this.$route.query["database"]) {
      window.location.href = "/?database=map";
      return;
    }
    document.querySelector("#selectBase").value = this.$route.query["database"];
    fetch("/databases_list.php")
      .then((x) => x.json())
      .then((x) => (this.pinDatabases = x));
  },
};
</script>

<style scoped></style>
