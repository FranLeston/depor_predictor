<template>
  <!-- Footer -->
  <footer class="font-small pt-4 mt-4">
    <div class="container text-left">
      <div class="row">
        <div class="col-sm-6">
          <h5 class="title">Footer Content</h5>
          <p>
            Here you can use rows and columns here to organize your footer
            content.
          </p>
        </div>
        <div class="col-sm-6">
          <h5 class="title">Links</h5>
          <ul>
            <li class="list-unstyled"><a href="#!">Link 1</a></li>
            <li class="list-unstyled"><a href="#!">Link 2</a></li>
            <li class="list-unstyled"><a href="#!">Link 3</a></li>
            <li class="list-unstyled"><a href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright text-center py-3">
      <div class="container-fluid">
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
}

a {
  color: #ffffff;
}
</style>
