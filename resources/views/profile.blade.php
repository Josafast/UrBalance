<x-app-layout title="{{ __('titles.profile') }}">
  <form action="{{ route('profile.change_email') }}" method="post" style="width: 50%;" class="form">
    @csrf
    @method('put')
    <h2 style="margin-bottom: 20px;">{{ __('validation_fields.titles.change_name_or_email') }}</h2>
    <label for="name">
      <input type="text" name="name" value="{{ auth()->user()->name }}" required>
      <h3>{{ __('validation_fields.name') }}</h3>
    </label>
    <div class="nameErrors"></div>
    <label for="email" style="margin-bottom: 50px;">
      <input type="email" name="email" value="{{ auth()->user()->email }}" required>
      <h3>{{ __('validation_fields.email') }}</h3>
    </label>
    <div class="emailErrors"></div>
    <input type="submit" value="{{ __('validation_fields.buttons.change') }}">
  </form>
  <form action="{{ route('profile.change_password') }}" method="post" style="width: 50%;" class="form">
    @csrf
    @method('put')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h2 style="margin-bottom: 20px;">{{ __('validation_fields.titles.change_password') }}</h2>
    <label for="current_password">
      <input type="password" name="current_password" required>
      <h3>{{ __('validation_fields.current_password') }}</h3>
    </label>
    <div class="current_passwordErrors"></div>
    <label for="new_password">
      <input type="password" name="new_password" required>
      <h3>{{ __('validation_fields.new_password') }}</h3>
    </label>
    <div class="new_passwordErrors"></div>
    <label for="new_password_confirmation" style="margin-bottom: 50px;">
      <input type="password" name="new_password_confirmation" required>
      <h3>{{ __('validation_fields.confirm_password') }}</h3>
    </label>
    <input type="submit" value="{{ __('validation_fields.buttons.change') }}">
  </form>
  <form action="{{ route('profile.destroy') }}" method="post" style="width: 50%;" class="form">
    @csrf
    @method('delete')
    <h2>{{ __('validation_fields.titles.delete_user') }}</h2>
    <small style="font-weight: bold;">*{{ __('validation_fields.small.all_data_will_be_deleted') }}</small>
    <label for="password">
      <input type="password" name="password" required>
      <h3>{{ __('validation_fields.password') }}</h3>
    </label>
    <div class="passwordErrors"></div>
    <label for="password_confirmation" style="margin-bottom: 50px;">
      <input type="password" name="password_confirmation" required>
      <h3>{{ __('validation_fields.confirm_password') }}</h3>
    </label>
    <input type="submit" value="{{ __('validation_fields.buttons.delete_user') }}" style="background-color: var(--red); color: #fff;">
  </form>
</x-app-layout>