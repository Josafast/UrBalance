<x-app-layout title="{{ __('titles.welcome') }}">
    <section class="index presentation" style="background: url('{{ asset('img/balance.jpg') }}') no-repeat center center scroll; background-size: cover;">
        <img src="{{ asset('img/balance-item.png') }}" alt="balancer" style="filter: invert(100%); flex-shrink: 1; max-width: 300px; max-height: 300px; margin-bottom: 20px;">
        <div style="display:flex; height: min-content; font-size: 2em;">
            <h1 style="transform: scaleX(-1);-moz-transform: scaleX(-1);-webkit-transform: scaleX(-1);-o-transform: scaleX(-1);font-weight:bold; color: #fff;">UR</h1>
            <h1 style="color: #fff !important; z-index: 11;">BALANCE</h1>
        </div>
        <h2 style="color: #fff; z-index: 11; margin: 0 40px; text-align: center; max-width: 340px;">{{ __('welcome.message.landing_message') }}</h2>
    </section>
    <section class="index">
        <div style="flex-grow: 1;padding: 30px 90px; display: flex; align-items: center; justify-content: space-between;">
            <div style="max-width: 60vw">
                <p style="font-size: 1.5em; margin-bottom: 30px; max-width: 600px; margin-right: auto;">{{ __('welcome.message.first_descripting_message') }}</p>
                <p style="font-size: 1.5em; text-align:end; font-weight: bold; margin-left: auto;">{{ __('welcome.message.second_descripting_message') }}</p>
            </div>
            <img src="{{ asset('img/calculator.png') }}" alt="calculator" style="max-width: 300px;">
        </div>
        <div class="glide">
            <div class="glide__track" data-glide-el="track">
              <ul class="glide__slides">
                <li class="glide__slide"><div style="background-color: var(--red); color: #fff; padding: 30px 90px; display: flex;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">{{ __('welcome.glide.title.spends') }}</h2>
                    <p style="font-size: 1.6em;">{{ __('welcome.glide.description.spends') }}</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/spends.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--yellow); color: #fff; padding: 30px 90px; display: flex;  align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">{{ __('welcome.glide.title.savings') }}</h2>
                    <p style="font-size: 1.6em;">{{ __('welcome.glide.description.savings') }}</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/savings.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--blue); color: #fff; padding: 30px 90px; display: flex;  align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">{{ __('welcome.glide.title.entrances') }}</h2>
                    <p style="font-size: 1.6em;">{{ __('welcome.glide.description.entrances') }}</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/entrance.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--purple); color: #fff; padding: 30px 90px; display: flex;  align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">{{ __('welcome.glide.title.debts_and_charges') }}</h2>
                    <p style="font-size: 1.6em;">{{ __('welcome.glide.description.debts_and_charges') }}</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/deudas.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--green); color: #fff; padding: 30px 90px; display: flex; align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">{{ __('welcome.glide.title.notes') }}</h2>
                    <p style="font-size: 1.6em;">{{ __('welcome.glide.description.notes') }}</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/notes.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
              </ul>
            </div>
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><</button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">></button>
              </div>
          </div>
    </section>
    <section style="height: calc(100vh - 69px); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px;">
        <h1 style="font-weight: bold;">{{ auth()->check() ? __('welcome.message.already_registered') : __('welcome.message.like_idea') }}</h1>
        <h1>{{auth()->check() ? __('welcome.message.see_your_dashboard') : __('welcome.message.register_now') }}</h1>
        <a href="{{ route('register.view') }}" style="text-decoration: none; font-weight: bold; color: #000;">
            <button style="position: relative; margin-top: 10px; font-size: 1.3em;">
                {{auth()->check() ? __('welcome.message.see_account') : __('validation_fields.buttons.register')}}
            </button>
        </a>    
    </section>
</x-app-layout>