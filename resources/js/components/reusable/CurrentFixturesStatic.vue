<template>
  <div class="card text-center">
    <div class="card-header">
      Partidos En Juego
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <div class="card-text">
        <ul class="list-group list-group-flush">
          <li
            v-for="(fixture, index) in currentFixtures"
            :key="index"
            class="list-group-item"
          >
            <div class="container">
              <div class="row no-gutters">
                <div class="col">
                  <span>{{
                    new Date(
                      fixture.event_timestamp + " GMT"
                    ).toLocaleDateString()
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
                    new Date(
                      fixture.event_timestamp + " GMT"
                    ).toLocaleTimeString()
                  }}</span>
                </div>
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
    console.log("comp mounted");
    this.$store.dispatch("getCurrentFixtures").then((resp) => {
      console.log(resp.data.fixtures);
    });
  },
  computed: {
    currentFixtures: function () {
      return this.$store.getters.currentFixtures;
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
