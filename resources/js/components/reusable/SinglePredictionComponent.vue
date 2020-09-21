<template>
  <div class="container">
    <div class="row justify-content-center">
      <div
        v-for="(prediction, index) in predictions"
        :key="index"
        class="col-sm-6 my-3"
      >
        <form @submit.prevent="savePrediction(index)">
          <div
            class="card text-center shadow-lg"
            v-bind:class="{
              'red-fade':
                prediction.short_status != 'NS' ||
                prediction.short_status != 'PST' ||
                prediction.short_status != 'FT' ||
                prediction.short_status != 'TBD',
              'depor-blue-fade': prediction.short_status === 'NS',
              'cloud-fade':
                prediction.short_status === 'FT' ||
                prediction.short_status === 'TBD',
            }"
          >
            <div class="card-body">
              <h5 class="card-title">{{ prediction.status_esp }}</h5>
              <h6
                v-if="
                  prediction.short_status == 'NS' ||
                  prediction.short_status == 'FT'
                "
                class="card-subtitle mb-2"
              >
                {{
                  new Date(prediction.event_date).toLocaleDateString() +
                  " - " +
                  new Date(prediction.event_date).toLocaleTimeString()
                }}
              </h6>
              <h6 v-else class="card-subtitle mb-2">
                {{ new Date(prediction.event_date).toLocaleDateString() }}
              </h6>

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
                      v-if="prediction.short_status === 'NS'"
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
                      class="h4"
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
                    <span v-else></span>
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
                      v-if="prediction.short_status === 'NS'"
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
                <div class="col-auto">
                  <span
                    >Tu Pronostico:
                    {{
                      prediction.predictions[0].home_team_prediction != null
                        ? prediction.predictions[0].home_team_prediction
                        : "X"
                    }}
                    -
                    {{
                      prediction.predictions[0].away_team_prediction != null
                        ? prediction.predictions[0].away_team_prediction
                        : "X"
                    }}
                  </span>
                </div>
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
  },

  computed: {
    predictions: function () {
      return this.$store.getters.predictions;
    },
  },
  methods: {
    isRed: function (index) {
      var status = this.$store.state.predictions[index].short_status;
      console.log(status);
      if (status === "NS") {
        return true;
      } else {
        return true;
      }
    },
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
