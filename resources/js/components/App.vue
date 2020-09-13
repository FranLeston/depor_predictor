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
        Depor Porra
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
              >Mis Pronosticos</router-link
            >
          </li>
        </ul>
        <ul v-if="isLoggedIn" class="navbar-nav ml-auto">
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
              <img
                :src="currentUser.avatar"
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
                >Register</router-link
              >
            </li>
          </ul>
        </div>
      </div>

      <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Mis Pronosticos</router-link>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" v-if="isLoggedIn">
            <button class="btn nav-link" @click="logout" to="/">Logout</button>
          </li>
          <li class="nav-item" v-else>
            <router-link class="nav-link" to="/login">Login</router-link>
          </li>
          <li class="nav-item" v-if="!isLoggedIn">
            <router-link class="nav-link" to="/register">Register</router-link>
          </li>
        </ul>
      </div> -->
    </nav>
    <div class="wrapper">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    },
    currentUser: function () {
      return this.$store.getters.currentUser;
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

<style lang="css" scoped>
.wrapper {
  margin: 15px 15px 15px 15px;
}
</style>
