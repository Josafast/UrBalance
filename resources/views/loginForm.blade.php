<x-app-layout title="{{request()->routeIs('login.view') ? 'Ingresar' : 'Registrarse'}}">
  <form action="{{ route( request()->routeIs('login.view') ? 'login' : 'register' ) }}" method="post" class="form login_form" style="color: #fff; background-color: var(--red); margin: auto;width: 400px;">
    @csrf
    @if ($into)
      <label for="name">
        <input type="text" name="name" required value="{{ old('name') }}">
        <h3>Nombre</h3>
      </label>
    @error('name')
      <small>*{{ $message }}</small>
    @enderror
    @endif
      <label for="email">
        <input type="text" name="email" required value="{{ old('email') }}">
        <h3>Correo electrónico</h3>
      </label>
    @error('email')
      <small>*{{ $message }}</small>
    @enderror
      <label for="password">
        <input type="password" name="password" required value="{{ old('password') }}">
        <h3>Contraseña</h3> 
      </label>
    @error('password')
      <small>*{{ $message }}</small>
    @enderror
    @if ($into)
      <label for="password_confirmation" style="margin-bottom: 60px">
        <input type="password" name="password_confirmation" required>
        <h3>Confirmar contraseña</h3>
      </label>
    @error('password_confirmation')
      <small>*{{ $message }}</small>
    @enderror
    @else
      <label for="rememberMe" style="display:flex;margin: 0; margin-top: 30px;">
        <input type="checkbox" name="rememberMe" style="width: min-content;margin-right: 10px;">
        <h4>Recuérdame</h4>
      </label>
    @endif
    <input type="submit" value="{{ request()->routeIs('login.view') ? 'Ingresar' : 'Siguiente' }}" style="background-color: #fff; color: var(--red)">
  </form>

  <script>
    let colors = ["red", "yellow", "green", "blue"];
    let iterator = 1;

    setInterval(() => {
      document.querySelector('.login_form').style.backgroundColor = `var(--${colors[iterator]})`;
      document.querySelector('.login_form').lastElementChild.style.color = `var(--${colors[iterator]})`;
      iterator = iterator == 3 ? 0 : iterator+1; 
    }, 2000);
  </script>
</x-app-layout>    