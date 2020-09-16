<template>
  <div class="card text-center shadow-lg">
    <div class="card-header">
      <div class="col">
        <span> Temporada: {{ currentFixtures[0].league.season }} </span>
      </div>
      <span>En Juego: {{ currentRound[0].round }}</span>
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
                  new Date(fixture.event_date).toLocaleTimeString()
                }}</span>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="card-footer">
      <router-link to="/predictions" class="btn btn-purple">Jugar</router-link>
    </div>
  </div>

  <!-- <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Fecha</th>
          <th scope="col">Logo</th>
          <th scope="col">Local</th>
          <th scope="col">Logo</th>
          <th scope="col">Visitante</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(fixture, index) in currentFixtures" :key="index">
          <th scope="row">{{ index }}</th>
          <td>
            {{
              new Date(fixture.event_timestamp + " GMT").toLocaleDateString() +
              " " +
              new Date(fixture.event_timestamp + " GMT").toLocaleTimeString()
            }}
          </td>
          <td>
            <img :src="fixture.home_team.logo" width="30" height="30" />
          </td>
          <td>{{ fixture.home_team.name }}</td>
          <td>
            <img :src="fixture.away_team.logo" width="30" height="30" />
          </td>
          <td>{{ fixture.away_team.name }}</td>
        </tr>
      </tbody>
    </table> -->
</template>
<script>
export default {
  mounted() {
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
