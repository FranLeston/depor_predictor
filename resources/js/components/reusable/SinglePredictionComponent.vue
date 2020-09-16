<template>
  <div class="container">
    <div class="row justify-content-center">
      <div
        v-for="(prediction, index) in predictions"
        :key="index"
        class="col-md-6 my-3"
      >
        <form @submit.prevent="savePrediction(index)">
          <div class="card text-center depor-blue-fade shadow-lg">
            <div class="card-body">
              <h5 class="card-title">{{ prediction.status }}</h5>
              <h6 class="card-subtitle mb-2">
                {{
                  new Date(prediction.event_date).toLocaleDateString() +
                  " - " +
                  new Date(prediction.event_date).toLocaleTimeString()
                }}
              </h6>
              <span ref="timer"></span>

              <div class="card-text">
                <div class="row">
                  <div class="col-4">
                    <figure>
                      <img
                        :src="prediction.home_team.logo"
                        width="50"
                        height="50"
                      />
                      <figcaption>{{ prediction.home_team.name }}</figcaption>
                    </figure>
                    <input
                      v-bind:readonly="prediction.short_status != 'NS'"
                      v-model="prediction.predictions[0].home_team_prediction"
                      type="number"
                      class="form-control form-control-sm"
                      min="0"
                      required
                    />
                  </div>
                  <div class="col-4">
                    <span
                      v-if="
                        prediction.goals_home_team != null &&
                        prediction.goals_away_team != null
                      "
                    >
                      {{
                        prediction.goals_home_team +
                        " - " +
                        prediction.goals_away_team
                      }}
                    </span>
                    <span v-else>0 - 0</span>
                  </div>
                  <div class="col-4">
                    <figure>
                      <img
                        :src="prediction.away_team.logo"
                        width="50"
                        height="50"
                      />
                      <figcaption>{{ prediction.away_team.name }}</figcaption>
                    </figure>
                    <input
                      v-bind:readonly="prediction.short_status != 'NS'"
                      v-model="prediction.predictions[0].away_team_prediction"
                      type="number"
                      class="form-control form-control-sm"
                      min="0"
                      required
                    />
                  </div>
                </div>
              </div>
              <div
                class="col-auto"
                v-if="prediction.predictions[0].points != null"
              >
                <h4>
                  <span class="badge badge-pill badge-purple"
                    >Puntos: {{ prediction.predictions[0].points }}</span
                  >
                </h4>
              </div>
              <div
                v-if="saved === index"
                class="alert alert-success my-3"
                role="alert"
              >
                Pronostico guardado 💪
              </div>
              <div
                v-if="errors === index"
                class="alert alert-danger my-3"
                role="alert"
              >
                Imposible..el partido ha comenzado! 😢
              </div>
              <button
                v-if="prediction.short_status === 'NS'"
                type="submit"
                class="btn btn-purple my-3"
              >
                Guardar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errors: "",
      saved: {},
    };
  },

  watch: {
    // whenever question changes, this function will run
    predictions: function (oldPredictions, newPredictions) {
      this.errors = "";
      this.saved = {};
    },
  },
  mounted() {
    this.$store.dispatch("getPredictions").then((resp) => {
      console.log("got single prediction");
    });
    const vm = this;

    var myfunc = setInterval(function () {
      for (let index = 0; index < vm.predictions.length; index++) {
        var countDownDate = new Date(
          vm.predictions[index].event_timestamp
        ).getTime();
        var now = new Date().getTime();
        var timeleft = countDownDate - now;

        // Calculating the days, hours, minutes and seconds left
        var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
        var hours = Math.floor(
          (timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
        var timeLeft = `${days} d, ${hours}h ${minutes}m ${seconds}s`;
        vm.$refs.timer[index].innerHTML = timeLeft;

        if (timeleft < 0) {
          clearInterval(myfunc);
          vm.$refs.timer[index].innerHTML = "";
        }
      }
    }, 1000);
  },

  computed: {
    predictions: function () {
      return this.$store.getters.predictions;
    },
  },
  methods: {
    savePrediction: function (index) {
      this.errors = "";
      let data = {
        fixture_id: this.predictions[index].fixture_id,
        home_team_prediction: this.predictions[index].predictions[0]
          .home_team_prediction,
        away_team_prediction: this.predictions[index].predictions[0]
          .away_team_prediction,
      };

      this.$store
        .dispatch("savePrediction", {
          data,
        })
        .then((resp) => {
          this.saved = index;
        })
        .catch((resp) => {
          this.errors = index;
        });
    },
  },
};
</script>

<style lang="css" scoped>
.badge-depor {
  background-color: #004a99;
  color: #ffffff;
}

.badge-purple {
  background-color: #724778;
  color: #ffffff;
}
</style>
