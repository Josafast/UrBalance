<footer>
  <a href="https://josafast.github.io/JosafatPortofolio"><img src="{{ asset('img/jfastSFX.svg') }}" alt="Josafast_logo"></a>
  <p style="margin: 0 70px;text-align: center;">Todos los derechos reservados para Ionic, y el uso de sus iconos "Ion-Icons"; y para la organización de Chart.js y su API de gráficas estadisticas © <b class="year"></b></p>
  <a href="https://github.io/Josafast"><img src="{{ asset('img/logo-github.svg') }}" alt="github_logo" style="width:30px;"></a>
</footer>
<script>
  let year = new Date().getFullYear();

  document.querySelector('.year').textContent = year;
</script>