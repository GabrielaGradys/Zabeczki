<template>
  <div class="justify-between gap-4">
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
</template>

<script>
export default {
  name: "AddBase",
  methods: {
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
};
</script>

<style scoped></style>
