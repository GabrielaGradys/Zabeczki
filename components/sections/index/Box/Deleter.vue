<template>
  <div id="Deleter" class="justify-center items-center gap-4 w-full h-full">
    <select
      id="selectPin"
      class="bg-blue rounded-xl font-bold text-center text-blue-200 w-full"
    >
      <option
        v-for="(item, i) in pinList"
        :key="i"
        :value="i"
        class="p-4 bg-blue rounded-xl"
      >
        {{ item.properties.title }}
      </option>
    </select>
    <button
      class="p-4 bg-blue rounded-xl text-white font-bold text-shadow shadow hover:bg-green transition-colors duration-300"
      @click="deletePin()"
    >
      Usuń
    </button>
  </div>
</template>

<script>
export default {
  name: "Deleter",
  data: () => ({ pinList: null, map_vue: null }),
  methods: {
    listPin() {
      const database = this.$route.query["database"];
      this.map_vue
        .readLibrary(database)
        .then((x) => (this.pinList = x.features))
        .then(() => {
          let ocdBox = document.querySelector("#ocdBox").__vue__;
          ocdBox.numberOFPin = this.pinList ? this.pinList.length : 0;
          console.log(ocdBox.numberOFPin);
        });
    },
    deletePin() {
      async function postData(url = "", data = {}) {
        const response = await fetch(url, {
          method: "POST",
          cache: "no-cache",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });
        return response.json();
      }
      const database = this.$route.query["database"];
      const toDelete = this.$el.querySelector("#selectPin").value;
      this.map_vue.readLibrary(database).then((markers) => {
        markers.features.splice(toDelete, 1);
        postData(`/save_to_json.php?database=${database}`, markers).then(() => {
          setTimeout(() => {
            location.reload(true);
          }, 1000);
        });
      });
    },
  },
  mounted() {
    this.map_vue = document.querySelector("#Map_Show").__vue__;
    setTimeout(() => {
      this.listPin();
    }, 1000);
  },
};
</script>

<style scoped></style>
