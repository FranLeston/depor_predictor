<template>
  <div>
    <table class="table table-sm">
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
    </table>
  </div>
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

<style>
</style>
