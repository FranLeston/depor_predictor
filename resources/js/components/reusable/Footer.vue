<template>
  <!-- Footer -->
  <footer class="font-small pt-4 mt-4">
    <div class="container text-left">
      <div class="row">
        <div class="col-sm-6">
          <h5 class="title">Contacto</h5>
          <p>
            ¿Tienes alguna sugerencia o problema? Me gustaría mucho conocerla.
            Ando por twitter en
            <a href="https://twitter.com/quinidepor">@QuiniDepor</a> o
            <a href="https://twitter.com/FranLeston">@FranLeston</a>
            . Si lo prefieres, puedes mandarme un email:
            <a href="mailto:fran.leston@outlook.com">fran.leston@outlook.com</a>
          </p>
        </div>
        <div class="col-sm-6">
          <h5 class="title">Enlaces</h5>
          <ul>
            <li class="list-unstyled">
              <router-link to="/predictions">Pronósticos</router-link>
            </li>
            <li class="list-unstyled">
              <router-link to="/rankings">Rankings</router-link>
            </li>
            <li class="list-unstyled">
              <router-link to="/rules">Reglas</router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright text-center py-3">
      <div class="container-fluid">
        <span>#VOLTAREMOS!</span>
        <br />
        &copy; Copyright: {{ new Date().getFullYear() }}
        <a href="https://www.QuiniDepor.com"> QuiniDepor.com </a>
      </div>
    </div>
  </footer>
</template>

<script>
export default {};
</script>

<style lang="css" scoped>
footer {
  background-color: #004a99;
  color: #ffffff;
  left: 0;
  bottom: 0;
  width: 100%;
}

a {
  color: #ffffff;
}
</style>
