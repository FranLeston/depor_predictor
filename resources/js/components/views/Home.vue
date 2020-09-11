<template>
  <div class="row no-gutters">
    <div class="col-7">
      <p>main view</p>
    </div>
    <div class="col-5">
      <currentFixturesStatic></currentFixturesStatic>
    </div>
  </div>
</template>
<script>
import currentFixturesStatic from "./../reusable/CurrentFixturesStatic";
export default {
  components: {
    currentFixturesStatic,
  },
  mounted() {
    this.$store.dispatch("getCurrentRound").then((resp) => {
      console.log(resp.data.rounds);
    });
  },
  computed: {
    currentRound: function () {
      return this.$store.getters.currentRound;
    },
  },
};
</script>

<style>
</style>
