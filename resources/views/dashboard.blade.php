@php
  $sinceUntil = [
    request()->has('since') ? request()->input('since') : null,
    request()->has('until') ? request()->input('until') : null 
];
@endphp

<x-app-layout title="Dashboard">
  <section class="dashboard-values">
    <div>
      <h3>Total:</h3>
      <h2 style="color: var(--green)">{{ $balance['total'] }}</h2>
    </div>
    <div>
      <h3>Ahorros:</h3>
      <h2 style="color: var(--yellow)">{{ $balance['saving'] }}</h2>
    </div>
    <div>
      <h3>Deudas:</h3>
      <h2 style="color: var(--red)">{{ $balance['deuda'] }}</h2>
    </div>
    <div>
      <h3>Cobros:</h3>
      <h2 style="color: var(--blue)">{{ $balance['cobro'] }}</h2>
    </div>
  </section>
  <section class="dashboard-charts">
    <script>
      const rootStyles = getComputedStyle(document.documentElement);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" stye="display:none;"></script>
    <x-chart-js :type="'spent'" :sinceUntil="$sinceUntil"/>
    <x-chart-js :type="'entrance'" :sinceUntil="$sinceUntil"/>
    <x-chart-js :type="'saving'" :sinceUntil="$sinceUntil"/>
  </section>
  <section class="dashboard-select-date">
    <form action="{{ route('dashboard') }}" method="get" id="sinceUntil" class="date_form">
      <label for="since">
        <h2>Desde: </h2>
        <input type="date" name="since" id="dateSINCE">
      </label>
      <label for="until">
        <h2>Hasta: </h2>
        <input type="date" name="until" id="dateUNTIL">
      </label>
      <input type="submit" value="Cambiar" style="position: relative; margin: 0; display: none;" id="submit">
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