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
};
</script>

<style>
</style>
