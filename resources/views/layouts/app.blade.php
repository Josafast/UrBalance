<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  @if (request()->routeIs('index') || request()->routeIs('dashboard'))
    @vite(['resources/js/glide.js',
    'node_modules/@glidejs/glide/dist/css/glide.core.min.css',
    'node_modules/@glidejs/glide/dist/css/glide.theme.min.css'])
  @endif
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>{{ $attributes['title'] }}</title>
</head>
<body>
  <x-message />
  <x-header />

  <main class="main" @if (request()->routeIs('index')) style="padding: 0;" @endif>
    {{ $slot }}
    @auth
      <x-balance-menu />
    @endauth
    @if (auth()->check())
      <x-balance-create />
    @endif
  </main>

  <x-footer />
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  @vite(['resources/js/forms.js'])
</body>
</html>