<template>
  <div class="row no-gutters">
    <div class="col-4 mx-auto my-auto text-center">
      <form @submit.prevent="updateProfile" enctype="multipart/form-data">
        <img
          class="rounded-circle mb-4"
          :src="currentUser.avatar"
          width="100"
          height="100"
        />
        <h1 class="h3 mb-3 font-weight-normal">Perfil</h1>
        <div v-if="errors" class="alert alert-danger" role="alert">
          {{ errors }}
        </div>
        <div class="form-group">
          <label for="name">Nombre</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            :placeholder="currentUser.name"
          />
        </div>
        <div class="form-group">
          <label for="inputImage">Avatar</label>
          <input type="file" class="form-control" @change="selectFile" />
        </div>

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
      name: "",
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
      this.avatar = event.target.files[0];
    },
    updateProfile: function (e) {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("avatar", this.avatar);
      formData.append("name", this.name);

      axios
        .post(`/api/v1/users/update/${this.currentUser.id}`, formData, config)
        .then(function (resp) {
          console.log(resp.data);
        })
        .catch(function (error) {
          this.errors = error;
        });
    },
  },
};
</script>

<style>
</style>
