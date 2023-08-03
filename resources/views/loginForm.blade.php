<x-app-layout title="{{request()->routeIs('login.view') ? __('titles.login') : __('titles.signin') }}">
  <form action="{{ route(request()->routeIs('login.view') ? 'login' : 'register' ) }}" method="post" class="form login_form" style="color: #fff; background-color: var(--red); margin: auto;width: 400px;">
    @csrf
    @if ($isRegister)
      <label for="name">
        <input type="text" name="name" required value="{{ old('name') }}">
        <h3>{{ __('validation_fields.name') }}</h3>
      </label>
    <div class="nameErrors"></div>
    @endif
      <label for="email">
        <input type="text" name="email" required value="{{ old('email') }}">
        <h3>{{ __('validation_fields.email') }}</h3>
      </label>
      <div class="emailErrors" style="margin-bottom: 10px"></div>
      <label for="password">
        <input type="password" name="password" required value="{{ old('password') }}">
        <h3>{{ __('validation_fields.password') }}</h3> 
      </label>
      <div class="passwordErrors" style="margin-bottom: 10px"></div>
    @if ($isRegister)
      <label for="password_confirmation" style="margin-bottom: 60px">
        <input type="password" required name="password_confirmation">
        <h3>{{ __('validation_fields.confirm_password') }}</h3>
      </label>
      <div class="password_confirmationErrors" style="margin-bottom: 10px"></div>
    @else
      <label for="rememberMe" style="display:flex;margin: 0; margin-top: 30px;">
        <input type="checkbox" name="rememberMe" style="width: min-content;margin-right: 10px;">
        <h4>{{ __('validation_fields.remember_me') }}</h4>
      </label>
    @endif
    <input type="submit" value="{{ request()->routeIs('login.view') ? __('validation_fields.buttons.login') : __('validation_fields.buttons.next') }}" style="background-color: #fff; color: var(--red)">
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