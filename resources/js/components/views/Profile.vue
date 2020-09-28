<template>
  <div class="row no-gutters">
    <div class="col-4 mx-auto my-auto text-center">
      <form @submit.prevent="updateProfile" enctype="multipart/form-data">
        <img
          class="rounded-circle mb-4"
          :src="`/images/profile/${currentUser.avatar}`"
          width="100"
          height="100"
        />
        <h1 class="h3 mb-3 font-weight-normal">Perfil</h1>
        <div v-if="errors" class="alert alert-danger" role="alert">
          Por favor, revisa los campos e intentalo de nuevo.
        </div>
        <div v-if="success" class="alert alert-success" role="alert">
          Perfil actualizado.
        </div>
        <div class="form-group">
          <label for="name">Nombre</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            v-bind:class="{ 'is-invalid': errors.name }"
          />
          <div v-if="errors.name" class="invalid-feedback">
            <span v-for="(error, index) in errors.name" :key="index">
              {{ error }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label for="inputImage">Avatar</label>

          <br />
          <label for="file-upload" id="file-name" class="btn btn-depor-blue">
            Subir Imagen (2Mb)
          </label>
          <input
            id="file-upload"
            type="file"
            class="form-control"
            v-bind:class="{ 'is-invalid': errors.avatar }"
            @change="selectFile"
            accept="image/png, image/jpeg, image/jpg"
          />

          <div v-if="errors.avatar" class="invalid-feedback">
            <span v-for="(error, index) in errors.avatar" :key="index">
              {{ error }}
            </span>
          </div>
        </div>
        <br />
        <button type="submit" class="btn btn-purple">Actualizar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errors: "",
      avatar: null,
      name: this.$store.getters.currentUser.name,
      success: "",
    };
  },
  computed: {
    currentUser: function () {
      return this.$store.getters.currentUser;
    },
  },
  methods: {
    selectFile: function (event) {
      const vm = this;
      vm.errors = "";
      var fileName = event.target.files[0].name;
      var sizeMB = event.target.files[0].size / 1024 / 1024;
      if (sizeMB > 2) {
        var errors = {
          avatar: ["La imagen pesa mas de 2 Megas"],
        };
        vm.errors = errors;
      } else {
        document.getElementById("file-name").innerHTML = fileName;
        this.avatar = event.target.files[0];
      }
    },
    updateProfile: function (e) {
      const vm = this;
      vm.errors = "";
      vm.success = "";
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      if (this.avatar) {
        formData.append("avatar", this.avatar);
      }
      formData.append("name", this.name);

      axios
        .post(`/api/v1/users/update/${this.currentUser.id}`, formData, config)
        .then(function (resp) {
          vm.$store
            .dispatch("getCurrentUser", vm.currentUser.id)
            .then((resp) => {
              vm.success = true;
            });
        })
        .catch(function (error) {
          vm.errors = error.response.data.errors;
        });
    },
  },
};
</script>

<style lang="css" scoped>
.row {
  height: 75vh;
}

input[type="file"] {
  display: none;
}
.custom-file-upload {
  border: 1px solid #ccc;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
}
</style>
