<header style="background-color: #fff;">
  <a href="{{ route('index') }}" style="display: flex; color: #707070; text-decoration: none">
    <h1 style="transform: scaleX(-1);-moz-transform: scaleX(-1);-webkit-transform: scaleX(-1);-o-transform: scaleX(-1);font-weight:bold; color: #545454;">UR</h1>
    <h1>BALANCE</h1>
  </a>
  <nav class="nav">
    <ul>
      @auth
        <li><a href="{{ route('dashboard') }}" style="font-weight: {{ request()->routeIs('dashboard') ? 'bold' : 'normal' }}">Dashboard</a></li>
        <li><a href="{{ route('transactions.index') }}" style="font-weight: {{ request()->routeIs('transactions.index') ? 'bold' : 'normal' }}">Transacciones</a></li>
        <li><a href="{{ route('profile.index') }}" style="font-weight: {{ request()->routeIs('profile.index') ? 'bold' : 'normal' }}">Perfil</a></li>
        <li><form action="{{ route('logout') }}" method="post">
          @csrf
          <a href="#" id="logout">Salir</a>
          <script>
            document.getElementById('logout').addEventListener('click',(e)=>{
              e.preventDefault();
              let form = e.target.parentElement;
              form.submit();
            });
          </script>
        </form></li>
      @else
        <li><a href="{{ route('login.view') }}" style="font-weight: {{ request()->routeIs('login.view') ? 'bold' : 'normal' }}">Iniciar sesión</a></li>
        <li><a href="{{ route('register.view') }}" style="font-weight: {{ request()->routeIs('register.view') ? 'bold' : 'normal' }}">Registrarse</a></li>
      @endauth
    </ul>
  </nav>
</header>