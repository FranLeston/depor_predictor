<template>
  <div>
    <table class="table shadow-lg">
      <thead class="depor-blue-fade">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Avatar</th>
          <th scope="col">Nombre</th>
          <th scope="col">Pronosticos</th>
          <th scope="col">Aciertos</th>
          <th scope="col">Puntos</th>
        </tr>
      </thead>
      <tbody style="background-color: #fff">
        <tr v-for="(user, index) in users.data" :key="index">
          <th
            :class="{
              'table-purple': index === 0,
              'table-primary': user.id === currentUser.id,
            }"
            scope="row"
          >
            {{ index + 1 }}
          </th>
          <td>
            <img
              class="rounded-circle"
              :src="`/images/profile/${user.avatar}`"
              width="35"
              height="35"
            />
          </td>
          <td>{{ user.name }}</td>
          <td>{{ user.played }}</td>
          <td>3</td>
          <td>{{ user.total ? user.total : "0" }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  mounted() {
    this.$store.dispatch("getRankings").then((resp) => {
      console.log("got rankings");
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

<style lang="css" scoped>
.depor-blue {
  background-color: #004a99;
  color: #fff;
}

.table-purple {
  background-color: #724778;
  color: #fff;
}
</style>
