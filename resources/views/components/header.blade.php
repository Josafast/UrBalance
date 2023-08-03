<header style="{{ request()->routeIs('index') ? 'position: absolute;' : (request()->routeIs('register.view') || request()->routeIs('login.view') ? 'background-color: transparent;' : '')}}" @if(request()->routeIs('index') || request()->routeIs('register.view') || request()->routeIs('login.view')) class="white transparent" @endif>
  <a href="{{ route('index') }}" style="{{ request()->routeIs('index') ? 'display: none;' : 'display: flex;' }} color: #707070; text-decoration: none">
    <h1 style="font-weight: bold; color: #545454;" class="horizontal">UR</h1>
    <h1>BALANCE</h1>
    <img src="{{ asset('img/balance-item.png') }}" alt="balancer">
  </a>
  <nav class="nav">
    <button class="menu">
      <ion-icon name="menu"></ion-icon>
    </button>
    <button class="close" style="display: none;">
      <ion-icon name="close"></ion-icon>
    </button>
    <script>
      let menuButton = document.querySelector('.menu');
      let closeButton = document.querySelector('.close');

      menuButton.addEventListener('click', ()=> menuButton.classList.add('active'));
      closeButton.addEventListener('click', ()=> menuButton.classList.remove('active'));
    </script>
    <ul class="nav-list">
      @auth
        <li><a href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) class="active" @endif>
          <img src="{{ asset('img/analytics-outline.svg') }}" alt="dashboard">
          <img src="{{ asset('img/analytics-sharp.svg') }}" alt="dashboard">
          <h3>{{ __('header.dashboard') }}</h3>
        </a></li>
        <li><a href="{{ route('transactions.index') }}" @if(request()->routeIs('transactions.index')) class="active" @endif>
          <img src="{{ asset('img/cash-outline.svg') }}" alt="transactions">
          <img src="{{ asset('img/cash.svg') }}" alt="transactions">
          <h3>{{ __('header.transactions') }}</h3>
        </a></li>
        <li><a href="{{ route('profile.index') }}" @if(request()->routeIs('profile.index')) class="active" @endif>
          <img src="{{ asset('img/person-outline.svg') }}" alt="transactions">
          <img src="{{ asset('img/person.svg') }}" alt="transactions">
          <h3>{{ __('header.profile') }}</h3>
        </a></li>
        <li><a href="{{ route('logout') }}" id="logout">
          <img src="{{ asset('img/log-out-outline.svg') }}" alt="logout">
          <h3>{{ __('header.logout') }}</h3>
        </a></li>
        <li class="change_balance">
          <button style="cursor: pointer; position: relative;">
            <img src="{{ asset('img/swap.svg') }}" alt="swap">
            <h3>{{ __('validation_fields.titles.change_main_balance') }}</h3>
          </button>
        </li>
        @if (request()->routeIs('transactions.index') || !Illuminate\Support\Str::startsWith(Illuminate\Support\Facades\Route::currentRouteName(), 'transactions'))
          <li class="transaction-create">
            <a href="{{ route('transactions.create') }}">
              <ion-icon name="ios-create"></ion-icon>
              <h3>{{ __('validation_fields.buttons.create_transaction') }}</h3>
            </a>
          </li>
        @endif
        @if (request()->user()->balance->count() < App\Models\Exchange::all()->count())
          <li class="create_balance_button">
            <button style="cursor: pointer; position: relative;">
              <img src="{{ asset('img/new.svg') }}" alt="swap">
              <h3>{{ __('validation_fields.titles.create_balance') }}</h3>
            </button>
          </li>
        @endif
        <li>
          <button class="switch-nav">
            <span></span>
          </button>
        </li>
        <script>
          document.querySelector('.change_balance').addEventListener('click',()=> document.querySelector('.menu_balance').removeAttribute('style'));
    
          document.querySelector('.switch-nav').addEventListener('click', e=> document.querySelector('.nav-list').classList.toggle('active'));

          document.querySelector('.create_balance_button').addEventListener('click',()=> document.querySelector('.create_balance').removeAttribute('style'));
        </script>
      @else
        <li class="register"><a href="{{ route('login.view') }}">
          <h3 style="font-weight: {{ request()->routeIs('login.view') ? 'bold' : 'normal' }}; @if(request()->routeIs('login.view') || request()->routeIs('register.view')) color: #545454;@endif">
            {{ __('header.login')}}
          </h3></a></li>
        <li class="login"><a href="{{ route('register.view') }}">
          <h3 style="font-weight: {{ request()->routeIs('register.view') ? 'bold' : 'normal' }}; @if(request()->routeIs('login.view') || request()->routeIs('register.view')) color: #545454;@endif">
            {{ __('header.signin') }}
          </h3></a></li>
      @endauth
    </ul>
  </nav>
</header>