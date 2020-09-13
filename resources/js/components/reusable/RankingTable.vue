<template>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Pronosticos</th>
        <th scope="col">Puntos</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(user, index) in users"
        :key="index"
        :class="{ 'table-primary': user.id === currentUser.id }"
      >
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ user.name }}</td>
        <td>{{ user.played }}</td>
        <td>{{ user.total }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  mounted() {
    this.$store.dispatch("getRankings").then((resp) => {
      console.log(resp);
    });
  },
  computed: {
    users: function () {
      return this.$store.getters.rankings;
    },
    currentUser: function () {
      return this.$store.getters.currentUser;
    },
  },
};
</script>

<style>
</style>
