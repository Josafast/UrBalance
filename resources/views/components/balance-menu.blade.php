<div class="float menu_balance" style="display: none;">
  <form action="{{ route('balance.change-main') }}" method="post" id="balance-menu" class="form">
    @csrf
    @method('put')
    <span class="close" id="closeFloatMenu">
      <img src="{{ asset('img/close.svg') }}" alt="close-icon" style="pointer-events: none; user-select: none;">
    </span>
    <h2 style="margin: 0 100px 30px 0;">{{ __('validation_fields.titles.select_your_balance') }}</h2>
    <label for="change_main" style="margin: 0;">
      <input type="hidden" name="change_main" id="change_main" value="false">
    </label>
    <label for="main" style="margin: 0;">
      <input type="hidden" name="main" id="main-id"value="{{ request()->session()->get('main') }}">
    </label>
    <ul>
      @php
        $balances = request()->user()->balance;
      @endphp
      @foreach ($balances as $position => $balance)
        <li style="margin-top: -1.5px; 
        {{ $position == 0 ? 'border-radius: 10px 10px 0 0;' : ($position == (count($balances)-1) ? 'border-radius: 0 0 10px 10px;' : '')}}
        @if ($balance->main == 1) 
          font-weight: 500;
        @endif"
        class="list-element
        @if ($balance->exchange_id == request()->session()->get('main'))
            selected
        @endif" id="{{ $balance->exchange_id }}">
          {{ __('exchange.'.strtolower($balance->exchange->name)) }}
          @if ($balance->exchange_id == request()->session()->get('main'))
            ({{ __('exchange.current') }})
          @endif
        </li>
      @endforeach
    </ul>
    <div style="margin-top: 30px; display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
      <button style="position: relative;" id="change_balance_button" option="1">{{ __('validation_fields.buttons.change') }}</button>
      <button style="position: relative;" id="change_main_balance_button" option="2">{{ __('validation_fields.buttons.change_main') }}</button>
      <button style="position: relative;" id="delete_balance_button" option="4">{{ __('validation_fields.buttons.delete') }}</button>
    </div>
  </form>
  @vite(['resources/js/balance-menu.js'])
</div>