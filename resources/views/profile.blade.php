<x-app-layout title="Perfil">
  <form action="{{ route('profile.change_email') }}" method="post" style="width: 50%;" class="form">
    @csrf
    @method('put')
    <h2 style="margin-bottom: 20px;">Cambiar nombre o correo electrónico</h2>
    <label for="name">
      <input type="text" name="name" value="{{ auth()->user()->name }}" required>
      <h3>Nombre</h3>
    </label>
    <div class="nameErrors"></div>
    <label for="email" style="margin-bottom: 50px;">
      <input type="email" name="email" value="{{ auth()->user()->email }}" required>
      <h3>Correo electrónico</h3>
    </label>
    <div class="emailErrors"></div>
    <input type="submit" value="Cambiar">
  </form>
  <form action="{{ route('profile.change_password') }}" method="post" style="width: 50%;" class="form">
    @csrf
    @method('put')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h2 style="margin-bottom: 20px;">Cambiar Contraseña</h2>
    <label for="current_password">
      <input type="password" name="current_password" required>
      <h3>Contraseña actual</h3>
    </label>
    <div class="current_passwordErrors"></div>
    <label for="new_password">
      <input type="password" name="new_password" required>
      <h3>Contraseña nueva</h3>
    </label>
    <div class="new_passwordErrors"></div>
    <label for="new_password_confirmation" style="margin-bottom: 50px;">
      <input type="password" name="new_password_confirmation" required>
      <h3>Confirmar contraseña</h3>
    </label>
    <input type="submit" value="Cambiar">
  </form>
  <form action="{{ route('profile.destroy') }}" method="post" style="width: 50%;" class="form">
    @csrf
    @method('delete')
    <h2>Borrar usuario</h2>
    <small style="font-weight: bold;">*Todos tus datos se eliminaran por completo</small>
    <label for="password">
      <input type="password" name="password" required>
      <h3>Contraseña</h3>
    </label>
    <div class="passwordErrors"></div>
    <label for="password_confirmation" style="margin-bottom: 50px;">
      <input type="password" name="password_confirmation" required>
      <h3>Confirmar contraseña</h3>
    </label>
    <input type="submit" value="Borrar Usuario" style="background-color: var(--red); color: #fff;">
  </form>
</x-app-layout>