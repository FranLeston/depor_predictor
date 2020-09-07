<template>
  <div class="row">
    <div class="col-4 mx-auto my-auto text-center">
      <form>
        <img
          class="mb-4"
          src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Escudo_del_Real_Club_Deportivo_de_La_Coru%C3%B1a.png"
          alt=""
          width="72"
          height="72"
        />
        <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>
        <div class="form-group">
          <label for="inputEmail">Email</label>
          <input
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
            type="password"
            class="form-control"
            id="inputPassword1"
            required
            placeholder="Contraseña"
          />
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</template>
<script>
export default {};
</script>


<style>
.row {
  height: 75vh;
}
</style>
