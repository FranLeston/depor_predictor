<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="row">
          <h1>Reglas de Juego</h1>
        </div>

        <h2 class="my-5">¿Como jugar?</h2>
        <p>
          Las reglas del juego son sencillas y cualquiera puede jugar. La
          division en que se juega siempre sera la del Depor. Cada jornada se
          podran hacer los pronosticos de los partidos en juego. Tienes hasta el
          inicio del partido parsa guardar tu pronostico.
        </p>
        <h2 class="my-5">Puntos</h2>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <span class="font-weight-bold">+5 Puntos -- </span>
            <span>Acierto total del pronostico.</span>
          </li>
          <li class="list-group-item">
            <span class="font-weight-bold">+3 Puntos -- </span>

            <span
              >Acierto parcial. Acierto solo del el numero de goles del equipo
              visitante o el equipo local.
            </span>
          </li>
          <li class="list-group-item">
            <span class="font-weight-bold">+1 Punto -- </span>
            <span
              >Si la diferencia de goles del resultado es igual a la diferencia
              de goles de tu pronostico. BONUS: Estos puntos se podran sumar a
              un acierto parcial.
            </span>
          </li>
        </ul>
        <h2 class="my-5">Clasificación</h2>
        <p>
          Hay clasificacion global y por jornadas. En caso de empate se tomara
          en cuenta el numero de Aciertos Exactos para el desempate. Si todavia
          hay empate, el que mas pronosticos jugados tenga estaria por encima.
          Habrá 1 Campeon cada Jornada, 1 Campeon de Invierno (al mitad de la
          temporada) y un Campeon de Temporada al finalizar la liga.
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
