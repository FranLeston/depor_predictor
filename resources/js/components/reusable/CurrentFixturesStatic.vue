<template>
  <div class="card text-center shadow-lg">
    <div class="card-header depor-blue-fade">
      <div class="col-md">
        <span> Temporada: 2020 </span>
      </div>
      <span>{{ $store.state.activeRound[0].round }}</span>
    </div>
    <div class="card-body p-0">
      <div class="card-text">
        <ul class="list-group list-group-flush">
          <li
            v-for="(fixture, index) in currentFixtures"
            :key="index"
            class="list-group-item mx-0 my-0 px-0"
          >
            <div class="row no-gutters">
              <div class="col">
                <span>{{
                  new Date(fixture.event_date).toLocaleDateString()
                }}</span>
              </div>
              <div class="col">
                <span>{{ fixture.home_team.name }}</span>
              </div>

              <div class="col-3">
                <img :src="fixture.home_team.logo" width="30" height="30" />
                <img :src="fixture.away_team.logo" width="30" height="30" />
              </div>
              <div class="col">
                <span>{{ fixture.away_team.name }}</span>
              </div>
              <div class="col">
                <span>{{
                  new Date(fixture.event_date).toLocaleTimeString([], {
                    hour: "2-digit",
                    minute: "2-digit",
                  })
                }}</span>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="card-footer depor-blue-fade">
      <router-link to="/predictions" class="btn btn-purple">Jugar</router-link>
    </div>
  </div>
</template>
<script>
export default {
  created() {
    this.$store.dispatch("getCurrentFixtures").then((resp) => {
      console.log("got current fixtures");
    });
    this.$store.dispatch("getCurrentRound").then((resp) => {
      console.log("got current round");
    });
  },
  computed: {
    currentFixtures: function () {
      return this.$store.getters.currentFixtures;
    },
    currentRound: function () {
      return this.$store.getters.currentRound;
    },
  },
};
</script>

<style lang="css" scoped>
.card-text {
  font-size: small;
}

.card-header {
  background-color: #004a99;
  color: #ffffff;
}
</style>>
