<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-depor">
      <router-link class="navbar-brand" to="/">
        <img
          src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Escudo_del_Real_Club_Deportivo_de_La_Coru%C3%B1a.png"
          width="30"
          height="30"
          class="d-inline-block align-top"
          alt="Depor Porra"
        />
        QuiniDepor beta
      </router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarDropdownMenuLink"
        aria-controls="navbarDropdownMenuLink"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarDropdownMenuLink">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link v-if="isLoggedIn" class="nav-link" to="/predictions"
              >Pronosticos</router-link
            >
          </li>
          <li class="nav-item">
            <router-link v-if="isLoggedIn" class="nav-link" to="/rankings"
              >Rankings</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/rules">Reglas</router-link>
          </li>
          <!-- <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              El Depor
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Clasificacion</a>
              <a class="dropdown-item" href="#">Jugadores</a>
              <a class="dropdown-item" href="#">Estadisticas</a>

              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li> -->
        </ul>
        <ul v-if="isLoggedIn" class="navbar-nav ml-auto">
          <li class="nav-item">
            <span v-if="userPoints[0]" class="nav-link active my-2 h5"
              >{{ userPoints[0].total || 0 }} Pts
            </span>
            <span class="nav-link active my-2 h5" v-else>0 Pts</span>
          </li>
          <li class="nav-item">
            <span v-if="userPoints[0]" class="nav-link active my-2 h5"
              >{{ userPoints[0].rank || 0 }}º Puesto
            </span>
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdownMenuLink"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <span>{{ currentUser.name }}</span>
              <img
                :src="`/images/profile/${currentUser.avatar}`"
                width="40"
                height="40"
                class="rounded-circle"
              />
            </a>
            <div
              class="dropdown-menu dropdown-menu-right text-right"
              aria-labelledby="navbarDropdownMenuLink"
            >
              <router-link class="dropdown-item" to="/profile"
                >Perfil</router-link
              >
              <div class="dropdown-divider"></div>
              <button class="dropdown-item" @click="logout" to="/">
                Logout
              </button>
            </div>
          </li>
        </ul>
        <div v-else>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/register"
                >Crear Cuenta</router-link
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="wrapper">
      <router-view />
    </div>
    <footersection
      v-if="
        isLoggedIn || this.$route.name == 'Home' || this.$route.name == 'Rules'
      "
    ></footersection>
  </div>
</template>

<script>
import footersection from "./reusable/Footer";
export default {
  components: {
    footersection,
  },
  mounted() {
    console.log(this.$router);
  },
  computed: {
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    },
    currentUser: function () {
      return this.$store.getters.currentUser;
    },
    userPoints: function () {
      return this.$store.getters.userPoints;
    },
  },
  methods: {
    logout: function () {
      this.$store.dispatch("logout").then(() => {
        this.$router.push("/login");
      });
    },
  },
};
</script>

<style lang="css">
.wrapper {
  margin: 15px 15px 15px 15px;
}

.depor-blue-fade {
  color: #fff;
  background: #0575e6; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to right,
    #004a99,
    #0575e6
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #004a99,
    #0575e6
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>
