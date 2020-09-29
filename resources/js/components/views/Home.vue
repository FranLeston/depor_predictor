<template>
  <div class="row">
    <div class="col-sm-8">
      <div v-if="!$store.getters.isLoggedIn" class="jumbotron">
        <h1 class="display-4">Bienvenido a QuiniDepor!</h1>
        <p class="lead">
          Hola a todos! Me llamo Fran y he creado este pequeño sitio en la web
          dedicado al Depor en mi rato libre para que nos divertamos un poco.
          Mas adelante, vendran mas cosillas interesantes pero por ahora, ya
          puedes dejar tus pronosticos y empezar a sumar puntos!
        </p>
        <hr class="my-4" />
        <p>¡Empieza a jugar creando tu cuenta ya!</p>
        <router-link
          class="btn btn-depor-blue btn-lg"
          to="/register"
          role="button"
          >Crear Cuenta</router-link
        >
      </div>
      <div v-else class="jumbotron">
        <h1 class="display-7">Hola, {{ currentUser.name }}</h1>
        <p class="lead">
          Echale un vistazo a las
          <router-link to="/rules">Reglas</router-link> para conocer el sistema
          de puntos y la clasificacion.
        </p>
        <p class="lead">
          Puedes actualizar tu avatar en tú página de
          <router-link to="/profile">Pérfil</router-link>.
        </p>
        <p class="lead">
          En los
          <router-link to="/rankings">Rankings </router-link>puedes ver tanto la
          clasificacion global como la de cada jornada.
        </p>
        <hr class="my-4" />
        <p>¿Ya has rellenado tus pronosticos?</p>
        <router-link
          class="btn btn-depor-blue btn-lg"
          to="/predictions"
          role="button"
          >Partidos en Juego</router-link
        >
      </div>
      <span class="h4">Ranking Global</span>
      <rankingTable></rankingTable>
    </div>
    <div class="col-sm-4">
      <adsense
        ad-client="ca-pub-3438390069739160"
        ad-slot="3438390069739160"
        ad-style="display: block"
        ad-format="auto"
      >
      </adsense>
      <span class="h4">En Juego</span>
      <currentFixturesStatic></currentFixturesStatic>
    </div>
  </div>
</template>
<script>
import currentFixturesStatic from "./../reusable/CurrentFixturesStatic";
import rankingTable from "./../reusable/RankingTable";

export default {
  data() {
    return {
      user: this.$store.getters.currentUser,
    };
  },
  components: {
    currentFixturesStatic,
    rankingTable,
  },
  mounted() {
    if (this.user.id) {
      this.$store.dispatch("getUserRanking", this.user.id).then((resp) => {
        console.log("got user ranking");
      });
    }
    this.$store.dispatch("getCurrentRound").then((resp) => {
      console.log("got current round");
    });
  },
  computed: {
    currentUser: function () {
      return this.$store.getters.currentUser;
    },
  },
};
</script>

<style>
</style>
