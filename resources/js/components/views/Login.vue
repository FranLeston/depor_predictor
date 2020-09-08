<template>
  <div class="row no-gutters">
    <div class="col-4 mx-auto my-auto text-center">
      <form @submit.prevent="login">
        <img
          class="mb-4"
          src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Escudo_del_Real_Club_Deportivo_de_La_Coru%C3%B1a.png"
          alt=""
          width="72"
          height="72"
        />
        <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>
        <div v-if="errors" class="alert alert-danger" role="alert">
          {{ errors }}
        </div>
        <div class="form-group">
          <label for="inputEmail">Email</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            id="inputEmail"
            aria-describedby="emailHelp"
            placeholder="Email"
            required
            autofocus
          />
          <small id="emailHelp" class="form-text text-muted"
            >Nunca compartiremos tú email.</small
          >
        </div>
        <div class="form-group">
          <label for="inputPassword1">Contraseña</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            id="inputPassword1"
            required
            placeholder="Contraseña"
          />
        </div>

        <button type="submit" class="btn btn-purple">
          Login
        </button>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {},
  data() {
    return {
      email: "",
      password: "",
      errors: "",
    };
  },
  methods: {
    login: function () {
      this.errors = "";
      let email = this.email;
      let password = this.password;
      this.$store
        .dispatch("login", { email, password })
        .then(() => this.$router.push("/"))
        .catch((err) => {
          console.log(err.response.data.message);
          this.errors = err.response.data.message;
        });
    },
  },
};
</script>


<style>
.row {
  height: 75vh;
}
</style>
