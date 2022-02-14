<template>
  <div id="ChangeBase">
    <div
      id="chooser"
      v-if="!visible"
      class="grid gap-4 justify-between items-center p-4"
    >
      <div class="flex items-center justify-center">
        <img src="/img/Zabeczki.gif" class="w-30 h-15" data-not-lazy />
      </div>
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
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="showAdder()"
      >
        Dodaj nową bazę danych
      </button>
    </div>
    <div id="newBase" v-if="visible" class="flex gap-4">
      <input
        id="newDatabaseName"
        placeholder="Nazwa bazy danych"
        class="rounded-xl p-2 w-full"
      />
      <button
        class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
        @click="createDatabase()"
      >
        Stwórz
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddBase",
  data: () => ({ visible: false, pinDatabases: null }),
  methods: {
    setDatabase(event) {
      console.log(event);
      window.location.href = `/?database=${event.target.value}`;
    },
    showAdder() {
      this.visible = true;
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
