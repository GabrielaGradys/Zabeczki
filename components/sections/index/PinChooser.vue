<template>
  <div
    id="Pin_Adder"
    class="fixed grid justify-center items-center gap-4 px-15 h-full"
  >
    <div
      id="New_pin_box"
      class="p-7 grid w-4/16 gap-4 shadow h-max bg-gradient-to-b from-pq-lightBlue to-green-500 rounded-xl tracking-wide"
    >
      <div id="Hello">
        <p
          class="text-white text-center text-10 font-bold text-shadow --font-secondary"
        >
          Witaj przygodo! :) <br />
          Chcemy Cię zamapiętać <br />
          Dodajmy punkt na mapie
        </p>
      </div>
      <PinForm />
    </div>
  </div>
</template>

<script>
export default {
  name: "PinChooser",
};
</script>

<style scoped></style>
