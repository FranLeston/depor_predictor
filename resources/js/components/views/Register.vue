<template>
  <div class="row no-gutters">
    <div class="col-sm-4 mx-auto my-auto text-center">
      <form @submit.prevent="register">
        <img
          class="mb-4"
          :src="'/images/site/rcdeporlogo.png'"
          alt=""
          width="72"
          height="72"
        />
        <h1 class="h3 mb-3 font-weight-normal">Crear Nuevo Usuario</h1>
        <div class="form-group">
          <label for="inputName">Nombre</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            v-bind:class="{ 'is-invalid': errors.name }"
            placeholder="Nombre"
            maxlength="15"
            required
            autofocus
          />
          <div v-if="errors.name" class="invalid-feedback">
            <span v-for="(error, index) in errors.name" :key="index">
              {{ error }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail">Email</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            v-bind:class="{ 'is-invalid': errors.email }"
            aria-describedby="emailHelp"
            placeholder="Email"
            required
          />
          <div v-if="errors.email" class="invalid-feedback">
            <span v-for="(error, index) in errors.email" :key="index">
              {{ error }}
            </span>
          </div>
          <small id="emailHelp" class="form-text text-muted"
            >Nunca compartiremos tú email.</small
          >
        </div>
        <div class="form-group">
          <label>Contraseña (minimo 8 carateres)</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            v-bind:class="{ 'is-invalid': errors.password }"
            required
            placeholder="Contraseña"
            minlength="8"
          />
          <div v-if="errors.password" class="invalid-feedback">
            <span v-for="(error, index) in errors.password" :key="index">
              {{ error }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label>Confirmar Contraseña</label>
          <input
            v-model="password_confirmation"
            type="password"
            class="form-control"
            v-bind:class="{ 'is-invalid': errors.password }"
            required
            placeholder="Confirmar Contraseña"
            minlength="8"
          />
          <div v-if="errors.password" class="invalid-feedback">
            <span v-for="(error, index) in errors.password" :key="index">
              {{ error }}
            </span>
          </div>
        </div>
        <button type="submit" class="btn btn-purple">Registrar</button>
      </form>
    </div>
  </div>
</template>
      <script>
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      errors: {},
    };
  },
  methods: {
    register: function () {
      let data = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
      };
      this.errors = {};
      this.$store
        .dispatch("register", data)
        .then((resp) => {
          this.$router.push("/login");
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>

<style lang="css" scoped>
/* .row {
  height: 75vh;
} */
</style>
