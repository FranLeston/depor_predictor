<template>
  <div class="row">
    <div class="col-md-6">
      <span class="h4">Ranking Global</span>
      <rankingTable></rankingTable>
    </div>
    <div class="col-md-6">
      <span class="h4">Por Jornada</span>
      <rankingTable></rankingTable>
    </div>
  </div>
</template>
<script>
import rankingTable from "./../reusable/RankingTable";

export default {
  data() {
    return {
      user: this.$store.getters.currentUser,
    };
  },
  components: {
    rankingTable,
  },
  mounted() {
    if (this.user.id) {
      this.$store.dispatch("getUserRanking", this.user.id).then((resp) => {
        console.log("got user ranking");
      });
    }
  },
  computed: {
    currentUser: function () {
      return this.$store.getters.currentUser;
    },
  },
};
</script>

<style>
</style>
