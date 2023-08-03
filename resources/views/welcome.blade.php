<x-app-layout title="{{ __('titles.welcome') }}">
    <section class="index presentation" style="background: url('{{ asset('img/balance.jpg') }}') no-repeat center center scroll; background-size: cover;">
        <img src="{{ asset('img/balance-item.png') }}" alt="balancer" style="filter: invert(100%); flex-shrink: 1; width: 100%; margin-bottom: 20px;">
        <div style="display:flex; height: min-content; font-size: 2em;">
            <h1 style="font-weight:bold; color: #fff;" class="horizontal">UR</h1>
            <h1 style="color: #fff !important; z-index: 11;">BALANCE</h1>
        </div>
        <h2 style="color: #fff; z-index: 11; margin: 0 40px; text-align: center; max-width: 340px;">{{ __('welcome.message.landing_message') }}</h2>
    </section>
    <section class="index">
        <div class="first-parraf">
            <div>
                <p style="margin-bottom: 30px; max-width: 600px; margin-right: auto;">{{ __('welcome.message.first_descripting_message') }}</p>
                <p style="text-align:end; font-weight: bold; margin-left: auto;">{{ __('welcome.message.second_descripting_message') }}</p>
            </div>
            <img src="{{ asset('img/calculator.png') }}" alt="calculator" style="max-width: 300px;">
        </div>
        <div class="glide">
            <div class="glide__track" data-glide-el="track">
              <ul class="glide__slides">
                <x-glide-welcome-track />
              </ul>
            </div>
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<" style="transform: rotate(180deg); margin-top: -18px">➤</button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">➤</button>
              </div>
          </div>
    </section>
    <section class="index getStarted">
        <h1 style="font-weight: bold;">{{ auth()->check() ? __('welcome.message.already_registered') : __('welcome.message.like_idea') }}</h1>
        <h1>{{auth()->check() ? __('welcome.message.see_your_dashboard') : __('welcome.message.register_now') }}</h1>
        <a href="{{ route('register.view') }}">
            <button>
                {{auth()->check() ? __('welcome.message.see_account') : __('validation_fields.buttons.register')}}
            </button>
        </a>    
    </section>
</x-app-layout>