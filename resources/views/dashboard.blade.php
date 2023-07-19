@php
  $sinceUntil = [
    request()->has('since') ? request()->input('since') : null,
    request()->has('until') ? request()->input('until') : null 
];
@endphp

<x-app-layout title="{{ __('titles.dashboard') }}">
  <section class="dashboard-values">
    <div>
      <h3>{{ __('dashboard.total') }}:</h3>
      <h2 style="color: var(--green)">{{ $balance['total'] }}</h2>
    </div>
    <div>
      <h3>{{ __('dashboard.savings') }}:</h3>
      <h2 style="color: var(--yellow)">{{ $balance['saving'] }}</h2>
    </div>
    <div>
      <h3>{{ __('dashboard.debts') }}:</h3>
      <h2 style="color: var(--red)">{{ $balance['debts'] }}</h2>
    </div>
    <div>
      <h3>{{ __('dashboard.charges') }}:</h3>
      <h2 style="color: var(--blue)">{{ $balance['charges'] }}</h2>
    </div>
  </section>
  <section class="dashboard-charts">
    <script>
      const rootStyles = getComputedStyle(document.documentElement);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" stye="display:none;"></script>
    @php
      $transactions = App\Models\Balance::where('exchange_id',request()->session()->get('main'))->where('user_id',request()->user()->id)->first()->transactions;
    @endphp
    <x-chart-js :transactions="$transactions" :type="'spend'" :sinceUntil="$sinceUntil"/>
    <x-chart-js :transactions="$transactions" :type="'entrance'" :sinceUntil="$sinceUntil"/>
    <x-chart-js :transactions="$transactions" :type="'saving'" :sinceUntil="$sinceUntil"/>
  </section>
  <section class="dashboard-select-date">
    <form action="{{ route('dashboard') }}" method="get" id="sinceUntil" class="form date_form">
      <label for="since">
        <h2>{{ __('query_fields.since') }}: </h2>
        <input type="date" name="since" id="dateSINCE">
      </label>
      <label for="until">
        <h2>{{ __('query_fields.until') }}: </h2>
        <input type="date" name="until" id="dateUNTIL">
      </label>
      <input type="submit" value="{{ __('validation_fields.buttons.filter') }}" style="position: relative; margin: 0; display: none;" id="submit">
    </form>
    <script>
      let dateSINCE = document.getElementById('dateSINCE');
      let dateUNTIL = document.getElementById('dateUNTIL');

      function showButton(){
        document.getElementById('submit').style.display = 'block';
      }

      dateSINCE.addEventListener('change',showButton);
      dateUNTIL.addEventListener('change',showButton);

      @if (request()->has('since'))
        dateSINCE.value = "{{ old('since') ? old('since') : request()->input('since') }}";
      @endif

      @if (request()->has('until'))
        dateUNTIL.value = "{{ old('since') ? old('since') : request()->input('until') }}";
      @endif
    </script>
  </section>
</x-app-layout>