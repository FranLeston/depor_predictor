<template>
  <div class="card text-center shadow-lg">
    <div class="card-header depor-blue-fade">
      <div class="col-md">
        <span> Temporada: 2020-21 </span>
      </div>
      <span>{{ currentFixtures[0].round }}</span>
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
                <span>{{ toDate(fixture.event_date) }}</span>
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
                <span>{{ toTime(fixture.event_date) }}</span>
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
  },
  computed: {
    currentFixtures: function () {
      return this.$store.getters.currentFixtures;
    },
  },
  methods: {
    toDate: function (date) {
      var formattedDate = date.replace(/-/g, "/");
      var newDate = new Date(formattedDate).toLocaleDateString();
      return newDate;
    },
    toTime: function (date) {
      var formattedDate = date.replace(/-/g, "/");
      var newTime = new Date(formattedDate).toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
      });
      return newTime;
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
