<header style="z-index: 10; @if (request()->routeIs('index')) background-color: transparent; position: absolute; @endif">
  <a href="{{ route('index') }}" style="{{ request()->routeIs('index') ? 'display: none;' : 'display: flex;' }} color: #707070; text-decoration: none">
    <h1 style="transform: scaleX(-1);-moz-transform: scaleX(-1);-webkit-transform: scaleX(-1);-o-transform: scaleX(-1);font-weight:bold; color: #545454;">UR</h1>
    <h1>BALANCE</h1>
  </a>
  <nav class="nav" style="margin-left: auto;">
    <ul>
      @auth
        <li><a href="{{ route('dashboard') }}" style="font-weight: {{ request()->routeIs('dashboard') ? 'bold' : 'normal' }}; @if (request()->routeIs('index')) color: #fff !important; @endif">{{ __('header.dashboard') }}</a></li>
        <li><a href="{{ route('transactions.index') }}" style="font-weight: {{ request()->routeIs('transactions.index') ? 'bold' : 'normal' }}; @if (request()->routeIs('index')) color: #fff !important; @endif">{{ __('header.transactions') }}</a></li>
        <li><a href="{{ route('profile.index') }}" style="font-weight: {{ request()->routeIs('profile.index') ? 'bold' : 'normal' }}; @if (request()->routeIs('index')) color: #fff !important; @endif">{{ __('header.profile') }}</a></li>
        <li><form action="{{ route('logout') }}" method="post">
          @csrf
          <a href="#" id="logout" @if (request()->routeIs('index')) style="color: #fff" !important; @endif>{{ __('header.logout') }}</a>
          <script>
            document.getElementById('logout').addEventListener('click',(e)=>{
              e.preventDefault();
              let form = e.target.parentElement;
              form.submit();
            });
          </script>
        </form></li>
        @if (request()->routeIs('transactions.index') || !Illuminate\Support\Str::startsWith(Illuminate\Support\Facades\Route::currentRouteName(), 'transactions'))
          <li class="create_transaction">
            <a href="{{ route('transactions.create') }}">
              <ion-icon name="ios-create"></ion-icon>
            </a>
          </li>
        @endif
      @else
        <li><a href="{{ route('login.view') }}" style="font-weight: {{ request()->routeIs('login.view') ? 'bold' : 'normal' }}; @if (request()->routeIs('index')) color: #fff !important; @endif">{{ __('header.login')}}</a></li>
        <li><a href="{{ route('register.view') }}" style="font-weight: {{ request()->routeIs('register.view') ? 'bold' : 'normal' }}; @if (request()->routeIs('index')) color: #fff !important; @endif">{{ __('header.signin') }}</a></li>
      @endauth
    </ul>
  </nav>
</header>