<template>
  <div>
    <table class="table table-striped table-sm shadow-lg">
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
            {{ index + users.from }}
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
          <td>{{ user.exact ? user.exact : "0" }}</td>
          <td>{{ user.total ? user.total : "0" }}</td>
        </tr>
      </tbody>
    </table>
    <div class="col-sm">
      <nav aria-label="weekly-pagination">
        <ul class="pagination justify-content-center">
          <li class="page-item" :class="{ disabled: !users.prev_page_url }">
            <button
              class="page-link"
              @click="handlePage(users.prev_page_url)"
              tabindex="-1"
            >
              Anterior
            </button>
          </li>

          <li class="page-item">
            <button class="page-link">
              {{ users.current_page }} <span class="sr-only">(current)</span>
            </button>
          </li>

          <li class="page-item" :class="{ disabled: !users.next_page_url }">
            <button class="page-link" @click="handlePage(users.next_page_url)">
              Siguiente
            </button>
          </li>
        </ul>
      </nav>
    </div>
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
  methods: {
    handlePage(e) {
      this.$store.dispatch("getRankings", e).then((resp) => {
        console.log("got next rankings");
      });
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
